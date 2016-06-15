<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

/*$Event = new \yii2fullcalendar\models\Event();
$Event->id = 1;
$Event->title = 'Testing';
$Event->start = date('Y-m-d\Th:m:s\Z');
$events[] = $Event;

$Event = new \yii2fullcalendar\models\Event();
$Event->id = 2;
$Event->title = 'Testing';
$Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
$events[] = $Event;*/
$jsEventClick = <<<JS
    function(event, jsEvent, view) {
        /*alert('Event: ' + event.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);*/
        // change the border color just for fun
        $(this).attr('role', 'modal-remote');
        $(this).attr('href', '/admin/event/update/' + event.id);
        $(this).css('border-color', 'red');
        $(this).trigger('click');
    }
JS;

$jsCustomButtons = <<<JS
    {
        addEventButton: {
            text: '添加事件',
            click: function() {
                $(this).attr('role', 'modal-remote');
                $(this).attr('href', '/admin/event/create');
                $(this).trigger('click');
            }
        }
    }
JS;

?>
<div class="event-index">
    <div class="row">
        <?php
        \yii\widgets\Pjax::begin([
            'id' => 'pjax-fullcalendar',
        ]);
        echo \yii2fullcalendar\yii2fullcalendar::widget(array(
            'events'=> $events,
            'clientOptions' => [
                'weekends' => true,
                'defaultView' => 'agendaWeek',
                'editable' => true,
                'selectHelper' => true,
                'customButtons' => new \yii\web\JsExpression($jsCustomButtons),
                'eventClick' => new \yii\web\JsExpression($jsEventClick),
            ],
            'header' => [
                'center'=>'title',
                'left'=>'prev,next today addEventButton',
                'right'=>'month,agendaWeek,agendaDay'
            ],
        )); \yii\widgets\Pjax::end(); ?>
    </div>
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
                    ['role'=>'modal-remote','title'=> 'Create new Events','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Events listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
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
//    $(function() {
//        //console.log($('.fc-day'));
//        $('.fc-day').each(function(index, Element) {
//            $(this).attr('role', 'modal-remote');
//            $(this).attr('href', '/admin/event/create');
//        });
//    });
//    $(document).on('click', '.fc-day', function(e) {
//        //console.log($(this));
//        $(this).attr('role', 'modal-remote');
//        $(this).attr('href', '/admin/event/create');
//    });
//    $('.fullcalendar').fullCalendar({
//        dayClick: function(date, jsEvent, view) {
////            alert('Clicked on: ' + date.format());
////            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
////            alert('Current view: ' + view.name);
////            // change the day's background color just for fun
////            $(this).css('background-color', 'red');
//            $(this).attr('role', 'modal-remote');
//            $(this).attr('href', '/admin/event/create');
//            $(this).trigger('click');
//
//        }
//    });
</script>
<?php \common\widgets\JsBlock::end(); ?>
