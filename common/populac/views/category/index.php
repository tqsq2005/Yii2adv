<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-16 上午11:48
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\components\CategoryModel;
use yii\helpers\Url;

\yii\bootstrap\BootstrapPluginAsset::register($this);
\common\populac\assets\AdminAsset::register($this);

$this->title = Yii::$app->getModule('populac')->activeModules[$this->context->module->id]->title;

$baseUrl = '/populac/'.$this->context->moduleName;
?>

<?= $this->render('_menu') ?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <?php if(sizeof($cats) > 0) : ?>
            <table class="table table-hover">
                <tbody>
                <?php foreach($cats as $cat) : ?>
                    <tr>
                        <td width="50"><?= $cat->category_id ?></td>
                        <td style="padding-left:  <?= $cat->depth * 20 ?>px;">
                            <?php if(count($cat->children)) : ?>
                                <i class="caret"></i>
                            <?php endif; ?>
                            <?php if(!count($cat->children) || !empty(Yii::$app->controller->module->settings['itemsInFolder'])) : ?>
                                <a href="<?= Url::to([$baseUrl . $this->context->viewRoute, 'id' => $cat->category_id]) ?>" <?= ($cat->status == CategoryModel::STATUS_OFF ? 'class="smooth"' : '') ?>><?= $cat->title ?></a>
                            <?php else : ?>
                                <span <?= ($cat->status == CategoryModel::STATUS_OFF ? 'class="smooth"' : '') ?>><?= $cat->title ?></span>
                            <?php endif; ?>
                        </td>
                        <td width="120" class="text-right" >
                            <div class="dropdown actions">
                                <i id="dropdownMenu<?= $cat->category_id ?>" data-toggle="dropdown" aria-expanded="true" title="<?= Yii::t('easyii', 'Actions') ?>" class="glyphicon glyphicon-menu-hamburger"></i>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu<?= $cat->category_id ?>">
                                    <li><a href="<?= Url::to([$baseUrl.'/a/edit', 'id' => $cat->category_id]) ?>"><i class="glyphicon glyphicon-pencil font-12"></i> <?= Yii::t('easyii', 'Edit') ?></a></li>
                                    <li><a href="<?= Url::to([$baseUrl.'/a/create', 'parent' => $cat->category_id]) ?>"><i class="glyphicon glyphicon-plus font-12"></i> <?= Yii::t('easyii', 'Add subcategory') ?></a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li><a href="<?= Url::to([$baseUrl.'/a/up', 'id' => $cat->category_id]) ?>"><i class="glyphicon glyphicon-arrow-up font-12"></i> <?= Yii::t('easyii', 'Move up') ?></a></li>
                                    <li><a href="<?= Url::to([$baseUrl.'/a/down', 'id' => $cat->category_id]) ?>"><i class="glyphicon glyphicon-arrow-down font-12"></i> <?= Yii::t('easyii', 'Move down') ?></a></li>
                                    <li role="presentation" class="divider"></li>
                                    <?php if($cat->status == CategoryModel::STATUS_ON) :?>
                                        <li><a href="<?= Url::to([$baseUrl.'/a/off', 'id' => $cat->category_id]) ?>" title="<?= Yii::t('easyii', 'Turn Off') ?>'"><i class="glyphicon glyphicon-eye-close font-12"></i> <?= Yii::t('easyii', 'Turn Off') ?></a></li>
                                    <?php else : ?>
                                        <li><a href="<?= Url::to([$baseUrl.'/a/on', 'id' => $cat->category_id]) ?>" title="<?= Yii::t('easyii', 'Turn On') ?>"><i class="glyphicon glyphicon-eye-open font-12"></i> <?= Yii::t('easyii', 'Turn On') ?></a></li>
                                    <?php endif; ?>
                                    <li><a href="<?= Url::to([$baseUrl.'/a/delete', 'id' => $cat->category_id]) ?>" class="confirm-delete" data-reload="1" title="<?= Yii::t('easyii', 'Delete item') ?>"><i class="glyphicon glyphicon-remove font-12"></i> <?= Yii::t('easyii', 'Delete') ?></a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?= Yii::t('easyii', 'No records found') ?></p>
        <?php endif; ?>
    </div>
</div>
