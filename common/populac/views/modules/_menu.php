<?php

use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $this->context->getReturnUrl(['/populac/modules/index']) ?>">
            <i class="fa fa-th font-12"></i>
            <?= Yii::t('easyii', 'List') ?>
        </a>
    </li>
    <?php if($action === 'create' || $action === 'index') : ?>
        <li <?= ($action==='create') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['/populac/modules/create']) ?>">
                <i class="fa fa-plus font-12"></i>
                <?= Yii::t('easyii', 'Create') ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if($action === 'edit') : ?>
        <li class="active">
            <a href="<?= Url::current()?>">
                <i class="fa fa-edit font-12"></i>
                修改
            </a>
        </li>
    <?php endif; ?>
    <?php if($action === 'settings') : ?>
        <li class="active">
            <a href="<?= Url::current()?>">
                <i class="fa fa-cog font-12 fa-spin"></i>
                设置
            </a>
        </li>
    <?php endif; ?>
</ul>
<br/>
