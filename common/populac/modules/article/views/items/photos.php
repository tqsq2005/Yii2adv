<?php
use common\populac\widgets\Photos;

$this->title = $model->title;
?>

<?= $this->render('_menu', ['category' => $model->category]) ?>
<div class="nav-tabs-custom">
    <?= $this->render('_submenu', ['model' => $model]) ?>
    <div style="padding: 20px 20px;">
        <?= Photos::widget(['model' => $model])?>
    </div>
</div>
