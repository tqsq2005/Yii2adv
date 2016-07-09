<?php

/* @var $this yii\web\View */
/* @var $user \dektrium\user\models\User */
$css = <<<CSS
.jstree-contextmenu-label{ font-size: 14px; font-weight: 700; }
ol > li { font-size: 16px !important; line-height: 24px !important; color: #1a1a1c !important; }
CSS;
$this->registerCss($css);

$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>
<div class="map-field-index">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-asterisk fa-spin"></i>
                        字段权限列表
                        <div class="pull-right">
                            <i class="fa fa-refresh fa-spin" data-toggle="tooltip" id="field-refresh" style="cursor: pointer"
                               title="更新字段权限列表"></i>&nbsp;
                            <i class="fa fa-question-circle" data-toggle="tooltip" id="field-help" style="cursor: pointer"
                               title="查看帮助"></i>
                        </div>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div id="field-search" style="margin-bottom: 10px;">
                        <input type="text" value="" style="box-shadow:inset 0 0 4px #eee; width:150px; margin:0; padding:6px 12px; border-radius:4px; border:1px solid silver; font-size:1.1em;"
                               id="unit_q" placeholder="搜索.." />
                    </div>
                    <div id="field-tree"></div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <h3 class="panel-title">
                            <i class="glyphicon glyphicon-th-list"></i>
                            字段权限
                            <div class="pull-right">
                                <i class="fa fa-question-circle" data-toggle="tooltip" id="map-field-help" style="cursor: pointer"
                                   title="查看帮助"></i>
                            </div>
                        </h3>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="box box-solid" id="map-field-help-text">
                        <div class="box-header with-border ">
                            <i class="fa fa-info-circle text-success"></i>
                            <h3 class="box-title text-success">操作提示</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ol>
                                <li id="field-detail">当前未选中任何『信息』</li>
                                <li>字段名称点击鼠标右键：
                                    <ol>
                                        <li><span class="text-success"><i class="fa fa-key"></i> 完全访问</span>:将设置该字段的权限为『完全访问』。 </li>
                                        <li><span class="text-info"><i class="fa fa-eye-slash"></i> 新增后查看访问</span>:将设置该字段的权限为『新增后查看访问』。 </li>
                                        <li><span class="text-primary"><i class="fa fa-eye"></i> 查看访问</span>:将设置该字段的权限为『查看访问』。 </li>
                                        <li><span class="text-muted"><i class="fa fa-lock"></i> 禁止访问</span>:将设置该字段的权限为『禁止访问』。 </li>
                                    </ol>
                                </li>
                                <li>鼠标右键且选择了相关权限后，系统会弹出『字段权限设置成功，是否需要刷新字段权限列表？』提示：
                                    <ol>
                                        <li>如需在字段权限列表上看到最新的权限请点击『确定』</li>
                                        <li>如需继续设置字段权限请点击『取消』</li>
                                    </ol>
                                </li>
                                <li>字段权限列表颜色说明：
                                    <ol>
                                        <li><span class="text-success"><i class="fa fa-key"></i> 字段名称</span>:表示当前字段的权限为『完全访问』。 </li>
                                        <li><span class="text-info"><i class="fa fa-eye-slash"></i> 新增后查看访问</span>:表示当前字段的权限为『新增后查看访问』。 </li>
                                        <li><span class="text-primary"><i class="fa fa-eye"></i> 字段名称</span>:表示当前字段的权限为『查看访问』。 </li>
                                        <li><span class="text-muted"><i class="fa fa-lock"></i> 字段名称</span>:表示当前字段的权限为『禁止访问』。 </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        //解决Yii2 modal加载ajax页面导致Jui等widget无法使用
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        //禁止鼠标拖拽
        document.ondragstart = function() { return false; };
        $(window).resize(function () {
            var h = Math.max($(window).height() - 300, 520);
            $('#field-tree').height(h);
        }).resize();
        //jstree search
        var to = false;
        $('#unit_q').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#unit_q').val();
                $('#field-tree').jstree(true).search(v);
            }, 250);
        });
        //ajax success
        var f_success = function(data) {
            if ( data == '权限不足,请向主管单位申请！' ) {
                layer.msg( data, { icon: 5, time: 2000, shift: 6 } );
            } else {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('字段权限设置成功，是否需要刷新字段权限列表？', {
                    title: '系统提示',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $('#field-tree').jstree('refresh');
                    layer.close(index);
                });
            }
        };
        //jstree
        $('#field-tree')
            .jstree({
                'core' : {
                    'data' : {
                        'url' : '<?= \yii\helpers\Url::to(['tree', 'user_id' => $user->id]) ?>',
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
                'plugins' : ["contextmenu", "search", "state", "types"],
                'contextmenu': {
                    'items': {
                        "permissionAllow": {
                            "label": "<span class='jstree-contextmenu-label text-success'>完全访问</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( id.indexOf('gdjs') < 0 ) {
                                    layer.msg('(' + id +')' + text + ' 类型为『表』,请在其『字段』中设置权限..', { icon: 5, time: 2000 });
                                    return false;
                                }
                                if ( text.indexOf('text-success') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『完全访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-field/permission/',
                                    type: 'post',
                                    data: { permission: 99, id: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置字段权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-key text-success'
                        },
                        "permissionViewAfterAdd": {
                            "label": "<span class='jstree-contextmenu-label text-primary'>新增后查看访问</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( id.indexOf('gdjs') < 0 ) {
                                    layer.msg('(' + id +')' + text + ' 类型为『表』,请在其『字段』中设置权限..', { icon: 5, time: 2000 });
                                    return false;
                                }
                                if ( text.indexOf('text-info') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『新增后查看访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-field/permission/',
                                    type: 'post',
                                    data: { permission: 9, id: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置字段权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-eye-slash text-info'
                        },
                        "permissionView": {
                            "label": "<span class='jstree-contextmenu-label text-primary'>查看访问</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( id.indexOf('gdjs') < 0 ) {
                                    layer.msg('(' + id +')' + text + ' 类型为『表』,请在其『字段』中设置权限..', { icon: 5, time: 2000 });
                                    return false;
                                }
                                if ( text.indexOf('text-primary') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『查看访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-field/permission/',
                                    type: 'post',
                                    data: { permission: 1, id: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置字段权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-eye text-primary'
                        },
                        "permissionDeny": {
                            "label": "<span class='jstree-contextmenu-label text-muted'>禁止访问</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( id.indexOf('gdjs') < 0 ) {
                                    layer.msg('(' + id +')' + text + ' 类型为『表』,请在其『字段』中设置权限..', { icon: 5, time: 2000 });
                                    return false;
                                }
                                if ( text.indexOf('text-muted') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『禁止访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-field/permission/',
                                    type: 'post',
                                    data: { permission: 0, id: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置字段权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-lock text-muted'
                        },
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
                    //$.pjax.reload({container:"#field-data",data: {'unitSearch[upid]':data.selected.join(':')}});
                    //data.selected 是Array类型
                    var info = data.selected.join('<br>');
                    $('#field-detail').html('当前『选中』为：(<span class="text-danger">'+ data.selected.join(',') +'</span>) ' + data.node.text);
                } else {
                    $('#field-detail').html('当前未选中任何『字段』');
                }
            });
        //点击更新字段权限列表
        $(document)
            .on('click', '#field-refresh', function() {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('<span class="text-info">即将刷新字段权限列表，确定吗?</span>', {
                    title: '系统信息',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $('#field-tree').jstree('refresh');
                    layer.close(index);
                }, function(index) {
                    layer.close(index);
                });
            })
            .on('click', '#field-help', function(e) {
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
                            element: "#field-tree",
                            title: "提示一",
                            placement: "top",
                            content: "字段权限列表区域，右键点击具体单位名称可以进行 权限设置操作！"
                        },
                        {
                            element: "#field-refresh",
                            title: "提示二",
                            content: "点击该按钮可以重新加载字段权限列表！"
                        },
                        {
                            element: "div#field-search input",
                            title: "提示三",
                            content: "搜索框输入信息，字段权限列表中如有单位名称与之相匹配，则以红色标识！"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            })
            .on('click', '#map-field-help', function(e) {
                var tour = new Tour({
                    duration: 10000,
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
                            element: "#map-field-help-text",
                            title: "字段权限设置帮助",
                            placement: "top",
                            content: "查看操作提示，这边有字段权限设置的详细介绍！"
                        },
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            });;


    });

</script>
<?php \common\widgets\JsBlock::end(); ?>
