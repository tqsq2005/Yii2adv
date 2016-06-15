<?php

namespace backend\controllers;

use bedezign\yii2\audit\models\AuditTrailSearch;
use Yii;
use backend\models\Event;
use backend\models\EventSearch;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use sintret\gii\models\LogUpload;
use sintret\gii\components\Util;


/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{

    public function behaviors()
    {
        return [
        /*'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','sample','parsing-log','excel'],
                        'roles' => ['viewer']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create','parsing'],
                        'roles' => ['author']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['editor']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'delete-all'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionList()
    {
        $grid = 'grid-'.self::className();
        $reset = Yii::$app->getRequest()->getQueryParam('p_reset');
        if ($reset) {
            \Yii::$app->session->set($grid, "");
        } else {
            $rememberUrl = Yii::$app->session->get($grid);
            $current = Url::current();
            if ($rememberUrl != $current && $rememberUrl) {
                Yii::$app->session->set($grid, "");
                $this->redirect($rememberUrl);
            }
            if (Yii::$app->getRequest()->getQueryParam('_pjax')) {
                \Yii::$app->session->set($grid, "");
                \Yii::$app->session->set($grid, Url::current());
            }
        }

        // validate if there is a editable input saved via AJAX
//        var_dump(Yii::$app->request->post());
//        exit();
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $eventId = Yii::$app->request->post('editableKey');
            $model = Event::findOne($eventId);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            // fetch the first entry in posted data (there should only be one entry
            // anyway in this array for an editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $posted = current($_POST['Event']);
            $post = ['Event' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['start'])) {
                    $output = Yii::$app->formatter->asDatetime($model->start);
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                // $output = ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * History lists all Event models.
     * @return mixed
     */
    public function actionHistory()
    {
        /*$auditdata = AuditTrailSearch::find()
            ->select(['entry_id', 'model_id', 'user_id', 'created', 'old_value'])
            ->where([
            'action' => 'DELETE',
            'model' => 'backend\models\Event',
            ])
            ->andFilterWhere(['>', 'old_value', "''"])
            ->orderBy(['model_id' => SORT_DESC])
            ->all();*/
//        $historyData = \yii\helpers\ArrayHelper::map($auditdata, 'model_id', 'old_value');
//        \yii\helpers\VarDumper::dump($historyData);

        $searchModel = new AuditTrailSearch;
        $searchFilter = [
            'AuditTrailSearch' => [
                'action' => 'DELETE',
                'model' => 'backend\models\Event'
            ]
        ];
        $dataProvider = $searchModel->search(\yii\helpers\ArrayHelper::merge(Yii::$app->request->get(), $searchFilter));
        //var_dump(Yii::$app->request->get());
        //\yii\helpers\VarDumper::dump($searchModel);
        $message = "<ol>恢复操作指引<li><删除内容>中输入内容筛选</li><li>点击复选框选中需要恢复的记录</li><li>点击<恢复记录>按钮</li></ol>";
        Yii::$app->session->setFlash('info', $message);
        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionRetrieve()
    {
        $oldEvent = Yii::$app->request->post('oldEvent');
        $error = '';
        $message = '';
        foreach($oldEvent as $event) {
            $model = new Event();
            //转化为[attr1 => val1, attr2 => val2, attr3 => val3, ..] 数据格式进行块赋值
            $model->attributes = \yii\helpers\Json::decode($event);
            if($model->save()) {
                $message .= "<li>事件<{$model->title}>恢复成功；</li>";
            } else {
                $error = '恢复操作发生意外！';
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
     * (string) actionIndex :
     * @return Event: events
     */
    public function actionIndex()
    {
        /*$events = Event::find()->all();

        return $this->render('index', [
            'events' => $events,
        ]);*/
        $todayEventNum = Event::find()->where(['like', 'start', date('Y-m-d')])->count(1);
        return $this->render('index', [
            'todayEventNum' => $todayEventNum,
        ]);
    }

    public function actionIndexw()
    {
        $events = Event::find()->all();

        return $this->render('index_widgets_bak', [
            'events' => $events,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '事件<'. $model->title .'>添加成功!  ');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model->loadDefaultValues(),
            ]);
        }
    }

    public function actionIndexAjaxData()
    {
        $type = Yii::$app->request->post('type');
        switch ($type) {
            case "fetch":
                $events = Event::find()->all();
                return Json::encode($events);
            case "newByClick":
                $model = new Event();
                $model->title = Yii::$app->request->post('title');
                $model->start = Yii::$app->request->post('start');
                $model->end = Yii::$app->request->post('end');
                if($model->save()) {
                    //Yii::$app->session->setFlash('success', '事件<'. $model->title .'>添加成功!  ');
                    return Json::encode($model);
                } else {
                    return Json::encode([
                        'message' => 'fail to save',
                        'status'=>'failed',
                    ]);
                }
            case "newByButton":
                $model = new Event();
                $model->title = Yii::$app->request->post('title');
                if($model->save()) {
                    //Yii::$app->session->setFlash('success', '事件<'. $model->title .'>添加成功!  ');
                    return Json::encode($model);
                } else {
                    return Json::encode([
                        'message' => 'fail to save',
                        'status'=>'failed',
                    ]);
                }
            case "resize":
                $model = Event::findOne(Yii::$app->request->post('eventid'));
                $model->start = Yii::$app->request->post('start');
                $model->end = Yii::$app->request->post('end');
                if($model->save()) {
                    return Json::encode($model);
                } else {
                    return Json::encode([
                        'message' => 'fail to update',
                        'status'=>'failed',
                    ]);
                }
            case "remove":
                if(Event::findOne(Yii::$app->request->post('eventid'))->delete()) {
                    //Yii::$app->session->setFlash('success', '事件已删除!  ');
                    return Json::encode([
                        'message' => 'remove success!',
                        'status' => 'success',
                    ]);
                } else {
                    return Json::encode([
                        'message' => 'fail to remove',
                        'status'=>'failed',
                    ]);
                }
        }
    }

    public function actionLog()
    {
        return $this->render('_log');
    }

    public function actionLogData()
    {
        $model_id = 10;
        $action = ['create', 'update'];
        $model = 'backend\models\Event';

    }

    public function actionDataTables()
    {
        $responseType = Yii::$app->request->get('type');
        $returnData = [];
        switch($responseType) {
            case "fetch":
                $returnData = Event::find()->select([
                    'id', 'title', 'description', 'start', 'end'
                ])->where([
                    'created_by' => Yii::$app->user->id,
                ])->orderBy([
                    'id' => SORT_DESC,
                ])->all();
                return Json::encode($returnData);
            case "crud":
                $requestAction = Yii::$app->request->post('action');

                switch($requestAction) {
                    case "create":
                        $requestID  = key(Yii::$app->request->post('data'));
                        $requestData = Yii::$app->request->post('data')[$requestID];
                        $model = new Event();
                        //块赋值
                        $model->attributes = $requestData;
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
                            $error = '恢复操作发生意外！';
                            throw new Exception($error);
                        }
                    case "edit":
                        $editID = array_keys(Yii::$app->request->post('data'));
                        //执行事务，保存必须都成功了才行
                        $transaction = Event::getDb()->beginTransaction();
                        //返回值
                        $data = [];
                        try {
                            foreach($editID as $requestID) {
                                $requestData = Yii::$app->request->post('data')[$requestID];
                                $model = Event::findOne($requestID);
                                //块赋值
                                $model->attributes = $requestData;
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
                                    $requestData = Event::find()->select([
                                        'id', 'title', 'description', 'start', 'end'
                                    ])->where([
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
                            Event::findOne($removeID)->delete();
                        }
                        return Json::encode($returnData);
                    default:
                        return Json::encode($returnData);
                };
            default:
                return $this->render('_data-tables');
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //var_dump(Yii::$app->request->post());
        //exit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '事件<'. $model->title .'>更新成功!  ');
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '记录已删除!  ');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSample() {

        //$objPHPExcel = new \PHPExcel();
        $template = Util::templateExcel();
        $model = new Event;
        $date = date('YmdHis');
        $name = $date.'Event';
        //$attributes = $model->attributeLabels();
        $models = Event::find()->all();
        $excelChar = Util::excelChar();
        $not = Util::excelNot();
        
        foreach ($model->attributeLabels() as $k=>$v){
            if(!in_array($k, $not)){
                $attributes[$k]=$v;
            }
        }

        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(Yii::getAlias($template));

        return $this->render('sample', ['models' => $models,'attributes'=>$attributes,'excelChar'=>$excelChar,'not'=>$not,'name'=>$name,'objPHPExcel' => $objPHPExcel]);
    }
    
    public function actionParsing() {
        $num = 0;
        $fields = [];
        $values = [];
        $log = '';
        $route = '';
        $model = new LogUpload;
        
        $date = date('Ymdhis') . Yii::$app->user->identity->id;

        if (Yii::$app->request->isPost) {
            $model->fileori = UploadedFile::getInstance($model, 'fileori');

            if ($model->validate()) {
                $fileOri = Yii::getAlias(LogUpload::$imagePath) . $model->fileori->baseName . '.' . $model->fileori->extension;
                $filename = Yii::getAlias(LogUpload::$imagePath) . $date . '.' . $model->fileori->extension;
                $model->fileori->saveAs($filename);
            }
            $params = Util::excelParsing(Yii::getAlias($filename));
            $model->params = \yii\helpers\Json::encode($params);
            $model->title = 'parsing Event';
            $model->fileori = $fileOri;
            $model->filename = $filename;


            if ($params)
                foreach ($params as $k => $v) {
                    foreach ($v as $key => $val) {
                        if ($num == 0) {
                            $fields[$key] = $val;
                            $max = $key;
                        }

                        if ($num >= 3) {
                            $values[$num][$fields[$key]] = $val;
                        }
                    }
                    $num++;
                }
            if (in_array('id', $fields)) {
                $model->type = LogUpload::TYPE_UPDATE;
            } else {
                $model->type = LogUpload::TYPE_INSERT;
            }
            $model->keys = \yii\helpers\Json::encode($fields);
            $model->values = \yii\helpers\Json::encode($values);
            if ($model->save()) {
                $log = 'log_Event'. Yii::$app->user->id;
                Yii::$app->session->setFlash('success', 'Well done! successfully to Parsing data, see log on log upload menu! Please Waiting for processing indicator if available...  ');
                Yii::$app->session->set($log, $model->id);
                $notification = new \sintret\gii\models\Notification;
                $notification->title = 'parsing Event';
                $notification->message = Yii::$app->user->identity->username . ' parsing Event ';
                $notification->params = \yii\helpers\Json::encode(['model' => 'Event', 'id' => $model->id]);
                $notification->save();
            }
        }
        $route = 'event/parsing-log';

        return $this->render('parsing', ['model' => $model,'log'=>$log,'route'=>$route]);
    }
    
    public function actionParsingLog($id) {
        $mod = LogUpload::findOne($id);
        $type = $mod->type;
        $keys = \yii\helpers\Json::decode($mod->keys);
        $values = \yii\helpers\Json::decode($mod->values);
        $modelAttribute = new Event;
        $not = Util::excelNot();
        
            foreach ($values as $value) {
                if ($type == LogUpload::TYPE_INSERT)
                    $model = new Event;
                else
                    $model = Event::findOne($value['id']);

                foreach ($keys as $v) {
                        $model->$v = $value[$v];
                }
                
                $e = 0;
                if ($model->save()) {
                    $model = NULL;
                    $pos = NULL;
                } else {
                    $error[] = \yii\helpers\Json::encode($model->getErrors());
                    $e = 1;
                }
            }

        if ($error) {
            foreach ($error as $err) {
                if ($err) {
                    $er[] = $err;
                    $e+=1;
                }
            }
            if ($e) {
                $mod->warning = \yii\helpers\Json::encode($er);
                $mod->save();
                echo '<pre>';
                print_r($er);
            }
        }
    }

    public function actionExcel() {
        $searchModel = new EventSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelAttribute = new Event;
        $not = Util::excelNot();
        foreach ($modelAttribute->attributeLabels() as $k=>$v){
            if(!in_array($k, $not)){
                $attributes[$k] = $v;
            }
        }

        $models = $dataProvider->getModels();
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load(Yii::getAlias(Util::templateExcel()));
        $excelChar = Util::excelChar();
        return $this->render('_excel', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'attributes' => $attributes,
                    'models' => $models,
                    'objReader' => $objReader,
                    'objPHPExcel' => $objPHPExcel,
                    'excelChar' => $excelChar
        ]);
    }
    public function actionDeleteAll() {
        $pk = Yii::$app->request->post('pk'); // Array or selected records primary keys
        $explode = explode(",", $pk);
        if ($explode)
            foreach ($explode as $v) {
                if($v)
                $this->findModel($v)->delete();
            }
        echo 1;
    }
}
