<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-22 下午3:19
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\controllers;

use bedezign\yii2\audit\models\AuditTrailSearch;
use common\populac\behaviors\SortableController;
use common\populac\models\Preferences;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\populac\models\ColTable;

class ColTableController extends \common\populac\components\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class'     => SortableController::className(),
                'model'     => ColTable::className(),
                'ordercol'  => 'sort_no',
            ]
        ]);
    }

    public function actionIndex()
    {
        $responseType = Yii::$app->request->get('type');
        $returnData = [];
        switch($responseType) {
            case "fetch":
                $returnData = ColTable::find()->select(['*'])->orderBy([
                    'pbc_tnam'  => SORT_ASC,
                    'sort_no'   => SORT_ASC,
                ])->all();
                return Json::encode($returnData);
            case "crud":
                $requestAction = Yii::$app->request->post('action');

                switch($requestAction) {
                    case "create":
                        $requestID  = key(Yii::$app->request->post('data'));
                        $requestData = Yii::$app->request->post('data')[$requestID];
                        $model = new ColTable();
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
                            $requestData['created_at'] = $model->created_at;
                            $requestData['updated_at'] = $model->updated_at;
                            $data = [];
                            $data[] = $requestData;
                            return Json::encode(['data' => $data]);
                        } else {
                            $error = '新增操作发生意外！';
                            throw new Exception($error);
                        }
                    case "edit":
                        $editID = array_keys(Yii::$app->request->post('data'));
                        //执行事务，保存必须都成功了才行
                        $transaction = ColTable::getDb()->beginTransaction();
                        //返回值
                        $data = [];
                        try {
                            foreach($editID as $requestID) {
                                $requestData = Yii::$app->request->post('data')[$requestID];
                                $model = ColTable::findOne($requestID);
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
                                    $requestData = ColTable::find()->select(['*'])->where([
                                        'id' => $requestID,
                                    ])->one();
                                } else {
                                    $requestData['id'] = $requestID;
                                    $requestData['created_at'] = $model->created_at;
                                    $requestData['updated_at'] = $model->updated_at;
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
                            ColTable::findOne($removeID)->delete();
                        }
                        return Json::encode($returnData);
                    default:
                        return Json::encode($returnData);
                };
            default:
                return $this->render('index');
        }
    }

    /**
     * History lists all ColTable models.
     * @return mixed
     */
    public function actionHistory()
    {
        $searchModel = new AuditTrailSearch();
        $searchFilter = [
            'AuditTrailSearch' => [
                'action' => 'DELETE',
                'model' => 'common\populac\models\ColTable'
            ]
        ];
        $dataProvider = $searchModel->search(\yii\helpers\ArrayHelper::merge(Yii::$app->request->get(), $searchFilter));
        //$message = "<ol>恢复操作指引<li><删除内容>中输入内容筛选</li><li>点击复选框选中需要恢复的记录</li><li>点击<恢复记录>按钮</li></ol>";
        //Yii::$app->session->setFlash('info', $message);
        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * (string) actionRetrieve : 恢复记录
     * @return string
     * @throws Exception
     */
    public function actionRetrieve()
    {
        $oldColTable = Yii::$app->request->post('oldColTable');
        $error = '';
        $message = '';
        foreach($oldColTable as $coltable) {
            $model = new ColTable();
            //转化为[attr1 => val1, attr2 => val2, attr3 => val3, ..] 数据格式进行块赋值
            $model->attributes = \yii\helpers\Json::decode($coltable);
            if($model->save()) {
                $message .= "<li>系统表字段配置<{$model->pbc_tnam}({$model->pbc_cnam})>恢复成功；</li>";
            } else {
                $error = '恢复操作发生意外,错误信息:' . \yii\helpers\Json::encode($model->errors);
                throw new Exception($error);
            }
        }
        if($error) {
            return Json::encode([
                'message' => $error,
                'status' => 'failed',
            ]);
        } else {
            return Json::encode([
                'message' => $message,
                'status' => 'success',
            ]);
        }
    }

    /**
     * (void) actionColMissing : 未配置字段
     */
    public function actionColMissing()
    {
        if( Yii::$app->request->get( 'type' ) == 'fetch' ) {
            $table = ColTable::showTables();
            $data  = [];
            foreach( $table as $pbc_tnam ) {
                $tmp = [];
                $tmp['pbc_tnam'] = $pbc_tnam;
                $tmp['pbc_cnam'] = implode( ',', ColTable::getMissingColumnsByTablenam( $pbc_tnam ) );
                $data[] = $tmp;
            }
            return Json::encode( $data );
        }

        return $this->render( 'col-missing' );
    }

    public function actionGetFieldConfig()
    {
        //传过来的数据格式为 pbc_tnam.pbc_cnam
        $params = Yii::$app->request->post('params', '');
        $config = [];
        if($params) {
            $paramArr = explode('.', $params);
            if(count($paramArr) == 2) {
                $pbc_tnam   = $paramArr[0];
                $pbc_cnam   = $paramArr[1];
                $classmark  = ColTable::getClassmark($pbc_tnam, $pbc_cnam);
                $data       = $classmark ? Preferences::getByClassmark($classmark) : [];
            }
        }

        if( count($data) ) {
            foreach( $data as $key=>$value ) {
                $tmp['id']   = $key;
                $tmp['text'] = $value;
                $config[]    = $tmp;
            }
        }

        return count($config) ? Json::encode($config) : '';
    }

    /**
     * (mixed) actionUp : sort_no + 1
     * @param $id
     * @return mixed
     */
    public function actionUp($id)
    {
        $pbc_tnam = Yii::$app->request->post('pbc_tnam', '');
        $condition = $pbc_tnam ? ['pbc_tnam' => $pbc_tnam] : [];
        return $this->move($id, 'up', $condition);
    }

    /**
     * (mixed) actionDown : sort_no - 1
     * @param $id
     * @return mixed
     */
    public function actionDown($id)
    {
        $pbc_tnam = Yii::$app->request->post('pbc_tnam', '');
        $condition = $pbc_tnam ? ['pbc_tnam' => $pbc_tnam] : [];
        return $this->move($id, 'down', $condition);
    }

}