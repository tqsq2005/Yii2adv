<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;
/* @var $this yii\web\View */
/* @var $searchModel bedezign\yii2\audit\models\AuditTrailSearch */
/* @var $dataProvider bedezign\yii2\audit\models\AuditTrail */

$this->title = '历史事件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
    <?= $this->render('_menu'); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    

<?php 
     $toolbars = [
        ['content' =>
            Html::button('<i class="fa fa-question-circle"></i> 操作指引', ['type' => 'button', 'title' => '操作指引-' . $this->title, 'class' => 'btn btn-warning', 'id' => 'helpButton']) . '&nbsp;&nbsp;' .
            Html::button('<i class="fa fa-history"></i> 恢复记录', ['type' => 'button', 'title' => '恢复记录-' . $this->title, 'class' => 'btn btn-success', 'id' => 'retrieveSelected']) . '&nbsp;&nbsp;' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['event/history','p_reset'=>true], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid']). ' '

            
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
            'width'=>'5%',
        ],
        [
            'class' => 'kartik\grid\SerialColumn',
            'order' => DynaGrid::ORDER_FIX_LEFT,
            'width' => '5%',
        ],
        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'5%',
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model, $key, $index, $column) {
                //return Yii::$app->controller->renderPartial('_details', ['model'=>$model]);
                return $model->old_value;
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'],
            'expandOneOnly'=>true,
        ],
        [
            'attribute'=>'model_id',
            'header' => '事件ID',
            'headerOptions'=>['class'=>'text-primary'],
            'vAlign' => 'middle',
            'hAlign'=>'center',
            //'value' => $auditdata->model_id ? Html::a($auditdata->model_id, ['audit/entry/view', 'id' => $auditdata->entry_id]) : '',
            'value' => function ($model, $key, $index, $column) {
                return $model->model_id ? Html::a($model->model_id, ['audit/entry/view', 'id' => $model->entry_id], ['target' => '_blank']) : '';
            },
            'format'=>'raw',
            'width'=>'6%',
        ],
        [
            'attribute'=>'user_id',
            'header' => '操作人员',
            'headerOptions'=>['class'=>'text-primary'],
            'vAlign' => 'middle',
            'hAlign'=>'center',
            'value' => function ($model, $key, $index, $column) {
                return \dektrium\user\models\User::findOne($model->user_id)->username;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>\yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->orderBy('username')->asArray()->all(), 'id', 'username'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'操作人员'],
            'format'=>'raw',
            'width'=>'10%',
        ],
        [
            'attribute'=>'created',
            'header' => '删除时间',
            'headerOptions'=>['class'=>'text-primary'],
            'vAlign' => 'middle',
            'hAlign'=>'center',
            'filterType'=>GridView::FILTER_DATE,
            'filterWidgetOptions'=>[
                'pluginOptions'=>[
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                ],
            ],
            'format' => 'datetime',
            'width'=>'15%',
        ],
        [
            'attribute'=>'old_value',
            'header' => '删除内容',
            'headerOptions'=>['class'=>'text-primary'],
            'vAlign' => 'middle',
            //'hAlign'=>'center',
            'format' => 'raw',
            'width'=>'54%',
            'content' => function ($model, $key, $index, $column) {
                return "<div class='event_old_value'>{$model->old_value}</div>";
            },
        ]
    ];
    
    $dynagrid = DynaGrid::begin([
                'id' => 'event-history-grid',
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
                'options' => ['id' => 'Event-history-'.Yii::$app->user->identity->id] // a unique identifier is important
    ]);

    DynaGrid::end();
?> </div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function(){
            /*var content = "<ul>恢复操作指引<li><font color='red'>删除内容</font>中输入内容筛选</li><li>点击复选框选中需要恢复的记录</li><li>点击按钮恢复记录</li></ul>";
            layer.msg(content, {
                shift: 0,
                icon: 6,
                time: 20000
            });*/
            $('.event_old_value').slimScroll({
                height: '40px',
                width: '600px'
            });
        });

        $(document).on('click', '#helpButton', function(e) {
            var tour = new Tour({
                duration: 3000,
                backdrop: true,
                template: "<div class='popover tour'>" +
                "<div class='arrow'></div>" +
                "<h3 class='popover-title'></h3>" +
                "<div class='popover-content'></div>" +
                "<div class='popover-navigation'>" +
                "<button class='btn btn-default' data-role='prev'><i class='fa fa-hand-o-left'></i>前</button>" +
                "<span data-role='separator'>|</span>" +
                "<button class='btn btn-default' data-role='next'><i class='fa fa-hand-o-right'></i>后</button>" +
                "<button class='btn btn-default' data-role='end'>结束</button>" +
                "</div>" +
                "</div>",
                steps: [
                    {
                        element: "input[name='AuditTrailSearch[old_value]']",
                        title: "第一步",
                        placement: "bottom",
                        content: "输入需要恢复的信息筛选！"
                    },
                    {
                        element: "input[name='selection_all']",
                        title: "第二步",
                        content: "点击复选框选中需要恢复的记录！"
                    },
                    {
                        element: "#retrieveSelected",
                        placement: "bottom",
                        title: "最后",
                        content: "点击按钮<恢复记录>！"
                    }
                ]});

            // Initialize the tour
            tour.init();

            // Start the tour
            tour.restart();
        });

        $(document).on('click', '#retrieveSelected',function(e){
            console.log(111);
            var array = "";
            var data = [];
            $(".simple").each(function(index){
                if($(this).prop("checked")){
                    array += $(this).val()+",";
                    data.push($(this).parents('tr').find('div.event_old_value').html());
                }
            });
            if(array==""){
                layer.alert('没有选中任何记录！', { title : '系统提示', icon : 5, scrollbar: false });
            } else {
                layer.confirm(
                    '将恢复所选记录，确定吗？',
                    {
                        title : '系统提示',
                        skin: 'layui-layer-molv',
                        shift: 6,
                        icon: 6,
                        scrollbar: false//锁定窗口
                    }, function(index) {
                        $.ajax({
                            type: "POST",
                            url: "<?= Yii::$app->urlManager->createUrl(['event/retrieve']); ?>",
                            data: {oldEvent:data},
                            success: function(response){
                                var resData = $.parseJSON(response);
                                if (resData.status == 'success') {
                                    layer.msg(resData.message, {icon: 6, time: 6000, title: '5秒后将跳转至日历界面'}, function() {
                                        location.href="<?= Yii::$app->urlManager->createUrl(['event/index']); ?>";
                                    });
                                }
                            },
                            error: function(e){
                                console.log(e.responseText);
                            }
                        });
                        layer.close(index);
                    }
                );
            }
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
