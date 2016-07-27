<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:50
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use bedezign\yii2\audit\models\AuditMailSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel AuditMailSearch */

$this->title = Yii::t('audit', 'Mails');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-th-list"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="audit-mail">

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
                        'attribute' => 'successful',
                        'options' => [
                            'width' => '80px',
                        ],
                    ],
                    'to',
                    'from',
                    'reply',
                    'cc',
                    'bcc',
                    'subject',
                    [
                        'attribute' => 'created',
                        'options' => ['width' => '150px'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

