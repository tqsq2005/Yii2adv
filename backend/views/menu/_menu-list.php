<?php

/* @var $this yii\web\View */
/* @var integer $parent */
/* @var string $parentName */

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-list">
    <table id="menu-list-data" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width:30px; padding:10px 0 10px 10px">
                    <input type="checkbox" id="checkAll"></th>
                <th>序号</th>
                <th>菜单ID</th>
                <th>名称</th>
                <th>父级名称</th>
                <th>路由</th>
                <th>顺序</th>
                <th>图标</th>
            </tr>
        </thead>
    </table>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        var editor; // use a global for the submit and return data rendering in the examples

        $(document).ready(function() {
            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    url:  "/admin/menu/data-tables?type=crud",
                    dataSrc: '',
                    error: function() {
                        layer.msg("数据处理失败，请重试!",{icon: 5});
                    }
                },
                table: "#menu-list-data",
                idSrc:  'id',
                i18n: {
                    create: {
                        button: "新增",
                        title:  "新增菜单",
                        submit: "保存"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改菜单",
                        submit: "保存"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除菜单",
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
                    label: "名称:",
                    name: "name"
                }, {
                    label: "父级名称:",
                    name: "parent",
                    def: "<?= $parent ?>"
                }, {
                    label: "路由:",
                    name: "route"
                }, {
                    label: "顺序:",
                    name: "order"
                }, {
                    label: "数据:",
                    name: "data"
                }]
            } );

            //修改过字段如果退出则警告
            var openVals;
            editor
                .on('open', function () {
                    openVals = JSON.stringify( editor.get() );
                } )
                .on('preBlur', function ( e ) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if ( openVals !== JSON.stringify( editor.get() ) ) {
                        return confirm( '您有未保存的更改..确定要退出吗?' );
                    }
                } )
                //新增并保存成功事件
                .on('create', function(e, json, data) {
                    table.search( data.classmark ).draw();
                    layer.msg('记录已新增！', {icon: 6});
                })
                //修改并保存成功事件
                .on('edit', function(e, json, data) {
                    table.search( data.classmark ).draw();
                    layer.msg('记录已修改！', {icon: 6});
                })
                //删除并保存成功事件
                .on('remove', function(e, json, data) {
                    layer.msg('记录已删除！', {icon: 6});
                });

            var table = $('#menu-list-data').DataTable( {
                //dom: "Bfrtip",
                lengthChange: false,
                ajax: {
                    url:  "/admin/menu/data-tables?type=fetch&id=<?= $parent ?>",
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
                            //var c = meta.settings._iDisplayStart + meta.row + 1;
                            return '';
                        }
                    },
                    { data: "id" },
                    { data: "name" },
                    { data: "parent" },
                    { data: "route" },
                    { data: "order" },
                    { data: "data" }
                ],
                //隐藏ID列
                columnDefs: [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1
                    },
                    {
                        "targets": 2,//隐藏菜单ID
                        "visible": false,
                        "searchable": false
                    }
                    ,
                    {
                        "targets": 4,//隐藏菜单父级名称
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [[ 1, "asc" ]],//初始排序
                //deferRender: true, //当处理大数据时，延迟渲染数据，有效提高Datatables处理能力
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
                        'print'
                    ]
                }
            ] );

            //checkbox全选
            $("#checkAll").on("click", function () {
                if ($(this).prop("checked") === true) {
                    $("input[name='checkList']").prop("checked", $(this).prop("checked"));
                    $('#menu-list-data tbody tr').addClass('selected');
                } else {
                    $("input[name='checkList']").prop("checked", false);
                    $('#menu-list-data tbody tr').removeClass('selected');
                }
            });

            //序号索引 order.dt：排序事件； search.dt：搜索事件； length.dt：页显示记录数变更事件
            table.on('order.dt search.dt',
                function() {
                    table.column(1, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

            table.buttons().container()
                .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>
