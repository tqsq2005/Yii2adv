<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\HelpmenuSearch $searchModel
 */

$this->title = $unitname;
?>
<div class="helpmenu-children">
    <?php Pjax::begin(['id' => 'helpmenu-data']); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'toggleDataOptions' => [
            'all' => [
                'icon' => 'resize-full',
                'label' => '显示全部数据',
                'class' => 'btn btn-default',
                'title' => '显示全部数据'
            ],
            'page' => [
                'icon' => 'resize-small',
                'label' => '显示第一页数据',
                'class' => 'btn btn-default',
                'title' => '显示第一页数据'
            ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'unitcode',
            'unitname',
            'upunitcode',
            'upunitname',
//            'corpflag',
//            'content:ntext',
//            'introduce:ntext',
//            'do_man',
//            ['attribute'=>'do_date','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'do_man_unit',
//            'advise:ntext',
//            'answer',
//            ['attribute'=>'answerdate','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_private',
//            'answercontent:ntext',
//            'created_at',
//            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['helpmenu/view','id' => $model->id,'edit'=>'t']), [
                            'title' => Yii::t('yii', 'Edit'),
                        ]);}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
</div>