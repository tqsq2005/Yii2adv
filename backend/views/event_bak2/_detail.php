<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */

?>
<div class="event-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'hidden' => true],
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
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>