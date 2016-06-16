<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Personal */

$this->title = 'Create Personal';
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
