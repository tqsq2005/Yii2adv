<?php

namespace backend\controllers;

use Yii;
use backend\models\Helpmenu;
use backend\models\HelpmenuSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * HelpmenuController implements the CRUD actions for Helpmenu model.
 */
class HelpmenuController extends Controller
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
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                    [
                        'actions' => ['treenode'],
                        'allow'     => true,
                        'roles'     => ['@', '?'],
                    ],
                ],
            ],*/
        ];
    }

    /**
     * @inheritDoc
     */
    public function beforeAction($action)
    {
        //actionID 为 detail 的话就禁用CSRF保护
        if(in_array($action->id, ['detail'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all Helpmenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpmenuSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Helpmenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Helpmenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Helpmenu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Helpmenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Helpmenu model.
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
     * Finds the Helpmenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Helpmenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Helpmenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * (void) actionTreenode : 生成目录树
     * @param string $unitcode
     */
    public function actionTreenode($unitcode='#')
    {
        if($unitcode == '#') {
            $data = [
                'id' => '%',
                'text' => '系统使用帮助',
                'children' => true,
                'icon' => './images/js18.png',
                'url' => Url::to(['detail', 'unitcode' => '^']),
            ];
        } else {
            $model = new Helpmenu();
            $data = $model->getChildren($unitcode);
        }

        //VarDumper::dump($data);
        Yii::$app->response->format = Response::FORMAT_JSON;
        echo json_encode($data);
    }

    public function actionDetail()
    {
        $unitcode = Yii::$app->request->post('unitcode', '%');
        $unitname = Yii::$app->request->post('unitname', '系统使用帮助');
        $helpmenu = new Helpmenu();

        if($helpmenu->isParent($unitcode)) {
            $searchModel = new HelpmenuSearch;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams(), $unitcode);

            return $this->renderAjax('_detail-help-children', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'unitname' => $unitname,
            ]);
        } else {
            $model = Helpmenu::findOne(['unitcode' => $unitcode]);
            return $this->renderAjax('_detail-help-info', ['model' => $model]);
        }
    }

    public function actionMain()
    {
        return $this->render('main');
    }

    /**
     * (string) actionList : 根据传入的上级代码生成下属列表
     * @param string $upunitcode
     * @return string
     */
    /*public function actionList($upunitcode = '%')
    {
        $searchModel = new HelpmenuSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }*/
}
