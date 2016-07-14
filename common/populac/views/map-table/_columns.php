<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'attribute'=>'tname',
        'width'=> '80px',
        'content' => function ($model, $key, $index, $column) {
            return \yii\helpers\Html::a($model->tname, Url::to(['update', 'id' => $model->id]), [
                'data-toggle' => 'tooltip',
                'data-original-title' => '修改『'.$model->cnname.'』表信息',
                'role' => 'modal-remote',
                'data-pjax' => '0'
            ]);
        }
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'cnname',
        'width'=> '120px',
        'editableOptions'=>[
            'header'=>'表中文名',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'memo',
        'editableOptions'=>[
            'header'=>'备注',
            'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
        ],
    ],
    [
        'attribute'=>'order_num',
        'width'=> '120px',
        'content' => function ($model, $key, $index, $column) {
            return '<span class="label label-primary">序号：'. $model->order_num .'</span> '
            .\yii\helpers\Html::a('<i class="fa fa-arrow-up text-success" style="cursor: pointer;"></i>', Url::to(['up', 'id' => $model->id]), [
                'data-toggle' => 'tooltip',
                'data-original-title' => '上移',
                'role' => 'modal-remote',
                'data-pjax' => '0',
                'data-request-method' => 'post'
            ]) . ' '
            . \yii\helpers\Html::a('<i class="fa fa-arrow-down text-success" style="cursor: pointer;"></i>', Url::to(['down', 'id' => $model->id]), [
                'data-toggle' => 'tooltip',
                'data-original-title' => '下移',
                'role' => 'modal-remote',
                'data-pjax' => '0',
                'data-request-method' => 'post'
            ]);
        }
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'status',
        'vAlign'=>'middle',
        'trueLabel' => '开启',
        'falseLabel' => '禁用',
        'content' => function ($model, $key, $index, $column) {
            $icon = '<i class="fa fa-toggle-off fa-lg text-gray" style="cursor: pointer;"></i>';
            $text = '当前『禁用』，点击可开启';
            $url  = Url::to(['on', 'id' => $model->id]);
            if( $model->status == \common\populac\models\MapTable::STATUS_ON ) {
                $icon = '<i class="fa fa-toggle-on fa-lg text-teal" style="cursor: pointer;"></i>';
                $text = '当前『开启』，点击可禁用';
                $url  = Url::to(['off', 'id' => $model->id]);
            }
            return \yii\helpers\Html::a($icon, $url, [
                'data-toggle' => 'tooltip',
                'data-original-title' => $text,
                'role' => 'modal-remote',
                'data-pjax' => '0',
                'data-request-method' => 'post'
            ]);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view} {delete}',//{view} {update} {delete}
        'viewOptions'=>['role'=>'modal-remote','title'=>'查看','data-toggle'=>'tooltip'],
        //'updateOptions'=>['role'=>'modal-remote','title'=>'更新', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'删除',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'系统提示?',
                          'data-confirm-message'=>'删除该条记录，确定吗？'],
    ],

];   