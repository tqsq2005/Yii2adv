<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\LogSearch $searchModel
 */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Log', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns'=>true,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'columns' => [
            [
                'class' => \liyunfang\contextmenu\KartikSerialColumn::className(),
                //header' => '序号',
                'contextMenu' => true,
                //'contextMenuAttribute' => 'id',
                //'template' => '{view} {update}',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'urlCreator' => function($action, $model, $key, $index) {
                    if('update' == $action){
                        return Yii::$app->getUrlManager()->createUrl(['/log/update','id' => $model->id]);
                    }
                    if('view' == $action){
                        return Yii::$app->getUrlManager()->createUrl(['/log/view','id' => $model->id]);
                    }
                    return '#';
                },
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                /*'header' => '全选',*/
                'headerOptions' => [
                    'class' => 'text-info text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                    'width' => '5%',
                ],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                }
            ],

            /*[
                'class' => 'yii\grid\SerialColumn',
                'header' => '序号',
                'headerOptions' => [
                    'class' => 'text-info text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center kv-align-center kv-align-middle',
                    'width' => '5%',
                ],
            ],*/

//            'id',
//            'user_id',
            [
                'attribute' => 'user_name',
                'contentOptions' => [
                    'width' => '15%',
                ],
                'filter' => \kartik\widgets\Select2::widget([
                    'model'     => $searchModel,
                    'attribute' => 'user_name',
                    'data'      => \yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'email', 'email'),
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'options'   => [
                        'prompt' => '---请选择需要筛选的用户---',
                    ],
                    /*'addon'         => [
                        'append'    => [
                            'content' => Html::button(\kartik\helpers\Html::icon('fa fa-user-plus', [], ''), [
                                'class' => 'btn btn-primary',
                                'title' => '请选择',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'right',
                            ]),
                            'asButton' => true
                        ]
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 3
                    ],*/
                ]),
            ],
//            'user_ip',
            [
                'attribute' => 'user_ip',
                'contentOptions' => [
                    'width' => '10%',
                ],
            ],
//            'user_agent',
//            'title',
//            'model',
//            'controller',
//            'action',
//            'handle_id', 
//            'result:ntext',
            [
                'attribute' => 'controller',
                'contentOptions' => [
                    'width' => '10%',
                ],
            ],
            [
                'attribute' => 'action',
                'contentOptions' => [
                    'width' => '10%',
                ],
            ],
            [
                'attribute' => 'result',
                //'format' => 'ntext',
                'contentOptions' => [
                    'width' => '20%',
                ],
                'content' => function($model, $key, $index, $column) {
                    $result = \yii\helpers\Json::decode($model->result);
                    //$classname = ucfirst($model->controller);
                    $classname = $model->model;
                    $dirtyAttributes = $result['dirtyAttrs'];
                    $contents = '';
                    if(count($dirtyAttributes)) {
                        $contents .= '<ol>';
                        foreach($dirtyAttributes as $key => $val) {
                            $contents .= "<li>" . (new $classname)->getAttributeLabel($key) . ":{$val}</li>";
                        }
                        $contents .= '</ol>';
                    }
                    return $contents;
                },
            ],
            [
                'attribute' => 'created_at',
                'format'    => 'datetime',
                'contentOptions' => [
                    'width' => '15%',
                ],
            ],
//            'describe:ntext', 
//            'created_at:datetime',
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'width' => '10%',
                ],
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['log/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
            ],
        ],
        'rowOptions' => function($model, $key, $index, $gird){
            $contextMenuId = $gird->columns[0]->contextMenuId;
            return ['data'=>[ 'toggle' => 'context','target'=> "#".$contextMenuId ]];
        },
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
