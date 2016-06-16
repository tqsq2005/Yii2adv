<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-16 下午8:34
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/* @var $this \yii\web\View */
/* @var $content string */

backend\assets\AppAsset::register($this);

dmstr\web\AdminLteAsset::register($this);
\bedezign\yii2\audit\web\JSLoggingAsset::register($this);//audit-Log

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<?php $this->head() ?>
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
