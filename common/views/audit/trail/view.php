<?php

/** @var yii\web\View $this */
/** @var bedezign\yii2\audit\models\AuditTrail $model */

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('audit', 'Trail #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Trails'), 'url' => ['trail/index']];
$this->params['breadcrumbs'][] = '#' . $model->id;

?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-info-circle"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => $model->getAttributeLabel('user_id'),
                'value' => Audit::getInstance()->getUserIdentifier($model->user_id),
                'format' => 'raw',
            ],
            [
                'attribute' => 'entry_id',
                'value' => $model->entry_id ? Html::a($model->entry_id, ['entry/view', 'id' => $model->entry_id]) : '',
                'format' => 'raw',
            ],
            'action',
            'model',
            'model_id',
            'field',
            'created',
        ],
    ]);

    echo Html::tag('h2', Yii::t('audit', 'Difference'));
    echo $model->getDiffHtml();
    ?>
    </div>
</div>

