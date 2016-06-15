<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-18 下午10:32
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\helpers\Image;
use common\populac\models\Photo;
use common\populac\widgets\Fancybox;
use yii\helpers\Html;
use yii\helpers\Url;
use common\populac\assets\PhotosAsset;

PhotosAsset::register($this);
Fancybox::widget(['selector' => '.plugin-box']);

$class = get_class($this->context->model);
$item_id = $this->context->model->primaryKey;

$linkParams = [
    'class' => $class,
    'item_id' => $item_id,
];

$photoTemplate = '<tr data-id="{{photo_id}}">'.(IS_ROOT ? '<td>{{photo_id}}</td>' : '').
    '<td><a href="'.Yii::$app->homeUrl.'{{photo_image}}" class="plugin-box" title="{{photo_description}}" rel="easyii-photos">'.
    '<img class="photo-thumb" id="photo-{{photo_id}}" src="{{photo_thumb}}"></a></td>'.
    '<td>'.
        '<textarea class="form-control photo-description">{{photo_description}}</textarea>'.
        '<a href="' . Url::to(['/populac/photos/description/{{photo_id}}']) . '" class="btn btn-sm btn-primary disabled save-photo-description">'. Yii::t('easyii', 'Save') .'</a>'.
    '</td>'.
    '<td class="control vtop">'.
        '<div class="btn-group btn-group-sm" role="group">'.
            '<a href="' . Url::to(['/populac/photos/up/{{photo_id}}'] + $linkParams) . '" class="btn btn-default move-up" title="'. Yii::t('easyii', 'Move up') .'"><span class="glyphicon glyphicon-arrow-up"></span></a>'.
            '<a href="' . Url::to(['/populac/photos/down/{{photo_id}}'] + $linkParams) . '" class="btn btn-default move-down" title="'. Yii::t('easyii', 'Move down') .'"><span class="glyphicon glyphicon-arrow-down"></span></a>'.
            '<a href="' . Url::to(['/populac/photos/image/{{photo_id}}'] + $linkParams) . '" class="btn btn-default change-image-button" title="'. Yii::t('easyii', 'Change image') .'"><span class="glyphicon glyphicon-floppy-disk"></span></a>'.
            '<a href="' . Url::to(['/populac/photos/delete/{{photo_id}}']) . '" class="btn btn-default color-red delete-photo" title="'. Yii::t('easyii', 'Delete item') .'"><span class="glyphicon glyphicon-remove"></span></a>'.
            '<input type="file" name="Photo[image]" class="change-image-input hidden">'.
        '</div>'.
    '</td>'.
'</tr>';
$this->registerJs("
var photoTemplate = '{$photoTemplate}';
", \yii\web\View::POS_HEAD);
$photoTemplate = str_replace('>\\', '>', $photoTemplate);
?>
<button id="photo-upload" class="btn btn-success text-uppercase"><span class="glyphicon glyphicon-arrow-up"></span> <?= Yii::t('easyii', 'Upload')?></button>
<small id="uploading-text" class="smooth"><?= Yii::t('easyii', 'Uploading. Please wait')?><span></span></small>

<table id="photo-table" class="table table-hover" style="display: <?= count($photos) ? 'table' : 'none' ?>;">
    <thead>
    <tr>
        <?php if(IS_ROOT) : ?>
        <th width="50">#</th>
        <?php endif; ?>
        <th width="150"><?= Yii::t('easyii', 'Image') ?></th>
        <th><?= Yii::t('easyii', 'Description') ?></th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($photos as $photo) : ?>
        <?= str_replace(
            ['{{photo_id}}', '{{photo_thumb}}', '{{photo_image}}', '{{photo_description}}'],
            [$photo->primaryKey, Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT), $photo->image, $photo->description],
            $photoTemplate)
        ?>
    <?php endforeach; ?>
    </tbody>
</table>
<p class="empty" style="display: <?= count($photos) ? 'none' : 'block' ?>;"><?= Yii::t('easyii', 'No photos uploaded yet') ?>.</p>

<?= Html::beginForm(Url::to(['/populac/photos/upload'] + $linkParams), 'post', ['enctype' => 'multipart/form-data']) ?>
<?= Html::fileInput('', null, [
    'id' => 'photo-file',
    'class' => 'hidden',
    'multiple' => 'multiple',
])
?>
<?php Html::endForm() ?>