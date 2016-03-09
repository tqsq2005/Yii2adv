<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\modules\preferences\models\Preferences $model
 */

$this->title = 'Create Preferences';
$this->params['breadcrumbs'][] = ['label' => 'Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preferences-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
