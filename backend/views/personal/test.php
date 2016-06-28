<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-20 上午9:26
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * @var integer $iSearchColNum
 */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-info-circle text-purple"></i>
        <h3 class="box-title text-purple">高级条件搜索</h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-info btn-sm" id="btn-view-search"
                    data-toggle="modal" data-target="#btn-view-adv-search" data-backdrop="static" title="可以单独对表名或字段名搜索">
                <i class="fa fa-search"></i> <span id="btn-view-search-title">显示高级搜索</span>
            </button>
            <button type="button" class="btn btn-success btn-sm" data-widget="collapse" data-toggle="tooltip" title="折叠">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /. tools -->
    </div>
    <div class="box-body">

    </div>
</div>
<div class="modal fade" id="btn-view-adv-search" tabindex="-1">
    <div class="modal-dialog" style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-info">多功能查询:输入值如果要输入多个，输入逗号、空格或回车键会自动隔开 <i id="btn-view-adv-search-help" class="fa fa-question-circle text-warning" data-toggle="tooltip" title="点击查看帮助" style="cursor: pointer"></i></h4>
            </div>
            <form id="btn-view-adv-search-form">
            <div class="modal-body">
            <?php for( $i = 0; $i < $iSearchColNum; $i++ ): ?>
                <div class="row row-<?=$i?>" style="margin: 5px 0;">
                    <div class="col-md-1 col-left">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'left-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tLeft'),
                            'value'     => '',
                            'options'   => [
                                'prompt' => '',
                                'title' => '如需要选择左括号，请选择..'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-3 col-field">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'field-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\ColTable::getColumnInfoByTablename('personal'),
                            'value'     =>  ($i==0) ? 'personal.unit' : (($i==1) ? 'personal.logout' : (($i==2) ? 'personal.name1' : '')),
                            'options'   => [
                                'prompt' => '过滤条件',
                                'class'  => 'field-select',
                                'data-classname' => 'select-value-' . $i,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-2 col-choose">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'choose-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tChoose'),
                            'value'     => 'like',
                            'options'   => [
                                'multiple'  => false,
                                'class'     => 'choose-select-' . $i,
                            ],
                            'pluginOptions' => [
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-4 col-value">
                        <select disabled class="value-select select-value-<?=$i?>" name="value-<?=$i?>" multiple="multiple" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-1 col-right">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'right-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tRight'),
                            'options'   => [
                                'prompt' => '',
                                'title' => '如需要选择右括号，请选择..'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-1 col-relation">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'relation-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tRelation'),
                            'value'     => 'and',
                            'options'   => [
                                'multiple'  => false,
                            ],
                            'pluginOptions' => [
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                </div>
            <?php endfor; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                <button type="button" class="btn btn-primary" id="btn-view-adv-search-relation">确 定</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
//echo "$o_dropdown";
\common\widgets\JsBlock::begin();
?>
    <script type="text/javascript">
        $(document).on('click', '#btn-view-adv-search-help', function() {
            var tour = new Tour({
                duration: 30000,
                backdrop: true,
                template: "<div class='popover tour'>" +
                "<div class='arrow'></div>" +
                "<h3 class='popover-title'></h3>" +
                "<div class='popover-content'></div>" +
                "<div class='popover-navigation'>" +
                "<button class='btn btn-default' data-role='prev'><i class='fa fa-hand-o-left'></i>前</button>" +
                "<span data-role='separator'>|</span>" +
                "<button class='btn btn-default' data-role='next'><i class='fa fa-hand-o-right'></i>后</button>" +
                "<button class='btn btn-default' data-role='end'>结束</button>" +
                "</div>" +
                "</div>",
                steps: [
                    {
                        element: "div.row-0 .col-left",
                        title: "提示一",
                        content: "左括号区域，逻辑关系比较复杂的可以选择"
                    },
                    {
                        element: "div.row-0 .col-field",
                        title: "提示二",
                        content: "过滤条件区域，选择需要过滤的信息段"
                    },
                    {
                        element: "div.row-0 .col-choose",
                        title: "提示三",
                        content: "逻辑比较符区域，如输入值有多个，建议选择'范围内'，如输入值只有一个，可选择'包含'"
                    },
                    {
                        element: "div.row-0 .col-value",
                        title: "提示四",
                        content: "输入值区域，如果是选择框可以多次选择，如果是输入框需要输入多个值，输入逗号、空格或回车键会自动隔开"
                    },
                    {
                        element: "div.row-0 .col-right",
                        title: "提示五",
                        content: "右括号区域，如果有选择左括号务必选一个右括号相对应"
                    },
                    {
                        element: "div.row-0 .col-relation",
                        title: "提示六",
                        content: "关系符区域，'与'表示'并且'的意思，'或'表示'或者'的意思"
                    },
                    {
                        element: "#btn-view-adv-search-relation",
                        title: "最后",
                        content: "点击'确定'按钮提交过滤条件"
                    }
                ]});

            // Initialize the tour
            tour.init();

            // Start the tour
            tour.restart();
        })
            .on('click', '#btn-view-adv-search-relation', function() {
                var data        = $('#btn-view-adv-search-form').serializeArray();
                var left        = [];
                var sfield      = [];
                var choose      = [];
                var value       = [];
                var right       = [];
                var relation    = [];
                var valid       = []; //有效行数
                var k_left      = []; //左括号key值
                var k_right     = []; //右括号key值
                var i_left      = 0;  //左括号数
                var i_right     = 0;  //右括号数
                var sql         = '';
                $.each(data, function(i, field) {
                    var key = (field.name).split('-')[1];
                    switch ((field.name).split('-')[0]) {
                        case 'left':
                            left[key]   = field.value;
                            if( field.value ) {
                                k_left.push(key);
                                i_left += (field.value).length;//计算左括号数量
                            }
                            break;
                        case 'field':
                            sfield[key] = field.value;
                            if (field.value) {
                                valid.push(key);//当该行有value值输入才判定为有效
                            }
                            break;
                        case 'choose':
                            choose[key] = field.value;
                            break;
                        case 'value':
                            value[key] = $('.select-value-' + key).val();
                            break;
                        case 'right':
                            right[key]  = field.value;
                            if( field.value ) {
                                k_right.push(key);
                                i_right += (field.value).length;//计算右括号数量
                            }
                            break;
                        case 'relation':
                            relation[key]   = field.value;
                            break;
                    }
                });

                //校验左右括号数目是否一致
                if ( i_left != i_right ) {
                    layer.msg('搜索条件中，左右括号数目不相同，请检查..', {icon: 5, time: 3000});
                    return false;
                }

                //拼接SQL
                for ( var i = 0; i < valid.length; i++ ) {
                    if ( !value[i] )//没有输入值，跳出当次循环
                        continue;
                    var s_value = value[i];
                    //如果有多个值，必须提醒[逻辑比较符]改为[范围内]或[范围外]
                    if( typeof( s_value ) == 'object' && s_value.length > 1 && choose[i] != 'in' && choose[i] != 'not in' ) {
                        layer.msg('输入值有多个，请将[逻辑比较符]改为[范围内]或[范围外]..', {icon: 5, time: 2000}, function(index) {
                            layer.tips('[逻辑比较符]改为[范围内]或[范围外]..', '.row-' + i + ' .col-choose', {
                                tips: [2, '#3595CC'], //可配置颜色 1上 2右 3下 4左
                                time: 4000
                            });
                        });
                        return false;
                    }
                    if ( sfield[i].split('.')[1] != 'unit' ) {//非单位编码字段
                        if ( choose[i] == 'like' || choose[i] == 'not like' ) {
                            s_value = "'%" + s_value + "%'";
                        }
                        if ( choose[i] == 'in' || choose[i] == 'not in' ) {
                            if ( typeof( s_value ) == 'string' ) {
                                s_value = "['" + s_value + "']";
                            } else {
                                var  s_value_tmp = '';
                                for ( var j = 0; j < s_value.length; j++ ) {
                                    s_value_tmp += (j > 0 ? ', ' : '') + "'" + s_value[j] + "'";
                                }
                                s_value = "[" + s_value_tmp + "]";
                            }
                        }
                        sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                            left[i] + sfield[i] + ' ' + choose[i] + ' ' + s_value + right[i];
                    } else {//单位编码字段
                        if ( choose[i] == 'like' || choose[i] == 'not like' ) {
                            s_value = "'" + s_value + "'";
                            sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                left[i] + ( choose[i] == 'not like' ? 'not ' : '' ) + "FIND_IN_SET (" + sfield[i] + ", " + s_value + ")" + right[i];
                        }
                        if ( choose[i] == 'in' || choose[i] == 'not in' ) {
                            if ( typeof( s_value ) == 'string' ) {
                                s_value = "'" + s_value + "'";
                                sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                    left[i] + ( choose[i] == 'not in' ? 'not ' : '' ) + "FIND_IN_SET (" + sfield[i] + ", " + s_value + ")" + right[i];
                            } else {
                                var  s_value_tmp = '';
                                for ( var j = 0; j < s_value.length; j++ ) {
                                    s_value_tmp += (j > 0 ? ' or ' : '') + "FIND_IN_SET (" + sfield[i] + ", '" + s_value + "')"
                                }
                                sql += ' ' + ( (i > 0 && sql > '') ? ( relation[i-1] + ' ' ) : '' ) +
                                    left[i] + ( choose[i] == 'not in' ? 'not ' : '' ) + '(' + s_value_tmp + ')' + right[i];
                            }
                        }

                    }
                }
                $('#btn-view-adv-search').modal('hide');
                //TODO
                console.log(sql);
            });
        $(function() {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};//modal bug

            /*$('.select-value-0').prop("disabled", false);
            $('.select-value-1').prop("disabled", false);
            $('.select-value-1').select2({
                data: [{"id":0,"text":"有效"},{"id":1,"text":"离退休"},{"id":2,"text":"死亡"},{"id":3,"text":"迁出"},{"id":4,"text"
                    :"开除"},{"id":5,"text":"辞职"},{"id":6,"text":"调离"},{"id":7,"text":"解除劳动合同"},{"id":8,"text":"合同期满"},{"id"
                    :9,"text":"其他"}]
            }).val("0").trigger("change");*/
            $('.field-select').on("select2:select", function (e) {
                if ( !($(this).val()) )
                    return false;
                var $fieldSelect = $('.' + $(this).attr('data-classname'));
                var params = $(this).val();
                var classmark = params.split('.')[1];
                //var $chooseSelect = $('.choose-select-' + ($(this).attr('name')).split('-')[1]);

                $.ajax({
                    url: '<?= Yii::$app->homeUrl ?>/populac/col-table/get-field-config',
                    data: { params : params },
                    type: 'post',
                    beforeSend: function () {
                        layer.load();
                    },
                    complete: function () {
                        layer.closeAll('loading');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        layer.alert('数据读取出错:' + textStatus + ' ' + errorThrown, {icon: 5});
                    },
                    success: function(data) {
                        $fieldSelect.prop("disabled", false);
                        if ( data ) {
                            //$chooseSelect.select2().val('in').trigger("change");
                            //$fieldSelect.select2('destroy');//先销毁
                            //$fieldSelect.attr('multiple', 'multiple');//设置为可多选
                            $fieldSelect.html('');//清空之前的选项
                            $fieldSelect.select2({
                                data: $.parseJSON(data)
                            });
                            if ( classmark == 'logout' )//注销原因
                                $fieldSelect.select2().val("0").trigger("change");
                        } else {
                            $fieldSelect.html('');//清空之前的选项
                            //$fieldSelect.select2('destroy');//先销毁
                            $fieldSelect.select2({
                                //data: [{id:0, text: '..'}],
                                placeholder: '输入值',
                                tags: true,//tagging support
                                tokenSeparators: [',', '，', ' '],//输入 ',' 或 '空格'的时候自动生成 tag
                            });
                        }
                    }
                });
            });
            //modal shown event: loading col-value's config data
            var i_modal_shown = 0;
            $('#btn-view-adv-search').on('shown.bs.modal', function (e) {
                if ( !i_modal_shown++ )
                {
                    $(".value-select").select2({
                        placeholder: '输入值',
                        tags: true,//tagging support
                        tokenSeparators: [',', '，', ' '],//输入 ',' 或 '空格'的时候自动生成 tag
                    });
                    $('.field-select').trigger('select2:select');
                }
            })
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>



