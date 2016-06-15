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

use common\populac\modules\article\api\Article;
use yii\helpers\Url;

$this->title = $article->model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['ji_sheng_gong_zuo_dong_tai/index']];
$this->params['breadcrumbs'][] = ['label' => $article->cat->title, 'url' => ['ji_sheng_gong_zuo_dong_tai/cat', 'slug' => $article->cat->slug]];
$this->params['breadcrumbs'][] = $article->model->title;
?>
<h1><?= $this->title ?></h1>

<?= $article->text ?>

<?php if(count($article->photos)) : ?>
    <div>
        <h4>Photos</h4>
        <?php foreach($article->photos as $photo) : ?>
            <?= $photo->box(100, 100) ?>
        <?php endforeach;?>
        <?php Article::plugin() ?>
    </div>
    <br/>
<?php endif; ?>
<p>
    <?php foreach($article->tags as $tag) : ?>
        <a href="<?= Url::to(['/ji_sheng_gong_zuo_dong_tai/cat', 'slug' => $article->cat->slug, 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
    <?php endforeach; ?>
</p>

<small class="text-muted">阅读次数: <?= $article->views?></small>