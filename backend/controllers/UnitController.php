<?php

namespace backend\controllers;

use Yii;
use common\models\Unit;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends Controller
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
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single Unit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', '单位(部门)[ ' . $model->unitname . ' ]添加成功！');
            return $this->redirect(['index']);
        } else {
            $parentId           = Yii::$app->request->get('parentId');
            $parentId           = ($parentId == '0') ? '%' : $parentId;
            $model->upunitcode  = $parentId;
            $model->upunitname  = Yii::$app->request->get('parentName');
            $model->corpflag    = strlen($parentId) > 1 ? '5' : '4';
            $model->unitcode    = Unit::getMaxunitcode($parentId);
            return $this->renderAjax('create', [
                'model'     => $model,
                'isParent'  => intval($this->findModel($parentId)->corpflag) < 5 ? "yes" : "no", //判断下级能建单位还是部门
            ]);
        }
    }

    /**
     * Updates an existing Unit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', '单位(部门)[ ' . $model->unitname . ' ]更新成功！');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model'     => $model,
                'isParent'  => 'no',
            ]);
        }
    }

    /**
     * Deletes an existing Unit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * (void) actionTreenode : 生成目录树
     * @param string $unitcode
     */
    public function actionTree($id='@')
    {
        $model = new Unit;
        if($id == '#') {
            $id = '@';
        }
        $data = $model->getChildren($id);

        Yii::$app->response->format = Response::FORMAT_JSON;
        echo json_encode($data);
    }

    /**
     * (string) actionDetail : 右侧区域信息
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail()
    {
        //$this->layout = 'bank';
        $id = Yii::$app->request->post('id', '%');
        if($id == '0' || $id == '@')
            $id = '%';
        $name = Yii::$app->request->post('name', '计生管理系统');
        $unit = new Unit();

        if($unit->isParent($id)) {
            return $this->renderAjax('_detail', [
                'parent' => $id,
                'parentName' => $name,
                'unitcode'  => Unit::getMaxunitcode($id),
                'isParent'  => intval($this->findModel($id)->corpflag) < 5 ? "yes" : "no",//判断下级能建单位还是部门
            ]);
        } else {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * (string) actionDataTables : datatable
     * @return string
     * @throws Exception
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionDataTables()
    {
        $responseType = Yii::$app->request->get('type');
        $returnData = [];
        switch($responseType) {
            case "fetch":
                $returnData = Unit::find()->select(['*'])->where([
                    'upunitcode' => Yii::$app->request->get('id')
                ])->orderBy([
                    'unitcode' => SORT_ASC,
                ])->all();
                return Json::encode($returnData);
            case "crud":
                $requestAction = Yii::$app->request->post('action');

                switch($requestAction) {
                    case "create":
                        $requestID  = key(Yii::$app->request->post('data'));
                        $requestData = Yii::$app->request->post('data')[$requestID];
                        $model = new Unit();
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
                        $transaction = Unit::getDb()->beginTransaction();
                        //返回值
                        $data = [];
                        try {
                            foreach($editID as $requestID) {
                                $requestData = Yii::$app->request->post('data')[$requestID];
                                $model = Unit::findOne($requestID);
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
                                    $requestData = Unit::find()->select(['*'])->where([
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
                            Unit::findOne($removeID)->delete();
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
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $unitcode
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($unitcode)
    {
        if (($model = Unit::findOne(['unitcode' => $unitcode])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('数据获取失败..');
        }
    }
}
