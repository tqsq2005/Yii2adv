<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Personal */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
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
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
