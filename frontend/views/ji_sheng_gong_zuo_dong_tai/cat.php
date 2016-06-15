<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-19 下午12:42
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $cat->model->title;
$this->params['breadcrumbs'][] = ['label' => '计生工作动态', 'url' => ['ji_sheng_gong_zuo_dong_tai/index']];
$this->params['breadcrumbs'][] = $cat->model->title;
?>
<h1><?= $this->title ?></h1>
<br/>

<?php if(count($items)) : ?>
    <?php foreach($items as $article) : ?>
        <div class="row">
            <div class="col-md-2">
                <?= Html::img($article->thumb(160, 120)) ?>
            </div>
            <div class="col-md-10">
                <?= Html::a($article->title, ['ji_sheng_gong_zuo_dong_tai/view', 'slug' => $article->slug]) ?>
                <p><?= $article->short ?></p>
                <p>
                    <?php foreach($article->tags as $tag) : ?>
                        <a href="<?= Url::to(['/ji_sheng_gong_zuo_dong_tai/cat', 'slug' => $article->cat->slug, 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
<?php else : ?>
    <p>Category is empty</p>
<?php endif; ?>

<?= $cat->pages() ?>