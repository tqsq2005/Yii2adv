<?php

/* @var $this yii\web\View */
/* @var $events backend\models\Event */
/* @var $todayEventNum integer 当天事件数 */

\common\assets\FullcalendarAsset::register($this);
$this->title = '日历';
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_menu');
?>
<div class="fullcalendar-index">
    <div class="row">
        <?php
        \yii\widgets\Pjax::begin([
            'id' => 'pjax-fullcalendar',
        ]);
        ?>
        <div id="populac-fullcalendar" style="margin: 0px 15px;"></div>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        var zone = "08:00";  //Change this to your timezone
        $.ajax({
            url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
            type: 'POST', // Send post data
            data: 'type=fetch',
            async: false,//是否异步请求，默认为true(异步) false则为同步
            success: function(data){
                json_events = data;
            }
        });
        var currentMousePos = {
            x: -1,
            y: -1
        };
        jQuery(document).on("mousemove", function (event) {
            currentMousePos.x = event.pageX;
            currentMousePos.y = event.pageY;
        });
        /* initialize the calendar
         -----------------------------------------------------------------*/

        $('#populac-fullcalendar').fullCalendar({
            events: JSON.parse(json_events),
            theme: true,
            timezone: 'Asia/Shanghai',
            header: {
                left: 'prev,next today addEventButton delEventButton retrieveEventButton',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true,
            selectable: true,
            selectHelper:true,
            slotDuration: '00:30:00',
            contentHeight: 600,
            weekends: true,//默认值为true true：显示周末， false：隐藏周末
            defaultView: "agendaWeek",
            customButtons: {
                addEventButton: {
                    text: '添加事件',
                    click: function() {
                        $(this).addClass('showModalButton');
                        $(this).attr('value', '<?= Yii::getAlias('@web'); ?>/event/create');
                        $(this).attr('title', '添加事件');
                        $(this).trigger('click');
                    }
                },
                delEventButton: {
                    text: '删除事件',
                    click: function() {
                        var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                        var message = '事件区域点击鼠标右键，选择“删除”或按快捷键“d”执行删除操作！';//请把 事件 拉到 [删除事件] 按钮区域执行删除操作！
                        layer.alert(message, {
                            title: '如何删除事件',
                            shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                            icon: 6,
                            scrollbar: false//锁定窗口
                        });
                    }
                },
                retrieveEventButton: {
                    text: '恢复事件',
                    click: function() {
                        var shiftNum = [0, 1, 2, 3, 4, 5];
                        layer.msg('即将跳转至[历史事件]界面..', {icon: 6, time: 4000}, function() {
                            location.href="<?= Yii::$app->urlManager->createUrl(['event/history']); ?>";
                        });
                    }
                }
            },
            //事件渲染后响应的动作
            eventRender: function(event, element) {
                //添加eventID到element,方便jquery-contextMenu对Event的操作
                element.append("<div style='display: none;' id='eventID'>" + event.id + "</div>");
                element.qtip({
                    id: event.id,
                    content: {
                        text: '时间：' + event.start.format("DD日 HH:mm") + ' 至 ' + (event.end ? event.end.format("DD日 HH:mm") : event.start.format("DD日 HH:mm")) + '<br><br>内容：' + (event.description ? event.description : '<span class="text-warning"><i class="fa fa-spinner fa-pulse fa-fw"></i> 无事件详情，请点击设置！</span>'),
                        title: {
                            //button: true,
                            text: '<img src="<?= Yii::getAlias('@web'); ?>/images/js16.png" /> ' + event.title
                        }
                    },
                    //show: { ready: true },
                    //hide: false,
                    //show: 'click',
                    show: {
                        effect: function() {
                            //$(this).slideDown();
                            $(this).fadeTo(500, 1);
                        }
                    },
                    hide: {
                        //Stay visible when mousing onto tooltip
                        fixed: true,
                        delay: 200,
                        effect: function() {
                            $(this).hide('puff', 300);
                        }
                    },
                    position: {
                        at: 'right center', //center center
                        my: 'left center',
                        container: $('#populac-fullcalendar')
                    },
                    style: {
                        widget: true,
                        classes: 'qtip-ui'
                    }
                });
                //影响时间衡度准确性
                //$('.fc-title').css('font-size', '1.25em');
                //$('.fc-time').css('font-size', '1.25em');
            },
            //点击事件更新
            eventClick: function(event, jsEvent, view) {
             /*$(this).addClass('showModalButton');
                $(this).attr('value', '<?= Yii::getAlias('@web'); ?>/event/update/' + event.id);
                $(this).attr('title', '修改事件');
                $(this).css('border-color', 'red');
                $(this).trigger('click');*/
                //$(this).removeClass('showModalButton');
            },
            //添加事件
            select: function(start, end) {
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
                        url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                        data: 'type=newByClick&title='+title+'&start='+start.format("YYYY-MM-DD HH:mm:SS")+'&end='+end.format("YYYY-MM-DD HH:mm:SS"),
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
                                    end: data.end,
                                    id: data.id
                                };
                                layer.msg('事件 <'+ data.title +'> 添加成功！', {icon: 6});
                                $('#populac-fullcalendar').fullCalendar('renderEvent', eventData, true);
                                //layer.closeAll();
                            } else {
                                console.log(data);
                            }
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                });
            },
            //事件拖动到 事件回收站 的区域则执行移除操作
            /*eventDragStop: function (event, jsEvent, ui, view) {
                if (isElemOverDiv()) {
                    var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                    layer.confirm('<span class="text-danger">您确定要删除事件[ '+ event.title +' ]吗?</span>', {
                        title: '删除事件<b>'+ event.title +'</b>',
                        shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                        icon: 2,
                        scrollbar: false
                    }, function(index){
                        $.ajax({
                            url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                            data: 'type=remove&eventid='+event.id,
                            type: 'POST',
                            dataType: 'json',
                            success: function(response){
                                //console.log(response);
                                if(response.status == 'success'){
                                    layer.msg("事件已删除,如需恢复请点击<front color='red'>恢复事件</front>！", {icon: 6}, function() {
                                        $('#populac-fullcalendar').fullCalendar('removeEvents');
                                        getFreshEvents();
                                    });
                                }
                            },
                            error: function(e){
                                alert('Error processing your request: '+e.responseText);
                            }
                        });
                        layer.close(index);
                    });
                }
            },*/
            //事件调整结束且事件的时间点确实发生变更的时候触发
            eventResize: function(event, delta, revertFunc) {
                var eventid = event.id;
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('<span class="text-info">事件[ '+ event.title +' ]的开始时间调整为 ' + event.start.format("DD日 HH:mm") +' 结束时间调整为 ' + event.end.format("DD日 HH:mm") +', 确定吗？</span>', {
                    title: '调整事件-<b>'+ event.title +'</b>',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $.ajax({
                        url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                        data: 'type=resize&eventid='+eventid+'&start='+event.start.format("YYYY-MM-DD HH:mm:SS")+'&end='+event.end.format("YYYY-MM-DD HH:mm:SS"),
                        type: 'POST',
                        dataType: 'json',
                        success: function(data){
                            if (!data.message) {
                                eventData = {
                                    title: data.title,
                                    start: data.start,
                                    end: data.end,
                                    id: data.id
                                };
                                layer.msg('事件 <'+ data.title +'> 更新成功！', {icon: 6});
                                $('#populac-fullcalendar').fullCalendar('updateEvent', eventData);
                            } else {
                                console.log(data);
                            }
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                    layer.close(index);
                }, function(index) {
                    revertFunc();
                    layer.close(index);
                });
            },
            //事件拖拽结束后触发
            eventDrop: function(event, delta, revertFunc) {
                var eventid = event.id;
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('<span class="text-info">事件[ '+ event.title +' ]的开始时间调整为 ' + event.start.format("DD日 HH:mm") +' 结束时间调整为 ' + event.end.format("DD日 HH:mm") +', 确定吗？</span>', {
                    title: '调整事件-<b>'+ event.title +'</b>',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $.ajax({
                        url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                        data: 'type=resize&eventid='+eventid+'&start='+event.start.format("YYYY-MM-DD HH:mm:SS")+'&end='+event.end.format("YYYY-MM-DD HH:mm:SS"),
                        type: 'POST',
                        dataType: 'json',
                        success: function(data){
                            if (!data.message) {
                                eventData = {
                                    title: data.title,
                                    start: data.start,
                                    end: data.end,
                                    id: data.id
                                };
                                layer.msg('事件 <'+ data.title +'> 更新成功！', {icon: 6});
                                $('#populac-fullcalendar').fullCalendar('updateEvent', eventData);
                            } else {
                                console.log(data);
                            }
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                    layer.close(index);
                }, function(index) {
                    revertFunc();
                    layer.close(index);
                });
            }

        });
        //重载所有 事件 到日历
        function getFreshEvents(){
            $.ajax({
                url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function(data){
                    freshevents = data;
                }
            });
            $('#populac-fullcalendar').fullCalendar('addEventSource', JSON.parse(freshevents));
        }
        //划定 事件回收站 的区域
        /*function isElemOverDiv() {
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
        }*/
        //修改 事件名 的字体大小；测试发现影响时间衡度准确性
//        $('.fc-title').css('font-size', '1.25em');
//        $('.fc-time').css('font-size', '1.25em');
        $('.fc-today-button').html('<span class="label label-success"><?= $todayEventNum ?></span> 今天');
        $('.fc-addEventButton-button').html('<i class="fa fa-calendar-plus-o"></i> 添加事件');
        $('.fc-delEventButton-button').html('<i class="fa fa-calendar-times-o"></i> 删除事件');
        $('.fc-retrieveEventButton-button').html('<i class="fa fa-history"></i> 恢复事件');

        //event 绑定jquery-contextMenu
        $.contextMenu({
            selector: 'a.fc-event',
            //trigger: 'left',
            callback: function(key, options) {
                var eventID = $(this).find('div#eventID').text();
                var eventTitle = $(this).find('div.fc-title').text();
                console.log(key)
                switch (key) {
                    case 'edit':
                        $(this).addClass('showModalButton');
                        $(this).attr('value', '<?= Yii::getAlias('@web'); ?>/event/update/' + eventID);
                        $(this).attr('title', '修改事件');
                        $(this).css('border-color', 'red');
                        $(this).trigger('click');
                        $(this).removeClass('showModalButton');
                        break;
                    case 'delete':
                        var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                        layer.confirm('<span class="text-danger">您确定要删除事件[ '+ eventTitle +' ]吗?</span>', {
                            title: '删除事件-<b>'+ eventTitle +'</b>',
                            shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                            icon: 2,
                            scrollbar: false
                        }, function(index){
                            $.ajax({
                                url: '<?= Yii::getAlias('@web'); ?>/event/index-ajax-data',
                                data: 'type=remove&eventid='+eventID,
                                type: 'POST',
                                dataType: 'json',
                                success: function(response){
                                    if(response.status == 'success'){
                                        layer.msg("事件已删除,如需恢复请点击<front color='red'>恢复事件</front>！", {icon: 6}, function() {
                                            $('#populac-fullcalendar').fullCalendar('removeEvents');
                                            getFreshEvents();
                                        });
                                    }
                                },
                                error: function(e){
                                    alert('Error processing your request: '+e.responseText);
                                }
                            });
                            layer.close(index);
                        });
                        break;
                    case "history":
                        var url = '<?= Yii::$app->urlManager->createUrl([""])?>'
                        window.open(url, '_blank');
                        break;
                    default:
                        layer.msg('插件jquery-contextMenu遇到未知错误！参数信息：' + key);
                }
            },
            items: {
                "edit": {name: "修改 [e]", icon: "edit", accesskey: "e"},
                "sep1": "---------",
                "delete": {name: "删除 [d]", icon: "delete", accesskey: "d"},
                "sep2": "---------",
                "history": {
                    name: "操作记录 [h]",
                    icon: "paste",
                    accesskey: "h"
                }
            }
        });
    });
</script>
<?php \common\widgets\JsBlock::end(); ?>
