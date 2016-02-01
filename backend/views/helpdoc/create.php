<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpdoc $model
 */

$this->title = 'Create Helpdoc';
$this->params['breadcrumbs'][] = ['label' => 'Helpdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpdoc-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
