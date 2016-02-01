<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}
//\kartik\icons\Icon::map($this);
\uran1980\yii\widgets\pace\Pace::widget([
    'color' => 'green',
    'theme' => 'Flash',//Flash, Minimal, Flat-Top, Bounce, Mac-OSX
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?php echo Yii::$app->getHomeUrl(); ?>/favicon.ico" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>
<!--//Get all flash messages and loop through them-->
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    $icon_type = '';
    if(empty($message['icon']))
    {
        $icon_type = "'icon_type'=> 'image',";
    }
    echo \kartik\growl\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : \kartik\growl\Growl::TYPE_INFO,////String, can only be set to danger, success, warning, info, and growl
        'title' => ((!empty($message['title'])) ? Html::encode($message['title']) : '<strong>计划生育信息管理系统</strong>&nbsp;<img src="'.Yii::getAlias('@web').'/images/js18.png" />'),
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-cog fa-lg fa-fw fa-spin',
        'body' => '&nbsp;<i class="fa fa-quote-left fa-pull-left"></i>&nbsp;<i class="fa fa-commenting-o fa-lg fa-fw fa-pull-right"></i>&nbsp;' . ((!empty($message['message'])) ? $message['message'] : '页面加载完成!<p></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前系统时间：' . date('Y.m.d H:i:s')) . '&nbsp;&nbsp;<i class="fa fa-quote-right"></i>',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            //'icon_type'=> (!empty($message['icon'])) ? '1' : 'image',
            //$icon_type,
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'showProgressbar' => true,
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'bottom',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<!--//flash messages end-->

    <?= $content ?>

<div class="btn-group-vertical" role="group" aria-label="侧边辅助按钮组" id="floatButton">
    <button type="button" class="btn btn-default" role="button" aria-label="去顶部" id="goTop" title="去顶部"><span
            class="glyphicon glyphicon-arrow-up"></span></button>
    <button type="button" class="btn btn-default" role="button" aria-label="刷新" id="refresh" title="刷新"><span
            class="glyphicon glyphicon-repeat"></span></button>
    <button type="button" class="btn btn-default" role="button" aria-label="本页二维码" id="pageQrcode" title="本页二维码"><span
            class="glyphicon glyphicon-qrcode"></span>
        <img class="qrcode" width="130" height="130" src="<?= \yii\helpers\Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])?>" />
    </button>
    <button type="button" class="btn btn-default" role="button" aria-label="去底部" id="goBottom" title="去底部"><span
            class="glyphicon glyphicon-arrow-down"></span></button>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
