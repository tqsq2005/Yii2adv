<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\HelpdocSearch $searchModel
 */

$this->title = '系统使用帮助';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpdoc-index">
    <div class="page-header hidden">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Helpdoc', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>
    <div class="row">
        <div class="col-md-3">
            something
        </div>
        <div class="col-md-9">
            <?php Pjax::begin(); echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class'         => 'yii\grid\CheckboxColumn',
                        // 你可以在这配置更多的属性
                        'header'        => '全选',
                        'headerOptions' => ['class' => 'text-info'],
                        'footer'        => '在底部了',
                    ],
                    [
                        'class'         => 'yii\grid\SerialColumn',
                        'header'        => '序号',
                        'headerOptions' => ['class' => 'text-info'],
                        'footer'        => '总计:' . $dataProvider->totalCount,
                    ],
                    //['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'title',
                    'author',
                    'content:ntext',
                    'status',
//            'upid',
//            'created_at',
//            'updated_at',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['helpdoc/view','id' => $model->id,'edit'=>'t']), [
                                    'title' => Yii::t('yii', 'Edit'),
                                ]);}

                        ],
                    ],
                ],
                'responsive'=>true,
                'hover'=>true,
                'condensed'=>true,
                'floatHeader'=>true,




                'panel' => [
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
                    'type'=>'info',
                    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 添加', ['create'], ['class' => 'btn btn-success']),
                    'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重新排版', ['index'], ['class' => 'btn btn-info']),
                    'showFooter'=>false
                ],
            ]); Pjax::end(); ?>
        </div>
    </div>
</div>
