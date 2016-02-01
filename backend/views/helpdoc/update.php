<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpdoc $model
 */

$this->title = 'Update Helpdoc: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Helpdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="helpdoc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
