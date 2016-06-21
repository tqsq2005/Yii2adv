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
        var $dropdown = '<div class="btn-group p-filter">' +
            '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '<i class="fa fa-filter"></i>' +
            '过滤 <span class="caret"></span>' +
            '</button>' +
            '<ul class="dropdown-menu">' +
            '<li><a href="#">包含历史资料</a></li>' +
            '<li><a href="#">流动人口</a></li>' +
            '<li><a href="#">已婚男性</a></li>' +
            '<li><a href="#">已婚女性</a></li>' +
            '<li><a href="#">未婚男性</a></li>' +
            '<li><a href="#">未婚女性</a></li>' +
            '<li><a href="#">已婚未育</a></li>' +
            '<li><a href="#">已婚育一孩</a></li>' +
            '<li><a href="#">已婚育二孩</a></li>' +
            '<li><a href="#">已婚育三孩及以上</a></li>' +
            '<li><a href="#">三个月内入职</a></li>' +
            '<li><a href="#">三个月内离开单位</a></li>' +
            '<li role="separator" class="divider"></li>' +
            '<li><a href="#">清空过滤条件</a></li>' +
            '</ul>' +
            '</div>';
        document.write($dropdown);
        function removejscssfile(filename, filetype){
            var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
            var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
            var allsuspects=document.getElementsByTagName(targetelement)
            for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
                if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
                    allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
            }
        }
        $(function() {
            $("div.p-filter .dropdown-menu li a").click(function(){
                var text = '<i class="fa fa-check-square-o text-red"></i> <span class="text-red">' + $(this).text() + '</span>';
                //$("div.p-filter .btn:first-child").text(text);
                //$("div.p-filter .btn:first-child").val(text);
                $("div.p-filter span#p-filter-data").text($(this).text());
                layer.tips('当前过滤条件为：' + text, 'div.p-filter', {
                    tips: [1, '#000'], //还可配置颜色
                    time: 300000
                });
            });
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>
<ul>
    <li id="unitlist">unitlist</li>
    <li id="personlist">personlist</li>
</ul>



