<?php
$this->title = Yii::t('easyii', 'Edit category');
?>
<?= $this->render('_menu') ?>

<?php if(!empty($this->params['submenu'])) echo $this->render('_submenu', ['model' => $model], $this->context); ?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
