<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-27 下午5:05
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

$this->title = Yii::t('easyii', 'Preferences');
\common\assets\DataTableEditorAsset::register($this);
\common\assets\Qtip::register($this);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <div class="populac-datatable-info-block" id="populac-datatable-view">
            <table class="populac-datatable-data-info" width="100%">
                <tr>
                    <td>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;
                                line-height: normal;width: 75%;padding-top: 5px;">
                                    项目配置参数详情
                                </h3>
                                <div class="pull-right">
                                    <button class="btn btn-danger" id="btn-view-delete" style="margin-right: 15px;">
                                        <i class="fa fa-remove"></i> 删除
                                    </button>
                                    <button class="btn btn-success" id="btn-view-copy" style="margin-right: 15px;">
                                        <i class="fa fa-copy"></i> 复制
                                    </button>
                                    <button class="btn btn-primary" id="btn-view-edit">
                                        <i class="fa fa-edit"></i> 修改
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body populac-datatable-info-content">
                                <div class="row-fluid">
                                    <div class="col-md-4">
                                        <label class="prop-name">ID号:</label>
                                        <div class="prop-value" id="primary-id"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="prop-name">项目名称-中文:</label>
                                        <div class="prop-value" id="classmarkcn"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="prop-name">项目名称-英文:</label>
                                        <div class="prop-value" id="classmark"></div>
                                    </div>

                                </div>
                                <div class="row-fluid">
                                    <div class="col-md-4">
                                        <label class="prop-name">参数编码:</label>
                                        <div class="prop-value" id="codes"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="prop-name">参数名称:</label>
                                        <div class="prop-value" id="name1"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="prop-name">状态:</label>
                                        <div class="prop-value" id="status"></div>
                                    </div>

                                </div>
                                <div class="row-fluid">
                                    <div class="col-md-4">
                                        <label class="prop-name">新增时间:</label>
                                        <div class="prop-value" id="created_at"></div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="prop-name">最后一次修改时间:</label>
                                        <div class="prop-value" id="updated_at"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
        <table id="preferences-data" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="width:50px; ">
                        全选<input type="checkbox" id="checkAll"></th>
                    <th>序号</th>
                    <th>项目ID</th>
                    <th>项目名称(中文)</th>
                    <th>项目名称(英文)</th>
                    <th>参数编码</th>
                    <th>参数名称</th>
                    <th>状态</th>
                    <th>添加时间</th>
                    <th>最后一次修改时间</th>
                </tr>
            </thead>
        </table>
    </div>
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
                ajax: {
                    url:  "/admin/populac/preferences/index?type=crud",
                    dataSrc: '',
                    error: function() {
                        layer.msg("数据处理失败，请重试!",{icon: 5});
                    }
                },
                table: "#preferences-data",
                idSrc:  'id',
                i18n: {
                    create: {
                        button: "新增",
                        title:  "新增系统配置参数",
                        submit: "保存"
                    },
                    edit: {
                        button: "修改",
                        title:  "修改系统配置参数",
                        submit: "保存"
                    },
                    remove: {
                        button: "删除",
                        title:  "删除系统配置参数",
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
                    label: "项目名称(中文):",
                    name: "classmarkcn"
                }, {
                    label: "项目名称(英文):",
                    name: "classmark"
                }, {
                    label: "参数编码:",
                    name: "codes"
                }, {
                    label: "参数名称:",
                    name: "name1"
                }, {
                    label: "状态:",
                    name: "status",
                    type: "select",
                    ipOpts: [
                        { "label": "启用", "value": "1" },
                        { "label": "禁用", "value": "0"}
                    ]
                } ]
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
                        if (confirm( '您有未保存的更改..确定要退出吗?' ))
                            return true;
                        else
                            return false;
                        //return confirm( '您有未保存的更改..确定要退出吗?' );
                    }
                } )
                //新增并保存成功事件
                .on('create', function(e, json, data) {
                    table.search( data.classmark ).draw();
                    layer.msg('记录已新增..如当前页没显示，请在搜索框中输入相关信息过滤查看！', {icon: 6});
                })
                //修改并保存成功事件
                .on('edit', function(e, json, data) {
                    table.search( data.classmark ).draw();
                    layer.msg('记录已修改..如当前页没显示，请在搜索框中输入相关信息过滤查看！', {icon: 6});
                })
                //删除并保存成功事件
                .on('remove', function(e, json, data) {
                    layer.msg('记录已删除..如是误删了该记录则请点击[恢复数据]按钮恢复！', {
                        time: 0, //不自动关闭
                        icon: 6,
                        title: '系统提示',
                        btn: ['恢复数据', '关闭'],
                        yes: function(index){
                            layer.close(index);
                            layer.msg('5秒后将跳转至[历史数据]界面..请按提示恢复误删记录！', {icon: 6, time: 5000, title: '系统提示'}, function() {
                                location.href="<?= Yii::$app->urlManager->createUrl(['/populac/preferences/history']); ?>";
                            });
                        }
                    });
                });


            //editable cell add fa-edit icon
            var editIcon = function ( data, type, row ) {
                if ( type === 'display' ) {
                    return data + ' <i class="fa fa-edit"/>';
                }
                return data;
            };

            var table = $('#preferences-data').DataTable( {
                /**
                 * DOM positioning default set:lfrtip
                 * l - Length changing
                 * f - Filtering input
                 * t - The Table!
                 * i - Information
                 * p - Pagination
                 * r - pRocessing
                 * < and > - div elements
                 * <"#id" and > - div with an id
                 * <"class" and > - div with a class
                 * <"#id.class" and > - div with an id and class
                 */
                //dom: "Bfrtip",
                //dom: 'rt<"bottom"iflp<"clear">>',
                lengthChange: true,     //是否允许用户改变表格每页显示的记录数，默认为true
                lengthMenu: [
                    [10, 8, 15, 20, 25, 50, 100, -1],
                    [10, 8, 15, 20, 25, 50, 100, "全部"]
                ],//每页显示条数设置
                stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
                ajax: {
                    url:  "/admin/populac/preferences/index?type=fetch",
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
                        data : function(row, type, set, meta) {
                            var c = meta.settings._iDisplayStart + meta.row + 1;
                            //var c = '';
                            return '';
                        }
                    },
                    { data: "id" },
                    { data: "classmarkcn" },
                    { data: "classmark" },
                    { data: "codes", className: 'editable', render: editIcon },
                    { data: "name1", className: 'editable', render: editIcon },
                    { data: "status", className: 'editable', render: function ( data, type, full ) {
                        if(data) {
                            return '<i class="fa fa-check text-success"></i>';
                        } else {
                            return '<i class="fa fa-close text-danger"></i>';
                        }
                    }
                    },
                    { data: "created_at", render: function ( data, type, full ) {
                        if(data){
                            var mDate = moment(data * 1000);
                            return (mDate && mDate.isValid()) ? mDate.format('YYYY-MM-DD HH:mm:ss') : "";
                        }
                        return "";
                    } },
                    { data: "updated_at", render: function ( data, type, full ) {
                        if(data){
                            var mDate = moment(data * 1000);
                            return (mDate && mDate.isValid()) ? mDate.fromNow() : "";
                        }
                        return "";
                    } }
                ],
                //隐藏ID列
                columnDefs: [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1
                    },
                    {
                        "targets": 2,//隐藏系统配置参数ID
                        "visible": false,
                        "searchable": false
                    }
                ],
                order: [[ 4, "asc" ]],//初始排序
                //https://datatables.net/reference/option/deferRender
                //当处理大数据时，延迟渲染数据，多页记录时只渲染当页，有效提高Datatables处理能力,但有个坏处就是影响了排序代码。
                //deferRender: true,
                //select: true,
                keys: {
                    columns: ':not(:first-child)',
                    editor:  editor
                },
                /*select: {
                    style:    'os',
                    selector: 'td:first-child',
                    blurable: true
                },*/
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
                        values.codes = '';
                        values.name1 = '';
                        editor
                            .create( {
                                title: '复制的记录',
                                buttons: '保 存'
                            } )
                            .set( values );
                    }
                },
                {
                    extend: "edit",
                    editor: editor,
                    action: function () {
                        var indexes = table.rows( {selected: true} ).indexes();

                        editor.edit( indexes, {
                            title: '修改系统配置参数',
                            buttons: indexes.length === 1 ?
                                backNext :
                                '保存'
                        } );
                    }
                },
                { extend: "remove", editor: editor },
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
            //新增时转移焦点
            $(document).on('click', '.buttons-create, .buttons-edit', function() {
                //$('td.focus').trigger('blur');
                $('h3.panel-title').trigger('click');
                /*editor
                    .on('preBlur', function ( e ) {
                        // On close, check if the values have changed and ask for closing confirmation if they have
                        if ( openVals !== JSON.stringify( editor.get() ) ) {
                            return confirm( '您有未保存的更改..确定要退出吗?' );
                        }
                    } );*/
            });

            //checkbox全选
            $("#checkAll").on("click", function () {
                if ($(this).prop("checked") === true) {
                    $("input[name='checkList']").prop("checked", $(this).prop("checked"));
                    $('#preferences-data tbody tr').addClass('selected');
                } else {
                    $("input[name='checkList']").prop("checked", false);
                    $('#preferences-data tbody tr').removeClass('selected');
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

            //按钮组和每页页码选择框间隔开
            table.buttons().container()
                .append('&nbsp;&nbsp;&nbsp;&nbsp;')
                .prependTo( $('.col-sm-6:eq(0) div.dataTables_length', table.table().container() ) );

            //Inline single cell editing on click
            $('#preferences-data')
                .on( 'click', 'tbody td.editable', function (e) {
                    //editor.inline( this );
                    //editor.bubble( this );
                    //editor.off('preBlur');
                    editor.inline( this, {
                        onBlur: 'submit'
                    } );
                } )
                //qtip
                .on('mouseenter', 'td', function (event) {
                    var item = table.row($(this).closest('tr')).data();
                    //console.log(item);
                    if(!item)
                        return;
                    var content = '<table class="table table-striped">' +
                            '<tr>'+
                                '<td align="right">项目ID:</td>'+
                                '<td>'+(item?item.id:'')+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">项目名称-中文:</td>'+
                                '<td>'+item.classmarkcn+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">项目名称-英文:</td>'+
                                '<td>'+item.classmark+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">参数编码:</td>'+
                                '<td>'+item.codes+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">参数名称:</td>'+
                                '<td>'+item.name1+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">状态:</td>'+
                                '<td>'+(item.status? '<i class="fa fa-check text-success"></i>':'<i class="fa fa-close text-danger"></i>')+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">新增时间:</td>'+
                                '<td>'+moment(item.created_at * 1000).format('YYYY-MM-DD HH:mm:ss')+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td align="right">最后修改时间:</td>'+
                                '<td>'+moment(item.updated_at * 1000).fromNow()+'</td>'+
                            '</tr>'+
                        '</table>';
                    $(this).qtip({
                        id: item.id,
                        overwrite: false,
                        content: {
                            title: {
                                //button: true,
                                text: '<img src="<?= Yii::getAlias('@web'); ?>/images/js32.png" /> <span style="font-size=15px;">详细信息</span>'+
                                        '<div class="pull-right">'+
                                            '<button class="btn btn-small btn-danger" style="margin-right: 2px;" id="btn-view-delete">'+
                                                '<i class="fa fa-remove"></i> 删除'+
                                            '</button>'+
                                            '<button class="btn btn-small btn-success" id="btn-view-edit">'+
                                                '<i class="fa fa-edit"></i> 修改'+
                                            '</button>'+
                                        '</div>'
                            },
                            text: content
                        },
                        position: {
                            at: 'right center', //center center
                            my: 'left center',
                            viewport: $('#preferences-data')
                        },
                        show: 'click',
                        hide: 'unfocus',
                        style: {
                            widget: true,
                            classes: 'qtip-ui',
                            width: 600
                        }
                    }, event);
                    // Note we passed the event as the second argument. Always do this when binding within an event handler


                })
                .on("click","tr",function(event) { //行点击事件   td:first-child
                    //获取该行对应的数据
                    var item = table.row($(this).closest('tr')).data();
                    if (!item) {
                        $("#populac-datatable-view .prop-value").text("");
                        return;
                    }
                    $("#primary-id").text(item.id);
                    $("#classmarkcn").text(item.classmarkcn);
                    $("#classmark").text(item.classmark);
                    $("#codes").text(item.codes);
                    $("#name1").text(item.name1);
                    $("#status").html(item.status? '<i class="fa fa-check text-success"></i>':'<i class="fa fa-close text-danger"></i>');
                    $("#created_at").text(moment(item.created_at * 1000).format('YYYY-MM-DD HH:mm:ss'));
                    $("#updated_at").text(moment(item.updated_at * 1000).fromNow());
                    $(this).addClass('last-visited-' + item.id);
                    Cookies.set('last-visited-id', item.id);
            });

            //datatable头部置顶
            $('#preferences-data').floatThead({
                top: $(".main-header").height() //i need this because of my floating header
            });
            //定制前后保存按钮 Previous / next editing buttons
            var backNext = [
                {
                    label: "&lt;",
                    fn: function (e) {
                        // On submit, find the currently selected row and select the previous one
                        this.submit( function () {
                            var indexes = table.rows( {search: 'applied'} ).indexes();
                            var currentIndex = table.row( {selected: true} ).index();
                            var currentPosition = indexes.indexOf( currentIndex );

                            if ( currentPosition > 0 ) {
                                table.row( currentIndex ).deselect();
                                table.row( indexes[ currentPosition-1 ] ).select();
                            }

                            // Trigger editing through the button
                            table.button( 1 ).trigger();
                        }, null, null, false );
                    }
                },
                '保存',
                {
                    label: "&gt;",
                    fn: function (e) {
                        // On submit, find the currently selected row and select the next one
                        this.submit( function () {
                            var indexes = table.rows( {search: 'applied'} ).indexes();
                            var currentIndex = table.row( {selected: true} ).index();
                            var currentPosition = indexes.indexOf( currentIndex );

                            if ( currentPosition < indexes.length-1 ) {
                                table.row( currentIndex ).deselect();
                                table.row( indexes[ currentPosition+1 ] ).select();
                            }

                            // Trigger editing through the button
                            table.button( 1 ).trigger();
                        }, null, null, false );
                    }
                }
            ];

            $(document).on('click', '#btn-view-edit', function() {
                var lastVisitedId = '.last-visited-' + Cookies.get('last-visited-id'); //table.rows( {selected: true} ).indexes();
                if (!Cookies.get('last-visited-id')) {
                    layer.msg('无法获取对象数据..请点击内容行再试！', {icon: 5});
                    return;
                }
                //关闭所有的qtip
                $('.qtip.ui-tooltip').qtip('hide');
                editor.edit( table.row(lastVisitedId).indexes(), {
                    title: '信息更新',
                    buttons: '保存'
                });
            })
                .on('click', '#btn-view-copy', function() {
                    var lastVisitedId = '.last-visited-' + Cookies.get('last-visited-id'); //table.rows( {selected: true} ).indexes();
                    if (!Cookies.get('last-visited-id')) {
                        layer.msg('无法获取对象数据..请点击内容行再试！', {icon: 5});
                        return;
                    }
                    //关闭所有的qtip
                    $('.qtip.ui-tooltip').qtip('hide');
                    var values = editor.edit(
                        table.row(lastVisitedId).indexes(),
                        false
                        )
                        .val();

                    // Create a new entry (discarding the previous edit) and
                    // set the values from the read values and customize self fields's default value
                    values.codes = '';
                    values.name1 = '';
                    editor
                        .create( {
                            title: '复制的记录',
                            buttons: '保 存'
                        } )
                        .set( values );
                })
                .on('click', '#btn-view-delete', function() {
                    var lastVisitedId = '.last-visited-' + Cookies.get('last-visited-id'); //table.rows( {selected: true} ).indexes();
                    if (!Cookies.get('last-visited-id')) {
                        layer.msg('无法获取对象数据..请点击内容行再试！', {icon: 5});
                        return;
                    }
                    /*editor.remove( table.row(lastVisitedId).indexes(), {
                        title: '删除系统配置参数',
                        formMessage: '确定要删除该条记录吗?',
                        buttons: '确认删除'
                    });*/
                    var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                    layer.confirm('<span class="text-danger">确定要删除该条记录吗?</span>', {
                        title: '删除系统配置参数',
                        shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                        icon: 5,
                        scrollbar: false
                    }, function(index) {
                        editor
                            .remove( table.row(lastVisitedId).indexes(), false )
                            .submit();
                        Cookies.remove('last-visited-id');
                        layer.msg('记录已删除..如需恢复请进入历史数据模块！', {icon: 6}, function(index) {
                            layer.close(index);
                        });
                    }, function(index) {
                        layer.close(index);
                    });
                });

            Cookies.remove('last-visited-id');
            // Inline whole line editing on click 整行编辑
            /*$('#preferences-data').on( 'click', 'tbody td:not(:first-child)', function (e) {
                editor.inline( this );
            } );

            // Inline whole line editing on tab focus
            table.on( 'key-focus', function ( e, datatable, cell ) {
                editor.inline( cell.index(), {
                    onBlur: 'submit'
                } );
            } );*/
        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>