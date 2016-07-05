<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \dektrium\user\models\User */
?>
<?php $this->beginContent('@backend/views/map-unit/_tree.php', ['user' => $user]) ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-th-list"></i>
                资料列表
                <div class="pull-right">
                    <i class="fa fa-search" data-toggle="tooltip" id="dagl-info-list-search" style="cursor: pointer"
                       title="多功能查询"></i>&nbsp;
                    <i class="fa fa-question-circle" data-toggle="tooltip" id="dagl-info-list-help" style="cursor: pointer"
                       title="查看帮助"></i>
                </div>
            </h3>
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div id="unit-detail">
            <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>
<?php $this->endContent() ?>
