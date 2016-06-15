<?php
$this->title = Yii::t('easyii', 'Create module');
?>
<?= $this->render('_menu') ?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>


