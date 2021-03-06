<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-23 下午5:47
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */
/* @var $this yii\web\View */

$this->title = '未配置字段';
\common\assets\DataTableAsset::register($this);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <table id="col-missing-data" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>表名</th>
                    <th>未配置字段名</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade" id="col-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">新增表字段配置</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="col-add-form" action="<?= \yii\helpers\Url::to(['create']) ?>">
                    <div class="form-group">
                        <label for="pbc_tnam" class="col-sm-2 control-label">表名</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="ColTable[pbc_tnam]" id="pbc_tnam" placeholder="输入表名..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_cnam" class="col-sm-2 control-label">字段名</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="ColTable[pbc_cnam]" id="pbc_cnam" placeholder="输入字段名..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_labl" class="col-sm-2 control-label">中文标签</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="ColTable[pbc_labl]" id="pbc_labl" placeholder="输入中文标签..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_classmark" class="col-sm-2 control-label">参数配置</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="ColTable[pbc_classmark]" id="pbc_classmark" placeholder="输入参数配置..">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                <button type="button" id="col-add-form-sumbit" class="btn btn-primary">保 存</button>
            </div>
        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#col-missing-data').DataTable( {
                lengthChange: true,     //是否允许用户改变表格每页显示的记录数，默认为true
                lengthMenu: [
                    [10, 8, 15, 20, 25, 50, 100, -1],
                    [10, 8, 15, 20, 25, 50, 100, "全部"]
                ],//每页显示条数设置
                stateSave: true,        //保存状态，如果当前页面是第五页，刷新还是在第五页，默认为false
                ajax: {
                    url:  "<?=Yii::$app->homeUrl?>/populac/col-table/col-missing?type=fetch",
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
                    //序号，
                    {
                        width : '40px',
                        data : null
                    },
                    {
                        width : '200px',
                        data: 'pbc_tnam'
                    },
                    {
                        data: 'pbc_cnam',
                        render: function ( data, type, full ) {
                            var array   = data.split(',');
                            var string  = '';
                            var label   = ['default', 'primary', 'success'];
                            for (var i in array)
                            {
                                string += ' <span style="cursor: pointer;" class="label label-' + label[ Math.floor(Math.random()*label.length) ] + ' label-col-add" data-pbc_cnam = "' + array[i] + '" data-toggle="tooltip" title="点击新增『' + array[i] + '』字段配置">' + array[i] + '</span> ';
                            }
                            return string;
                        }
                    }
                ],
                order: [[ 1, "asc" ]],//初始排序
                /*select: {
                    style: 'os',
                    items: 'cell',
                    blurable: true
                },*/
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
                    table.column(0, {
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

            //datatable头部置顶
            $('#col-missing-data').floatThead({
                top: $(".main-header").height() //i need this because of my floating header
            });

            //col-add  #col-add-form
            $(document)
                .on('click', 'span.label-col-add', function() {
                    var pbc_cnam = $(this).attr('data-pbc_cnam');
                    var pbc_tnam = $(this).parents('tr').find('td:eq(1)').text().trim();
                    $('form#col-add-form input#pbc_tnam').val(pbc_tnam);
                    $('form#col-add-form input#pbc_cnam').val(pbc_cnam);
                    $('#col-form-modal').modal('show');
                })
                .on('click', '#col-add-form-sumbit', function() {
                    var form = $('form#col-add-form');
                    $.ajax({
                        url  : form.attr('action'),
                        type : 'post',
                        data : form.serialize(),
                        beforeSend: function () {
                            layer.load(1);
                        },
                        complete: function () {
                            layer.closeAll('loading');
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            layer.alert('保存出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                        },
                        success: function(data) {
                            var msg = $.parseJSON(data);
                            if ( msg.status == 'success' ) {
                                $('#col-form-modal').modal('hide');
                                table.ajax.reload();
                                layer.msg(msg.message, { icon: 6, time: 2000 });
                            } else {
                                layer.msg(msg.message, { icon: 5, time: 2000 });
                            }
                        }
                    });
                });
        } );

    </script>
<?php \common\widgets\JsBlock::end(); ?>