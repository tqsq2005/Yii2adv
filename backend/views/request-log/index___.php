<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 * @var View $this
 * @var RequestLogSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/** @var IdentityInterface|ActiveRecord $identity */
$identity = Yii::$app->getUser()->identityClass;

$this->title = Module::t('Requests');
echo Breadcrumbs::widget(['links' => [
    $this->title
]]);
?>
<div class="request-log-default-index">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $index, $dataColumn) {
                    /** @var RequestLog $model */
                    return $model->id;
                },
                'filter' => false
            ],
            'app_id',
            'route',
            'params',
            [
                'attribute' => 'user_id',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->user ? $model->user->{Module::getInstance()->usernameAttribute} : Module::t('Guest');
                },
                'filter' => ArrayHelper::map($identity::find()->all(), 'id', Module::getInstance()->usernameAttribute)
            ],
            'ip',
            [
                'attribute' => 'datetime',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->datetime;
                },
                'filter' => false
            ],
            [
                'attribute' => 'user_agent',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->user_agent;
                },
                'filter' => false
            ],
        ]
    ]);
    Pjax::end();
    ?>
</div>
