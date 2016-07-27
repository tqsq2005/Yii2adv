<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:38
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-th-list"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
    </div>
</div>

<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-info-circle"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
    </div>
</div>

<script type="text/javascript">
    $.ajax({
        url: '<?=Yii::$app->homeUrl?>/populac/col-table/down/' + Cookies.get('coltable-last-visited-id'),
        type: 'post',
        data: { pbc_tnam : Cookies.get('coltable-last-visited-pbctnam') },
        beforeSend: function () {
            layer.load();
        },
        complete: function () {
            layer.closeAll('loading');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            layer.alert('上移操作出错:' + textStatus + ' ' + errorThrown, {icon: 5});
        },
        success: function(data) {
            layer.msg('已上移..', {icon: 6, time: 1500}, function(index) {
                table.ajax.reload();
            });
        }
    });
</script>


