<?php

namespace backend\controllers;

use common\models\Unit;
use common\populac\models\Preferences;
use Yii;
use common\models\Personal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Personal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personal;

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

    public function actionTest()
    {
        $preferences            = [];
        $preferences['sex']     = Preferences::getByClassmark('psex');
        $preferences['marry']   = Preferences::getByClassmark('pmarry');
        $preferences['flag']    = Preferences::getByClassmark('pflag');
        $preferences['work1']   = Preferences::getByClassmark('pwork1');
        //var_dump(\common\populac\models\ColTable::getByTablename('child'));
        var_dump(\common\populac\models\ColTable::getMissingColumnsByTablenam('personal'));
        return;
        return $this->render('test', [
            'preferences'   => Json::encode($preferences),
        ]);
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
        $name   = Yii::$app->request->post('name', '计生管理系统');
        /*配置参数*/
        $preferences            = [];
        $preferences['sex']     = Preferences::getByClassmark('psex');
        $preferences['marry']   = Preferences::getByClassmark('pmarry');
        $preferences['flag']    = Preferences::getByClassmark('pflag');
        $preferences['work1']   = Preferences::getByClassmark('pwork1');

        return $this->renderAjax('_list', [
            'parent'        => $id,
            'parentName'    => $name,
            'code1'         => Personal::getMaxCode(),//获取最大的6位数字code1
            'preferences'   => Json::encode($preferences),
        ]);
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
                //前三个月日期
                $dateThreeMonthAgo = date('Ymd', mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));
                $unitlist = Unit::getChildList(Yii::$app->request->get('id'));
                $returnData = Personal::find()
                    ->select(['*'])
                    ->where('FIND_IN_SET (unit, :unitlist)', [':unitlist' => $unitlist]);
                //extra_filter
                $extra_filter = Yii::$app->request->get('extra_filter');
                switch($extra_filter) {
                    case "包含历史资料":
                        break;
                    case "流动人口":
                        $returnData->andFilterWhere(['<>', 'flag', '01'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚男性":
                        $returnData->andFilterWhere(['sex' => '01'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚女性":
                        $returnData->andFilterWhere(['sex' => '02'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚人员":
                        $returnData->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "未婚人员":
                        $returnData->andFilterWhere(['marry' => '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "未婚男性":
                        $returnData->andFilterWhere(['sex' => '01'])
                            ->andFilterWhere(['marry' => '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "未婚女性":
                        $returnData->andFilterWhere(['sex' => '02'])
                            ->andFilterWhere(['marry' => '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚未育":
                        $returnData->andFilterWhere(['childnum' => '0'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚育一孩":
                        $returnData->andFilterWhere(['childnum' => '1'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚育二孩":
                        $returnData->andFilterWhere(['childnum' => '2'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "已婚育三孩及以上":
                        $returnData->andFilterWhere(['>=', 'childnum', '3'])
                            ->andFilterWhere(['<>', 'marry', '10'])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "三个月内入职":
                        $returnData->andFilterWhere(['>=', 'ingoingdate', $dateThreeMonthAgo])
                            ->andFilterWhere(['<=', 'logout', 0]);
                        break;
                    case "三个月内离开单位":
                        $returnData->andFilterWhere(['>', 'logout', 0]) //离职，系统内调动的不算在内
                            ->andFilterWhere(['>=', 'e_date', $dateThreeMonthAgo]);
                        break;
                    default:
                        $returnData->andFilterWhere(['<=', 'logout', 0]);
                        break;
                }

                $returnData = $returnData->orderBy([
                    'code1' => SORT_ASC,
                ])->all();
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
     * (void) actionSummary : 一个单位或部门的情况概述.
     * @param string $unit 单位编码
     * @return string
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
            ->andFilterWhere(['>', 'logout', 0]) //离职，系统内调动的不算在内
            ->andFilterWhere(['>=', 'e_date', $dateThreeMonthAgo])
            ->count(1);
        $data = "总人数为<span data-toggle='tooltip' data-filter='无过滤条件' title='总人数' class='text-red p-extra-filter'> {$num1} </span>人，" .
            "流动人口为<span data-toggle='tooltip' data-filter='流动人口' title='流动人口' class='text-red p-extra-filter'> {$num2} </span>人，" .
            "已婚男性人数为<span data-toggle='tooltip' data-filter='已婚男性' title='已婚男性人数' class='text-red p-extra-filter'> {$num3} </span>人，" .
            "已婚女性人数为<span data-toggle='tooltip' data-filter='已婚女性' title='已婚女性人数' class='text-red p-extra-filter'> {$num4} </span>人，" .
            "未婚男性人数为<span data-toggle='tooltip' data-filter='未婚男性' title='未婚男性人数' class='text-red p-extra-filter'> {$num5} </span>人，" .
            "未婚女性人数为<span data-toggle='tooltip' data-filter='未婚女性' title='未婚女性人数' class='text-red p-extra-filter'> {$num6} </span>人，" .
            "已婚未育<span data-toggle='tooltip' data-filter='已婚未育' title='已婚未育' class='text-red p-extra-filter'> {$num7} </span>人，" .
            "已婚育一孩<span data-toggle='tooltip' data-filter='已婚育一孩' title='已婚育一孩' class='text-red p-extra-filter'> {$num8} </span>人，" .
            "已婚育二孩<span data-toggle='tooltip' data-filter='已婚育二孩' title='已婚育二孩' class='text-red p-extra-filter'> {$num9} </span>人，" .
            "已婚育三孩及以上<span data-toggle='tooltip' data-filter='已婚育三孩及以上' title='已婚育三孩及以上' class='text-red p-extra-filter'> {$num10} </span>人，" .
            "近三个月内新入职<span data-toggle='tooltip' data-filter='近三个月内新入职' title='近三个月内新入职' class='text-red p-extra-filter'> {$num11} </span>人，" .
            "近三个月内离开单位<span data-toggle='tooltip' data-filter='近三个月内离开单位' title='近三个月内离开单位' class='text-red p-extra-filter'> {$num12} </span>人";
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
