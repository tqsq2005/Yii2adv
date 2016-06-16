<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-index">


    <p>
        <?= Html::a('Create Personal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'code1',
                    'name1',
                    'sex',
                    'birthdate',
                    'fcode',
                    // 'mz',
                    // 'marry',
                    // 'marrydate',
                    // 'address1',
                    // 'hkaddr',
                    // 'tel',
                    // 'postcode',
                    // 'hkxz',
                    // 'work1',
                    // 'whcd',
                    // 'is_dy',
                    // 'title',
                    // 'zw',
                    // 'grous',
                    // 'obect1',
                    // 'flag',
                    // 'childnum',
                    // 'unit',
                    // 'jobdate',
                    // 'ingoingdate',
                    // 'memo1',
                    // 'lhdate',
                    // 'zhdate',
                    // 'picture_name',
                    // 'onlysign',
                    // 'selfno',
                    // 'ltunit',
                    // 'ltaddr',
                    // 'ltman',
                    // 'lttel',
                    // 'ltpostcode',
                    // 'memo',
                    // 'cztype',
                    // 'carddate',
                    // 'examinedate',
                    // 'cardcode',
                    // 'fzdw',
                    // 'feeddate',
                    // 'yzdate',
                    // 'checkunit',
                    // 'incity',
                    // 'memo2',
                    // 's_date',
                    // 'logout',
                    // 'e_date',
                    // 'personal_id',
                    // 'do_man',
                    // 'marrowdate',
                    // 'oldunit',
                    // 'leavedate',
                    // 'checktime',
                    // 'audittime',
                    // 'id',
                    // 'created_by',
                    // 'updated_by',
                    // 'created_at',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
