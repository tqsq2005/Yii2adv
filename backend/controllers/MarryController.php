<?php

namespace backend\controllers;

use common\models\Personal;
use common\populac\models\Preferences;
use Yii;
use common\models\Marry;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarryController implements the CRUD actions for Marry model.
 */
class MarryController extends Controller
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
     * (string) actionIndex : marryList
     * @param $pid personal_id
     * @return string
     */
    public function actionIndex( $pid )
    {
        /*Personal*/
        $personal               = Personal::getPersonalByPid($pid);
        if( !$personal )
            die('参数错误..');
        $code1                  = $personal->code1;
        $because                = $personal->marry;
        $becausedate            = $personal->marrydate;
        switch( $because ) {
            case '22':
                $becausedate    = $personal->zhdate;
                break;
            case '23':
                $becausedate    = $personal->fhdate;
                break;
            case '30':
            case '40':
                $becausedate    = $personal->lhdate;
                break;
        }
        /*配置参数*/
        $preferences            = [];
        $preferences['marry']   = Preferences::getByClassmark('pmarry');
        $preferences['hkxz']    = Preferences::getByClassmark('chkxz');
        return $this->render('index', [
            'pid'           => $pid,
            'code1'         => $code1,
            'because'       => $because,
            'becausedate'   => $becausedate,
            'preferences'   => Json::encode($preferences),
        ]);
    }

    /**
     * (string) actionDataTables :
     * @param string $type
     * @param $pid
     * @return string
     * @throws Exception
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionDataTables( $type = 'fetch', $pid )
    {
        $returnData = [];
        switch($type) {
            case "fetch":
                $returnData = Personal::getPersonalByPid($pid)->marries;
                return Json::encode($returnData);
            case "crud":
                $requestAction = Yii::$app->request->post('action');

                switch($requestAction) {
                    case "create":
                        $requestID  = key(Yii::$app->request->post('data'));
                        $requestData = Yii::$app->request->post('data')[$requestID];
                        $model = new Personal();
                        //块赋值
                        $model->attributes = $requestData;
                        //返回错误信息给datatable
                        if(!$model->validate()) {
                            $fieldErrors = [];
                            foreach($model->errors as $name => $status) {
                                $fieldErrors[] = [
                                    'name' => $name,
                                    'status' => Json::encode($status),
                                ];
                            }
                            return Json::encode(['fieldErrors' => $fieldErrors, 'data' => []]);
                        }
                        if($model->save()) {
                            $requestData['id'] = $model->id;
                            $data = [];
                            $data[] = $requestData;
                            return Json::encode(['data' => $data]);
                        } else {
                            var_dump($model->errors);
                            $error = '恢复操作发生意外！';
                            throw new Exception($error);
                        }
                    case "edit":
                        $editID = array_keys(Yii::$app->request->post('data'));
                        //执行事务，保存必须都成功了才行
                        $transaction = Personal::getDb()->beginTransaction();
                        //返回值
                        $data = [];
                        try {
                            foreach($editID as $requestID) {
                                $requestData = Yii::$app->request->post('data')[$requestID];
                                $model = Personal::findOne($requestID);
                                //块赋值
                                $model->attributes = $requestData;
                                //返回错误信息给datatable
                                if(!$model->validate()) {
                                    $fieldErrors = [];
                                    foreach($model->errors as $name => $status) {
                                        $fieldErrors[] = [
                                            'name' => $name,
                                            'status' => Json::encode($status),
                                        ];
                                    }
                                    return Json::encode(['fieldErrors' => $fieldErrors, 'data' => []]);
                                }
                                $model->save();
                                //单个字段更新的时候
                                if(count($requestData)==1 || !is_array($requestData)) {
                                    $requestData = Personal::find()->select(['*'])->where([
                                        'id' => $requestID,
                                    ])->one();
                                } else {
                                    $requestData['id'] = $requestID;
                                }
                                $data[] = $requestData;
                            }
                            //提交事务
                            $transaction->commit();
                            return Json::encode(['data' => $data]);
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                            throw $e;
                        }
                    case "remove":
                        //多选则删除全部 用deleteAll()不会触发 event： EVENT_BEFORE_DELETE 和 EVENT_AFTER_DELETE
                        foreach(Yii::$app->request->post('data') as $removeID => $removeData) {
                            Personal::findOne($removeID)->delete();
                        }
                        return Json::encode($returnData);
                    default:
                        return Json::encode($returnData);
                };
            default:
                throw new \Exception('参数错误！');
        }
    }

    /**
     * Finds the Marry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
