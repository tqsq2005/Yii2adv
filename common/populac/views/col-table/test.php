<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-8 下午10:54
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */
?>
<h4>123</h4>
<table>
    <tr class="even" role="row">
        <td>2</td>
        <td class="sorting_1">col_table</td>
        <td>
            <span class="label label-default" title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="pbc_tnam">pbc_tnam</span>
            <span class="label label-info" title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="sort_no">sort_no</span>
            <span class="label label-primary" title="pbc_cnam" data-toggle="tooltip" style="cursor: pointer;">pbc_cnam</span>
            <span class="label label-success" title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="pbc_labl">pbc_labl</span>
            <span class="label label-warning" title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="id">id</span>
            <span class="label label-default" title="" data-toggle="tooltip" style="cursor: pointer;" data-original-title="pbc_classmark">pbc_classmark</span>
            <span class="label label-info" title="status" data-toggle="tooltip" style="cursor: pointer;">status</span>
            <span class="label label-primary" title="created_at" data-toggle="tooltip" style="cursor: pointer;">created_at</span>
            <span class="label label-success" title="updated_at" data-toggle="tooltip" style="cursor: pointer;">updated_at</span>
        </td>
    </tr>
</table>
<div class="modal fade" id="col-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">新增表字段配置</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="col-add-form">
                    <div class="form-group">
                        <label for="pbc_tnam" class="col-sm-2 control-label">表名</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="pbc_tnam" id="pbc_tnam" placeholder="输入表名..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_cnam" class="col-sm-2 control-label">字段名</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="pbc_cnam" id="pbc_cnam" placeholder="输入字段名..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_labl" class="col-sm-2 control-label">中文标签</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="pbc_labl" id="pbc_labl" placeholder="输入中文标签..">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pbc_classmark" class="col-sm-2 control-label">参数配置</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="pbc_classmark" id="pbc_classmark" placeholder="输入参数配置..">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                <button type="button" id="form-sumbit" class="btn btn-primary">保 存</button>
            </div>
        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin() ?>
    <script type="text/javascript">
        $(document).on('click', 'span.label', function() {
            var pbc_cnam = $(this).text().trim();
            var pbc_tnam = $(this).parents('tr').find('td:eq(1)').text().trim();
            $('form#col-add-form input#pbc_tnam').val(pbc_tnam);
            $('form#col-add-form input#pbc_cnam').val(pbc_cnam);
            //console.log($('form#col-add-form input#pbc_tnam'));
            $('#col-form-modal').modal('show');
        }).on('click', '#form-sumbit', function() {
            var form = $('form#col-add-form');
            console.log(form);
            console.log(form.serialize());
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>



