<?php

/**
 * @var $this yii\web\View
 * @var string $pid personal_id
 * @var integer $pPrimaryKey 表personal的自增ID
 * @var integer $id 配偶序号
 * @var string $code1 员工编码
 * @var string $because 与职工婚姻关系
 * @var string $becausedate 发生婚姻关系时间
 * @var integer $selfno 生育次数
 * @var object $preferences jsondata
 * @var object $preferencesForDT jsondata
 */

use yii\helpers\Url;

$this->title = '配偶情况';
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

div.dataTables_wrapper {
    width: 100%;
    margin: 0 auto;
}

span.p-extra-filter {
    cursor: pointer;
}
CSS;
$this->registerCss($css);
\common\assets\DataTableEditorNoPDFAsset::register($this);
echo $this->render('@backend/views/personal/_menu', [
    'id'  => $pPrimaryKey,
    'pid' => $pid,
]);
?>
<div class="box box-solid">
    <div class="box-body">
        <div class="marry-list">
            <table id="marry-list-data" class="table table-striped table-bordered" cellspacing="0" width="2000">
                <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th style="width: 40px;">序号</th>
                    <th style="width: 60px;">员工编号</th>
                    <th style="width: 60px;">配偶姓名</th>
                    <th style="width:100px;">与职工婚姻关系</th>
                    <th style="width:100px;">发生婚姻关系时间</th>
                    <th style="width:100px;">配偶出生日期</th>
                    <th style="width:100px;">配偶婚姻状况</th>
                    <th style="width:100px;">配偶户口性质</th>
                    <th style="width:140px;">配偶身份证号</th>
                    <th style="width:140px;">结婚证号</th>
                    <th style="width:100px;">配偶生育次数</th>
                    <th style="width:200px;">配偶户口地址</th>
                    <th style="width:180px;">配偶工作单位</th>
                    <th style="width:200px;">配偶单位地址</th>
                    <th style="width:100px;">配偶单位电话</th>
                    <th style="width:100px;">配偶单位邮编</th>
                    <th style="width: 120px;">备注</th>
                    <th style="width: 40px;">操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
<script type="text/javascript">

    //身份证合法性
    function certificateNoParse(certificateNo){
        var pat = /^\d{6}(((19|20)\d{2}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])\d{3}([0-9]|x|X))|(\d{2}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])\d{3}))$/;
        if(!pat.test(certificateNo))
            return null;

        var parseInner = function(certificateNo, idxSexStart, birthYearSpan){
            var res = {};
            var idxSex = 1 - certificateNo.substr(idxSexStart, 1) % 2;
            res.sex = idxSex == '1' ? '02' : '01';

            var year = (birthYearSpan == 2 ? '19' : '') +
                certificateNo.substr(6, birthYearSpan);
            var month = certificateNo.substr(6 + birthYearSpan, 2);
            var day = certificateNo.substr(8 + birthYearSpan, 2);
            res.birthday = year + '' + month + '' + day;

            var d = new Date(); //当然，在正式项目中，这里应该获取服务器的当前时间
            var monthFloor = ((d.getMonth()+1) < parseInt(month,10) || (d.getMonth()+1) == parseInt(month,10) && d.getDate() < parseInt(day,10)) ? 1 : 0;
            res.age = d.getFullYear() - parseInt(year,10) - monthFloor;
            return res;
        };

        return parseInner(certificateNo, certificateNo.length == 15 ? 14 : 16, certificateNo.length == 15 ? 2 : 4);
    };

    var editor = null; // use a global for the submit and return data rendering in the examples
    var preferences         = $.parseJSON('<?= $preferences ?>');
    var preferencesForDT    = $.parseJSON('<?= $preferencesForDT ?>');
    $(document).ready(function() {

        layer.closeAll('tips');

        editor = new $.fn.dataTable.Editor( {
            ajax: {
                url:  "<?=Url::to(['/marry/data-tables', 'type'=>'crud', 'pid'=>$pid])?>",
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
            table: "#marry-list-data",
            idSrc:  'mid',
            i18n: {
                create: {
                    button: "新增",
                    title:  "新增配偶资料",
                    submit: "保存"
                },
                edit: {
                    button: "修改",
                    title:  "修改配偶资料",
                    submit: "保存"
                },
                remove: {
                    button: "删除",
                    title:  "删除配偶资料",
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
                { name: "personal_id", def: "<?= $pid ?>", type: "hidden" },
                { name: "id", def: "<?= $id ?>", type: "hidden" },
                {
                    label: "员工编码:",
                    type: "readonly",
                    name: "code1",
                    def: "<?= $code1 ?>"
                },
                {
                    label: "配偶姓名:",
                    name: "marrow"
                },
                {
                    label: "与职工婚姻关系:",
                    name: "because",
                    type: "select",
                    def: "<?= $because ?>",
                    ipOpts: preferencesForDT['marry']
                },
                {
                    label: "发生婚姻关系时间:",
                    name: "becausedate",
                    def: "<?= $becausedate ?>"
                },
                {
                    label: "配偶婚姻状况:",
                    name: "hmarry",
                    type: "select",
                    def: "<?= $because ?>",
                    ipOpts: preferencesForDT['marry']
                },
                {
                    label: "配偶户口性质:",
                    name: "hfp",
                    type: "select",
                    ipOpts: preferencesForDT['hkxz']
                },
                {
                    label: "配偶身份证号:",
                    name: "mfcode"
                },
                {
                    label: "配偶出生日期:",
                    name: "marrowdate"
                },
                {
                    label: "结婚证号:",
                    name: "marrycode"
                },
                {
                    label: "配偶生育次数:",
                    def: "<?= $selfno ?>",
                    name: "marrowno"
                },
                {
                    label: "配偶户口地址:",
                    name: "mhkdz"
                },
                {
                    label: "配偶工作单位:",
                    name: "marrowunit"
                },
                {
                    label: "配偶单位地址:",
                    name: "maddr"
                },
                {
                    label: "配偶单位电话:",
                    name: "othertel"
                },
                {
                    label: "配偶单位邮编:",
                    name: "mpostcode"
                },
                {
                    label: "备 注:",
                    name: "mem"
                }
            ]
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
                    //return confirm( '您有未保存的更改..确定要退出吗?' );
                    layer.msg('您有未保存的更改，窗口已锁定，强烈建议先保存，如需强行退出请按键盘上的<kbd>ESC</kbd>键' +
                        '或点击弹出层右上方的<kbd><i class="fa fa-times text-red" aria-hidden="true"></i>按钮</kbd>！',
                        {
                            icon: 6,
                            shift: 6
                        }
                    );
                    return false;
                }
            } )
            //新增并保存成功事件
            .on('create', function(e, json, data) {
                //table.search( data.unitname ).draw();
                layer.msg('记录已新增！', {icon: 6, time: 1500});
            })
            //修改并保存成功事件
            .on('edit', function(e, json, data) {
                //table.search( data.unitname ).draw();
                layer.msg('记录已修改！', {icon: 6, time: 1500});
            })
            //删除并保存成功事件
            .on('remove', function(e, json, data) {
                layer.msg('记录已删除！', {icon: 6, time: 1500});
            });

        // Edit record
        $('#marry-list-data').on('click', 'i.editor_edit', function (e) {
            //e.preventDefault();
            editor.edit( $(this).closest('tr'), {
                title: '修改配偶资料',
                buttons: '保存'
            } );
        } );
        // Delete a record
        $('#marry-list-data').on('click', 'i.editor_remove', function (e) {
            //e.preventDefault();
            editor.remove( $(this).closest('tr'), {
                title: '删除配偶资料',
                message: '确定要删除该条记录吗?',
                buttons: '确认删除'
            } );
        } );

        var table = $('#marry-list-data').DataTable( {
            //dom: "bfrtip",
            //dom:"<'row'<'col-md-9'l><'col-md-3'f>r>tip",
            dom:"<'row'<'col-sm-12'l>r>t",
            lengthChange: false,     //是否允许用户改变表格每页显示的记录数，默认为true
            lengthMenu: [
                [10, 8, 15, 20, 25, 50, 100, -1],
                [10, 8, 15, 20, 25, 50, 100, "全部"]
            ],//每页显示条数设置
            stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
            scrollX: true,          //水平滚动
            scrollY: 200,
            ajax: {
                url:  "<?=Url::to(['/marry/data-tables', 'type'=>'fetch', 'pid'=>$pid])?>",
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
                    data : "id",
                    className: 'text-center',
                    orderable: false
                },
                { data: "code1" },
                { data: "marrow" },
                {
                    data: null,
                    className: 'text-center',
                    render: function ( data, type, row ) {
                        // Combine the first and last names into a single table field
                        return preferences.marry[data.because] ? preferences.marry[data.because] : '未知' ;
                    }
                },
                {
                    data: "becausedate",
                    className: 'text-center'
                },
                {
                    data: "marrowdate",
                    className: 'text-center'
                },
                {
                    data: null,
                    className: 'text-center',
                    render: function ( data, type, row ) {
                        // Combine the first and last names into a single table field
                        return preferences.marry[data.hmarry] ? preferences.marry[data.hmarry] : '未知';
                    }
                },
                {
                    data: null,
                    className: 'text-center',
                    render: function ( data, type, row ) {
                        // Combine the first and last names into a single table field
                        return preferences.hkxz[data.hfp] ? preferences.hkxz[data.hfp] : '未知';
                    }
                },
                {
                    data: "mfcode",
                    className: 'text-center'
                },
                {
                    data: "marrycode",
                    className: 'text-center'
                },
                {
                    data: "marrowno",
                    className: 'text-center'
                },
                { data: "mhkdz" },
                { data: "marrowunit" },
                { data: "maddr" },
                { data: "othertel" },
                { data: "mpostcode" },
                { data: "mem" },
                {
                    data: null,
                    className: "text-center",
                    defaultContent: '<i class="fa fa-pencil text-primary editor_edit" data-toggle="tooltip" data-placement="bottom" title="修改" style="cursor: pointer;"></i> &nbsp;&nbsp;' +
                    '<i class="fa fa-trash text-primary editor_remove" data-toggle="tooltip" data-placement="bottom" title="删除" style="cursor: pointer;"></i>'
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
            order: [[ 5, "asc" ]],//初始排序
            //deferRender: true, //当处理大数据时，延迟渲染数据，有效提高Datatables处理能力
            /*select: {
                style: 'multi'
            },*/
            keys: {
                columns: ':not(:first-child)',
                editor:  editor
            },
            select: {
                style:    'os',
                selector: 'td:first-child',
                blurable: true
            },
            createdRow: function( row, data, dataIndex ) {
                if ( data.because >= '30' ) {
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

        new $.fn.dataTable.Buttons( table, [
            { extend: "create", editor: editor, text: '<i class="fa fa-plus"></i> 新增' },
            { extend: "edit",   editor: editor, text: '<i class="fa fa-pencil"></i> 修改' },
            { extend: "remove", editor: editor, text: '<i class="fa fa-trash"></i> 删除' },
            /*{ extend: "edit",   editor: editor },
             { extend: "remove", editor: editor },*/
            //column selector
            {
                extend: 'colvis',
                text: '掩藏/显示 列',
                //第几列开始
                //columns: ':gt(1)'
            },
            {
                extend: 'collection',
                text: '<i class="fa fa-share-square-o"></i> 导出',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fa fa-clipboard"></i> 复制',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> 导出Excel',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-excel-o"></i> 导出Csv',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> 打印全部',
                        //disable auto print
                        autoPrint: false,
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' );

                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );

                            $(win.document.body).find( 'h1' )
                                .addClass( 'text-center' );
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> 打印所选',
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
                    //console.log(cell);
                    cell.innerHTML = i + 1;
                    table.cell(cell).invalidate('dom');//解决打印时不显示序号
                });
            }).draw();



        /*table.buttons().container()
         .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );*/

        //按钮组和每页页码选择框间隔开
        table.buttons().container()
            .append('&nbsp;&nbsp;&nbsp;&nbsp;')
            .prependTo( $('.col-sm-12:eq(0)', table.table().container() ) );

        $(document)
            //输入身份证，自动生成性别及出生日期
            .on('keyup blur', '#DTE_Field_mfcode', function() {
                var fcode = $(this).val();
                var res   = certificateNoParse(fcode);
                if ( res ) {
                    $('#DTE_Field_marrowdate').val(res.birthday);
                }
            });
    } );
</script>
<?php \common\widgets\JsBlock::end(); ?>
