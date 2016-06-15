<?php
$this->title = Yii::t('easyii/article', 'Create article');
?>
<?= $this->render('_menu', ['category' => $category]) ?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
