<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $events backend\models\Event */

$this->title = '日历';
$this->params['breadcrumbs'][] = $this->title;

$jsEventClick = <<<JS
    function(event, jsEvent, view) {
        /*alert('Event: ' + event.title);
        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        alert('View: ' + view.name);*/
        // change the border color just for fun
        //$(this).attr('role', 'modal-remote');
        $(this).addClass('showModalButton');
        $(this).attr('value', '/admin/event/update/' + event.id);
        $(this).attr('title', '添加事件');
        $(this).css('border-color', 'red');
        $(this).trigger('click');
    }
JS;

$jsCustomButtons = <<<JS
    {
        addEventButton: {
            text: '添加事件',
            click: function() {
                $(this).addClass('showModalButton');
                $(this).attr('value', '/admin/event/create');
                $(this).attr('title', '添加事件');
                $(this).trigger('click');
            }
        },
        delEventButton: {
            text: '删除事件',
            click: function() {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.alert('请把 事件 拉到 [删除事件] 按钮区域执行删除操作！', {
                    title: '如何删除事件',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false//锁定窗口
                });
            }
        }
    }
JS;

$jsSelect = <<<JS
    function(start, end) {
        //var title1 = prompt('Event Title:');
        var shiftNum = [0, 1, 2, 3, 4, 5, 6];
        var title = '请设置[' + start.format("DD日 HH:mm") + ' 至 ' + end.format("DD日 HH:mm") + ']事件名！';
        layer.prompt({
            title: title,
            formType: 2, //prompt风格，支持0-2 2：textarea
            maxlength: 100, //可输入文本的最大长度，默认500
            shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
            icon: 6,
            scrollbar: false//锁定窗口
        }, function(title){
            //layer.msg('title：'+ title +' ;start：'+ start.format("YYYY-MM-DD HH:mm:SS") + ';end:' + end.format("YYYY-MM-DD HH:mm:SS"));
            $.ajax({
                url: '/admin/event/create-by-title',
                data: 'type=new&title='+title+'&start='+start.format("YYYY-MM-DD HH:mm:SS")+'&end='+end.format("YYYY-MM-DD HH:mm:SS"),
                type: 'POST',
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    //event.id = data.id;
                    //$('#calendar').fullCalendar('updateEvent',data);
                    if (!data.message) {
                        eventData = {
                            title: data.title,
                            start: data.start,
                            end: data.end
                        };
                        $('.fullcalendar').fullCalendar('renderEvent', eventData, true);
                        layer.closeAll();
                    } else {
                        console.log(data);
                    }
                },
                error: function(e){
                    console.log(e.responseText);
                }
            });
        });
    }
JS;

$jsEventDragStop = <<<JS
    /*var con = confirm('Are you sure to delete this event permanently?');
    if(con == true) {
        $.ajax({
            url: 'process.php',
            data: 'type=remove&eventid='+event.id,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 'success'){
                    $('#calendar').fullCalendar('removeEvents');
                    getFreshEvents();
                }
            },
            error: function(e){
                alert('Error processing your request: '+e.responseText);
            }
        });
    }*/
    function (event, jsEvent, ui, view) {
        console.log(currentMousePos.x);
        console.log(currentMousePos.y);
        if (isElemOverDiv()) {
            layer.confirm('您确定要删除事件['+ event.title +']吗?', function(index){
                //do something

                layer.close(index);
            });
        }
    }
JS;


/*$jsEventResize = <<<JS
    function(event, delta, revertFunc) {
        console.log(event);
        var title = event.title;
        var end = event.end.format();
        var start = event.start.format();
        console.log(event);
        update(title,start,end,event.id);
    }
JS;*/

echo $this->render('_menu');
?>
<div class="fullcalendar-index">
    <div class="row">
        <?php
        \yii\widgets\Pjax::begin([
            'id' => 'pjax-fullcalendar',
        ]);
        echo \yii2fullcalendar\yii2fullcalendar::widget(array(
            'events'=> $events,
            'clientOptions' => [
                'theme' => true,
                'weekends' => true,
                'defaultView' => 'agendaWeek',
                'editable' => true,
                "selectable" => true,
                'selectHelper' => true,
                "droppable" => true,
                'customButtons' => new \yii\web\JsExpression($jsCustomButtons),
                'eventClick' => new \yii\web\JsExpression($jsEventClick),
                'select' => new \yii\web\JsExpression($jsSelect),
                'eventDragStop' => new \yii\web\JsExpression($jsEventDragStop),
                //'eventResize' => new \yii\web\JsExpression($jsEventResize),
            ],
            'header' => [
                'center'=>'title',
                'left'=>'prev,next today addEventButton delEventButton',
                'right'=>'month,agendaWeek,agendaDay'
            ],
        )); \yii\widgets\Pjax::end(); ?>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        var currentMousePos = {
            x: -1,
            y: -1
        };
        jQuery(document).on("mousemove", function (event) {
            currentMousePos.x = event.pageX;
            currentMousePos.y = event.pageY;
        });
        function isElemOverDiv() {
            var trashEl = jQuery('.fc-delEventButton-button');

            var ofs = trashEl.offset();

            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);

            if (currentMousePos.x >= x1-100 && currentMousePos.x <= x2+100 &&
                currentMousePos.y >= y1-50 && currentMousePos.y <= y2+50) {
                return true;
            }
            return false;
        }
    });
//    $(function() {
//        //console.log($('.fc-day'));
//        $('.fc-day').each(function(index, Element) {
//            //$(this).attr('role', 'modal-remote');
//            $(this).addClass('showModalButton');
//            $(this).attr('value', '/admin/event/create');
//            $(this).attr('title', '添加事件');
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
