<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HelpdocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统使用帮助';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="helpdoc-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> '新增帮助','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'刷新']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Helpdocs listing',
                'before'=>'<em>* 表格间距可以自由调整.</em>',
                'after'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; 删除所有选中',
                        ["bulk-delete"] ,
                        [
                            "class"=>"btn btn-danger btn-xs",
                            'role'=>'modal-remote-bulk',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-confirm-title'=>'您确定吗?',
                            'data-confirm-message'=>'您确定要删除这条信息吗？'
                        ]).
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
