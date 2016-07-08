<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\populac\models\MapTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统表信息';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$js = <<<JS
$.fn.modal.Constructor.prototype.enforceFocus = function() {};
JS;
$this->registerJs($js);

?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <div class="map-table-index">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax'=>true,
                    'pjaxSettings'=>[
                        'loadingCssClass' => false,//禁用 kv-grid-loading
                    ],
                    'columns' => require(__DIR__.'/_columns.php'),
                    'toolbar'=> [
                        ['content'=>
                            Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                                ['role'=>'modal-remote','title'=> '新增表信息','class'=>'btn btn-default']).
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                                ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'刷新表格', 'data-toggle' => 'tooltip']).
                            '{toggleData}'.
                            '{export}'
                        ],
                    ],
                    'resizableColumns'=>true,//列宽可调整
                    'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'panel' => [
                        'type' => 'info',
                        'heading' => '<i class="glyphicon glyphicon-list"></i> 系统表明细',
                        'after'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; 删除所选',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'系统提示?',
                                    'data-confirm-message'=>'删除所选记录，确定吗？'
                                ]).
                            '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
