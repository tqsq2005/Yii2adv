<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Personals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <p>
        <?php /* echo Html::a('Create Personal', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code1',
            'name1',
            'sex',
            'birthdate',
            'fcode',
//            'mz', 
//            'marry', 
//            'marrydate', 
//            'address1', 
//            'hkaddr', 
//            'tel', 
//            'postcode', 
//            'hkxz', 
//            'work1', 
//            'whcd', 
//            'is_dy', 
//            'title', 
//            'zw', 
//            'grous', 
//            'obect1', 
//            'flag', 
//            'childnum', 
//            'unit', 
//            'jobdate', 
//            'ingoingdate', 
//            'memo1', 
//            'lhdate', 
//            'zhdate', 
//            'picture_name', 
//            'onlysign', 
//            'selfno', 
//            'ltunit', 
//            'ltaddr', 
//            'ltman', 
//            'lttel', 
//            'ltpostcode', 
//            'memo', 
//            'cztype', 
//            'carddate', 
//            'examinedate', 
//            'cardcode', 
//            'fzdw', 
//            'feeddate', 
//            'yzdate', 
//            'checkunit', 
//            'incity', 
//            'memo2', 
//            's_date', 
//            'logout', 
//            'e_date', 
//            'personal_id', 
//            'do_man', 
//            'marrowdate', 
//            'oldunit', 
//            'leavedate', 
//            'checktime', 
//            'audittime', 
//            'id', 
//            'created_by', 
//            'updated_by', 
//            'created_at', 
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['personal/view','id' => $model->id,'edit'=>'t']), [
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
