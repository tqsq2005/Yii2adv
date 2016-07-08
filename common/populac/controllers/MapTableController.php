<?php

namespace common\populac\controllers;

use common\populac\behaviors\SortableController;
use common\populac\behaviors\StatusController;
use Yii;
use common\populac\models\MapTable;
use common\populac\models\MapTableSearch;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * MapTableController implements the CRUD actions for MapTable model.
 */
class MapTableController extends \common\populac\components\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            'sortable' => [
                'class'     => SortableController::className(),
                'model'     => MapTable::className(),
            ],
            'statusable' => [
                'class' => StatusController::className(),
                'model' => MapTable::className(),
            ]
        ];
    }

    /**
     * Lists all MapTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = MapTable::findOne($id);
            $out = Json::encode(['output'=>'', 'message'=>'失败']);
            $posted = current($_POST['MapTable']);
            $post = ['MapTable' => $posted];
            // load model like any single model validation
            if ($model->load($post)) {
                $model->save();
                $out = Json::encode(['output'=>'', 'message'=>'已保存']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        $searchModel = new MapTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single MapTable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            return [
                    'title'=> "表信息 #".$model->cnname,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('保 存',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new MapTable model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MapTable();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                $model->status = MapTable::STATUS_ON;
                return [
                    'title'=> "新增表信息",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('保 存',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "系统提示",
                    'content'=>'<span class="text-success">表信息新增成功！</span>',
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('继续新增',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{
                $model->status = MapTable::STATUS_ON;
                return [
                    'title'=> "新增表信息",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('保 存',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing MapTable model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "更新表信息 #".$model->cnname,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('保 存',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "更新表信息 #".$model->cnname,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('修 改',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "更新表信息 #".$model->cnname,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('关 闭',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('保 存',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing MapTable model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing MapTable model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * (mixed) actionUp : sort_no + 1
     * @param $id
     * @return mixed
     */
    public function actionUp($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            $this->move($id, 'up');
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true, 'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->move($id, 'up');
        }
    }

    /**
     * (mixed) actionDown : sort_no - 1
     * @param $id
     * @return mixed
     */
    public function actionDown($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            $this->move($id, 'down');
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true, 'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->move($id, 'down');
        }
    }

    public function actionOn($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            $this->changeStatus($id, MapTable::STATUS_ON);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true, 'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->changeStatus($id, MapTable::STATUS_ON);
        }
    }

    public function actionOff($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            $this->changeStatus($id, MapTable::STATUS_OFF);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true, 'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->changeStatus($id, MapTable::STATUS_OFF);
        }
    }

    /**
     * Finds the MapTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MapTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MapTable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
