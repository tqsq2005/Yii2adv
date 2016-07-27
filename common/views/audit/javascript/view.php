<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:52
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/** @var yii\web\View $this */
/** @var bedezign\yii2\audit\models\AuditJavascript $model */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('audit', 'Javascript #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Javascripts'), 'url' => ['index']];
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
                'attribute' => 'entry_id',
                'value' => $model->entry_id ? Html::a($model->entry_id, ['entry/view', 'id' => $model->entry_id]) : '',
                'format' => 'raw',
            ],
            'type',
            'origin',
            'message',
            'created',
        ],
    ]);

    //print_r($model->data);
    ?>
    </div>
</div>
