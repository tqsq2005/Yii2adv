<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-28 下午5:14
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/* @var $this yii\web\View */
/* @var object $preferences jsondata */
/* @var string $sql */

$this->title = '人员列表';
$this->params['breadcrumbs'][] = $this->title;
$css = <<<CSS
span.p-extra-filter {
    cursor: pointer;
}
CSS;
$this->registerCss($css);
\common\assets\DataTableEditorAsset::register($this);
?>
<div class="person-search-list">
    <table id="person-search-list-data" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width:30px;"></th>
                <th>序号</th>
                <th>所在部门</th>
                <th>姓名</th>
                <th>性别</th>
                <th>出生日期</th>
                <th>婚姻状况</th>
                <th>现子女数</th>
                <th>户籍性质</th>
                <th>编制</th>
                <th>登记日期</th>
                <th style="width:30px;">操作</th>
            </tr>
        </thead>
    </table>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        var editor = null; // use a global for the submit and return data rendering in the examples
        var preferences = $.parseJSON('<?= $preferences ?>');
        window.pdfMake.fonts  = {
            msyh: {
                normal: 'msyh.ttf',
                bold: 'msyh.ttf',
                italics: 'msyh.ttf',
                bolditalics: 'msyh.ttf',
            }
        };

        $(document).ready(function() {

            layer.closeAll('tips');

            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    url:  "<?=Yii::$app->homeUrl?>/personal/search-data-tables?type=crud",
                    dataSrc: '',
                    beforeSend: function () {
                        layer.load();
                    },
                    complete: function () {
                        layer.closeAll('loading');
                    },
                    error: function() {
                        layer.msg("数据处理失败，请重试!",{icon: 5});
                    }
                },
                table: "#person-search-list-data",
                idSrc:  'id',
                i18n: {
                    create: {
                        button: "新增",
                        title:  "新增员工档案",
                        submit: "保存"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改员工档案",
                        submit: "保存"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除员工档案",
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
                fields: [
                    {
                        label: "登记日期:",
                        name: "s_date",
                        def: moment(new Date).format('YYYYMMDD')
                    },
                    {
                        label: "姓名:",
                        name: "name1",
                    },
                    {
                        label: "性别:",
                        name: "sex",
                        type: "select",
                        ipOpts: [
                            { "label": "男", "value": "01" },
                            { "label": "女", "value": "02"}
                        ]
                    }
                ]
            } );

            editor
            //删除并保存成功事件
                .on('remove', function(e, json, data) {
                    layer.msg('记录已删除！', {icon: 6, time: 2000});
                });

            // Edit record
            $('#person-search-list-data').on('click', 'i.editor_edit', function (e) {
                //e.preventDefault();
                var item = table.row($(this).closest('tr')).data();
                layer.msg('进入个人档案修改界面..', {icon: 6, time: 1000}, function(index) {
                    window.open('<?= \yii\helpers\Url::to(['/personal/update']) ?>/' + item.id, '_blank');
                });
            } );

            // Delete a record
            $('#person-search-list-data').on('click', 'i.editor_remove', function (e) {
                //e.preventDefault();
                editor.remove( $(this).closest('tr'), {
                    title: '删除员工档案',
                    message: '确定要删除该条记录吗?',
                    buttons: '确认删除'
                } );
            } );

            var table = $('#person-search-list-data').DataTable( {
                //dom: "bfrtip",
                dom:"<'row'<'col-md-9'l><'col-md-3'f>r>tip",
                lengthChange: true,     //是否允许用户改变表格每页显示的记录数，默认为true
                lengthMenu: [
                    [10, 8, 15, 20, 25, 50, 100, -1],
                    [10, 8, 15, 20, 25, 50, 100, "全部"]
                ],//每页显示条数设置
                stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
                ajax: {
                    url:  "<?=Yii::$app->homeUrl?>/personal/search-data-tables?type=fetch",
                    type: "POST",
                    data: { sql : "<?= $sql ?>" },
                    dataSrc: '',
                    beforeSend: function () {
                        layer.load();
                    },
                    complete: function () {
                        layer.closeAll('loading');
                    },
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
                        width : '30px',
                        data : null,
                        className: 'text-center',
                        orderable: false
                    },
                    { data: "unit" },
                    {
                        data: null,
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return '(' + data.code1 + ')' + data.name1;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return preferences.sex[data.sex] ? preferences.sex[data.sex] : '未知' ;
                        }
                    },
                    {
                        data: "birthdate",
                        className: 'text-center'
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return preferences.marry[data.marry] ? preferences.marry[data.marry] : '未知';
                        }
                    },
                    {
                        data: "childnum",
                        className: 'text-center'
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return preferences.flag[data.flag] ? preferences.flag[data.flag] : '未知';
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return preferences.work1[data.work1] ? preferences.work1[data.work1] : '未知';
                        }
                    },
                    {
                        data: "s_date",
                        className: 'text-center'
                    },
                    {
                        data: null,
                        className: "text-center",
                        defaultContent: '<i class="fa fa-pencil text-primary editor_edit" data-toggle="tooltip" title="修改" style="cursor: pointer;"></i> &nbsp;&nbsp;' +
                        '<i class="fa fa-trash text-primary editor_remove" data-toggle="tooltip" title="删除" style="cursor: pointer;"></i>'
                    }
                ],
                //隐藏ID列
                columnDefs: [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": [0,1]
                    }
                ],
                order: [[ 3, "asc" ]],//初始排序
                select: {
                    style: 'multi'
                },
                createdRow: function( row, data, dataIndex ) {
                    if ( data.sex == '01' && data.marry > '10' ) {
                        $(row).addClass( 'text-purple' );
                        return;
                    }
                    if ( data.sex == '02' && data.marry > '10' ) {
                        $(row).addClass( 'text-red' );
                        return;
                    }
                    if ( data.logout > 0 ) {
                        $(row).addClass( 'text-muted' );
                        return;
                    }
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
                    "processing":     "处理中...",
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

            var e_p_btn_edit = function (e) {
                //e.preventDefault();
                var str = '';
                table.rows('.selected').data().each(function (i, o) {
                    str += i.id;
                    str += ",";
                });
                console.log(str);
                /*$("input[name='checkList']:checked").each(function (i, o) {
                 str += $(this).val();
                 str += ",";
                 });
                 if (str.length > 0) {
                 var IDS = str.substr(0, str.length - 1);
                 alert("你要删除的数据集id为" + IDS);
                 } else {
                 alert("至少选择一条记录操作");
                 }*/
            };

            new $.fn.dataTable.Buttons( table, [
                {
                    text: '<i class="fa fa-edit"></i> 修改',
                    action: e_p_btn_edit
                },
                {
                    extend: 'collection',
                    text: '更多操作',
                    buttons: [
                        { extend: "remove", editor: editor },
                        { extend: "selectAll", text: '全选' },
                        { extend: "selectNone", text: '取消全选' }
                    ]
                },
                {
                    extend: 'colvis',
                    text: '掩藏/显示 列',
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

            //按钮组和每页页码选择框间隔开
            table.buttons().container()
                .append('&nbsp;&nbsp;&nbsp;&nbsp;')
                .prependTo( $('.col-md-9:eq(0) div.dataTables_length', table.table().container() ) );


        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>
