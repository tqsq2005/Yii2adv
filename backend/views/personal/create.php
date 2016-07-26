<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Personal $model
 * @var string $unitname
 */

$this->title = '新增个人档案信息';
$this->params['breadcrumbs'][] = ['label' => '员工档案资料管理', 'url' => ['/unit/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
            'unitname' => $unitname,
        ]) ?>
    </div>
</div>
