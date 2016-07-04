<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->identity;
$user_avatar = Yii::$app->homeUrl.'/uploads/user/default/user2-160x160.jpg';
if( $avatar = \common\models\UserAvatar::getAvatar($user->id) ) {
    $user_avatar = Yii::$app->homeUrl.'/uploads/user/avatar/' . $avatar;
}
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render('_menu') ?>
            </div>
            <div class="col-md-9">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <?= Html::encode($this->title) ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 <?= strlen(Yii::$app->homeUrl) <= 1 ? 'hidden' : '';?>" >
                                <div class="box-body box-profile">
                                    <?= \common\components\cropper\CropAvatarWidget::widget([
                                        'imgSrc' => $user_avatar,
                                        'imgSavePath' => '/uploads/user/avatar/',
                                    ]) ?>
                                    <h5 class="profile-username text-center" id="user_avatar"><?= $user->profile->name ? $user->profile->name : $user->username ?></h5>
                                    <p class="text-muted text-center"><?= $user->profile->bio ?></p>
                                </div>
                            </div>
                            <div class="col-md-<?= strlen(Yii::$app->homeUrl) <= 1 ? 12 : 8;?>">
                                <?php $form = \yii\widgets\ActiveForm::begin([
                                    'id' => 'profile-form',
                                    'options' => ['class' => 'form-horizontal'],
                                    'fieldConfig' => [
                                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                                    ],
                                    'enableAjaxValidation'   => true,
                                    'enableClientValidation' => false,
                                    'validateOnBlur'         => false,
                                ]); ?>

                                <?= $form->field($model, 'name') ?>

                                <?= $form->field($model, 'public_email') ?>

                                <?= $form->field($model, 'website') ?>

                                <?= $form->field($model, 'location') ?>

                                <?= $form->field($model, 'gravatar_email')->hint(\yii\helpers\Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com')) ?>

                                <?= $form->field($model, 'bio')->textarea() ?>

                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-9">
                                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                                    </div>
                                </div>

                                <?php \yii\widgets\ActiveForm::end(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

