<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-2 下午6:30
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\components\cropper\Cropper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $widget Cropper */
$css = <<<CSS
.cropper-img-container,
.cropper-img-preview {
  background-color: #f7f7f7;
  width: 100%;
  text-align: center;
}

.cropper-img-container {
  min-height: 200px;
  max-height: 516px;
  margin-bottom: 20px;
}

@media (min-width: 768px) {
  .cropper-img-container {
    min-height: 516px;
  }
}

.cropper-img-container > img {
  max-width: 100%;
}
.cropper-img-preview {
  width: 160px;
  height: 160px;
}
.cropper-img-preview {
  float: left;
  margin-right: 2px;
  margin-bottom: 2px;
  overflow: hidden;
}
.cropper-img-preview > img {
  max-width: 100%;
}

.docs-tooltip {
  display: block;
  margin: -6px -12px;
  padding: 6px 12px;
}

.docs-tooltip > .icon {
  margin: 0 -3px;
  vertical-align: top;
}
CSS;

$this->registerCss($css);
?>
<div class="modal fade" id="<?= $widget->id ?>" role="modal" data-backdrop="static">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">框选好照片区域后后点击『裁 剪』保存</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="crop-image-container col-md-9">
                        <?= Html::img($widget->image, $widget->imageOptions) ?>
                    </div>
                    <div class="cropper-img-preview col-md-3"></div>
                </div>
                <div class="row" style="margin-top: 3px;">
                    <div class="col-md-12 cropper-buttons">
                        <div class="btn-group">
                            <label class="btn btn-primary btn-upload" for="cropper-inputImage" title="Upload image file">
                                <input type="file" class="sr-only" id="cropper-inputImage" name="file" accept="image/*">
                                <span class="docs-tooltip" data-toggle="tooltip" title="请从您的电脑文件中选择一张图片..">
                                  <span class="fa fa-upload"></span> 上传
                                </span>
                            </label>
                            <button type="button" class="btn btn-primary" data-cropper-method="setDragMode" data-option="move" data-toggle="tooltip" title="非裁剪区域可以按住鼠标移动图片">
                                <span class="docs-tooltip" data-toggle="tooltip" title="非裁剪区域可以按住鼠标移动图片">
                                  <span class="fa fa-arrows"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="setDragMode" data-option="crop" data-toggle="tooltip" title="非裁剪区域可以按住鼠标重新设定裁剪区域">
                                <span class="docs-tooltip" data-toggle="tooltip" title="非裁剪区域可以按住鼠标重新设定裁剪区域">
                                  <span class="fa fa-crop"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="rotate" data-option="45" data-toggle="tooltip" title="顺时针旋转45°">
                                <span class="docs-tooltip" data-toggle="tooltip" title="顺时针旋转45°">
                                  <span class="fa fa-rotate-right"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="rotate" data-option="-45" data-toggle="tooltip" title="逆时针旋转45°">
                                <span class="docs-tooltip" data-toggle="tooltip" title="逆时针旋转45°">
                                  <span class="fa fa-rotate-left"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="scaleX" data-option="-1" data-toggle="tooltip" title="水平180°旋转">
                                <span class="docs-tooltip" data-toggle="tooltip" title="水平180°旋转">
                                  <span class="fa fa-arrows-h"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="scaleY" data-option="-1" data-toggle="tooltip" title="垂直180°旋转">
                                <span class="docs-tooltip" data-toggle="tooltip" title="垂直180°旋转">
                                  <span class="fa fa-arrows-v"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="clear" data-toggle="tooltip" title="图片重新裁剪">
                                <span class="docs-tooltip" data-toggle="tooltip" title="图片重新裁剪">
                                  <span class="fa fa-remove"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-cropper-method="reset" data-toggle="tooltip" title="恢复图片原样">
                                <span class="docs-tooltip" data-toggle="tooltip" title="恢复图片原样">
                                  <span class="fa fa-refresh"></span> 重置
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关 闭</button>
                <button type="button" class="btn btn-primary crop-submit">裁 剪</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            var $image = $('#cropper-image');
            // Tooltip
            //$('[data-toggle="tooltip"]').tooltip();
            // Methods
            $('.cropper-buttons').on('click', '[data-cropper-method]', function () {
                var $this = $(this);
                var data = $this.data();
                var $target;
                var result;

                if ($this.prop('disabled') || $this.hasClass('disabled')) {
                    return;
                }

                if ($image.data('cropper') && data.cropperMethod) {
                    data = $.extend({}, data); // Clone a new one
                    //console.log(data);

                    if (typeof data.target !== 'undefined') {
                        $target = $(data.target);

                        if (typeof data.option === 'undefined') {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    result = $image.cropper(data.cropperMethod, data.option, data.secondOption);

                    switch (data.cropperMethod) {
                        case 'scaleX':
                        case 'scaleY':
                            $(this).data('option', -data.option);
                            break;

                        /*case 'getCroppedCanvas':
                            if (result) {

                                // Bootstrap's Modal
                                $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                                if (!$download.hasClass('disabled')) {
                                    $download.attr('href', result.toDataURL('image/jpeg'));
                                }
                            }

                            break;*/
                    }

                    if ($.isPlainObject(result) && $target) {
                        try {
                            $target.val(JSON.stringify(result));
                        } catch (e) {
                            console.log(e.message);
                        }
                    }

                }
            });


            // Keyboard
            $(document.body).on('keydown', function (e) {

                if (!$image.data('cropper') || this.scrollTop > 300) {
                    return;
                }

                switch (e.which) {
                    case 37:
                        e.preventDefault();
                        $image.cropper('move', -1, 0);
                        break;

                    case 38:
                        e.preventDefault();
                        $image.cropper('move', 0, -1);
                        break;

                    case 39:
                        e.preventDefault();
                        $image.cropper('move', 1, 0);
                        break;

                    case 40:
                        e.preventDefault();
                        $image.cropper('move', 0, 1);
                        break;
                }

            });


            // Import image
            var $inputImage = $('#cropper-inputImage');
            var URL = window.URL || window.webkitURL;
            var blobURL;

            if (URL) {
                $inputImage.change(function () {
                    var files = this.files;
                    var file;
                    if (!$image.data('cropper')) {
                        return;
                    }

                    if (files && files.length) {
                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {
                            blobURL = URL.createObjectURL(file);
                            $image.one('built.cropper', function () {

                                // Revoke when load complete
                                URL.revokeObjectURL(blobURL);
                            }).cropper('reset').cropper('replace', blobURL);
                            $inputImage.val('');
                        } else {
                            window.alert('请选择一张有效图片..');
                        }
                    }
                });
            } else {
                $inputImage.prop('disabled', true).parent().addClass('disabled');
            }
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
