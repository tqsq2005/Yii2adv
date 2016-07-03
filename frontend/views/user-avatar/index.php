<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-3 下午9:33
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-1 下午4:16
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
$user_avatar = \common\populac\models\Preferences::get('sSystem', 'backendUrl').'/uploads/user/default/user2-160x160.jpg';
if( $avatar ) {
    $user_avatar = \common\populac\models\Preferences::get('sSystem', 'backendUrl').'/uploads/user/avatar/' . $avatar;
}
$this->title = '修改用户头像';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render('@common/views/user/settings/_menu') ?>
            </div>
            <div class="col-md-9">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <?= \yii\helpers\Html::encode($this->title) ?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="box box-solid">
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img-circle" src="<?= $user_avatar ?>" alt="用户头像">
                                        <h5 class="profile-username text-center"><?= $user->profile->name ? $user->profile->name : $user->username ?></h5>
                                        <p class="text-muted text-center"><?= $user->profile->bio ?></p>
                                        <button class="btn btn-primary btn-block btn-user-avatar-edit" type="button" data-toggle="tooltip" title="点击上传图片修改头像">
                                            <i class="glyphicon glyphicon-scissors"></i>
                                            修改头像
                                        </button>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-md-9">
                                <?= \iisns\webuploader\Cropper::widget() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            $('div#filePicker').hide();
            $(document).on('click', '.btn-user-avatar-edit', function() {
                $('div#filePicker input').trigger('click');
            });
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>


