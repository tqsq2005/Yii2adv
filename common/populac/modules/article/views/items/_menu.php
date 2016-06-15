<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>
<ul class="nav nav-pills">
    <?php if($action == 'index') : ?>
        <li><a href="<?= Url::to(['/populac/'.$module]) ?>">
                <i class="fa fa-th font-12"></i>
                <?= Yii::t('easyii', 'Categories') ?></a>
        </li>
    <?php endif; ?>
    <li <?= ($action == 'index') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/'.$module.'/items/index', 'id' => $category->primaryKey]) ?>">
            <i class="fa fa-th-list font-12"></i>
            <?= $category->title ?></a></li>
    <?php if($action === 'create' || $action === 'index') : ?>
        <li <?= ($action == 'create') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/populac/'.$module.'/items/create', 'id' => $category->primaryKey]) ?>">
                <i class="fa fa-plus font-12"></i>
                <?= Yii::t('easyii', 'Add') ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if($action === 'edit') : ?>
        <li class="active">
            <a href="<?= Url::to(['/populac/'.$module.'/items/edit', 'id' => $model->primaryKey]) ?>">
                <i class="fa fa-edit font-12"></i>
                修改
            </a>
        </li>
    <?php endif; ?>
</ul>
<br/>