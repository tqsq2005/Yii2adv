<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:45
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

use bedezign\yii2\audit\models\AuditTrailSearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Trails');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-th-list"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="audit-trail">


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                    'id',
                    [
                        'attribute' => 'entry_id',
                        'class' => 'yii\grid\DataColumn',
                        'value' => function ($data) {
                            return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => Yii::t('audit', 'User ID'),
                        'class' => 'yii\grid\DataColumn',
                        'value' => function ($data) {
                            return Audit::getInstance()->getUserIdentifier($data->user_id);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'action',
                        'filter' => AuditTrailSearch::actionFilter(),
                    ],
                    'model',
                    'model_id',
                    'field',
                    [
                        'label' => Yii::t('audit', 'Diff'),
                        'value' => function ($model) {
                            return $model->getDiffHtml();
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'created',
                        'options' => ['width' => '150px'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

