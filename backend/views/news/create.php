<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\models\News $model
*/

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => $model->getAliasModel(true), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud news-create">

    <h1>
        <?= $model->getAliasModel() ?>        <small>
                        <?= $model->title ?>        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
