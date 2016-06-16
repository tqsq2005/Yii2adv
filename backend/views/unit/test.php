<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-15 下午9:09
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.co
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-13 下午2:59
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/* @var $this yii\web\View */
/* @var integer $parent */
/* @var string $parentName */
/* @var string $unitcode */
/* @var integer $isParent */

$this->title = '单位列表';
$this->params['breadcrumbs'][] = $this->title;
\common\assets\DataTableEditorAsset::register($this);
?>
<div class="unit-list">
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Extn.</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Extn.</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
        </tfoot>
    </table>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        var editor; // use a global for the submit and return data rendering in the examples

        $(document).ready(function() {
            window.pdfMake.fonts  = {
                msyh: {
                    normal: 'msyh.ttf',
                    bold: 'msyh.ttf',
                    italics: 'msyh.ttf',
                    bolditalics: 'msyh.ttf',
                }
            };
            editor = new $.fn.dataTable.Editor( {
                ajax: "https://editor.datatables.net/examples/php/staff.php",
                table: "#example",
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
                    label: "First name:",
                    name: "first_name"
                }, {
                    label: "Last name:",
                    name: "last_name"
                }, {
                    label: "Position:",
                    name: "position"
                }, {
                    label: "Office:",
                    name: "office"
                }, {
                    label: "Extension:",
                    name: "extn"
                }, {
                    label: "Start date:",
                    name: "start_date"
                }, {
                    label: "Salary:",
                    name: "salary"
                }
                ]
            } );

            var openVals;
            editor
                .on( 'open', function () {
                    // Store the values of the fields on open
                    openVals = JSON.stringify( editor.get() );
                } )
                .on( 'preBlur', function ( e ) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if ( openVals !== JSON.stringify( editor.get() ) ) {
                        return confirm( '您有未保存的更改..确定要退出吗?' );
                    }
                } )
                .on('create', function(e, json, data) {
                    //table.search( data.unitname ).draw();
                    layer.msg('记录已新增！', {icon: 6}, function () {
                        $('#unit-tree').jstree('refresh');
                    });
                })
                //修改并保存成功事件
                .on('edit', function(e, json, data) {
                    //table.search( data.unitname ).draw();
                    layer.msg('记录已修改！', {icon: 6}, function () {
                        $('#unit-tree').jstree('refresh');
                    });
                })
                //删除并保存成功事件
                .on('remove', function(e, json, data) {
                    layer.msg('记录已删除！', {icon: 6}, function () {
                        $('#unit-tree').jstree('refresh');
                    });
                });

            var table = $('#example').DataTable( {
                //dom: "frtip",
                lengthChange: true,     //是否允许用户改变表格每页显示的记录数，默认为true
                lengthMenu: [
                    [10, 8, 15, 20, 25, 50, 100, -1],
                    [10, 8, 15, 20, 25, 50, 100, "全部"]
                ],//每页显示条数设置
                stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
                ajax: "/admin/data.txt",
                columns: [
                    { data: null, render: function ( data, type, row ) {
                        // Combine the first and last names into a single table field
                        return data.first_name+' '+data.last_name;
                    } },
                    { data: "position" },
                    { data: "office" },
                    { data: "extn" },
                    { data: "start_date" },
                    { data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
                ],
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
                /*buttons: [
                    { extend: "create", editor: editor },
                    { extend: "edit",   editor: editor },
                    { extend: "remove", editor: editor }
                ]*/
            } );

            new $.fn.dataTable.Buttons( table, [
                { extend: "create", editor: editor },
                { extend: "edit",   editor: editor },
                { extend: "remove", editor: editor },
                //column selector
                {
                    extend: 'colvis',
                    text: '掩藏/显示 列',
                    //第几列开始
                    //columns: ':gt(1)'
                },
                {
                    extend: 'collection',
                    text: '导出',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '复制',
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        {
                            extend: 'excel',
                            text: '导出Excel',
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '导出Csv',
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        {
                            extend: 'pdf',
                            text: '所选导出PDF',
                            pageSize: 'A3',//LEGAL
                            exportOptions: {
                                columns: ':visible',
                                modifier: {
                                    selected: true
                                    //当前页导出
                                    //page: 'current'
                                }
                            },
                            customize: function ( doc ) {
                                doc.defaultStyle = {
                                    font: 'msyh'
                                };
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '全部导出PDF',
                            pageSize: 'A3',//LEGAL
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function ( doc ) {
                                doc.defaultStyle = {
                                    font: 'msyh'
                                };
                            }
                        },
                        {
                            extend: 'print',
                            text: '打印全部',
                            //disable auto print
                            autoPrint: false,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            text: '打印所选',
                            //disable auto print
                            autoPrint: false,
                            exportOptions: {
                                columns: ':visible',
                                modifier: {
                                    selected: true
                                }
                            }
                        }
                    ]
                }
            ] );

            table.buttons().container()
                .append('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
                .prependTo( $('.col-sm-6:eq(0) div.dataTables_length', table.table().container() ) );
        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>
