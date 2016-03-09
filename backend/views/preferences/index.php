<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\PreferencesSearch $searchModel
 */

$this->title = '系统参数配置';
$this->params['breadcrumbs'][] = $this->title;
//设置pageSize
//$dataProvider->pagination->pageSize = 11;
?>
<div class="preferences-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Preferences', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'input[name="per-page"]',
        'id' => 'preferences-gridview',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                /*'header' => '全选',*/
                'headerOptions' => [
                    'class' => 'text-info text-center',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                ],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id];
                }
            ],
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '序号',
                'headerOptions' => [
                    'class' => 'text-info text-center',
                ],
            ],

            'classmarkcn',
            'classmark',
            'name1',
            'codes',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusOptions(), [
                    'prompt' => '----全部----',
                    'class' => 'form-control',
                ]),
                'content' => function ($model, $key, $index, $column) {
                    if($model->status) {
                        return '<span class="fa fa-check text-success" />';
                    } else {
                        return '<span class="fa fa-close text-danger" />';
                    }
                },
                'contentOptions' => [
                    'class' => 'text-center',
                ],
            ],
            //'status',
            //'changemark',
            //'classmark',
            //'id',
//            'classmarkcn', 
//            'status', 
//            'created_at', 
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'headerOptions' => [
                    'class' => 'text-info text-center',
                ],
                'buttons' => [
                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil" style="cursor: pointer;"></span>',
                                            false,
                                            [
                                                'class' => 'showModalButton',
                                                'title' => '修改系统参数',
                                                'value' => Yii::$app->urlManager->createUrl(['preferences/update','id' => $model->id]),
                                                //'value' => Yii::$app->urlManager->createUrl(['preferences/view','id' => $model->id,'edit'=>'t']),
                                            ]);},
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" style="cursor: pointer;"></span>',
                            false,
                            [
                                'class' => 'showModalButton',
                                'title' => '查看系统参数',
                                'value' => Yii::$app->urlManager->createUrl(['preferences/view','id' => $model->id]),
                                //'value' => Yii::$app->urlManager->createUrl(['preferences/view','id' => $model->id,'edit'=>'t']),
                            ]);}
                ],
                'contentOptions' => [
                    'class' => 'text-center',
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', false, [
                'class' => 'showModalButton btn btn-success',
                'value' => \yii\helpers\Url::to(['preferences/create', 'create-classmark' => Yii::$app->request->get('create-classmark')]),
                'title' => '新增系统参数',
            ]) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
            Html::a('<i class="fa fa-lg fa-cog fa-spin"></i> 当前每页显示 <strong>'.Yii::$app->request->get('per-page', 20).'</strong> 条记录 请点击设置', false, [
                'class' => 'per-page-set btn btn-info',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => '请点击设置每页显示记录数',
            ]),
            'after'=>Html::a('<i class="fa fa-warning"></i> 删除选中列', ['delcolumn'], ['class' => 'delcolumn btn btn-danger']) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
                Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
                '<input type="hidden" class="per-page-size-set" name="per-page" value='. Yii::$app->request->get('per-page', 20) .'>',
            'showFooter'=>false,
        ],
        //自定义分页
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭自带分页
            'firstPageLabel'    => '<span class="fa fa-step-backward" />',
            'prevPageLabel'     => '<span class="fa fa-chevron-left" />',
            'nextPageLabel'     => '<span class="fa fa-chevron-right" />',
            'lastPageLabel'     => '<span class="fa fa-step-forward" />',
            'maxButtonCount'    => 15,//最大按钮数
        ],
        //自定义行的颜色状态 bootstrap table
        //.active	鼠标悬停在行或单元格上时所设置的颜色
        //.success	标识成功或积极的动作
        //.info	标识普通的提示信息或动作
        //.warning	标识警告或需要用户注意
        //.danger	标识危险或潜在的带来负面影响的动作
        'rowOptions' => function ($model, $key, $index, $grid) {
            if(!$model->status) {
                return [
                    'class' => 'danger',
                ];
            } /*else {
                return [
                    'class' => 'info',
                ];
            }*/
        },
    ]); Pjax::end(); ?>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    //js获取get参数
    function GetUrlParms()
    {
        var args=new Object();
        var query=location.search.substring(1);//获取查询串
        var pairs=query.split("&");//在逗号处断开
        for(var i=0;i<pairs.length;i++)
        {
            var pos=pairs[i].indexOf('=');//查找name=value
            if(pos==-1)   continue;//如果没有找到就跳过
            var argname=pairs[i].substring(0,pos);//提取name
            var value=pairs[i].substring(pos+1);//提取value
            args[argname]=unescape(value);//存为属性
        }
        return args;
    }
    //preferences-create输入classmark自动显示`已存在的clssmarkcn`
    $(document).on('blur', '#preferences-classmark', function() {
        $.post('<?= \yii\helpers\Url::to(['preferences/getclassmarkcn']); ?>',
            { classmark : $(this).val() },
            function(data) {
                $('#preferences-classmarkcn').val(data);
            }
        );
    });

    $(document).on('click', '.per-page-set', function(e) {
        var args = new Object();
        args = GetUrlParms();
        var pagesize = 20;
        if (args['per-page']) {
            pagesize = args['per-page'];
        }
        layer.prompt({
            title: '请输入每页显示的记录数',
            name: 'per-page-size-set',
            skin: 'layui-layer-molv',
            //shift: 6,
            icon: 6,
            value : pagesize,
            scrollbar: false,//锁定窗口
            formType: 0 //prompt风格，支持0-2  0-input=text  1-input=password  2-input=textarea
        }, function(value, index, elem){
            //设置per-page值并触发onChange事件
            $('input[name="per-page"]').val(value);
            $('input[name="per-page"]').trigger('change');
            layer.close(index);
        });
    });

    $(document).on('click', '.delcolumn', function(e) {
        var keys = $('#preferences-gridview').yiiGridView('getSelectedRows');
        //console.log(keys);
        if(keys.length > 0) {
            layer.confirm(
                '确定要删除选中的列吗？',
                {
                    title : '系统提示',
                    skin: 'layui-layer-molv',
                    shift: 6,
                    icon: 5,
                    scrollbar: false//锁定窗口
                }, function(index) {
                    //do something
                    for (var i = 0; i < keys.length; i++) {
                        alert(keys[i]);
                        //ajax 删除
                    }
                    layer.close(index);
                }
            );
        } else {
            layer.alert('没有选中任何列！', { title : '系统提示', icon : 5, scrollbar: false });
        }
        e.preventDefault();
    });
</script>
<?php \common\widgets\JsBlock::end(); ?>
