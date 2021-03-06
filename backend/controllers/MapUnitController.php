<?php

namespace backend\controllers;

use common\models\Unit;
use common\populac\models\Preferences;
use dektrium\user\models\User;
use Yii;
use common\models\MapUnit;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MapUnitController implements the CRUD actions for MapUnit model.
 */
class MapUnitController extends Controller
{
    /** 传入的unitcode更新map_unit表的时候只更新当前的unitcode */
    const UPDATE_SELF       = 1;
    /** 传入的unitcode更新map_unit表的时候更新当前的unitcode及其下级 */
    const UPDATE_CHILDLIST  = 2;
    /** 传入的unitcode更新map_unit表的时候更新当前的unitcode的父级 */
    const UPDATE_PARENTLIST = 3;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'permission' => ['post'],
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

    /**
     * (string) actionPermission : 设置单位权限
     * @return string   返回更新记录说明
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionPermission() {
        $permission = Yii::$app->request->post('permission');
        $unitcode   = Yii::$app->request->post('unitcode');
        $user_id    = Yii::$app->request->post('user_id');
        /** @var $result integer 更新的记录数 */
        $result     = 0;

        if( $permission > '' && $unitcode > '' && $user_id > '' ) {
            //转换 单位编码为0的情况
            $unitcode   = ($unitcode == '0') ? '%' : $unitcode;
            //当前登录用户ID值
            $currentUID = Yii::$app->user->identity->id;
            switch($permission) {
                case MapUnit::USER_POWER_ALLOW:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //先处理单个更新情况
                        if(Yii::$app->request->post('type') == 'single') {
                            //只更新自身
                            $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $unitcode);
                            //如果自身有更新成功则判断上级是否设置了最低操作权限：查看单位权限, 没更新说明权限不足
                            if( $result ) {
                                $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                                $this->userPowerUpdate($currentUID, $user_id, $minpermission, $unitcode, self::UPDATE_PARENTLIST);
                            }
                        } else {//处理批量更新
                            //自身及下属都更新为允许访问
                            $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $unitcode, self::UPDATE_CHILDLIST);

                            //如果自身或下级有更新成功则判断上级是否设置了最低操作权限：查看单位权限, 没更新说明权限不足
                            if( $result ) {
                                $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                                $this->userPowerUpdate($currentUID, $user_id, $minpermission, $unitcode, self::UPDATE_PARENTLIST);
                            }
                        }

                        //提交事务
                        $transaction->commit();

                        return $result ? '单位权限『完全访问』更新成功『'.$result.'』条记录' : '权限不足,请向主管单位申请！';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                case MapUnit::USER_POWER_VIEW_ALL:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //自身及下属都更新为查看访问
                        $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $unitcode, self::UPDATE_CHILDLIST);

                        //如果自身或下级有更新成功则判断上级是否设置了最低操作权限：查看单位权限, 没更新说明权限不足,请向主管单位申请！
                        if( $result ) {
                            $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                            $this->userPowerUpdate($currentUID, $user_id, $minpermission, $unitcode, self::UPDATE_PARENTLIST);
                        }

                        //提交事务
                        $transaction->commit();

                        return $result ? '单位权限『查看访问单位及人员』更新成功『'.$result.'』条记录' : '权限不足,请向主管单位申请！';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                case MapUnit::USER_POWER_DENY:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //自身及下属都更新为查看访问或拒绝访问
                        $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $unitcode, self::UPDATE_CHILDLIST);

                        //提交事务
                        $transaction->commit();

                        return $result ? '单位权限『禁止访问』更新成功『'.$result.'』条记录' : '权限不足,请向主管单位申请！';
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                case MapUnit::USER_POWER_VIEW_DEPT:
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //只更新自身为查看单位权限
                        $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $unitcode);

                        //如果自身有更新成功则判断上级是否设置了最低操作权限：查看单位权限, 没更新说明权限不足,请向主管单位申请！
                        if( $result ) {
                            $minpermission  = MapUnit::USER_POWER_VIEW_DEPT;
                            $this->userPowerUpdate($currentUID, $user_id, $minpermission, $unitcode, self::UPDATE_PARENTLIST);
                        }

                        //提交事务
                        $transaction->commit();

                        return $result ? '单位权限『查看访问单位』更新成功『'.$result.'』条记录' : '权限不足,请向主管单位申请！';
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
     * (string) actionCheckUnitAccessible : 客户端ajax校验当前用户是否取得单位编码的完全访问权限
     * 见common\components\validators\UnitAccessible
     * @return string
     */
    public function actionCheckUnitAccessible()
    {
        /** @var string $attribute 字段：unitcode、upunitcode或unit */
        $attribute  = Yii::$app->request->post('attribute');
        /** @var string $value 字段对应的值 */
        $value      = Yii::$app->request->post('value');
        /** @var integer $user_id 当前用户ID */
        $user_id    = Yii::$app->user->identity->id;
        $errMsg     = '';
        switch( $attribute ) {
            case 'unitcode'://修改
                if( Unit::findOne(['unitcode' => $value]) && MapUnit::getUserPower( $user_id, $value ) != MapUnit::USER_POWER_ALLOW ) {
                    $errMsg = '你没有单位(部门)『'. $value .'』的『完全访问』权限.';
                }
                break;
            case 'upunitcode'://新增
                if( !Unit::findOne(['upunitcode' => $value]) && MapUnit::getUserPower( $user_id, $value ) < MapUnit::USER_POWER_VIEW_DEPT ) {
                    $errMsg = '你没有单位(部门)『'. $value .'』的『完全访问』权限.';
                }
                break;
        }
        return $errMsg;
    }

    /**
     * (返回更新的记录数) userPowerUpdate :
     * @param $currentUID   integer 当前登录的用户ID
     * @param $setUID       integer 需要设置单位权限的用户ID
     * @param $permission   integer 单位权限级别
     * @param $unitcode     string  单位编码
     * @param int $type             更新类型
     * @return 返回更新的记录数
     * @throws \yii\db\Exception
     */
    private function userPowerUpdate($currentUID, $setUID, $permission, $unitcode, $type = self::UPDATE_SELF)
    {
        /** @var $result 返回更新的记录数*/
        $result     = 0;
        /** @var $adminRole string 在Preferences中配置，classmark：sSystem */
        $adminRole  = Preferences::get('sSystem', 'adminRole');//超级管理员
        /** @var $role \yii\rbac\Role[] 当前用户角色数组*/
        $role       = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
        /** @var $is_admin boolean 是否为超级管理员*/
        $is_admin   = array_key_exists($adminRole, $role);
        $unitlist   = $unitcode;
        switch($type) {
            case self::UPDATE_CHILDLIST:
                $unitlist = Unit::getChildList($unitcode);
                break;
            case self::UPDATE_PARENTLIST:
                $unitlist = Unit::getParentList($unitcode);
                break;
        }

        $SQL = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
            " SELECT $setUID, cur_mu.unitcode, CASE WHEN cur_mu.user_power >= :user_power THEN :user_power ELSE cur_mu.user_power END FROM ".
            " (SELECT unitcode, user_power FROM `map_unit` WHERE `user_id` = :currentUID AND FIND_IN_SET(unitcode,:unitlist)) cur_mu ".
            " LEFT JOIN (SELECT unitcode, user_power FROM `map_unit` WHERE `user_id` = :setUID ) set_mu ON (cur_mu.unitcode = set_mu.unitcode) ".
            " WHERE (set_mu.user_power <= cur_mu.user_power and set_mu.user_power <> :user_power or set_mu.user_power IS NULL)";

        //超级管理员
        if( $is_admin ) {
            $SQL = "REPLACE INTO `map_unit`(`user_id`, `unitcode`, `user_power`) ".
                " SELECT $setUID, u.unitcode, $permission FROM ".
                " (SELECT unitcode FROM `unit` WHERE FIND_IN_SET(unitcode,:unitlist)) u ".
                " LEFT JOIN (SELECT unitcode, user_power FROM `map_unit` WHERE `user_id` = :setUID ) set_mu ON (u.unitcode = set_mu.unitcode) ".
                " WHERE :currentUID > 0 and (set_mu.user_power <> :user_power or set_mu.user_power IS NULL)";
        }

        $result = Yii::$app->db->createCommand($SQL)
            ->bindValues([
                ':currentUID'   => $currentUID,
                ':user_power'   => $permission,
                ':unitlist'     => $unitlist,
                ':setUID'       => $setUID,
            ])
            ->execute();

        if( $permission == MapUnit::USER_POWER_DENY ) {
            //清除禁止访问的
            MapUnit::deleteAll(['user_power' => MapUnit::USER_POWER_DENY]);
        }

        return $result;
    }
}
