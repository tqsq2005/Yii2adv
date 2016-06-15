<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-5 下午12:43
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据还原';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'time',
                'label' => '备份名称',
                'value' => function($model) {
                    return date('Ymd-His', $model['time']);
                }
            ],
            'part:text:卷数',
            'compress:text:压缩',
            [
                'attribute' => 'size',
                'label' => '数据大小',
                'value' => function($model) {
                    return Yii::$app->formatter->asShortSize($model['size']);
                }
            ],
//            'create_time:text:备份时间',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{a} {b}',
                'buttons' => [
                    'a' => function ($url, $model, $key) {
                        return Html::a('还原',
                            ['init', 'time' => $model['time']],
                            ['class' => 'db-import']
                        );
                    },
                    'b' => function ($url, $model, $key) {
                        return Html::a('删除',
                            ['del'],
                            [
                                'data-method' => 'post',
                                'data-ajax' => 1,
                                'data-params' => ['time' => $model['time']],
                                'data-confirm' => '删除后不能恢复,确定要删除吗?'
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        function updateAlert(msg, type) {
            var icon = (type == 'alert-error') ? '{icon: 5}' : '{icon: 6}';
            layer.msg(msg, icon);
        }
        $(".db-import").click(function(){
            var self = this, status = ".";
            $.get(self.href, success, "json");
            window.onbeforeunload = function(){ return "正在还原数据库，请不要关闭！" }
            return false;

            function success(data){
                if(data.status){
                    if(data.gz){
                        data.info += status;
                        if(status.length === 5){
                            status = ".";
                        } else {
                            status += ".";
                        }
                    }
                    $(self).parent().prev().text(data.info);
                    if(data.part){
                        $.get('<?= \yii\helpers\Url::to(['start'])?>',
                            {"part" : data.part, "start" : data.start},
                            success,
                            "json"
                        );
                    }  else {
                        window.onbeforeunload = function(){ return null; }
                    }
                } else {
                    updateAlert(data.info,'alert-error');
                }
            }
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
