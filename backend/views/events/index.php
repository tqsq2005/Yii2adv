<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\EventsSearch $searchModel
 */

$this->title = '事件管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="events-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Events', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            //'user_id',
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'options' => [
                    'width' => '20%',
                ],
                'filter' => \kartik\widgets\Select2::widget([
                    //'name'      => 'username',
                    'model'     => $searchModel,
                    'attribute' => 'user_id',
                    'data'      => \yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username'),
                    //'value'     => Yii::$app->user->identity->getId(),
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
                    ],*/
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 3,
                        'allowClear' => true,
                    ],
                ]),
            ],
            'title',
            'data:ntext',
            'time:datetime',
//            'created_at', 
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil" style="cursor: pointer;"></span>', false, [
                            'class' => 'showModalButton',
                            'value' => Yii::$app->urlManager->createUrl(['events/view','id' => $model->id,'edit'=>'t']),
                            'title' => Yii::t('yii', 'Edit'),
                        ]);},
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" style="cursor: pointer;"></span>', false, [
                            'class' => 'showModalButton',
                            'value' => Yii::$app->urlManager->createUrl(['events/view','id' => $model->id]),
                            'title' => Yii::t('yii', 'View'),
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新增', false, [
                'class' => 'showModalButton btn btn-success',
                'value' => \yii\helpers\Url::to(['events/create']),
                'title' => '新增事件',
            ]),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
        //自定义分页
        'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'pager' => [
            'class' => \common\widgets\LinkPager::className(),
            'template' => '{pageButtons} {customPage} {pageSize}',
            //'pageSizeList' => [ 1, 2, 3, 10, 20, 30, 50],
            'pageSizeMargin' => 'margin-left:5px;margin-right:5px;',
            'pageSizeOptions' => ['class' => 'form-control','style' => 'display: inline-block;width:auto;margin-top:0px; margin-bottom: 2px;'],
            'customPageWidth' => 50,
            'customPageBefore' => ' <span class="text-center text-primary" style="margin-left: 10px;"><i class="fa fa-cog fa-lg fa-spin"></i> 跳转至第</span> ',
            'customPageAfter' => ' <span class="text-center text-primary">页 每页显示</span> ',
            'customPageMargin' => 'margin-left:5px;margin-right:5px; ime-mode:disabled; margin-bottom: 2px;',
            //'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;'],
            'firstPageLabel'    => '<span class="fa fa-step-backward" />',
            'prevPageLabel'     => '<span class="fa fa-chevron-left" />',
            'nextPageLabel'     => '<span class="fa fa-chevron-right" />',
            'lastPageLabel'     => '<span class="fa fa-step-forward" />',
            'maxButtonCount'    => 15,//最大按钮数
        ],
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
    //新增完继续新增
    /*$('form#events-form').on('beforeSubmit', function(e) {
        var $form = $(this);
        $.post(
            $form.attr('action'),
            $form.serialize()
        ).done(function(result) {
            console.log(result);
        });
    });*/

</script>
<?php \common\widgets\JsBlock::end(); ?>
