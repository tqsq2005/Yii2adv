<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\RequestLogSearch;

class RequestLogController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestLogSearch;
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
