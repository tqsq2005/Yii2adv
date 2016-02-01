<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Preferences */

$this->title = '添加系统参数';
$this->params['breadcrumbs'][] = ['label' => '系统参数配置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preferences-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
