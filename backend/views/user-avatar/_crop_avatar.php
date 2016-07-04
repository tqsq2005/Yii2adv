<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-4 上午9:27
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */


/**
 * @var \mdm\admin\models\User $user 当前用户
 * @var string $avatar 用户头像地址
 * @var \yii\web\View $this
 */
$user_avatar = Yii::$app->homeUrl.'/uploads/user/default/user2-160x160.jpg';
if( $avatar ) {
    $user_avatar = Yii::$app->homeUrl.'/uploads/user/avatar/' . $avatar;
}
$this->title = '修改用户头像';
$this->params['breadcrumbs'][] = $this->title;

//\common\components\cropper\CropperAsset::register($this);

//$this->registerCssFile('/admin/plus/crop-avatar/css/main.css', ['depends' => 'common\components\cropper\CropperAsset']);
//$this->registerJsFile('/admin/plus/crop-avatar/js/main.js', ['depends' => 'common\components\cropper\CropperAsset']);
?>
<div class="form-group">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $user_avatar ?>" alt="用户头像">
                <h5 class="profile-username text-center" id="user_avatar"><?= $user->profile->name ? $user->profile->name : $user->username ?></h5>
                <p class="text-muted text-center"><?= $user->profile->bio ?></p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?= \common\components\cropper\CropAvatarWidget::widget([
                    'imgSrc' => $user_avatar,
                    'imgSavePath' => '/uploads/user/avatar/',
                ]) ?>
                <h5 class="profile-username text-center" id="user_avatar"><?= $user->profile->name ? $user->profile->name : $user->username ?></h5>
                <p class="text-muted text-center"><?= $user->profile->bio ?></p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
</div>


