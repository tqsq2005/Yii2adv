<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午9:59
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\helpers\Image;
use common\populac\modules\gallery\api\Gallery;
use common\populac\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-gallery');

$this->title = $page->model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>
<br/>

<?php foreach(Gallery::cats() as $album) : ?>
    <a class="center-block" href="<?= Url::to(['ji_sheng_feng_cai/view', 'slug' => $album->slug]) ?>">
        <?= Html::img(Image::thumbFrontend($album->image, 160, 120)) ?><br/><?= $album->title ?>
    </a>
    <br/>
<?php endforeach; ?>
