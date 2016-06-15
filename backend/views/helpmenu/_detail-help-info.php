<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpmenu $model
 */

$this->title = $model->unitname;
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> <?= $this->title ?> </h3>
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div id="helpmenu-view">
            <?= $model->content ?>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>
