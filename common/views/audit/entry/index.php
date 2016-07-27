<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:42
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

use bedezign\yii2\audit\models\AuditEntrySearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Entries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-th-list"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="audit-entry-index">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
                    'id',
                    [
                        'attribute' => 'user_id',
                        'label' => Yii::t('audit', 'User'),
                        'class' => 'yii\grid\DataColumn',
                        'value' => function ($data) {
                            return Audit::getInstance()->getUserIdentifier($data->user_id);
                        },
                        'format' => 'raw',
                    ],
                    'ip',
                    [
                        'filter' => AuditEntrySearch::methodFilter(),
                        'attribute' => 'request_method',
                    ],
                    [
                        'filter' => [1 => \Yii::t('audit', 'Yes'), 0 => \Yii::t('audit', 'No')],
                        'attribute' => 'ajax',
                        'value' => function($data) {
                            return $data->ajax ? Yii::t('audit', 'Yes') : Yii::t('audit', 'No');
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'route',
                        'filter' => AuditEntrySearch::routeFilter(),
                        'format' => 'html',
                        'value' => function ($data) {
                            return HTML::tag('span', '', [
                                'title' => \yii\helpers\Url::to([$data->route]),
                                'class' => 'glyphicon glyphicon-link'
                            ]) . ' ' . $data->route;
                        },
                    ],
                    [
                        'attribute' => 'duration',
                        'format' => 'decimal',
                        'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
                    ],
                    [
                        'attribute' => 'memory_max',
                        'format' => 'shortsize',
                        'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
                    ],
                    [
                        'attribute' => 'trails',
                        'value' => function ($data) {
                            return $data->trails ? count($data->trails) : '';
                        },
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute' => 'mails',
                        'value' => function ($data) {
                            return $data->mails ? count($data->mails) : '';
                        },
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute' => 'javascripts',
                        'value' => function ($data) {
                            return $data->javascripts ? count($data->javascripts) : '';
                        },
                        'contentOptions' => ['class' => 'text-right'],
                    ],
                    [
                        'attribute' => 'errors',
                        'value' => function ($data) {
                            return $data->linkedErrors ? count($data->linkedErrors) : '';
                        },
                        'contentOptions' => ['class' => 'text-right'],
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

