<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-6 下午6:01
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\modules\guestbook\api\Guestbook;
use common\populac\modules\page\api\Page;

$page = Page::get('page-guestbook');

$this->title = $page->model->title;
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $this->title ?></h1>

<div class="row">
    <div class="col-md-8">
        <br>
        <?php foreach(Guestbook::items(['pagination' => ['pageSize' => 5]]) as $item) : ?>
            <div class="guestbook-item">
                <b><?= $item->name ?></b>
                <small class="text-muted"><?= $item->date ?></small>
                <p><?= $item->text ?></p>
                <?php if($item->answer) : ?>
                    <blockquote class="bg-info text-muted">
                        <b>管理员</b><br>
                        <?= $item->answer?>
                    </blockquote>
                <?php else: ?>
                    <blockquote class="bg-info text-warning">
                        <b>暂未回复</b><br>
                    </blockquote>
                <?php endif; ?>
            </div>
            <br>
        <?php endforeach; ?>
    </div>
    <div class="col-md-4">
        <?php if(Yii::$app->request->get(Guestbook::SENT_VAR)) : ?>
            <h4 class="text-success"><i class="glyphicon glyphicon-ok"></i> 您的留言已提交，请留意您的联系邮箱，我们将尽快回复！</h4>
        <?php else : ?>
            <h4>请留言</h4>
            <div class="well well-sm">
                <?= Guestbook::form() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= Guestbook::pages() ?>
