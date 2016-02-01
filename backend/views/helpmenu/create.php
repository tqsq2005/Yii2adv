<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpmenu $model
 */

$this->title = 'Create Helpmenu';
$this->params['breadcrumbs'][] = ['label' => 'Helpmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpmenu-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
