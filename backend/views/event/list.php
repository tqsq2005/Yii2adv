<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '事件管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
    <?= $this->render('_menu'); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    

<?php 
     $toolbars = [
        ['content' =>
            Html::a('<i class="glyphicon glyphicon-plus"></i>', ['event/create'], ['type' => 'button', 'title' => 'Add ' . $this->title, 'class' => 'btn btn-success']) . ' ' .
            Html::a('<i class="fa fa-file-excel-o"></i>', ['event/parsing'], ['type' => 'button', 'title' => 'Parsing Excel ' . $this->title, 'class' => 'btn btn-warning']) . ' ' .
            Html::button('<i class="fa fa-download"></i>', ['type' => 'button', 'title' => 'Excel Backup ' . $this->title, 'class' => 'btn btn-default','id'=>'backupExcel']) . ' ' .
            Html::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'title' => 'Delete Selected ' . $this->title, 'class' => 'btn btn-danger', 'id' => 'deleteSelected']) . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['event/list','p_reset'=>true], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid']). ' '

            
        ],
        ['content' => '{dynagridFilter}{dynagridSort}{dynagrid}'],
        '{export}',
    ];
    $panels = [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  ' . $this->title . '</h3>',
        'before' => '<div style="padding-top: 7px;"><em>* 右边可以导出各种格式并对表格进行个性化设置</em></div>',
    ];
    $columns = [
        [
            'class' => '\kartik\grid\CheckboxColumn',
            'checkboxOptions' => [
                'class' => 'simple'
            ],
            //'pageSummary' => true,
            'rowSelectedClass' => GridView::TYPE_SUCCESS,
            'headerOptions'=>['class'=>'kartik-sheet-style'],
        ],
        ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],
        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'50px',
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model, $key, $index, $column) {
                //return Yii::$app->controller->renderPartial('_details', ['model'=>$model]);
                return $model->description;
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'expandOneOnly'=>true,
        ],
        //'id',
//        'title',
        //'description',
        [
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>'title',
            'editableOptions'=>[
                //'header'=>'事件标题',
                'inputType'=>\kartik\editable\Editable::INPUT_TEXT,
            ],
            'hAlign'=>'center',
            'vAlign'=>'middle',
        ],
        [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'allDay',
            'vAlign'=>'middle',
            'trueLabel' => '是',
            'falseLabel' => '否',
        ],
        //'allDay',
        [
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>'start',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'width'=>'9%',
            'format'=>'datetime',
            'xlFormat'=>"php:Y-m-d H:i:s",
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column'],
            'filterType'=>GridView::FILTER_DATE,
            'filterWidgetOptions'=>[
                'pluginOptions'=>[
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                ],
            ],
            /*'readonly'=>function($model, $key, $index, $widget) {
                return (!$model->status); // do not allow editing of inactive records
            },*/
            'editableOptions'=>[
                'header'=>'开始时间',
                'size'=>'md',
                'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
                'widgetClass'=> 'kartik\datecontrol\DateControl',
                'options'=>[
                    'type'=>\kartik\datecontrol\DateControl::FORMAT_DATETIME,
                    'displayFormat'=>'php:Y-m-d H:i:s',
                    'saveFormat'=>'php:Y-m-d H:i:s',
                    'options'=>[
                        'pluginOptions'=>[
                            'autoclose'=>true
                        ]
                    ]
                ]
            ],
        ],
        [
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>'end',
            'hAlign'=>'center',
            'vAlign'=>'middle',
            'width'=>'9%',
            'format'=>'datetime',
            'xlFormat'=>"php:Y-m-d H:i:s",
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column'],
            'filterType'=>GridView::FILTER_DATE,
            'filterWidgetOptions'=>[
                'pluginOptions'=>[
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                ],
            ],
            /*'readonly'=>function($model, $key, $index, $widget) {
                return (!$model->status); // do not allow editing of inactive records
            },*/
            'editableOptions'=>[
                'header'=>'开始时间',
                'size'=>'md',
                'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
                'widgetClass'=> 'kartik\datecontrol\DateControl',
                'options'=>[
                    'type'=>\kartik\datecontrol\DateControl::FORMAT_DATETIME,
                    'displayFormat'=>'php:Y-m-d H:i:s',
                    'saveFormat'=>'php:Y-m-d H:i:s',
                    'options'=>[
                        'pluginOptions'=>[
                            'autoclose'=>true
                        ]
                    ]
                ]
            ],
        ],
//        'start',
//        'end',
        'dow',
        'url:url',
        //'className',
        [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'editable',
            'vAlign'=>'middle',
            'trueLabel' => '是',
            'falseLabel' => '否',
        ],
        [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'startEditable',
            'vAlign'=>'middle',
            'trueLabel' => '是',
            'falseLabel' => '否',
        ],
        [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'durationEditable',
            'vAlign'=>'middle',
            'trueLabel' => '是',
            'falseLabel' => '否',
        ],
//        'editable',
//        'startEditable',
//        'durationEditable',
        //'source',
        [
            'attribute'=>'color',
            'value'=>function ($model, $key, $index, $widget) {
                return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" . $model->color . '</code>';
            },
            'width'=>'8%',
            'filterType'=>GridView::FILTER_COLOR,
            'filterWidgetOptions'=>[
                'showDefaultPalette'=>false,
                //'pluginOptions'=>$colorPluginOptions,
            ],
            'vAlign'=>'middle',
            'format'=>'raw',
            'noWrap'=>true
        ],
        [
            'attribute'=>'backgroundColor',
            'value'=>function ($model, $key, $index, $widget) {
                return "<span class='badge' style='background-color: {$model->backgroundColor}'> </span>  <code>" . $model->backgroundColor . '</code>';
            },
            'width'=>'8%',
            'filterType'=>GridView::FILTER_COLOR,
            'filterWidgetOptions'=>[
                'showDefaultPalette'=>true,
                //'pluginOptions'=>$colorPluginOptions,
            ],
            'vAlign'=>'middle',
            'format'=>'raw',
            'noWrap'=>true
        ],
        [
            'attribute'=>'borderColor',
            'value'=>function ($model, $key, $index, $widget) {
                return "<span class='badge' style='background-color: {$model->borderColor}'> </span>  <code>" . $model->borderColor . '</code>';
            },
            'width'=>'8%',
            'filterType'=>GridView::FILTER_COLOR,
            'filterWidgetOptions'=>[
                'showDefaultPalette'=>false,
                //'pluginOptions'=>$colorPluginOptions,
            ],
            'vAlign'=>'middle',
            'format'=>'raw',
            'noWrap'=>true
        ],
        [
            'attribute'=>'textColor',
            'value'=>function ($model, $key, $index, $widget) {
                return "<span class='badge' style='background-color: {$model->textColor}'> </span>  <code>" . $model->textColor . '</code>';
            },
            'width'=>'8%',
            'filterType'=>GridView::FILTER_COLOR,
            'filterWidgetOptions'=>[
                'showDefaultPalette'=>false,
                //'pluginOptions'=>$colorPluginOptions,
            ],
            'vAlign'=>'middle',
            'format'=>'raw',
            'noWrap'=>true
        ],
//        'color',
//        'backgroundColor',
//        'borderColor',
//        'textColor',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign' => 'middle',
            'viewOptions' => ['title' => 'view', 'data-toggle' => 'tooltip'],
            'updateOptions' => ['title' => 'update', 'data-toggle' => 'tooltip'],
            'deleteOptions' => ['title' => 'delete', 'data-toggle' => 'tooltip'],
        ],

    ];
    
    $dynagrid = DynaGrid::begin([
                'id' => 'user-grid',
                'columns' => $columns,
                'theme' => 'panel-primary',
                'showPersonalize' => true,
                'storage' => 'db',
                //'maxPageSize' =>500,
                'allowSortSetting' => true,

                'gridOptions' => [
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showPageSummary' => true,
                    'floatHeader' => true,
                    'pjax' => true,
                    'panel' => $panels,
                    'toolbar' => $toolbars,
                    'hover' => true,
                ],
                'options' => ['id' => 'Event'.Yii::$app->user->identity->id] // a unique identifier is important
    ]);

    DynaGrid::end();
?> </div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(document).on("click", "#backupExcel", function(){
            var myUrl = window.location.href;
            //console.log(myUrl.replace(/index/gi, "excel"));
            location.href=myUrl.replace(/list/gi, "excel");
        });

        $(document).on('click', '#deleteSelected',function(e) {
            var array = "";
            $(".simple").each(function(index){
                if($(this).prop("checked")){
                    array += $(this).val()+",";
                }
            })
            if(array==""){
                //layer.alert("必须选择一项进行删除！");
                layer.alert('没有选中任何记录！', { title : '系统提示', icon : 5, scrollbar: false });
            } else {
                /*if(window.confirm("所选记录将被删除，你确定吗？")){
                    $.ajax({
                        type:"POST",
                        url:"'.Yii::$app->urlManager->createUrl(['event/delete-all']).'",
                        data :{pk:array},
                        success:function(){
                            location.href="";
                        }
                    });
                }*/
                layer.confirm(
                    '所选记录将被删除，你确定吗？',
                    {
                        title : '系统提示',
                        skin: 'layui-layer-molv',
                        shift: 6,
                        icon: 5,
                        scrollbar: false//锁定窗口
                    }, function(index) {
                        //do something
                        /*for (var i = 0; i < keys.length; i++) {
                            alert(keys[i]);
                            //ajax 删除
                        }*/
                        //console.log(array);
                        $.ajax({
                            type:"POST",
                            url: "<?= Yii::$app->urlManager->createUrl(['event/delete-all']); ?>",
                            data :{pk:array},
                            success:function(){
                                layer.msg('事件已删除,如需恢复请在历史事件中还原！', {icon: 6}, function() {
                                    location.href="";
                                });
                            }
                        });
                        layer.close(index);
                    }
                );
            }
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
