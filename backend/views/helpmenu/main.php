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
        <div class="col-md-9 helpmenu-detail">

        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        $(window).resize(function () {
            var h = Math.max($(window).height() - 300, 520);
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
            'plugins' : ['state','dnd']
        })
        .on('changed.jstree', function (e, data) {
            if(data && data.selected && data.selected.length) {
//                console.log(data);
//                console.log(data.selected);
                //$.pjax.reload({container:"#helpmenu-data",data: {'HelpmenuSearch[upunitcode]':data.selected.join(':')}});
                $('.helpmenu-detail').load('<?= \yii\helpers\Url::to(['detail']) ?>',
                    { unitcode : data.selected, unitname : data.node.text },
                    function(response, status, xhr) {
                    if (status == 'error') {
                        layer.alert('页面加载出错...', {icon: 6});
                    }
                });
            }
        });
</script>
<?php \common\widgets\JsBlock::end(); ?>
