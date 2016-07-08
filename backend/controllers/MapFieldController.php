<?php

namespace backend\controllers;

use Yii;
use common\models\MapField;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Lists all MapField models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Finds the MapField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param string $pbc_tnam
     * @param string $pbc_cnam
     * @return MapField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $pbc_tnam, $pbc_cnam)
    {
        if (($model = MapField::findOne(['user_id' => $user_id, 'pbc_tnam' => $pbc_tnam, 'pbc_cnam' => $pbc_cnam])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
