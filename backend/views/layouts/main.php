<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

//\kartik\icons\Icon::map($this);
\uran1980\yii\widgets\pace\Pace::widget([
    'color' => 'green',
    'theme' => 'Flash',//Flash, Minimal, Flat-Top, Bounce, Mac-OSX
]);
if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);
    \bedezign\yii2\audit\web\JSLoggingAsset::register($this);//audit-Log

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
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
        <?php $this->registerLinkTag(['rel' => 'canonical', 'url' => \yii\helpers\Url::canonical()]); ?>
        <?php $this->registerCssFile(Yii::$app->getHomeUrl() . '/css/print.css', ['media' => 'print']) ?>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini layout-boxed">
    <?php $this->beginBody() ?>

    <!--//Get all flash messages and loop through them-->
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message):; ?>
        <?php
        $icon_type = '';
        if(empty($message['icon']))
        {
            $icon_type = "'icon_type'=> 'image',";
        }
        echo \kartik\growl\Growl::widget([
            'type' => (!empty($type)) ? $type : \kartik\growl\Growl::TYPE_INFO,////String, can only be set to danger, success, warning, info, and growl
            'title' => ((!empty($message['title'])) ? Html::encode($message['title']) : '<strong>计划生育信息管理系统</strong>&nbsp;<img src="'.Yii::getAlias('@web').'/images/js18.png" />'),
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-cog fa-lg fa-fw fa-spin',
            'body' => '&nbsp;<i class="fa fa-quote-left fa-pull-left"></i>&nbsp;<i class="fa fa-commenting-o fa-lg fa-fw fa-pull-right"></i>&nbsp;' . (!empty($message['message']) ? $message['message'] : $message) . '&nbsp;&nbsp;<i class="fa fa-quote-right"></i>',
            'showSeparator' => true,
            'delay' => 5, //This delay is how long before the message shows
            'pluginOptions' => [
                //'icon_type'=> (!empty($message['icon'])) ? '1' : 'image',
                //$icon_type,
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 10000, //This delay is how long the message shows for
                'showProgressbar' => true,
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                ]
            ]
        ]);
        ?>
    <?php endforeach; ?>
    <!--//flash messages end-->

    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
    </div>

    <div class="btn-group-vertical" style="display: none;" role="group" aria-label="侧边辅助按钮组" id="floatButton">
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
    <?php
        \yii\bootstrap\Modal::begin([
            'headerOptions' => ['id' => 'modalHeader'],
            //'footer'        => '<button type="button" class="btn btn-success" data-dismiss="modal">关闭</button>',
            //'footerOptions' => ['id' => 'modalFooter'],
            'id' => 'modal',
            'size' => 'modal-lg',
            //keeps from closing modal with esc key or by clicking out of the modal.
            // user must click cancel or X to close
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
        ]);
        echo "<div id='modalContent'><div style='text-align:center'><img src='" . Yii::$app->getHomeUrl() . "/images/loading.gif'></div></div>";
        yii\bootstrap\Modal::end();
    ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
