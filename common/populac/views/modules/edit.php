<?php
$this->title = $model->title;
?>
<div class="nav-tabs-custom">
    <?= $this->render('_menu') ?>
    <?= $this->render('_submenu', ['model' => $model]) ?>
    <div style="padding-bottom: 20px;">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
