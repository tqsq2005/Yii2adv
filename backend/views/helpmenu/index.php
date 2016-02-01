<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\HelpmenuSearch $searchModel
 */

$this->title = '系统使用帮助';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<div class="helpmenu-index container-fluid" role="main">
    <div class="page-header hidden">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Helpmenu', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <h3 class="panel-title"><i class="fa fa-asterisk fa-spin"></i> 系统帮助目录 </h3>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div id="helpmenu-tree"></div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-md-9">
            <?php Pjax::begin(['id' => 'helpmenu-data']); echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'hover' => true,
                'toggleDataOptions' => [
                    'all' => [
                        'icon' => 'resize-full',
                        'label' => '显示全部数据',
                        'class' => 'btn btn-default',
                        'title' => '显示全部数据'
                    ],
                    'page' => [
                        'icon' => 'resize-small',
                        'label' => '显示第一页数据',
                        'class' => 'btn btn-default',
                        'title' => '显示第一页数据'
                    ],
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'unitcode',
                    'unitname',
                    'upunitcode',
                    'upunitname',
//            'corpflag',
//            'content:ntext',
//            'introduce:ntext',
//            'do_man',
//            ['attribute'=>'do_date','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'do_man_unit',
//            'advise:ntext',
//            'answer',
//            ['attribute'=>'answerdate','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_private',
//            'answercontent:ntext',
//            'created_at',
//            'updated_at',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['helpmenu/view','id' => $model->id,'edit'=>'t']), [
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
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        $(window).resize(function () {
            var h = Math.max($(window).height() - 300, 420);
            $('#helpmenu-tree').height(h);
        }).resize();
    });
    $('#helpmenu-tree')
        .jstree({
            'core' : {
                'data' : {
                    'url' : '<?= \yii\helpers\Url::to(['helpmenu/treenode']) ?>',
                    'data' : function (node) {
                        return { 'unitcode' : node.id };
                    }
                },
                'check_callback' : true,
                'themes' : {
                    'responsive' : false
                },
                'types' : {
                    'default' : { 'icon' : 'fa fa-folder' },
                    'file' : { 'valid_children' : [], 'icon' : 'fa fa-file' }
                }
            },
            'force_text' : true,
            'plugins' : ['state','dnd','contextmenu']
        }).on('changed.jstree', function (e, data) {
            if(data && data.selected && data.selected.length) {
                /*$.get('<?= \yii\helpers\Url::to(['helpmenu/index']) ?>?HelpmenuSearch[upunitcode]=' + data.selected.join(':'), function (d) {
                    //console.log(d);
                    //$('#treeview1 .default').html(d.text).show();
                });*/
                //console.log(data);
                //console.log(data.selected);
                $.pjax.reload({container:"#helpmenu-data",data: {'HelpmenuSearch[upunitcode]':data.selected.join(':')}});

            }
        });
</script>
<?php \common\widgets\JsBlock::end(); ?>
