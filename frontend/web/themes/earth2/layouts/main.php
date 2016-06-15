<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-19 上午10:01
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

// You can use the registerAssetBundle function if you'd like
//$this->registerAssetBundle('app');

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <link rel='stylesheet' type='text/css' href='<?php echo $this->theme->baseUrl; ?>/files/main_style.css' title='wsite-theme-css' />
    <?php $this->head(); ?>
    </head>
    <body class='wsite-theme-light tall-header-page wsite-page-index weeblypage-index'>
        <?php $this->beginBody(); ?>
        <div id="wrapper">
            <div id="container">
                <table id="header">
                  <tr>
                    <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title"><?php echo Html::encode(\Yii::$app->name); ?></span></a></span></td>
                    <td id="header-right">
                      <table>
                        <tr>
                          <td class="phone-number"></td>
                          <td class="social"></td>
                        </tr>
                      </table>
                      <div class="search"></div>
                    </td>
                  </tr>
                </table>
            <div id="navigation">
                <?php echo Menu::widget(array(
                    'options' => array('class' => 'nav'),
                    'items' => array(
                      array('label' => 'Home', 'url' => array('/site/index')),
                      array('label' => 'About', 'url' => array('/site/about')),
                      array('label' => 'Contact', 'url' => array('/site/contact')),
                      Yii::$app->user->isGuest ?
                        array('label' => 'Login', 'url' => array('/site/login')) :
                        array('label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => array('/site/logout')),
                    ),
                  )); ?>
            </div>
            <div id="banner">
              <div class="wsite-header"></div>
            </div>
            <div id="content">
              <div id='wsite-content' class='wsite-not-footer'>
                <?php echo $content; ?>
            </div>

            </div>
            <div class="clear"></div>
            </div>
            <div class="footerclear"></div>
        </div>
        <div id="footer">
          <?php echo Html::encode(\Yii::$app->name); ?>

        </div>

        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>