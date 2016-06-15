<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午10:02
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\modules\gallery\api\Gallery;

$this->title = $album->model->title;
$this->params['breadcrumbs'][] = ['label' => '计生风采', 'url' => ['ji_sheng_feng_cai/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<?php if(count($photos)) : ?>
    <div>
        <h4 class="hidden">照片</h4>
        <?php foreach($photos as $photo) : ?>
            <?= $photo->box(100, 100) ?>
        <?php endforeach;?>
        <?php Gallery::plugin() ?>
    </div>
    <br/>
<?php else : ?>
    <p>Album is empty.</p>
<?php endif; ?>
<?= $album->pages() ?>
<?= $this->render('comment', [
    'model' => $album->model,
    'commentModel' => $commentModel,
    'commentModels' => $commentModels,
    'pages' => $pages,
    'commentDataProvider' => $commentDataProvider,
    'commentNum' => $commentNum,
])?>
<?= \common\widgets\danmu\Danmu::widget(['id' => $album->model->category_id, 'comment_type' => 'gallery']);?>
<?php
/*$this->registerJsFile('@web/js/jquery.lazyload.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(<<<js
    $(function(){
        $('.view-content iframe').addClass('embed-responsive-item').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $("img.lazy").show().lazyload({effect: "fadeIn"});
    });
js
);*/
?>