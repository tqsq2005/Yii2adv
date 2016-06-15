<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Unit */
/* @var integer $isParent */

$this->title = 'Create Unit';
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <?= $this->render('_form', [
        'model'     => $model,
        'isParent'  => $isParent,
    ]) ?>

</div>
