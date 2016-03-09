<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Personal $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-view">
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
            'code1',
            'name1',
            'sex',
            'birthdate',
            'fcode',
            'mz',
            'marry',
            'marrydate',
            'address1',
            'hkaddr',
            'tel',
            'postcode',
            'hkxz',
            'work1',
            'whcd',
            'is_dy',
            'title',
            'zw',
            'grous',
            'obect1',
            'flag',
            'childnum',
            'unit',
            'jobdate',
            'ingoingdate',
            'memo1',
            'lhdate',
            'zhdate',
            'picture_name',
            'onlysign',
            'selfno',
            'ltunit',
            'ltaddr',
            'ltman',
            'lttel',
            'ltpostcode',
            'memo',
            'cztype',
            'carddate',
            'examinedate',
            'cardcode',
            'fzdw',
            'feeddate',
            'yzdate',
            'checkunit',
            'incity',
            'memo2',
            's_date',
            'logout',
            'e_date',
            'personal_id',
            'do_man',
            'marrowdate',
            'oldunit',
            'leavedate',
            'checktime',
            'audittime',
            'id',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
