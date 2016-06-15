<?php

use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>

<ul class="nav nav-tabs">
    <li <?= ($action === 'edit') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/'.$module.'/items/edit', 'id' => $model->primaryKey]) ?>">
            <i class="fa fa-edit font-12"></i>
            <?= Yii::t('easyii/article', 'Edit article') ?></a></li>
    <li <?= ($action === 'photos') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/'.$module.'/items/photos', 'id' => $model->primaryKey]) ?>">
            <span class="glyphicon glyphicon-camera"></span> <?= Yii::t('easyii', 'Photos') ?></a></li>

</ul>
<br>