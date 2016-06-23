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
                        data: 'pbc_cnam'
                    }
                ],
                order: [[ 1, "asc" ]],//初始排序
                select: {
                    style: 'os',
                    items: 'cell',
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
        } );
    </script>
<?php \common\widgets\JsBlock::end(); ?>