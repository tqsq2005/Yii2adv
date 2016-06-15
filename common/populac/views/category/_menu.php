<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $this->context->getReturnUrl(['/populac/'.$this->context->moduleName.'/']) ?>">
            <i class="fa fa-th font-12"></i>
            <?= Yii::t('easyii', 'Categories') ?>
        </a>
    </li>
    <?php if($action === 'create' || $action === 'index') : ?>
        <li <?= ($action === 'create') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/populac/'.$this->context->moduleName.'/a/create']) ?>">
                <i class="fa fa-plus font-12"></i>
                <?= Yii::t('easyii', 'Create category') ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if($action === 'edit') : ?>
        <li class="active">
            <a href="<?= Url::current()?>">
                <i class="fa fa-edit font-12"></i>
                <?= Yii::t('easyii', 'Edit category') ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if($action === 'photos') : ?>
        <li class="active">
            <a href="<?= Url::current()?>">
                <i class="fa fa-edit font-12"></i>
                <?= Yii::t('easyii', 'Upload photos') ?>
            </a>
        </li>
    <?php endif; ?>
</ul>
<br/>