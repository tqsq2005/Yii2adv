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
<!-- Single button -->
<div class="btn-group p-filter">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-filter"></i>
        过滤 <span class="hidden" id="p-filter-data">清空过滤条件</span> <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#">包含历史资料</a></li>
        <li><a href="#">流动人口</a></li>
        <li><a href="#">已婚男性</a></li>
        <li><a href="#">已婚女性</a></li>
        <li><a href="#">未婚男性</a></li>
        <li><a href="#">未婚女性</a></li>
        <li><a href="#">已婚未育</a></li>
        <li><a href="#">已婚育一孩</a></li>
        <li><a href="#">已婚育二孩</a></li>
        <li><a href="#">已婚育三孩及以上</a></li>
        <li><a href="#">三个月内入职</a></li>
        <li><a href="#">三个月内离开单位</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">清空过滤条件</a></li>
    </ul>
</div>
<?php
//echo "$o_dropdown";
\common\widgets\JsBlock::begin();
?>
    <script type="text/javascript">
        $(function() {
            var preferences = $.parseJSON('<?= $preferences ?>');
            var work1 = '';
            var work2 = '01';

            var text = preferences.work1[work2] ? preferences.work1[work2] : '未知';
            console.log(text);

            var text = preferences.work1[work1] ? preferences.work1[work1] : '未知';
            console.log(text);
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>
<ul>
    <li id="unitlist">unitlist</li>
    <li id="personlist">personlist</li>
</ul>



