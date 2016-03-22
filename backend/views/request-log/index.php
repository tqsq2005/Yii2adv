<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\dynagrid\DynaGrid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\RequestLogSearch $searchModel
 */

$this->title = '用户访问记录';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    //['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
    [
        'class'=>'kartik\grid\SerialColumn',
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'36px',
        'header'=>'序号',
        'headerOptions'=>['class'=>'kartik-sheet-style text-primary']
    ],
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'width'=>'50px',
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail'=>function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('_details', ['model'=>$model]);
        },
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'expandOneOnly'=>true,
    ],
    [
        'attribute' => 'user_id',
        'content' => function($model, $key, $index, $column) {
            $userdata = \dektrium\user\models\User::findOne($model->user_id);
            if($userdata)
                return $userdata->username;
            else
                return '';
        },
        'vAlign'=>GridView::ALIGN_MIDDLE,
        'hAlign' => GridView::ALIGN_CENTER,
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=>\yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'---请选择用户---'],
        'format'=>'raw'
    ],
//    'app_id',
    //'route',
    [
        'attribute' => 'route',
        'vAlign'=>GridView::ALIGN_MIDDLE,
        'hAlign' => GridView::ALIGN_LEFT,
    ],
    [
        'attribute' => 'params',
        'vAlign'=>GridView::ALIGN_MIDDLE,
        'hAlign' => GridView::ALIGN_LEFT,
    ],
    //'params:ntext',
    //'user_id',

//    'ip',
//    'datetime',
//    'user_agent',
    [
        'attribute'=>'datetime',
        'filterType'=>GridView::FILTER_DATE,
        'format'=>'raw',
        'width'=>'170px',
        'vAlign'=>GridView::ALIGN_MIDDLE,
        'hAlign' => GridView::ALIGN_CENTER,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['format'=>'yyyy-mm-dd']
        ],
    ]
];
?>
<div class="request-log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Request Log', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo DynaGrid::widget([
        'columns'=>$columns,
        'storage'=>DynaGrid::TYPE_COOKIE,
        'theme'=>'panel-info',
        'showPersonalize'=>true,
        'gridOptions'=>[
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
            //'floatHeader'=>true,
            //'pjax'=>true,
            'panel'=>['heading'=>'<h3 class="panel-title">' . $this->title . '</h3>'],
            'toolbar' =>  [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'重新加载'])
                ],
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
    ]); Pjax::end(); ?>

</div>
