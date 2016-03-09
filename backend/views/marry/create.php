<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Marry $model
 */

$this->title = 'Create Marry';
$this->params['breadcrumbs'][] = ['label' => 'Marries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marry-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
