<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-13 下午2:46
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * @var yii\web\View $this
 * @var integer $iSearchColNum
 */

$this->title = '单位管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <div class="unit-index container-fluid" role="main">
            <div class="row">
                <div class="col-md-3">
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
                <div class="col-md-9 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <h3 class="panel-title">
                                    <i class="glyphicon glyphicon-th-list"></i>
                                    资料列表
                                    <div class="pull-right">
                                        <i class="fa fa-search" data-toggle="tooltip" id="dagl-info-list-search" style="cursor: pointer"
                                           title="多功能查询"></i>&nbsp;
                                        <i class="fa fa-question-circle" data-toggle="tooltip" id="dagl-info-list-help" style="cursor: pointer"
                                           title="查看帮助"></i>
                                    </div>
                                </h3>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="unit-detail"></div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="btn-view-adv-search" tabindex="-1">
    <div class="modal-dialog" style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-info">多功能查询:输入值如果要输入多个，输入逗号、空格或回车键会自动隔开 <i id="btn-view-adv-search-help" class="fa fa-question-circle text-warning" data-toggle="tooltip" title="点击查看帮助" style="cursor: pointer"></i></h4>
            </div>
            <form id="btn-view-adv-search-form">
                <div class="modal-body">
                    <?php for( $i = 0; $i < $iSearchColNum; $i++ ): ?>
                        <div class="row row-<?=$i?>" style="margin: 5px 0;">
                            <div class="col-md-1 col-left">
                                <?= \kartik\widgets\Select2::widget([
                                    'name'      => 'left-' . $i,
                                    'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'data'      => \common\populac\models\Preferences::getByClassmark('tLeft'),
                                    'value'     => '',
                                    'options'   => [
                                        'prompt' => '',
                                        'title' => '如需要选择左括号，请选择..'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                                    ]
                                ]);?>
                            </div>
                            <div class="col-md-3 col-field">
                                <?= \kartik\widgets\Select2::widget([
                                    'name'      => 'field-' . $i,
                                    'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'data'      => \common\populac\models\ColTable::getColumnInfoByTablename('personal'),
                                    'value'     =>  ($i==0) ? 'personal.unit' : (($i==1) ? 'personal.logout' : (($i==2) ? 'personal.name1' : '')),
                                    'options'   => [
                                        'prompt' => '过滤条件',
                                        'class'  => 'field-select',
                                        'data-classname' => 'select-value-' . $i,
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ]
                                ]);?>
                            </div>
                            <div class="col-md-2 col-choose">
                                <?= \kartik\widgets\Select2::widget([
                                    'name'      => 'choose-' . $i,
                                    'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'data'      => \common\populac\models\Preferences::getByClassmark('tChoose'),
                                    'value'     => 'like',
                                    'options'   => [
                                        'multiple'  => false,
                                        'class'     => 'choose-select-' . $i,
                                    ],
                                    'pluginOptions' => [
                                        'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                                    ]
                                ]);?>
                            </div>
                            <div class="col-md-4 col-value">
                                <select disabled class="value-select select-value-<?=$i?>" name="value-<?=$i?>" multiple="multiple" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-1 col-right">
                                <?= \kartik\widgets\Select2::widget([
                                    'name'      => 'right-' . $i,
                                    'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'data'      => \common\populac\models\Preferences::getByClassmark('tRight'),
                                    'options'   => [
                                        'prompt' => '',
                                        'title' => '如需要选择右括号，请选择..'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                                    ]
                                ]);?>
                            </div>
                            <div class="col-md-1 col-relation">
                                <?= \kartik\widgets\Select2::widget([
                                    'name'      => 'relation-' . $i,
                                    'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                                    'data'      => \common\populac\models\Preferences::getByClassmark('tRelation'),
                                    'value'     => 'and',
                                    'options'   => [
                                        'multiple'  => false,
                                    ],
                                    'pluginOptions' => [
                                        'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                                    ]
                                ]);?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                    <button type="button" class="btn btn-primary" id="btn-view-adv-search-relation">确 定</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
                'plugins' : ["contextmenu", "dnd", "search", "state", "types"],
                'contextmenu': {
                    'items': {
                        "create": {
                            "label": "新增",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                obj = inst.get_node(data.reference);
                                var id = obj.id;
                                var text = obj.text;
                                var a_Obj = $('#' + obj.a_attr.id);

                                a_Obj.addClass('showModalButton');
                                a_Obj.attr('value', '<?= Yii::getAlias('@web'); ?>/unit/create?parentId=' + id + '&parentName=' + text );
                                a_Obj.attr('title', '添加 [' + text + '] 的子级单位(部门)');
                                a_Obj.trigger('click');
                                a_Obj.removeClass('showModalButton');
                            },
                            "icon": 'fa fa-plus'
                        },
                        "rename": {
                            "label": "修改",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                var id = obj.id;
                                var text = obj.text;
                                var a_Obj = $('#' + obj.a_attr.id);

                                a_Obj.addClass('showModalButton');
                                a_Obj.attr('value', '<?= Yii::getAlias('@web'); ?>/unit/update/' + id );
                                a_Obj.attr('title', '修改单位(部门) [' + text + '] 信息');
                                a_Obj.trigger('click');
                                a_Obj.removeClass('showModalButton');
                            },
                            "icon": 'fa fa-pencil'
                        },
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
                        },
                        "remove": {
                            "label": "删除",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                var id = obj.id;
                                var text = obj.text;
                                var a_Obj = $('#' + obj.a_attr.id);

                                layer.confirm('删除单位(部门)：『'+ text +'['+ id +']』，确定吗？', {
                                    title: '系统提示',
                                    shift: 6,
                                    icon: 5,
                                    scrollbar: false
                                }, function(index) {
                                    $.ajax({
                                        url: '<?=Yii::$app->homeUrl?>/unit/delete/',
                                        type: 'post',
                                        data: { unitcode: id },
                                        beforeSend: function () {
                                            layer.load(1);
                                        },
                                        complete: function () {
                                            layer.closeAll('loading');
                                        },
                                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                                            layer.alert('删除单位(部门)出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                                        },
                                        success: function() {
                                            var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                                            layer.confirm('单位(部门)：『'+ text +'['+ id +']』已删除，是否需要刷新单位列表？', {
                                                title: '系统提示',
                                                shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                                                icon: 6,
                                                scrollbar: false
                                            }, function(index) {
                                                $('#unit-tree').jstree('refresh');
                                                layer.close(index);
                                            });
                                        }
                                    });
                                    layer.close(index);
                                });
                            },
                            "icon": 'fa fa-trash-o'
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
        //btn-view-adv-search
        $('.field-select').on("select2:select", function (e) {
            if ( !($(this).val()) )
                return false;
            var $fieldSelect = $('.' + $(this).attr('data-classname'));
            var params = $(this).val();
            var classmark = params.split('.')[1];
            //var $chooseSelect = $('.choose-select-' + ($(this).attr('name')).split('-')[1]);

            $.ajax({
                url: '<?= Yii::$app->homeUrl ?>/populac/col-table/get-field-config',
                data: { params : params },
                type: 'post',
                beforeSend: function () {
                    layer.load();
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('数据读取出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                },
                success: function(data) {
                    $fieldSelect.prop("disabled", false);
                    if ( data ) {
                        //$chooseSelect.select2().val('in').trigger("change");
                        //$fieldSelect.select2('destroy');//先销毁
                        //$fieldSelect.attr('multiple', 'multiple');//设置为可多选
                        $fieldSelect.html('');//清空之前的选项
                        $fieldSelect.select2({
                            data: $.parseJSON(data)
                        });
                        if ( classmark == 'logout' )//注销原因
                            $fieldSelect.select2().val("0").trigger("change");
                    } else {
                        $fieldSelect.html('');//清空之前的选项
                        //$fieldSelect.select2('destroy');//先销毁
                        $fieldSelect.select2({
                            //data: [{id:0, text: '..'}],
                            placeholder: '输入值',
                            tags: true,//tagging support
                            tokenSeparators: [',', '，', ' '],//输入 ',' 或 '空格'的时候自动生成 tag
                        });
                    }
                }
            });
        });
        //modal shown event: loading col-value's config data
        var i_modal_shown = 0;
        $('#btn-view-adv-search').on('shown.bs.modal', function (e) {
            if ( !i_modal_shown++ )
            {
                $(".value-select").select2({
                    placeholder: '输入值',
                    tags: true,//tagging support
                    tokenSeparators: [',', '，', ' '],//输入 ',' 或 '空格'的时候自动生成 tag
                });
                $('.field-select').trigger('select2:select');
            }
        })
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
            })
            .on('click', '#dagl-info-list-help', function() {
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
                            element: "#dagl-info-list-search",
                            title: "多功能查询",
                            placement: "left",
                            content: "点击多功能查询会弹出一个窗口，在窗口中设置自己需要筛选的条件，在资料列表区域会显示经过筛选后的人员明细。"
                        },
                        {
                            element: "#unit-detail",
                            title: "资料列表区域",
                            placement: "left",
                            content: "显示单位(部门)或人员基本信息。"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            })
            .on('click', '#dagl-info-list-search', function() {
                $('#btn-view-adv-search').modal({
                    keyboard: false,
                    backdrop: 'static',
                }).modal('show');
            })
            .on('click', '#btn-view-adv-search-help', function() {
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
                            element: "div.row-0 .col-left",
                            title: "提示一",
                            content: "左括号区域，逻辑关系比较复杂的可以选择"
                        },
                        {
                            element: "div.row-0 .col-field",
                            title: "提示二",
                            content: "过滤条件区域，选择需要过滤的信息段"
                        },
                        {
                            element: "div.row-0 .col-choose",
                            title: "提示三",
                            content: "逻辑比较符区域，如输入值有多个，建议选择'范围内'，如输入值只有一个，可选择'包含'"
                        },
                        {
                            element: "div.row-0 .col-value",
                            title: "提示四",
                            content: "输入值区域，如果是选择框可以多次选择，如果是输入框需要输入多个值，输入逗号、空格或回车键会自动隔开"
                        },
                        {
                            element: "div.row-0 .col-right",
                            title: "提示五",
                            content: "右括号区域，如果有选择左括号务必选一个右括号相对应"
                        },
                        {
                            element: "div.row-0 .col-relation",
                            title: "提示六",
                            content: "关系符区域，'与'表示'并且'的意思，'或'表示'或者'的意思"
                        },
                        {
                            element: "#btn-view-adv-search-relation",
                            title: "最后",
                            content: "点击'确定'按钮提交过滤条件"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            })
            .on('click', '#btn-view-adv-search-relation', function() {
                var data        = $('#btn-view-adv-search-form').serializeArray();
                var left        = [];
                var sfield      = [];
                var choose      = [];
                var value       = [];
                var right       = [];
                var relation    = [];
                var valid       = []; //有效行数
                var k_left      = []; //左括号key值
                var k_right     = []; //右括号key值
                var i_left      = 0;  //左括号数
                var i_right     = 0;  //右括号数
                var sql         = '';
                $.each(data, function(i, field) {
                    var key = (field.name).split('-')[1];
                    switch ((field.name).split('-')[0]) {
                        case 'left':
                            left[key]   = field.value;
                            if( field.value ) {
                                k_left.push(key);
                                i_left += (field.value).length;//计算左括号数量
                            }
                            break;
                        case 'field':
                            sfield[key] = field.value;
                            if (field.value) {
                                valid.push(key);//当该行有value值输入才判定为有效
                            }
                            break;
                        case 'choose':
                            choose[key] = field.value;
                            break;
                        case 'value':
                            value[key] = $('.select-value-' + key).val();
                            break;
                        case 'right':
                            right[key]  = field.value;
                            if( field.value ) {
                                k_right.push(key);
                                i_right += (field.value).length;//计算右括号数量
                            }
                            break;
                        case 'relation':
                            relation[key]   = field.value;
                            break;
                    }
                });

                //校验左右括号数目是否一致
                if ( i_left != i_right ) {
                    layer.msg('搜索条件中，左右括号数目不相同，请检查..', {icon: 5, time: 3000});
                    return false;
                }

                //拼接SQL
                for ( var i = 0; i < valid.length; i++ ) {
                    if ( !value[i] )//没有输入值，跳出当次循环
                        continue;
                    var s_value = value[i];
                    //如果有多个值，必须提醒[逻辑比较符]改为[范围内]或[范围外]
                    if( typeof( s_value ) == 'object' && s_value.length > 1 && choose[i] != 'in' && choose[i] != 'not in' ) {
                        layer.msg('输入值有多个，请将[逻辑比较符]改为[范围内]或[范围外]..', {icon: 5, time: 2000}, function(index) {
                            layer.tips('[逻辑比较符]改为[范围内]或[范围外]..', '.row-' + i + ' .col-choose', {
                                tips: [2, '#3595CC'], //可配置颜色 1上 2右 3下 4左
                                time: 4000
                            });
                        });
                        return false;
                    }
                    if ( sfield[i].split('.')[1] != 'unit' ) {//非单位编码字段
                        if ( choose[i] == 'like' || choose[i] == 'not like' ) {
                            s_value = "'%" + s_value + "%'";
                        }
                        if ( choose[i] == 'in' || choose[i] == 'not in' ) {
                            if ( typeof( s_value ) == 'string' ) {
                                s_value = "['" + s_value + "']";
                            } else {
                                var  s_value_tmp = '';
                                for ( var j = 0; j < s_value.length; j++ ) {
                                    s_value_tmp += (j > 0 ? ', ' : '') + "'" + s_value[j] + "'";
                                }
                                s_value = "[" + s_value_tmp + "]";
                            }
                        }
                        sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                            left[i] + sfield[i] + ' ' + choose[i] + ' ' + s_value + right[i];
                    } else {//单位编码字段
                        if ( choose[i] == 'like' || choose[i] == 'not like' ) {
                            s_value = "'" + s_value + "'";
                            sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                left[i] + ( choose[i] == 'not like' ? 'not ' : '' ) + "FIND_IN_SET (" + sfield[i] + ", " + s_value + ")" + right[i];
                        }
                        if ( choose[i] == 'in' || choose[i] == 'not in' ) {
                            if ( typeof( s_value ) == 'string' ) {
                                s_value = "'" + s_value + "'";
                                sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                    left[i] + ( choose[i] == 'not in' ? 'not ' : '' ) + "FIND_IN_SET (" + sfield[i] + ", " + s_value + ")" + right[i];
                            } else {
                                var  s_value_tmp = '';
                                for ( var j = 0; j < s_value.length; j++ ) {
                                    s_value_tmp += (j > 0 ? ' or ' : '') + "FIND_IN_SET (" + sfield[i] + ", '" + s_value + "')"
                                }
                                sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                    left[i] + ( choose[i] == 'not in' ? 'not ' : '' ) + '(' + s_value_tmp + ')' + right[i];
                            }
                        }

                    }
                }
                $('#btn-view-adv-search').modal('hide');
                //load search list page
                //console.log(sql);
                if( sql == '' ) {
                    layer.msg('多功能查询中未设置过滤条件，系统将随机抽取部分记录..', {icon: 6, time: 2000});
                }
                $('#unit-detail').load('<?= \yii\helpers\Url::to(['/personal/search-result']) ?>',
                    { sql : sql },
                    function(response, status, xhr) {
                        if (status == 'error') {
                            layer.alert('页面加载出错...', {icon: 6});
                        }
                    });
            });


    });

</script>
<?php \common\widgets\JsBlock::end(); ?>
