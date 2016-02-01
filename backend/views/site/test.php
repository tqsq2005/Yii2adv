<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Test';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<div class="site-test">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
<div class="row">
    <div class="col-md-3">
        <div id="tree1">

        </div>
    </div>
    <div class="col-md-9">
        <div id="treeview1">
            <div class="content default" style="text-align:center;">Select a node from the tree.</div>
        </div>
    </div>
</div>
<!-- 3 setup a container element -->
<div id="jstree">
    <!-- in this example the tree is populated from inline HTML -->
    <ul>
        <li>Root node 1
            <ul>
                <li id="child_node_1">Child node 1</li>
                <li>Child node 2</li>
            </ul>
        </li>
        <li>Root node 2</li>
    </ul>
</div>
<button>demo button</button>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">
    $(function () {
        // 6 create an instance when the DOM is ready
        $('#jstree').jstree({
            "plugins" : [ "contextmenu", "dnd", "search", "state", "types", "wholerow", "checkbox" ]
        });
        // 7 bind to events triggered on the tree
        $('#jstree').on("changed.jstree", function (e, data) {
            console.log(data.selected);
        });
        // 8 interact with the tree - either way is OK
        $('button').on('click', function () {
            $('#jstree').jstree(true).select_node('child_node_1');
            $('#jstree').jstree('select_node', 'child_node_1');
            $.jstree.reference('#jstree').select_node('child_node_1');
        });
        ////////
        $(window).resize(function () {
            var h = Math.max($(window).height() - 0, 420);
            $('#row, #treeview1, #tree1, #treeview1 .content').height(h).filter('.default').css('lineHeight', h + 'px');
        }).resize();
        $('#tree1')
            .jstree({
                'core' : {
                    'data' : {
                        'url' : '<?= \yii\helpers\Url::to(['helpmenu/treenode']) ?>',
                        'data' : function (node) {
                            return { 'unitcode' : node.id };
                        }
                    },
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
                'plugins' : ['state','dnd','contextmenu']
            }).on('changed.jstree', function (e, data) {
                if(data && data.selected && data.selected.length) {
                    $.get('<?= \yii\helpers\Url::to(['helpmenu/treenode']) ?>?unitcode=' + data.selected.join(':'), function (d) {
                        //console.log(d);
                        $('#treeview1 .default').html(d.text).show();
                    });
                }
                else {
                    $('#treeview1 .content').hide();
                    $('#treeview1 .default').html('Select a file from the tree.').show();
                }
            });
    });
</script>
<?php \common\widgets\JsBlock::end(); ?>



