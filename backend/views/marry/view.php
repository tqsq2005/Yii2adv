<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Marry $model
 */

$this->title = $model->mid;
$this->params['breadcrumbs'][] = ['label' => 'Marries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marry-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'code1',
            'marrow',
            'because',
            'becausedate',
            'mfcode',
            'mhkdz',
            'marrowdate',
            'marrowunit',
            'othertel',
            'hfp',
            'maddr',
            'mpostcode',
            'marrowno',
            'hmarry',
            'marrycode',
            'mem',
            'unit',
            'personal_id',
            'do_man',
            'mid',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->mid],
            'data'=>[
                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
