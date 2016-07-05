<?php

namespace backend\controllers;

use common\models\Unit;
use dektrium\user\models\User;
use Yii;
use common\models\MapUnit;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MapUnitController implements the CRUD actions for MapUnit model.
 */
class MapUnitController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * (string) actionIndex :
     * @param $user_id
     * @return string
     */
    public function actionIndex( $user_id )
    {
        /** @var User $user */
        //$this->layout = '@backend/views/map-unit/_tree.php';
        $user = User::findOne($user_id);

        return $this->render('index', [
            'user'          => $user,
        ]);
    }

    /**
     * (void) actionTree : 树
     * @param string $id
     * @param $user_id 用户ID
     */
    public function actionTree($id='@', $user_id)
    {
        $model = new MapUnit();
        if($id == '#') {
            $id = '@';
        }
        $data = $model->getChildren($id, $user_id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        echo json_encode($data);
    }

    public function actionTest($id='000023040001') {
        $childList = Unit::getParentList($id);
        $user_id   = 1;
        $permission = MapUnit::USER_POWER_ALLOW;
        $SQL = "replace into `map_unit`(`user_id`, `unitcode`, `user_power`) ".
            " SELECT $user_id, `unitcode`, $permission FROM `unit` where FIND_IN_SET(unitcode, :unitlist)";
        $rawSQL = Yii::$app->db->createCommand($SQL)
            ->bindValue(':unitlist', $childList)
            ->getRawSql();
        echo $rawSQL;
    }

    public function actionPermission() {
        $permission = Yii::$app->request->post('permission');
        $unitcode   = Yii::$app->request->post('unitcode');
        $user_id    = Yii::$app->request->post('user_id');
        if( $permission > '' && $unitcode > '' && $user_id > '' ) {
            $unitcode = ($unitcode == '0') ? '%' : $unitcode;
            switch($permission) {
                case MapUnit::USER_POWER_ALLOW:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //先处理单个更新情况
                        if(Yii::$app->request->post('type') == 'single') {
                            //只更新自身
                            $SQL        = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                                " SELECT $user_id, `unitcode`, $permission FROM `unit` where `unitcode` = :unitcode";
                            Yii::$app->db->createCommand($SQL)
                                ->bindValue(':unitcode', $unitcode)
                                ->execute();

                            //判断上级是否设置了最低操作权限：查看单位权限
                            $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                            $parentList     = Unit::getParentList($unitcode);
                            $SQL            = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                                " SELECT $user_id, u.unitcode, $minpermission FROM `unit` u LEFT JOIN `map_unit` mu ON u.unitcode = mu.unitcode ".
                                " where FIND_IN_SET(u.unitcode, :unitlist) and (mu.user_power < 0 or mu.user_power IS NULL)";
                            Yii::$app->db->createCommand($SQL)
                                ->bindValue(':unitlist', $parentList)
                                ->execute();
                        } else {//处理批量更新
                            //自身及下属都更新为允许访问
                            $childList  = Unit::getChildList($unitcode);
                            $SQL        = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) " .
                                " SELECT $user_id, `unitcode`, $permission FROM `unit` where FIND_IN_SET(`unitcode`, :unitlist)";
                            Yii::$app->db->createCommand($SQL)
                                ->bindValue(':unitlist', $childList)
                                ->execute();

                            //上级只更新为 允许查看单位权限
                            $parentList         = Unit::getParentList($unitcode);
                            $parentPermission   = MapUnit::USER_POWER_VIEW_DEPT;
                            $SQL                = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) " .
                                " SELECT $user_id, `unitcode`, $parentPermission FROM `unit` where FIND_IN_SET(`unitcode`, :unitlist)";
                            Yii::$app->db->createCommand($SQL)
                                ->bindValue(':unitlist', $parentList)
                                ->execute();
                        }

                        //提交事务
                        $transaction->commit();

                        return '单位权限更新成功';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                case MapUnit::USER_POWER_VIEW_ALL:
                case MapUnit::USER_POWER_DENY:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //自身及下属都更新为查看访问或拒绝访问
                        $childList  = Unit::getChildList($unitcode);
                        $SQL        = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) " .
                            " SELECT $user_id, `unitcode`, $permission FROM `unit` where FIND_IN_SET(`unitcode`, :unitlist)";
                        Yii::$app->db->createCommand($SQL)
                            ->bindValue(':unitlist', $childList)
                            ->execute();

                        if( $permission == MapUnit::USER_POWER_VIEW_ALL ) {
                            //判断上级是否设置了最低操作权限：查看单位权限
                            $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                            $parentList     = Unit::getParentList($unitcode);
                            $SQL            = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                                " SELECT $user_id, u.unitcode, $minpermission FROM `unit` u LEFT JOIN `map_unit` mu ON u.unitcode = mu.unitcode ".
                                " where FIND_IN_SET(u.unitcode, :unitlist) and (mu.user_power < 0 or mu.user_power IS NULL)";
                            Yii::$app->db->createCommand($SQL)
                                ->bindValue(':unitlist', $parentList)
                                ->execute();
                        }

                        //提交事务
                        $transaction->commit();

                        return '单位权限更新成功';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                case MapUnit::USER_POWER_VIEW_DEPT:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //只更新自身为查看单位权限
                        $SQL        = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                            " SELECT $user_id, `unitcode`, $permission FROM `unit` where `unitcode` = :unitcode";
                        Yii::$app->db->createCommand($SQL)
                            ->bindValue(':unitcode', $unitcode)
                            ->execute();

                        //判断上级是否设置了最低操作权限：查看单位权限
                        $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                        $parentList     = Unit::getParentList($unitcode);
                        $SQL            = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                            " SELECT $user_id, u.unitcode, $minpermission FROM `unit` u LEFT JOIN `map_unit` mu ON u.unitcode = mu.unitcode ".
                            " where FIND_IN_SET(u.unitcode, :unitlist) and (mu.user_power < 0 or mu.user_power IS NULL)";
                        Yii::$app->db->createCommand($SQL)
                            ->bindValue(':unitlist', $parentList)
                            ->execute();

                        //提交事务
                        $transaction->commit();

                        return '单位权限更新成功';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                default:
                    throw new \Exception("非法参数：{permission: $permission}！");
            }
        } else {
            throw new \Exception('参数不完整！');
        }

    }

    /**
     * (Response) actionDelete : Deletes an existing MapUnit model.
     * @param $user_id
     * @param $unitcode
     * @return Response
     * @throws \Exception
     */
    public function actionDelete($user_id, $unitcode)
    {
        $this->findModel($user_id, $unitcode)->delete();

        return $this->redirect(['index']);
    }

    /**
     * (null|static) findModel : 根据`$user_id`及`$unitcode`返回`MapUnit`的实例
     * @param $user_id
     * @param $unitcode
     * @return null|MapUnit
     */
    protected function findModel($user_id, $unitcode)
    {
        if (($model = MapUnit::findOne(['user_id' => $user_id, 'unitcode' => $unitcode])) !== null) {
            return $model;
        }

        return null;
    }
}
