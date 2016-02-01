<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var dektrium\user\models\LoginForm $model  */
/* @var dektrium\user\Module           $module */

$this->title = '机关企事业单位计划生育信息管理系统-登录';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputOptions' => ['tabindex' => '1', 'autofocus' => 'autofocus'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputOptions' => ['tabindex' => '1'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
\common\widgets\CssBlock::begin();
?>
    <style type="text/css">
        body,ul,blockquote{margin:0;padding:0;}
        /*annouce*/
        .populac-nav-left-annouce{margin-left: 20px;width:320px;}
        .populac-annouce{float: left;width:9px;height: 15px;color: #f00000;margin-right:6px;margin-top: 15px;}
        .populac-annouce-div{width: 300px;overflow: hidden;*zoom:1;height: 46px;position: relative;}
        .populac-annouce-div li{width: 300px;overflow: hidden;*zoom:1;height:46px;line-height:46px;*float: left;*clear: both;}
        .populacannoucepos{position: absolute;top:0;left:0;}
    </style>
<?php \common\widgets\CssBlock::end(); ?>

<div class="login-box">
    <div class="login-logo hidden">
        <a href="#"><span class="text-primary"><b>计生管理员</b>登录</span></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="text-primary text-center">管理员登录</h3>
        <div class=" populac-nav-left populac-nav-left-annouce">
            <i class="populac-annouce fa fa-volume-up"></i>
            <div class="populac-annouce-div">
                <div style="top: -138px;" id="populac_annouce" class="populacannoucepos">
                    <ul>
                        <li><a href="#" class="text-success">登录名可以是您的用户名、邮箱或者手机号</a></li>
                        <li><a href="#" class="text-success">公共环境下请勿勾选“一个月内自动登录”</a></li>
                        <li><a href="#" class="text-success">新的计生管理员请先点击“注册登录账户”注册</a></li>
                        <li><a href="#" class="text-success">点击“忘记密码”可以通过邮箱重置您的密码</a></li>
                        <li><a href="http://localhost" target="_blank" class="text-success">点击打开计生宣传网查看最新计生动态</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableAjaxValidation'   => true,
            'enableClientValidation' => false,
            'validateOnBlur'         => false,
            'validateOnType'         => false,
            'validateOnChange'       => false
        ]); ?>

        <?= $form
            ->field($model, 'login', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => '请输入用户名、邮箱或手机号', 'autocomplete' => 'off']) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => '请输入密码', 'autocomplete' => 'off']) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe', ['inputOptions' => ['tabindex' => '4']])->label('一个月内自动登录', ['class' => 'text-danger', 'title' => '公共环境下请谨慎选择！'])->checkbox(['value' => 0]) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登 录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button', 'inputOptions' => ['tabindex' => '3']]) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div>-->
        <!-- /.social-auth-links -->

        <a href="<?= \yii\helpers\Url::to(['/user/recovery/request'])?>" id="login-forgetpw" class="text-warning" style="line-height: 40px;"><i class="fa fa-user-secret"></i> 忘记密码</a><br>
        <a href="<?= \yii\helpers\Url::to(['/user/registration/register']) ?>" class="text-success"><i class="fa fa-user-plus"></i> 注册登录账户</a>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<?php
//$this->registerJsFile('@web/js/jquery.backstretch.min.js', [\yii\web\View::POS_END]);
\common\widgets\JsBlock::begin() ?>
    <script type="text/javascript">
        (function(){
            $('#login-form-rememberme').click(function(e) {
                //e.preventDefault();
                $(this).addClass('animated shake');
                /*layer.tips('公共环境下请谨慎选择！', '#login-form-rememberme', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });*/
                if($(this).val()) {
                    $(this).removeClass('animated shake');
                } else {
                    $(this).addClass('animated shake');
                }
            });

            /*-背景图像轮播 开始-*/
            document.ondragstart = function() {
                return false;
            };
            //背景图片轮换
            jQuery.backstretch([
                "/admin/images/bg/0.jpg",
                "/admin/images/bg/1.jpg",
                "/admin/images/bg/2.jpg",
                "/admin/images/bg/3.jpg",
                "/admin/images/bg/4.jpg",
                "/admin/images/bg/5.jpg",
                "/admin/images/bg/6.jpg",
                "/admin/images/bg/7.jpg"
            ], {
                fade: 1000,
                duration: 4000
            });
            /*-背景图像轮播 结束-*/
            /*-广播 开始-*/
            var getH = function(d){
                return d.offsetHeight || d.clientHeight;
            }
            var index = 0,
                populac_annouce = document.getElementById('populac_annouce'),
                ul = populac_annouce.getElementsByTagName('ul')[0],
                len = ul.getElementsByTagName('li').length,
                as = ul.getElementsByTagName('a'),
                height = getH(ul),
                step = height / len;
            var move = function(d,c){
                d.style.top = -step*index + 'px';
                var texta = as[index],
                    text = texta.innerHTML,
                    textlen = text.length,
                    tcount = 1;
                texta.innerHTML = '';
                var inter = setInterval(function(){
                    tcount++;
                    texta.innerHTML = text.substring(0,tcount);
                    if(tcount > textlen){
                        clearInterval(inter);
                        index++
                        c();
                        return;
                    }
                },60)
            }

            if(populac_annouce.length <= 0) return;
            var ex = function(){
                setTimeout(function(){
                    if(index >= len) {populac_annouce.style.top = 0;index = 0;}
                    move(populac_annouce,function(){
                        ex();
                    });
                },4000)
            }
            move(populac_annouce,function(){
                ex();
            });
            /*-广播 结束-*/
        })();
    </script>
<?php \common\widgets\JsBlock::end() ?>
