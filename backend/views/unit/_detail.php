<?php
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
$css = <<<CSS
div.modal-dialog {
    width: 800px;
}

div.DTE_Body div.DTE_Body_Content div.DTE_Field {
    float: left;
    width: 50%;
    padding: 5px 10px;
    clear: none;
    box-sizing: border-box;
}

div.DTE_Body div.DTE_Form_Content:after {
    content: ' ';
    display: block;
    clear: both;
}
CSS;
$this->registerCss($css);
\common\assets\DataTableEditorAsset::register($this);
?>
<div class="box box-success">
    <div class="box-header with-border">
        <span class="box-title text-green" id="box-unitname"><?= $parentName ?>-基本情况</span>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12" style="height: 58px;">
                <span id="box-unit-info"  class="text-purple">总人数为 -- 人，流动人口为 -- 人，已婚男性人数为 -- 人，已婚女性人数为 -- 人，未婚男性人数
为 -- 人，未婚女性人数为 -- 人，已婚未育 -- 人，已婚育一孩 -- 人，已婚育二孩 -- 人，近三个月内新入职 -- 人，近三个月内离开单位 -- 人。 </span>
                <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<div class="unit-list">
    <table id="unit-list-data-<?=$unitcode?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width:50px;">
                    全选<input type="checkbox" id="checkAll"></th>
                <th>序号</th>
                <th>单位名称</th>
                <th>通讯地址</th>
                <th>专干姓名</th>
                <th>联系电话</th>
                <th>邮政编码</th>
            </tr>
        </thead>
    </table>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        function boxUnitInfo(unit) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['personal/summary']) ?>',
                type : 'get',
                data : { unit: unit },
                beforeSend: function () {
                    layer.load();
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                error: function() {
                    layer.msg("单位基本情况数据获取失败..",{icon: 5});
                },
                success: function(data, textStatus){
                    $("#box-unit-info").html(data);
                    $("#box-unit-info").textPrint(30);
                }
            });
        }
        var editor; // use a global for the submit and return data rendering in the examples

        $(document).ready(function() {
            if (editor) {
                editor.off('open')
                    .off('preSubmit')
                    .off('preBlur')
                    .off('create')
                    .off('edit')
                    .off('remove');
            }
            window.pdfMake.fonts  = {
                msyh: {
                    normal: 'msyh.ttf',
                    bold: 'msyh.ttf',
                    italics: 'msyh.ttf',
                    bolditalics: 'msyh.ttf',
                }
            };

            boxUnitInfo('<?= $parent ?>');

            editor = new $.fn.dataTable.Editor( {
                ajax: {
                    url:  "/admin/unit/data-tables?type=crud",
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
                table: "#unit-list-data-<?=$unitcode?>",
                idSrc:  'id',
                i18n: {
                    create: {
                        button: "新增",
                        title:  "新增单位(部门)",
                        submit: "保存"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改单位(部门)",
                        submit: "保存"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除单位(部门)",
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
                        label: "主管单位编码:",
                        name: "upunitcode",
                        type: "readonly",
                        id: "unit-upunitcode",
                        def: "<?= $parent ?>"
                    },
                    {
                        label: "主管单位名称:",
                        name: "upunitname",
                        type: "readonly",
                        def: "<?= $parentName ?>"
                    },
                    {
                        label: "单位编码:",
                        name: "unitcode",
                        id: "unit-unitcode",
                        def: "<?= $unitcode ?>"
                    },
                    {
                        label: "单位名称:",
                        name: "unitname",
                        id: "unit-unitname"
                    },
                    {
                        label: "类型:",
                        name: "corpflag",
                        type: "select",
                        id: "unit-corpflag",
                        ipOpts: [
                            { "label": "部门", "value": "5" },
                            { "label": "单位", "value": "4"}
                        ]
                    },
                    {
                        label: "专干姓名:",
                        name: "oname"
                    },
                    {
                        label: "联系电话:",
                        name: "tel"
                    },
                    {
                        label: "通讯地址:",
                        name: "address1"
                    },
                    {
                        label: "所属街道:",
                        name: "office"
                    },
                    {
                        label: "邮政编码:",
                        name: "postcode"
                    },
                    {
                        label: "传真:",
                        name: "fax"
                    },
                    {
                        label: "人事姓名:",
                        name: "date1"
                    },
                    {
                        label: "法人代表:",
                        id: "unit-corporation",
                        name: "corporation"
                    },
                    {
                        label: "党政一把手:",
                        id: "unit-leader",
                        name: "leader"
                    },
                    {
                        label: "党政联系电话:",
                        id: "unit-leadertel",
                        name: "leadertel"
                    }
                ]
            } );

            //editor validation

            $(document).on('change', '#unit-corpflag', function() {
                //单位
                if ($(this).val() == '4') {
                    $('div.DTE_Field_Name_corporation, div.DTE_Field_Name_leader, div.DTE_Field_Name_leadertel').removeClass('hidden');
                } else if ($(this).val() == '5') {//部门
                    $('div.DTE_Field_Name_corporation, div.DTE_Field_Name_leader, div.DTE_Field_Name_leadertel').addClass('hidden');
                }
            });

            //修改过字段如果退出则警告
            var openVals;
            editor
                .on('open', function () {
                    openVals = JSON.stringify( editor.get() );
                    //如果主管单位编码是'%'则类型锁定为'单位'
                    if ($('#unit-upunitcode').val() == '%') {
                        $('#unit-corpflag').val(4);
                        $('#unit-corpflag').attr('readOnly', true);
                        $('#unit-corpflag option:not(:selected)').attr('disabled', true);
                    }
                    //如果主管单位类型是'部门'则类型锁定为'部门'
                    if ('<?= $isParent ?>' == 'no') {
                        $('#unit-corpflag').attr('readOnly', true);
                        $('#unit-corpflag option:not(:selected)').attr('disabled', true);
                    }
                    //获取单位类型
                    var corpflag = $("#unit-corpflag option:selected").val();
                    //部门的话掩藏列：法人代表、党政一把手、党政联系电话
                    if (corpflag == '5') {
                        $('div.DTE_Field_Name_corporation, div.DTE_Field_Name_leader, div.DTE_Field_Name_leadertel').addClass('hidden');
                    }
                } )
                //添加前置验证
                .on( 'preSubmit', function ( e, o, action ) {
                    if ( action !== 'remove' ) {
                        var unitcode = editor.field( 'unitcode' );
                        if ( ! unitcode.isMultiValue() ) {
                            if ( ! unitcode.val() ) {
                                unitcode.error( '请输入单位编码..' );
                            }

                            if ( unitcode.val().length >= 30 ) {
                                unitcode.error( '单位编码长度请控制在30以内..' );
                            }
                        }

                        var unitname = editor.field( 'unitname' );
                        if ( ! unitname.isMultiValue() ) {
                            if ( ! unitname.val() ) {
                                unitname.error( '请输入单位名称..' );
                            }

                            if ( unitname.val().length >= 40 ) {
                                unitname.error( '单位名称长度请控制在40字以内..' );
                            }
                        }

                        // If any error was reported, cancel the submission so it can be corrected
                        if ( this.inError() ) {
                            return false;
                        }
                    }
                } )
                .on('preBlur', function ( e ) {
                    // On close, check if the values have changed and ask for closing confirmation if they have
                    if ( openVals !== JSON.stringify( editor.get() ) ) {
                        return confirm( '您有未保存的更改..确定要退出吗?' );
                        /*layer.msg('您有未保存的更改，窗口已锁定，强烈建议先保存，如需强行退出请按键盘上的<kbd>ESC</kbd>键' +
                            '或点击弹出层右上方的<kbd><i class="fa fa-times text-red" aria-hidden="true"></i>按钮</kbd>！',
                            {
                                icon: 6,
                                shift: 6
                            }
                        );
                        return false;*/
                    }
                } )
                //新增并保存成功事件
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

            var table = $('#unit-list-data-<?=$unitcode?>').DataTable( {
                //dom: "Bfrtip",
                lengthChange: true,     //是否允许用户改变表格每页显示的记录数，默认为true
                lengthMenu: [
                    [10, 8, 15, 20, 25, 50, 100, -1],
                    [10, 8, 15, 20, 25, 50, 100, "全部"]
                ],//每页显示条数设置
                stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
                ajax: {
                    url:  "/admin/unit/data-tables?type=fetch&id=<?= $parent ?>",
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
                        width : '40px',
                        data : null
                    },
                    {
                        data: null,
                        render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return '(' + data.unitcode + ')' + data.unitname;
                        }
                    },
                    { data: "address1" },
                    { data: "oname" },
                    { data: "tel" },
                    { data: "postcode" }
                ],
                //隐藏ID列
                columnDefs: [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1
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
                {
                    extend: "selectedSingle",
                    text: '复制',
                    action: function ( e, dt, node, config ) {
                        // Place the selected row into edit mode (but hidden),
                        // then get the values for all fields in the form
                        var values = editor.edit(
                            table.row( { selected: true } ).index(),
                            false
                            )
                            .val();

                        // Create a new entry (discarding the previous edit) and
                        // set the values from the read values and customize self fields's default value
                        values.unitcode = '<?= $unitcode?>';
                        values.unitname = '';
                        editor
                            .create( {
                                title: '复制的记录',
                                buttons: '保 存'
                            } )
                            .set( values );
                    }
                },
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

            //checkbox全选
            $("#checkAll").on("click", function () {
                if ($(this).prop("checked") === true) {
                    $("input[name='checkList']").prop("checked", $(this).prop("checked"));
                    $('#unit-list-data-<?=$unitcode?> tbody tr').addClass('selected');
                } else {
                    $("input[name='checkList']").prop("checked", false);
                    $('#unit-list-data-<?=$unitcode?> tbody tr').removeClass('selected');
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

            /*table.buttons().container()
                .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );*/

            //按钮组和每页页码选择框间隔开
            table.buttons().container()
                .append('&nbsp;&nbsp;&nbsp;&nbsp;')
                .prependTo( $('.col-sm-6:eq(0) div.dataTables_length', table.table().container() ) );

            $('#unit-list-data-<?=$unitcode?>')
                .on("click","tr",function(event) { //行点击事件   td:first-child
                    //获取该行对应的数据
                    var item = table.row($(this).closest('tr')).data();
                    if (item) {
                        $("#box-unitname").html(item.unitname);
                        $("#box-unitname").textPrint(30);
                        boxUnitInfo(item.unitcode);
                    }
                    return ;
                });

        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>
