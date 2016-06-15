<?php

/**
 * @var yii\web\View $this
 */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
\common\assets\DataTableEditorAsset::register($this);
?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <div class="menu-index container-fluid" role="main">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-asterisk fa-spin"></i> 菜单目录 </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="menu-search" style="margin-bottom: 10px;">
                                <input type="text" value="" style="box-shadow:inset 0 0 4px #eee; width:150px; margin:0; padding:6px 12px; border-radius:4px; border:1px solid silver; font-size:1.1em;"
                                       id="menu_q" placeholder="搜索.." />
                            </div>
                            <div id="menu-tree"></div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
                <div class="col-md-9 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> 菜单列表 </h3>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="menu-detail"></div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(window).resize(function () {
            var h = Math.max($(window).height() - 300, 520);
            $('#menu-tree').height(h);
        }).resize();
        //jstree search
        var to = false;
        $('#menu_q').keyup(function () {
            if(to) { clearTimeout(to); }
            to = setTimeout(function () {
                var v = $('#menu_q').val();
                $('#menu-tree').jstree(true).search(v);
            }, 250);
        });
        //jstree
        $('#menu-tree')
            .jstree({
                'core' : {
                    'data' : {
                        'url' : '<?= \yii\helpers\Url::to(['tree']) ?>',
                        'data' : function (node) {
                            return { 'id' : node.id };
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
                                a_Obj.attr('value', '<?= Yii::getAlias('@web'); ?>/menu/create?parentId=' + id + '&parentName=' + text );
                                a_Obj.attr('title', '添加 [' + text + '] 的子级菜单');
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
                                a_Obj.attr('value', '<?= Yii::getAlias('@web'); ?>/menu/update/' + id );
                                a_Obj.attr('title', '修改菜单 [' + text + '] 信息');
                                a_Obj.trigger('click');
                                a_Obj.removeClass('showModalButton');
                            },
                            "icon": 'fa fa-pencil'
                        },
                        "remove": {
                            "label": "删除",
                            "action": function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                var id = obj.id;
                                var text = obj.text;
                                var a_Obj = $('#' + obj.a_attr.id);

                                a_Obj.addClass('showModalButton');
                                a_Obj.attr('value', '<?= Yii::getAlias('@web'); ?>/menu/delete/' + id );
                                a_Obj.attr('title', '添加 [' + text + '] 的子级菜单');
                                a_Obj.trigger('click');
                                a_Obj.removeClass('showModalButton');
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
                    //$.pjax.reload({container:"#menu-data",data: {'menuSearch[upid]':data.selected.join(':')}});
                    //data.selected 是Array类型
                    $('#menu-detail').load('<?= \yii\helpers\Url::to(['detail']) ?>',
                        { id : data.selected.join(':'), name : data.node.text },
                        function(response, status, xhr) {
                            if (status == 'error') {
                                layer.alert('页面加载出错...', {icon: 6});
                            }
                        });
                } else {
                    $('#menu-detail').load('<?= \yii\helpers\Url::to(['detail']) ?>',
                        { id : 1, name : '计生管理系统' },
                        function(response, status, xhr) {
                            if (status == 'error') {
                                layer.alert('页面加载出错...', {icon: 6});
                            }
                        });
                }
            });
    });

</script>
<?php \common\widgets\JsBlock::end(); ?>
