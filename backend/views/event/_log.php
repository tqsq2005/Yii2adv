<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Event */

$this->title = '事件操作记录';
$this->params['breadcrumbs'][] = ['label' => '事件管理', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
//echo $this->render('_menu');
\common\assets\TimelineAsset::register($this);
?>
<div class="event-log">
    <div id="timeline" style="height: 650px;"></div>
    <?=\common\widgets\TrailsLog::widget();?>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        var timeline = new TL.Timeline('timeline', '/admin/eras.json', {
            language: "zh-cn",
            /*width: "100%",
            height: '450',*/
            is_embed:true
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
