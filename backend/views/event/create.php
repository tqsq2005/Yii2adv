<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Event */

$this->title = '添加事件';
$this->params['breadcrumbs'][] = ['label' => '事件管理', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
//echo $this->render('_menu');
?>
<div class="event-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
