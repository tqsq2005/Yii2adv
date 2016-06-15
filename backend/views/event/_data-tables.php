<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider backend\models\Event */

$this->title = '事件dataTables';
$this->params['breadcrumbs'][] = ['label' => '日历', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\common\assets\DataTableEditorAsset::register($this);
?>
<div class="event-data-tables">
    <?php echo $this->render('_menu'); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box box-primary">
        <div class="box-body" id="admin-body">
            <table id="event-data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th></th>
                    <th>序号</th>
                    <th>事件编号</th>
                    <th>事件名称</th>
                    <th>事件内容</th>
                    <th>事件开始时间</th>
                    <th>时间结束时间</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th>序号</th>
                    <th>事件编号</th>
                    <th>事件名称</th>
                    <th>事件内容</th>
                    <th>事件开始时间</th>
                    <th>时间结束时间</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        var editor; // use a global for the submit and return data rendering in the examples

        $(document).ready(function() {
            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    url:  "/admin/event/data-tables?type=crud",
                    dataSrc: '',
                    error: function() {
                        layer.msg("数据处理失败，请重试!",{icon: 5});
                    }
                },
                table: "#event-data",
                idSrc:  'id',
                i18n: {
                    create: {
                        button: "新增",
                        title:  "新增事件",
                        submit: "保存"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改事件",
                        submit: "保存"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除事件",
                        submit: "确认删除",
                        confirm: {
                            _: "确定要删除这 %d 条记录吗?",
                            1: "确定要删除该条记录吗?"
                        }
                    },
                    error: {
                        system: "发生错误，请刷新页面或与系统管理员联系！"
                    },
                    multi: {
                        title: "多个值",
                        info: "此条选定的元素包含不同的值。要编辑和移动的此项的相同值的所有元素，点击或按这里，否则他们将保留自己的值.",
                        restore: "取消更改"
                    },
                    datetime: {
                        previous: '前',
                        next:     '后',
                        months:   [ '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月' ],
                        weekdays: [ '日', '一', '二', '三', '四', '五', '六' ]
                    }
                },
                fields: [ {
                    label: "事件名称:",
                    name: "title"
                }, {
                    label: "事件内容:",
                    name: "description",
                    type: "textarea"
                }, {
                    label: "事件开始时间:",
                    name: "start",
                    type: "datetime",
                    format: 'YYYY-M-D HH:mm:ss',
                    def:    function () { return new Date(); }
                }, {
                    label: "事件结束时间:",
                    name: "end",
                    type: "datetime",
                    format: 'YYYY-M-D HH:mm:ss',
                    def:    function () { return new Date(); }
                } ]
            } );

            var table = $('#event-data').DataTable( {
                //dom: "Bfrtip",
                lengthChange: false,
                ajax: {
                    url:  "/admin/event/data-tables?type=fetch",
                    dataSrc: '',
                    error: function() {
                        layer.msg("数据读取失败，请刷新重试!",{icon: 5});
                    }
                },
                columns: [
                    //checkbox
                    {
                        data: null,
                        defaultContent: '',
                        className: 'select-checkbox',
                        orderable: false
                    },
                    //序号，
                    {
                        width : '40px',
                        data : function(row, type, set, meta) {
                            var c = meta.settings._iDisplayStart + meta.row + 1;
                            return c;
                        }
                    },
                    { data: "id" },
                    { data: "title" },
                    { data: "description" },
                    { data: "start" },
                    { data: "end" }
                ],
                //隐藏ID列
                columnDefs: [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1
                    },
                    {
                        "targets": 2,//隐藏事件ID
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [[ 1, "asc" ]],//初始排序
                deferRender: true, //当处理大数据时，延迟渲染数据，有效提高Datatables处理能力
                //select: true,
                keys: {
                    columns: ':not(:first-child)',
                    editor:  editor
                },
                select: {
                    style:    'os',
                    selector: 'td:first-child',
                    blurable: true
                },
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                }
            } );

            // Display the buttons
            new $.fn.dataTable.Buttons( table, [
                { extend: "create", editor: editor },
                { extend: "edit",   editor: editor },
                { extend: "remove", editor: editor },
                {
                    extend: 'collection',
                    text: '导出',
                    buttons: [
                        'copy',
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }
            ] );

            table.buttons().container()
                .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

            // Inline editing on click
            $('#event-data').on( 'click', 'tbody td:not(:first-child)', function (e) {
                editor.inline( this );
            } );

            // Inline editing on tab focus
            table.on( 'key-focus', function ( e, datatable, cell ) {
                editor.inline( cell.index(), {
                    onBlur: 'submit'
                } );
            } );
            //给datatables添加序号
            /*table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();*/
        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>
