<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 下午2:07
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */


use yii\helpers\Markdown;
use kartik\helpers\Html;

?>
<!--评论-->
<div id="comments">
    <h4>共 <span class="text-danger"><?=$commentNum?></span> 条评论</h4>
    <div class="col-4">
        <ul class="media-list">
            <?php foreach ($commentModels as $item):?>
                <li class="media" data-key="<?=$item->id?>">
                    <div class="media-left">
                        <a href="<?= \yii\helpers\Url::to(['/user', 'id' => $item->user_id])?>">
                            <img class="media-object" src="<?php //echo $item->profile->avatarUrl?>" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="media-heading"><a href="<?= \yii\helpers\Url::to(['/user', 'id' => $item->user_id])?>"><?=$item->user->username?></a> 评论于 <?=date('Y-m-d H:i', $item->created_at)?></div>
                        <div class="media-content"><?= $item->content?></div>
                        <?php foreach ($item->sons as $son):?>
                            <div class="media">
                                <div class="media-left">
                                    <a href="<?= \yii\helpers\Url::to(['/user', 'id' => $son->user_id])?>" rel="author" title=""><img class="media-object" src="<?= $son->profile->avatarUrl?>" alt=""></a>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="<?= \yii\helpers\Url::to(['/user', 'id' => $son->user_id])?>" rel="author" data-original-title="<?=$son->user->username?>" title=""><?=$son->user->username?></a> 回复于 <?=date('Y-m-d H:i', $son->created_at)?>
                                        <span class="pull-right"><a class="reply-btn j_replayAt" href="javascript:;">回复</a></span>
                                    </div>
                                    <div class="media-content"><?= $son->content?></div>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <div class="media-action">
                            <a class="reply-btn" href="#">回复</a><span class="vote"><a class="up" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'up'])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="fa fa-thumbs-o-up"></span> <em><?=$item->up?></em></a><a class="down" href="<?=\yii\helpers\Url::to(['/vote', 'id' => $item->id, 'type' => 'comment', 'action' => 'down'])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="fa fa-thumbs-o-down"></span> <em><?=$item->down?></em></a></span>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $commentDataProvider->getPagination()
        ]); ?>
    </div>
</div>
<h4>发表评论</h4>

    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('comment/create')]); ?>
    <?= $form->field($commentModel, 'content')->label(false)
        ->widget(\kucha\ueditor\UEditor::className(), [
            'clientOptions' => [
                //编辑区域大小
                'initialFrameHeight' => '200',
                //设置语言
                'lang' =>'zh-cn', //中文为 zh-cn
                //定制菜单
                'toolbars' => [
                    [
                        'fullscreen', 'source', 'undo', 'redo', '|',
                        'fontsize',
                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                        'forecolor', 'backcolor', '|',
                        'lineheight', '|',
                        'indent', '|'
                    ],
                ]
            ]
        ]); ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'article_id'), $model->category_id) ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'comment_type'), 'gallery') ?>
    <div class="form-group">
        <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        <?php else: ?>
            <?= Html::a('登录', ['/site/login'], ['class' => 'btn btn-primary'])?>
        <?php endif; ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <!--回复-->
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('comment/create'), 'options' => ['class' => 'reply-form hidden']]); ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'article_id'), $model->category_id) ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'comment_type'), 'gallery') ?>
    <?= Html::hiddenInput(Html::getInputName($commentModel, 'parent_id'), 0, ['class' => 'parent_id']) ?>
    <?=$form->field($commentModel, 'content')->label(false)->textarea()?>
    <div class="form-group">
        <?php if (!Yii::$app->user->isGuest): ?>
            <button type="submit" class="btn btn-sm btn-primary">回复</button>
        <?php else: ?>
            <?= Html::a('登录', ['/site/login'], ['class' => 'btn btn-primary'])?>
        <?php endif; ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
