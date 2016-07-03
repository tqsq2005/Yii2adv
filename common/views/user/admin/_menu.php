<?php

use yii\helpers\Html;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <?= Html::a('<i class="fa fa-th-list"></i> '.Yii::t('user', 'Users'), ['/user/admin/index']); ?>
    </li>
    <?php if($action === 'create' || $action === 'index') : ?>
        <li <?= ($action==='create') ? 'class="active"' : 'id="menu-user-create"' ?>>
            <?= Html::a('<i class="fa fa-plus"></i>'.Yii::t('user', 'New user'), ['/user/admin/create']); ?>
        </li>
    <?php endif; ?>
    <?php if(in_array($action, ['update', 'update-profile', 'info', 'assignments'])) : ?>
        <li class="active">
            <?= Html::a('<i class="fa fa-edit"></i>'.Yii::t('user', 'Update user account'), \yii\helpers\Url::current()); ?>
        </li>
    <?php endif; ?>
</ul>
