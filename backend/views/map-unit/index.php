<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-5 上午11:45
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;

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
<div class="map-unit-index">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-asterisk fa-spin"></i>
                        单位权限列表
                        <div class="pull-right">
                            <i class="fa fa-refresh fa-spin" data-toggle="tooltip" id="unit-refresh" style="cursor: pointer"
                               title="更新单位权限列表"></i>&nbsp;
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
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <h3 class="panel-title">
                            <i class="glyphicon glyphicon-th-list"></i>
                            单位权限
                            <div class="pull-right">
                                <i class="fa fa-question-circle" data-toggle="tooltip" id="map-unit-help" style="cursor: pointer"
                                   title="查看帮助"></i>
                            </div>
                        </h3>
                    </h3>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="box box-solid" id="map-unit-help-text">
                        <div class="box-header with-border ">
                            <i class="fa fa-info-circle text-success"></i>
                            <h3 class="box-title text-success">操作提示</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ol>
                                <li id="unit-detail">当前未选中任何『单位(部门)』</li>
                                <li>单位(部门)名称点击鼠标右键：
                                    <ol>
                                        <li><span class="text-success"><i class="fa fa-key"></i> 完全访问[含下级]</span>:将设置该单位(部门)及其下级的权限为『完全访问』，其上级的权限为『查看访问单位』。 </li>
                                        <li><span class="text-success"><i class="fa fa-key"></i> 完全访问[当前节点]</span>:将仅设置当前单位(部门)的权限为『完全访问』。 </li>
                                        <li><span class="text-primary"><i class="fa fa-eye"></i> 查看访问单位及人员</span>:将设置该单位(部门)及其下级的权限为『查看访问单位及人员』。 </li>
                                        <li><span class="text-info"><i class="fa fa-eye-slash"></i> 查看访问单位</span>:将仅设置当前单位(部门)的权限为『查看访问单位』。 </li>
                                        <li><span class="text-muted"><i class="fa fa-lock"></i> 禁止访问</span>:将设置该单位(部门)及其下级的权限为『禁止访问』。 </li>
                                    </ol>
                                </li>
                                <li>鼠标右键且选择了相关权限后，系统会弹出『单位权限设置成功，是否需要刷新单位权限列表？』提示：
                                    <ol>
                                        <li>如需在单位权限列表上看到最新的权限请点击『确定』</li>
                                        <li>如需继续设置单位权限请点击『取消』</li>
                                    </ol>
                                </li>
                                <li>单位权限列表颜色说明：
                                    <ol>
                                        <li><span class="text-success"><i class="fa fa-key"></i> 单位(部门)名称</span>:表示当前单位(部门)的权限为『完全访问』。 </li>
                                        <li><span class="text-primary"><i class="fa fa-eye"></i> 单位(部门)名称</span>:表示当前单位(部门)的权限为『查看访问单位及人员』。 </li>
                                        <li><span class="text-info"><i class="fa fa-eye-slash"></i> 单位(部门)名称</span>:表示当前单位(部门)的权限为『查看访问单位』。 </li>
                                        <li><span class="text-muted"><i class="fa fa-lock"></i> 单位(部门)名称</span>:表示当前单位(部门)的权限为『禁止访问』。 </li>
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
        //ajax success
        var f_success = function(data) {
            if ( data == '权限不足,请向主管单位申请！' ) {
                layer.msg( data, { icon: 5, time: 2000, shift: 6 } );
            } else {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('单位权限设置成功，是否需要刷新单位权限列表？', {
                    title: '系统提示',
                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                    icon: 6,
                    scrollbar: false
                }, function(index) {
                    $('#unit-tree').jstree('refresh');
                    layer.close(index);
                });
            }
        };
        //jstree
        $('#unit-tree')
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
                            "label": "<span class='jstree-contextmenu-label text-success'>完全访问[含下级]</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( text.indexOf('text-success') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『完全访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-unit/permission/',
                                    type: 'post',
                                    data: { permission: 99, unitcode: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置单位权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-key text-success'
                        },
                        "permissionAllowSingle": {
                            "label": "<span class='jstree-contextmenu-label text-success'>完全访问[当前节点]</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( text.indexOf('text-success') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『完全访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-unit/permission/',
                                    type: 'post',
                                    data: { permission: 99, type: 'single', unitcode: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置单位权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-key text-success'
                        },
                        "permissionViewAll": {
                            "label": "<span class='jstree-contextmenu-label text-primary'>查看访问单位及人员</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( text.indexOf('text-primary') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『查看访问单位及人员』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-unit/permission/',
                                    type: 'post',
                                    data: { permission: 9, unitcode: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置单位权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-eye text-primary'
                        },
                        "permissionViewDept": {
                            "label": "<span class='jstree-contextmenu-label text-info'>查看访问单位</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( text.indexOf('text-info') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『查看访问单位』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-unit/permission/',
                                    type: 'post',
                                    data: { permission: 1, unitcode: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置单位权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                    },
                                    success: f_success
                                });
                            },
                            "icon": 'fa fa-eye-slash text-info'
                        },
                        "permissionDeny": {
                            "label": "<span class='jstree-contextmenu-label text-muted'>禁止访问</span>",
                            "action": function (data) {
                                var inst    = $.jstree.reference(data.reference),
                                    obj     = inst.get_node(data.reference);
                                var id      = obj.id;
                                var text    = obj.text;
                                if ( text.indexOf('text-muted') > 0 ) {
                                    layer.msg('(' + id +')' + text + ' 的权限已经是『禁止访问』了..', { icon: 6, time: 2000 });
                                    return false;
                                }
                                $.ajax({
                                    url: '<?=Yii::$app->homeUrl?>/map-unit/permission/',
                                    type: 'post',
                                    data: { permission: 0, unitcode: obj.id, user_id: <?= $user->id ?> },
                                    beforeSend: function () {
                                        layer.load();
                                    },
                                    complete: function () {
                                        layer.closeAll('loading');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        layer.alert('设置单位权限出错:' + textStatus + ' ' + errorThrown, {icon: 5});
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
                    //$.pjax.reload({container:"#unit-data",data: {'unitSearch[upid]':data.selected.join(':')}});
                    //data.selected 是Array类型
                    var info = data.selected.join('<br>');
                    $('#unit-detail').html('当前『单位(部门)』为：(<span class="text-danger">'+ data.selected.join(',') +'</span>) ' + data.node.text);
                } else {
                    $('#unit-detail').html('当前未选中任何『单位(部门)』');
                }
            });
        //点击更新单位权限列表
        $(document)
            .on('click', '#unit-refresh', function() {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                layer.confirm('<span class="text-info">即将刷新单位权限列表，确定吗?</span>', {
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
                            content: "单位权限列表区域，右键点击具体单位名称可以进行 权限设置操作！"
                        },
                        {
                            element: "#unit-refresh",
                            title: "提示二",
                            content: "点击该按钮可以重新加载单位权限列表！"
                        },
                        {
                            element: "div#unit-search input",
                            title: "提示三",
                            content: "搜索框输入信息，单位权限列表中如有单位名称与之相匹配，则以红色标识！"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            })
            .on('click', '#map-unit-help', function(e) {
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
                            element: "#map-unit-help-text",
                            title: "单位权限设置帮助",
                            placement: "top",
                            content: "查看操作提示，这边有单位权限设置的详细介绍！"
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
