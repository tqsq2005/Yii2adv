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
?>
<div class="box box-primary">
    <div class="box-body">
        <form>
            <?php for( $i = 0; $i < 8; $i++ ): ?>
                <div class="row row-<?=$i?>" style="margin: 5px 0;">
                    <div class="col-md-1">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'left-' + $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tLeft'),
                            'options'   => [
                                'prompt' => '选择左括号',
                                'title' => '如需要选择左括号，请选择..'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-4">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'field-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\ColTable::getColumnInfoByTablename('personal'),
                            'value'     => 'unit',
                            'options'   => [
                                'prompt' => '请选择需要过滤的条件',
                                'class'  => 'field-select',
                                'data-classname' => 'select-value-' . $i,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-1">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'choose-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tChoose'),
                            'value'     => 'like',
                            'options'   => [
                                'multiple' => false,
                            ],
                            'pluginOptions' => [
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-4">
                        <select class="value-select select-value-<?=$i?>" name="value-<?=$i?>" multiple="multiple" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col-md-1">
                        <?= \kartik\widgets\Select2::widget([
                            'name'      => 'right-' . $i,
                            'theme'     => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'data'      => \common\populac\models\Preferences::getByClassmark('tRight'),
                            'options'   => [
                                'prompt' => '选择右括号',
                                'title' => '如需要选择右括号，请选择..'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumResultsForSearch' => 'Infinity',//禁用搜索框
                            ]
                        ]);?>
                    </div>
                    <div class="col-md-1">
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
        </form>
    </div>
</div>
<?php
//echo "$o_dropdown";
\common\widgets\JsBlock::begin();
?>
    <script type="text/javascript">
        $(function() {
            $(".value-select").select2({
                placeholder: '请直接输入，按逗号或空格键分隔..',
                tags: true,//tagging support
                tokenSeparators: [',', '，', ' '],//输入 ',' 或 '空格'的时候自动生成 tag
            });
            $('.field-select').on("select2:select", function (e) {
                var $fieldSelect = $('.' + $(this).attr('data-classname'));
                $.ajax({
                    url: '<?= Yii::$app->homeUrl ?>/populac/col-table/get-field-config',
                    data: { params : $(this).val() },
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
                        if ( data ) {
                            $fieldSelect.select2('destroy');//先销毁
                            $fieldSelect.attr('multiple', 'multiple');//设置为可多选
                            $fieldSelect.select2({
                                data: $.parseJSON(data)
                            });
                        }
                    }
                });
            });
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>



