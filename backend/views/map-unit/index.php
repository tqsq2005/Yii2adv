<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \dektrium\user\models\User */
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>
<div class="map-unit-index">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-asterisk fa-spin"></i>
                        单位列表
                        <div class="pull-right">
                            <i class="fa fa-refresh fa-spin" data-toggle="tooltip" id="unit-refresh" style="cursor: pointer"
                               title="更新单位列表"></i>&nbsp;
                            <i class="fa fa-question-circle" data-toggle="tooltip" id="unit-help" style="cursor: pointer"
                               title="查看帮助"></i>
                        </div>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div id="unit-search" style="margin-bottom: 10px;">
                        <input type="text" value="" style="box-shadow:inset 0 0 4px #eee; width:150px; margin:0; padding:6px 12px; border-radius:4px; border:1px solid silver; font-size:1.1em;"
                               id="unit_q" placeholder="搜索.." />
                    </div>
                    <div id="unit-tree"></div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
</div>
<?php $this->endContent() ?>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        //解决Yii2 modal加载ajax页面导致Jui等widget无法使用
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(window).resize(function () {
            var h = Math.max($(window).height() - 300, 520);
            $('#unit-tree').height(h);
        }).resize();
        //jstree search
        var to = false;
        $('#unit_q').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#unit_q').val();
                $('#unit-tree').jstree(true).search(v);
            }, 250);
        });
        //jstree
        $('#unit-tree')
            .jstree({
                'core' : {
                    'data' : {
                        'url' : '<?= \yii\helpers\Url::to(['tree']) ?>',
                        'data' : function (node) {
                            return { 'id' : node.id };
                        },
                        beforeSend: function () {
                            layer.load();
                        },
                        complete: function () {
                            layer.closeAll('loading');
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.alert('数据加载出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                        }
                    },
                    "multiple" : false,//是否允许多选：默认为 true
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
                'plugins' : ["checkbox", "dnd", "search", "state", "types"],
                'contextmenu': {
                    'items': {
                        "move-up": {
                            "label": "上移",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                var id = obj.id;
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/unit/down/',
                                    type: 'post',
                                    data: { upunitcode : obj.id },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('上移操作出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: function(data) {
                                        layer.msg('已上移..', {icon: 6, time: 1500}, function(index) {
                                            ( typeof(table) == 'object' ) ? table.ajax.reload() : (console.log('已上移..'));
                                        });
                                    }
                                });
                            },
                            "icon": 'fa fa-arrow-up'
                        },
                        "move-down": {
                            "label": "上移",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                var id = obj.id;
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/unit/up/',
                                    type: 'post',
                                    data: { upunitcode : obj.id },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('下移操作出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: function(data) {
                                        layer.msg('已下移..', {icon: 6, time: 1500}, function(index) {
                                            ( typeof(table) == 'object' ) ? table.ajax.reload() : (console.log('已下移..'));
                                        });
                                    }
                                });
                            },
                            "icon": 'fa fa-arrow-down'
                        }
                    }
                }
            })
            .on('create_node.jstree', function (e, data) {
                //'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text
                console.log(data);

            })
            .on('changed.jstree', function (e, data) {
                if(data && data.selected && data.selected.length) {
//                console.log(data);
//                console.log(data.selected);
                    //$.pjax.reload({container:"#unit-data",data: {'unitSearch[upid]':data.selected.join(':')}});
                    //data.selected 是Array类型
                    $('#unit-detail').load('<?= \yii\helpers\Url::to(['/unit/detail']) ?>',
                        { id : data.selected.join(':'), name : data.node.text },
                        function(response, status, xhr) {
                            if (status == 'error') {
                                layer.alert('页面加载出错...', {icon: 6});
                            }
                        });
                } else {
                    $('#unit-detail').load('<?= \yii\helpers\Url::to(['/unit/detail']) ?>',
                        { id : '@', name : '计生管理系统单位列表' },
                        function(response, status, xhr) {
                            if (status == 'error') {
                                layer.alert('页面加载出错...', {icon: 6});
                            }
                        });
                }
            });
        //点击更新单位列表
        $(document)
            .on('click', '#unit-refresh', function() {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('<span class="text-info">即将刷新单位列表，确定吗?</span>', {
                    title: '系统信息',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $('#unit-tree').jstree('refresh');
                    layer.close(index);
                }, function(index) {
                    layer.close(index);
                });
            })
            .on('click', '#unit-help', function(e) {
                var tour = new Tour({
                    duration: 30000,
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
                            element: "#unit-tree",
                            title: "提示一",
                            placement: "top",
                            content: "单位列表区域，右键点击具体单位名称可以进行 新增、修改、删除操作！"
                        },
                        {
                            element: "#unit-refresh",
                            title: "提示二",
                            content: "点击该按钮可以重新加载单位列表！"
                        },
                        {
                            element: "div#unit-search input",
                            title: "提示三",
                            content: "搜索框输入信息，单位列表中如有单位名称与之相匹配，则以红色标识！"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            });


    });

</script>
<?php \common\widgets\JsBlock::end(); ?>
