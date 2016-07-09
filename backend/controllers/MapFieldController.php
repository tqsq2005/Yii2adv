<?php

namespace backend\controllers;

use common\populac\models\Preferences;
use dektrium\user\models\User;
use Yii;
use common\models\MapField;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MapFieldController implements the CRUD actions for MapField model.
 */
class MapFieldController extends Controller
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
        $user = User::findOne($user_id);

        return $this->render('index', [
            'user'          => $user,
        ]);
    }

    /**
     * (string) actionPermission : 设置字段权限
     * @return string   返回更新记录说明
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionPermission() {
        $permission = Yii::$app->request->post('permission');
        $id   = Yii::$app->request->post('id');
        $user_id    = Yii::$app->request->post('user_id');
        /** @var $result integer 更新的记录数 */
        $result     = 0;

        if( in_array($permission, [MapField::USER_POWER_ALLOW, MapField::USER_POWER_VIEW_AFTER_ADD,
                MapField::USER_POWER_VIEW, MapField::USER_POWER_DENY]) && $id > '' && $user_id > '' )
        {
            //当前登录用户ID值
            $currentUID = Yii::$app->user->identity->id;
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $result = $this->userPowerUpdate($currentUID, $user_id, $permission, $id);
                //提交事务
                $transaction->commit();

                return $result ? '字段权限更新成功' : '权限不足,请向主管单位申请！';
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        } else {
            throw new \Exception('参数不完整！');
        }

    }

    /**
     * (void) actionTree : 生成目录树
     * @param string $id
     * @param string $user_id
     */
    public function actionTree($id='#', $user_id)
    {
        if($id == '#') {
            $data = [
                'id' => 'js.map_field',
                'text' => Preferences::getName1Text('sSystem', 'appName'),
                'children' => true,
                'icon' => './images/js18.png',
            ];
        } else {
            $model = new MapField;
            $data = $model->createTree($id, $user_id);
        }

        //print_r($data);
        Yii::$app->response->format = Response::FORMAT_JSON;
        echo Json::encode($data);
    }

    /**
     * (返回更新的记录数) userPowerUpdate :
     * @param $currentUID   integer 当前登录的用户ID
     * @param $setUID       integer 需要设置单位权限的用户ID
     * @param $permission   integer 字段权限级别
     * @param $id           string  格式：gdjs.pbc_tnam.pbc_cnam
     * @return 返回更新的记录数
     * @throws \yii\db\Exception
     */
    private function userPowerUpdate($currentUID, $setUID, $permission, $id)
    {
        /** @var $result 返回更新的记录数*/
        $result     = 0;
        /** @var array $pbc_data [ 0 => 'gdjs', 1 => pbc_tnam, 2 => pbc_cnam ] */
        $pbc_data   = explode('.', $id);
        //校验格式，格式不对，返回 0
        if($pbc_data[0] != 'gdjs' || count($pbc_data) != 3)
            return  $result;

        /** @var string $pbc_tnam 表名 */
        $pbc_tnam   = $pbc_data[1];
        /** @var string $pbc_cnam 字段名 */
        $pbc_cnam   = $pbc_data[2];
        /** @var $adminRole string 在Preferences中配置，classmark：sSystem */
        $adminRole  = Preferences::get('sSystem', 'adminRole');//超级管理员
        /** @var $role \yii\rbac\Role[] 当前用户角色数组*/
        $role       = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
        /** @var $is_admin boolean 是否为超级管理员*/
        $is_admin   = array_key_exists($adminRole, $role);

        $SQL = "REPLACE INTO `map_field`(`user_id`, `pbc_tnam`, `pbc_cnam`, `user_power`) ".
            " SELECT :setUID, :pbc_tnam, :pbc_cnam, :user_power FROM `map_field` ".
            " WHERE (SELECT COUNT(1) FROM `map_field` WHERE ".
            " `user_id`=:currentUID AND `pbc_tnam`=:pbc_tnam AND `pbc_cnam`=:pbc_cnam) <= 0 LIMIT 1";

        //超级管理员
        if( $is_admin ) {
            $SQL = "REPLACE INTO `map_field`(`user_id`, `pbc_tnam`, `pbc_cnam`, `user_power`) ".
                " SELECT :setUID, :pbc_tnam, :pbc_cnam, :user_power FROM `map_field` ".
                " WHERE :currentUID > 0 LIMIT 1";
        }

        $result = Yii::$app->db->createCommand($SQL)
            ->bindValues([
                ':currentUID'   => $currentUID,
                ':setUID'       => $setUID,
                ':pbc_tnam'     => $pbc_tnam,
                ':pbc_cnam'     => $pbc_cnam,
                ':user_power'   => $permission,
            ])
            ->execute();

        if( $permission == MapField::USER_POWER_ALLOW ) {
            //清除完全访问的
            MapField::deleteAll(['user_power' => MapField::USER_POWER_ALLOW]);
        }

        return $result;
    }
}
