<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PreferencesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统参数配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preferences-index">

    <div class="callout callout-success lead">
        <span>
            <i class="fa fa-wrench"></i>
            <?= Html::encode($this->title) ?>
        </span>
        <span class="pull-right">"{summary}"</span>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加系统参数', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel'   => $searchModel,
        'layout'        => "{summary}\n{items}\n{pager}",
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

            'classmarkcn',
            'classmark',
            'name1',
            'codes',
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class'         => 'yii\grid\ActionColumn',
                'header'        => '操作',
                'headerOptions' => ['class' => 'text-info'],
            ],
            [
                'label'=>'更多操作',
                'format'=>'raw',
                'value' => function($data) {
                    $url = "http://www.baidu.com";
                    return Html::a('添加权限组', $url, ['title' => '审核']);
                }
            ],
        ],
        'pager' => [
            'firstPageLabel'    => '首页',
            'lastPageLabel'     => '尾页',
            'prevPageLabel'     => '<span class="fa fa-chevron-left"></span>',
            'nextPageLabel'     => '<span class="fa fa-chevron-right"></span>',
            'maxButtonCount'    => 10,
        ],
    ]); ?>

</div>
