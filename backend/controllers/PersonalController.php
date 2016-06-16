<?php

namespace backend\controllers;

use common\models\Unit;
use Yii;
use common\models\Personal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonalController implements the CRUD actions for Personal model.
 */
class PersonalController extends Controller
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
     * Lists all Personal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Personal::find(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personal model.
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
     * Creates a new Personal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Personal model.
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
     * Deletes an existing Personal model.
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
     * (void) actionSummary : 一个单位或部门的情况概述， eg:总人数为--人，流动人口为--人，已婚男性人数为--人，
     * 已婚女性人数为--人，未婚男性人数 为--人，未婚女性人数为--人，已婚未育--人，已婚育一孩--人，已婚育二孩--人，
     * 近三个月内新入职--人，近三个月内离开单位--人。
     * @param string $unit 单位编码
     */
    public function actionSummary($unit='%')
    {
        //前三个月日期
        $dateThreeMonthAgo = date('Ymd', mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));
        $unitlist = Unit::getChildList($unit);
        //总人数
        $num1 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
            ])
            ->count(1);
        //流动人口
        $num2 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
            ])
            ->andFilterWhere(['<>', 'flag', '01']) //非户籍人口
            ->count(1);
        //已婚男性
        $num3 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'sex' => '01',
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->count(1);
        //已婚女性
        $num4 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'sex' => '02',
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->count(1);
        //未婚男性
        $num5 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'sex' => '01',
                'marry' => '10'//未婚
            ])
            ->count(1);
        //未婚女性
        $num6 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'sex' => '02',
                'marry' => '10'//未婚
            ])
            ->count(1);
        //已婚未育
        $num7 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'childnum' => 0,//无小孩
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->count(1);
        //已婚育一孩
        $num8 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'childnum' => 1,//1孩
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->count(1);
        //已婚育二孩
        $num9 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
                'childnum' => 2,//2孩
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->count(1);
        //已婚育三孩+
        $num10 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
            ])
            ->andFilterWhere(['<>', 'marry', '10']) //已婚
            ->andFilterWhere(['>=', 'childnum', '3']) //已婚
            ->count(1);
        //近三个月内新入职
        $num11 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere([
                'logout' => 0,//在职
            ])
            ->andFilterWhere(['>=', 'ingoingdate', $dateThreeMonthAgo])
            ->count(1);
        //近三个月内离开单位
        $num12 = Personal::find()->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist])
            ->andFilterWhere(['<>', 'logout', 0]) //离职，系统内调动的不算在内
            ->andFilterWhere(['>=', 'e_date', $dateThreeMonthAgo])
            ->count(1);
        $data = "总人数为<span class='text-red'> {$num1} </span>人，流动人口为<span class='text-red'> {$num2} </span>人，已婚男性人数为<span class='text-red'> {$num3} </span>人，已婚女性人数为<span class='text-red'> {$num4} </span>人，" .
            "未婚男性人数 为<span class='text-red'> {$num5} </span>人，未婚女性人数为<span class='text-red'> {$num6} </span>人，已婚未育<span class='text-red'> {$num7} </span>人，已婚育一孩<span class='text-red'> {$num8} </span>人，已婚育二孩<span class='text-red'> {$num9} </span>人，" .
            "已婚育三孩及以上<span class='text-red'> {$num10} </span>人，近三个月内新入职<span class='text-red'> {$num11} </span>人，近三个月内离开单位<span class='text-red'> {$num12} </span>人";
        return $data;
    }

    /**
     * Finds the Personal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Personal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
