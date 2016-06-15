<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
?>
<div class="event-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'allDay',
            'start',
            'end',
            'dow',
            'url:url',
            'className',
            'editable',
            'startEditable',
            'durationEditable',
            'source',
            'color',
            'backgroundColor',
            'borderColor',
            'textColor',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
