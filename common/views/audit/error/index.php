<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:55
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;
use yii\grid\GridView;

use bedezign\yii2\audit\models\AuditErrorSearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel AuditErrorSearch */

$this->title = Yii::t('audit', 'Errors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-th-list"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="audit-error">


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                    [
                        'attribute' => 'id',
                        'options' => [
                            'width' => '80px',
                        ],
                    ],
                    [
                        'attribute' => 'entry_id',
                        'class' => 'yii\grid\DataColumn',
                        'value' => function ($data) {
                            return $data->entry_id ? Html::a($data->entry_id, ['entry/view', 'id' => $data->entry_id]) : '';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'filter' => AuditErrorSearch::messageFilter(),
                        'attribute' => 'message',
                    ],
                    [
                        'attribute' => 'code',
                        'options' => [
                            'width' => '80px',
                        ],
                    ],
                    [
                        'filter' => AuditErrorSearch::fileFilter(),
                        'attribute' => 'file',
                    ],
                    [
                        'attribute' => 'line',
                        'options' => [
                            'width' => '80px',
                        ],
                    ],
                    [
                        'attribute' => 'hash',
                        'options' => [
                            'width' => '100px',
                        ],
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

