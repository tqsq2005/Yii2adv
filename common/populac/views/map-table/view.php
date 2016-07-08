<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\populac\models\MapTable */
?>
<div class="map-table-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tname',
            'cnname',
            'memo',
            'order_num',
            //'status',
            [
                'attribute' => 'status',
                'value' => $model->status ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-remove text-danger"></i>',
                'format' => 'html',
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => Yii::$app->user->identity->findIdentity($model->created_by) ? Yii::$app->user->identity->findIdentity($model->created_by)->username : '未知',
                'format' => 'raw',
            ],
            [
                'attribute' => 'updated_by',
                'value' => Yii::$app->user->identity->findIdentity($model->updated_by) ? Yii::$app->user->identity->findIdentity($model->updated_by)->username : '未知',
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
