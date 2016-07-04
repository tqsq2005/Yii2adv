<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-4 下午12:25
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * @var string $imgSrc 图片地址
 * @var string $imgTitle 图片标题
 * @var string $imgClass 图片样式
 * @var string $imgSavePath 图片保存路径
 * @var \yii\web\View $this
 */

$imgSrc = $imgSrc ? $imgSrc : Yii::$app->homeUrl.'/uploads/user/default/user2-160x160.jpg';
?>
<div id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view" title="<?= $imgTitle ?>">
        <img class="<?= $imgClass ?>" src="<?= $imgSrc ?>" alt="Avatar">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="avatar-form" action="<?= \yii\helpers\Url::to(['/user-avatar/crop-avatar']) ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">照片裁剪</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">

                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                                <input type="hidden" class="avatar-src" value="<?= $imgSavePath ?>" name="avatar_imgSavePath">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <label for="avatarInput">照片上传</label>
                                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                            </div>

                            <!-- Crop and preview -->
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="avatar-wrapper"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="avatar-preview preview-lg"></div>
                                    <div class="avatar-preview preview-md"></div>
                                    <div class="avatar-preview preview-sm"></div>
                                </div>
                            </div>

                            <div class="row avatar-btns">
                                <div class="col-md-9">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="-90" title="逆时针旋转90°">
                                            <span class="fa fa-rotate-left"> 逆时针</span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="-15" title="逆时针旋转15°">-15°</button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="-30" title="逆时针旋转30°">-30°</button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="-45" title="逆时针旋转45°">-45°</button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="90" title="顺时针旋转90°">
                                            <span class="fa fa-rotate-right"> 顺时针</span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="15" title="逆时针旋转15°">15°</button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="30" title="逆时针旋转30°">30°</button>
                                        <button type="button" class="btn btn-primary" data-crop-method="rotate" data-option="45" title="逆时针旋转45°">45°</button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-crop-method="scaleX" data-option="-1" data-toggle="tooltip" title="水平180°旋转">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="水平180°旋转">
                                                <span class="fa fa-arrows-h"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-crop-method="scaleY" data-option="-1" data-toggle="tooltip" title="垂直180°旋转">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="垂直180°旋转">
                                                <span class="fa fa-arrows-v"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-crop-method="clear" data-toggle="tooltip" title="图片重新裁剪">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="图片重新裁剪">
                                                <span class="fa fa-remove"></span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-crop-method="reset" data-toggle="tooltip" title="恢复图片原样">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="恢复图片原样">
                                                <span class="fa fa-refresh"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div><!-- /.modal -->
</div>


