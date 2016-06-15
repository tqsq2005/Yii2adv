<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-26 下午12:47
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */


use yii\helpers\Url;

$this->title = '系统维护';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <p>
            <a id="view-cache" style="cursor: pointer;" class="btn btn-success" data-href="<?= Url::to(['/system/view-cache']) ?>"><i class="glyphicon glyphicon-eye-open"></i> 查看系统当前缓存</a>
            <a href="<?= Url::to(['/system/flush-cache']) ?>" data-confirm="您确定要清空后台系统缓存吗？" class="btn btn-danger"><i class="glyphicon glyphicon-flash"></i> 清空后台系统缓存</a>
        </p>
        <br>
        <p>
            <a href="<?= Url::to(['/system/clear-assets', 'type' => 'backend']) ?>" data-confirm="您确定要清空后台临时文件吗？" class="btn btn-warning"><i class="glyphicon glyphicon-trash"></i> 清空后台临时文件</a>
        </p>
        <br>
        <p>
            <a href="<?= Url::to(['/system/clear-assets', 'type' => 'frontend']) ?>" data-confirm="您确定要清空前台临时文件吗？" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i> 清空前台临时文件</a>
        </p>
    </div>
</div>
<?php \common\widgets\JsBlock::begin();?>
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#view-cache', function() {
                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                var href = $(this).attr('data-href');
                $.ajax({
                    url: href,
                    success: function(data){
                        console.log(data);
                        layer.open({
                            skin: 'layui-layer-molv', //样式类名,
                            type: 1, //page层
                            area: ['600px', '450px'],
                            title: '系统当前缓存信息',
                            shade: 0.6, //遮罩透明度
                            moveType: 1, //拖拽风格，0是默认，1是传统拖动
                            shift: shiftNum, //0-6的动画形式，-1不开启
                            content: '<div style="padding:10px;">' + data + '</div>'
                        });
                    },
                });
            });
        });
    </script>
<?php \common\widgets\JsBlock::end();?>
