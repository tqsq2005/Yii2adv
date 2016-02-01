<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpmenu $model
 */

$this->title = 'Update Helpmenu: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Helpmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="helpmenu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
