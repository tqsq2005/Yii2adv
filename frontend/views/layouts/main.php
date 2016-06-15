<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-19 下午12:20
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */


use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div id="wrapper" class="container">
    <header>
        <!------------------------code---------------start---------------->
        <nav class="navbar navbar-findcond navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= Url::home() ?>">
                        <img width="30" height="30" src="/images/js80.png" alt="Brand" title="<?=Yii::$app->params['app.name']?>">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <?=\yii\bootstrap\Nav::widget([
                            'options' => ['class' => 'nav navbar-nav'],
                            'encodeLabels' => false,
                            'items' => [
                                ['label' => '<i class="fa fa-home" aria-hidden="true"></i> 首页', 'url' => ['/site/index']],
                                ['label' => 'Shop', 'url' => ['/shop/index']],
                                ['label' => 'News', 'url' => ['/news/index']],
                                ['label' => '<i class="fa fa-street-view" aria-hidden="true"></i> 计生动态', 'url' => ['/ji_sheng_gong_zuo_dong_tai/index']],
                                ['label' => '<i class="fa fa-picture-o" aria-hidden="true"></i> 计生风采', 'url' => ['/ji_sheng_feng_cai/index']],
                                ['label' => '<i class="fa fa-rss" aria-hidden="true"></i> 留言板', 'url' => ['/guestbook/index']],
                                ['label' => 'FAQ', 'url' => ['/faq/index']],
                                ['label' => 'Contact', 'url' => ['/contact/index']],
                                [
                                    'label' => '<i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> 登录',
                                    'url' => '#',
                                    'visible' => Yii::$app->user->isGuest,
                                    'linkOptions' => [
                                        'data-target' => '#loginModal',
                                        'data-toggle' => 'modal',
                                    ],
                                ],
                                [
                                    'label' => Yii::$app->user->isGuest? '' : '<i class="glyphicon glyphicon-user" aria-hidden="true"></i> ' . \Yii::$app->user->identity->username,
                                    'url' => '#',
                                    'visible' => !Yii::$app->user->isGuest,
                                    'items' => Yii::$app->user->isGuest? [] : [
                                        [
                                            'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> 查看个人信息',
                                            'url' => ['/user/profile/show', 'id' => \Yii::$app->user->identity->getId()],
                                        ],
                                        [
                                            'label' => '<i class="glyphicon glyphicon-cog" aria-hidden="true"></i> 设置个人信息',
                                            'url' => ['/user/settings/profile'],
                                        ],
                                        '<li class="divider"></li>',
                                        [
                                            'label' => '<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> 退出账号',
                                            'url' => '#',
                                            'linkOptions' => [
                                                'id' => 'user-logout',
                                                'data-href' => ['/user/logout'],
                                                'title' => '退出账号',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ]); ?>
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-bell-o"></i> Notification <span class="badge">0</span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="fa fa-fw fa-tag"></i> <span class="badge">Music</span> ABC <span class="badge">Video</span> Sun Sun Sun </a></li>
                                <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Music</span> Sun Sun Sun</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Video</span> Sun Sun Sun</a></li>
                                <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Game</span> Sun Sun Sun</a></li>
                            </ul>
                        </li>
                        <li class="active"><a href="#">Video <span class="sr-only">(current)</span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Sairam</a></li>
                                <li><a href="#">Gopal</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Login</a></li>
                                <li><a href="#exit">Log out</a></li>
                            </ul>
                        </li>-->
                    </ul>
                    <form class="navbar-form navbar-left search-form" role="search" action="/search" method="get">
                        <!--<div class="form-group has-feedback">
                            <input type="text" name="q" class="form-control" placeholder="搜索.." />
                            <i class="glyphicon glyphicon-search form-control-feedback"></i>
                        </div>-->
                        <div class="input-group populac-add-on">
                            <input type="text" class="form-control" placeholder="搜索.." name="q" id="populac-search-item">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <!----Code------end----------------------------------->
        <!--<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?/*= Url::home() */?>"><?php /*echo \yii\helpers\Html::encode(\Yii::$app->name); */?></a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-menu">
                    <?/*= Menu::widget([
                        'options' => ['class' => 'nav navbar-nav'],
                        'items' => [
                            ['label' => 'Home', 'url' => ['/site/index']],
                            ['label' => 'Shop', 'url' => ['/shop/index']],
                            ['label' => 'News', 'url' => ['/news/index']],
                            ['label' => '计生动态', 'url' => ['/ji_sheng_gong_zuo_dong_tai/index']],
                            ['label' => '计生风采', 'url' => ['/ji_sheng_feng_cai/index']],
                            ['label' => 'Guestbook', 'url' => ['/guestbook/index']],
                            ['label' => 'FAQ', 'url' => ['/faq/index']],
                            ['label' => 'Contact', 'url' => ['/contact/index']],
                            [
                                'label' => 'logout',
                                'options' => ['class' => 'nav navbar-nav'],
                                'url' => '#',
                                /*'items' => [
                                    ['label' => 'Home', 'url' => ['/site/index']],
                                    ['label' => 'Shop', 'url' => ['/shop/index']],
                                ],*/
                            ],
                        ],
                    ]); */?>
                    <?php /*if(\Yii::$app->user->identity) : */?>
                        <a data-href="<?/*= Url::to(['/user/logout']) */?>" class="btn btn-default navbar-btn navbar-right"
                           title="注销账号" id="user-logout">
                            <i class="glyphicon glyphicon-log-out"></i>
                            <?/*= \Yii::$app->user->identity->username */?>
                        </a>
                    <?php /*else : */?>
                        <a class="btn btn-default navbar-btn navbar-right"
                           data-target="#loginModal" data-toggle="modal" title="登录系统">
                            <i class="glyphicon glyphicon-log-in"></i>
                            <span class="text-muted">登录</span>
                        </a>
                    <?php /*endif; */?>


                </div>
            </div>
        </nav>-->
    </header>
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
            'title' => ((!empty($message['title'])) ? \yii\helpers\Html::encode($message['title']) : '<strong>计划生育信息管理系统</strong>&nbsp;<img src="'.Yii::getAlias('@web').'/images/js18.png" />'),
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
    <main>
        <?php if($this->context->id != 'site') : ?>
            <br/>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])?>
        <?php endif; ?>
        <?= $content ?>
        <div class="push"></div>
    </main>
    <!-- 辅助按钮 -->
    <div id="inbox">
        <div class="fab btn-group show-on-hover dropup">
            <div data-toggle="tooltip" data-placement="left" title="回到首页" style="margin-left: 42px;">
                <button type="button" id="btn-gohome"  data-href="<?= Url::home() ?>" class="btn btn-danger btn-io dropdown-toggle" data-toggle="dropdown">
                    <span class="fa-stack fa-2x">
                        <i class="fa fa-circle fa-stack-2x fab-backdrop"></i>
                        <i class="fa fa-plus fa-stack-1x fa-inverse fab-primary"></i>
                        <i class="fa fa-home fa-stack-1x fa-inverse fab-secondary"></i>
                    </span>
                </button>
            </div>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#" data-toggle="tooltip" data-placement="left" id="goTop" title="去顶部">
                        <i class="fa fa-arrow-up"></i></a></li>
                <li><a href="#" data-toggle="tooltip" data-placement="left" id="refresh" title="刷新页面">
                        <i class="fa fa-refresh fa-spin"></i></a></li>
                <li><a href="#" data-href="<?= \yii\helpers\Url::to(['/guestbook', 'from' => 'fab-btn']) ?>" data-toggle="tooltip" data-placement="left" id="goToGuestbook" title="我要留言">
                        <i class="fa fa-edit"></i></a></li>
                <li><a href="#" data-toggle="tooltip" data-placement="left" aria-label="本页二维码" id="pageQrcode" title="本页二维码">
                        <i class="fa fa-qrcode"></i>
                        <img class="qrcode" width="130" height="130" src="<?= \yii\helpers\Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])?>" />
                    </a></li>

                <li><a href="#" data-toggle="tooltip" data-placement="left" id="goBottom" title="去底部">
                        <i class="fa fa-arrow-down"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<!--<div class="btn-group-vertical" role="group" aria-label="侧边辅助按钮组" id="floatButton">
    <button type="button" class="btn btn-default" role="button" aria-label="去顶部" id="goTop" title="去顶部"><span
            class="glyphicon glyphicon-arrow-up"></span></button>
    <button type="button" class="btn btn-default" role="button" aria-label="刷新" id="refresh" title="刷新"><span
            class="glyphicon glyphicon-repeat"></span></button>
    <button type="button" class="btn btn-default" role="button" aria-label="本页二维码" id="pageQrcode" title="本页二维码"><span
            class="glyphicon glyphicon-qrcode"></span>
        <img class="qrcode" width="130" height="130" src="<?/*= \yii\helpers\Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])*/?>" />
    </button>
    <button type="button" class="btn btn-default" role="button" aria-label="去底部" id="goBottom" title="去底部"><span
            class="glyphicon glyphicon-arrow-down"></span></button>
</div>-->
<?php $this->endContent(); ?>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">请输入用户名及密码</h4>
            </div>
            <div class="modal-body">
                <form id="login-form" action="<?= Url::to(['/user/login']) ?>" method="post" role="form">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken(); ?>">
                    <div class="form-group has-feedback field-login-form-login required">
                        <input type="text" id="login-form-login" class="form-control" name="login-form[login]" tabindex="1" autofocus="autofocus" placeholder="请输入用户名、邮箱或手机号" autocomplete="off"><span class='glyphicon glyphicon-envelope form-control-feedback'></span>

                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="form-group has-feedback field-login-form-password required">

                        <input type="password" id="login-form-password" class="form-control" name="login-form[password]" tabindex="1" placeholder="请输入密码" autocomplete="off"><span class='glyphicon glyphicon-lock form-control-feedback'></span>

                        <p class="help-block help-block-error"></p>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group field-login-form-rememberme">
                                <div class="checkbox">
                                    <label id="login-form-rememberme-label" class="text-danger" title="警告：公共环境下请勿勾选！" data-toggle="tooltip" data-placement="bottom" for="login-form-rememberme">
                                        <input type="hidden" name="login-form[rememberMe]" value="0"><input type="checkbox" id="login-form-rememberme" name="login-form[rememberMe]" value="0">
                                        一个月内自动登录
                                    </label>
                                    <p class="help-block help-block-error"></p>

                                </div>
                            </div>            </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" id="login-form-submit" class="btn btn-primary btn-block btn-flat" name="login-button" inputOptions='{"tabindex":"3"}'>登 录</button>            </div>
                        <!-- /.col -->
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
