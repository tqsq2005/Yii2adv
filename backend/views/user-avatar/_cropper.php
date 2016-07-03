<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-2 下午5:56
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
 */
$user_avatar = Yii::$app->homeUrl.'/uploads/user/default/user2-160x160.jpg';
if( $avatar ) {
    $user_avatar = Yii::$app->homeUrl.'/uploads/user/avatar/' . $avatar;
}
?>
<div class="form-group">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $user_avatar ?>" alt="用户头像">
                <h5 class="profile-username text-center" id="user_avatar"><?= $user->profile->name ? $user->profile->name : $user->username ?></h5>
                <p class="text-muted text-center"><?= $user->profile->bio ?></p>
                <?= \common\components\cropper\Cropper::widget([
                    'modal' => true,
                    'modalView' => '@backend/views/cropper/modal',
                    'cropUrl' => ['cropper'],
                    'image' => $user_avatar,
                    'aspectRatio' => 'NaN',//4 / 3,
                    'pluginOptions' => [
                        'minCropBoxWidth' => 160, // minimal crop area width
                        'minCropBoxHeight' => 160, // minimal crop area height
                    ],
                    // HTML-options for widget container
                    'options' => [
                        'class' => 'btn btn-primary btn-block'
                    ],
                    // HTML-options for cropper image tag
                    'imageOptions' => [
                        'id' => 'cropper-image'
                    ],
                    // Additional ajax-options for send crop-request. See jQuery $.ajax() options
                    'ajaxOptions' => [
                        'success' => new \yii\web\JsExpression(<<<JS
                        function(data) {
                            // data - your JSON response from [[cropUrl]]
                            $("#user_avatar").attr("src", data.croppedImageSrc);
                        }
JS
                        ),
                    ],
                ]); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-4">
        <?//= \iisns\webuploader\Cropper::widget() ?>
    </div>
    <div class="col-md-4">

    </div>
</div>


