<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-1 下午3:11
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\bootstrap\Nav;

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('user', 'Profile settings');
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
      <div class="col-xs-12 col-sm-4 col-md-2">
      <?= Nav::widget([
          'encodeLabels' => false,
          'items' => [
              ['label' => '<span class="glyphicon glyphicon-home"></span> ' . Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
              ['label' => '<span class="glyphicon glyphicon-user"></span> ' . Yii::t('user', 'Account'), 'url' => ['/user/settings/account']],
              //['label' => '<span class="glyphicon glyphicon-cog"></span> ' . Yii::t('user', 'Networks'), 'url' => ['/user/settings/networks'], 'visible' => $networksVisible],
          ],
          'options' => ['class' => 'nav nav-pills nav-stacked']
      ])
      
      ?>
      </div>
      <div class="col-xs-12 col-sm-8 col-md-10">
        <?php echo $content; ?>
      </div>
<?php $this->endContent(); ?>