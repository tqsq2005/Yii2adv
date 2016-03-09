<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis acipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PreferencesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '配偶信息';
$this->params['breadcrumbs'][] = $this->title;
/*$personalFilterData = \yii\helpers\ArrayHelper::map(\backend\models\Personal::find()->all(), 'personal_id', function($model, $defaultValue) {
    return sprintf('配偶姓名：%s', $model->name1);
});*/

//$personalFilterData = \yii\helpers\ArrayHelper::map(\backend\models\Personal::find()->all(), 'personal_id', 'name1');
?>
<div class="personal-grid">

    <div class="callout callout-success lead">
        <span>
            <i class="fa fa-wrench"></i>
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider'  => $dataProvider,
        'filterModel' => $searchModel,
        'layout'        => "{summary}\n{items}\n{pager}",
        'columns' => [
            'marrow',
            'marrowdate',
            'because',
            'becausedate',
            'mfcode',
            [
                'header' => '个人情况',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a($model->personal->name1, ['personal/view', 'id' => $model->personal->id, 'name1' => $model->personal->name1]);
                },
                //'filter' => Html::activeDropDownList($searchModel, 'personal_id', $personalFilterData, ['prompt' => '--全部--']),
            ],
            [
                'header' => '员工姓名',
                'attribute' => 'personal_id',
                'value' => 'personal.name1',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => '操作',
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
