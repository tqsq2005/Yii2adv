<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var integer $id
 * @var string $pid personal_id
 * @var common\models\Personal $model
 */

$this->title = '更新个人档案信息';
$this->params['breadcrumbs'][] = ['label' => '员工档案资料管理', 'url' => ['/unit/index']];
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_menu', [
    'id'  => $id,
    'pid' => $pid,
]);
?>
<div class="box box-solid">
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
</div>
