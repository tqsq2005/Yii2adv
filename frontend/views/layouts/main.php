<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
\kartik\icons\Icon::map($this);
\uran1980\yii\widgets\pace\Pace::widget([
    'color' => 'green',
    'theme' => 'Flash',//Flash, Minimal, Flat-Top, Bounce, Mac-OSX
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/favicon.ico?v=1" type="image/x-icon" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['app.name'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

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

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

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
