<?php

namespace backend\controllers;

use Yii;
use common\models\Preferences;
use common\models\PreferencesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PreferencesController implements the CRUD actions for Preferences model.
 */
class PreferencesController extends Controller
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
     * Lists all Preferences models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreferencesSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Preferences model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('view', ['model' => $model]);
        }/*
        if($model->load(Yii::$app->request->post() && $model->save())) {
            return $this->redirect(['view', 'id' => (string) $model->_id ]);
        } elseif(Yii::$app->request->isAjax) {
            return $this->render('_form', [
                'model' => $model
            ]);
        } else {
            return $this->render('_form', [
                'model' => $model
            ]);
        }*/
    }

    /**
     * Creates a new Preferences model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Preferences;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'PreferencesSearch[classmark]' => $model->classmark, 'create-classmark' => $model->classmark]);
        } elseif(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        } else {
            return $this->render('_form', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Preferences model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } elseif(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        } else {
            return $this->render('_form', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Preferences model.
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
     * Finds the Preferences model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Preferences the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Preferences::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * (mixed|string) actionGetclassmarkcn : Ajax返回classmark对应的classmarkcn
     * @param string $classmark
     * @return mixed|string
     */
    public function actionGetclassmarkcn($classmark = '')
    {
        if(Yii::$app->request->isPost) {
            return Preferences::getClassmarkcnByClassmark($_POST['classmark']);
        } else {
            return '';
        }
    }

}
