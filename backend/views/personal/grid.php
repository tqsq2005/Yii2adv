<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PreferencesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人档案Grid';
$this->params['breadcrumbs'][] = $this->title;
$sexFilterData = \yii\helpers\ArrayHelper::map(\common\models\Preferences::find()->where(['classmark' => 'psex'])->all(), 'codes', 'name1');
$sumOfId = 0;
if(count($dataProvider->getModels()) > 0) {
    foreach($dataProvider->getModels() as $m) {
        $sumOfId += $m->id;
    }
}
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
        'showFooter' => true,
        //'layout'        => "{summary}\n{items}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '序号',
                'footer' => '<span class="text-primary">小计</span>',
            ],
            [
                'attribute' => 'id',
                'footer' => $sumOfId . '--' . $t_sumOfId,
            ],
            's_date',
            'code1',
            //'sex',
            [
                'attribute' => 'sex',
                'filter' => Html::activeDropDownList($searchModel, 'sex', $sexFilterData, ['prompt' => '--全部--', 'class' => 'form-control']),
            ],
            'name1',
            'birthdate',
            'fcode',
            [
                'header' => '配偶情况',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a('<button class="btn btn-xs btn-primary" type="button">配偶情况<span class="badge">'. $model->marriesCount .'</span></button>', ['marry/grid', 'personal_id' => $model->personal_id, 'id' => $model->id]);
                },
            ],
            /*[
                'header' => 'new..',
                'footer' => 'hsahjdijaidja',
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => '操作',
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
