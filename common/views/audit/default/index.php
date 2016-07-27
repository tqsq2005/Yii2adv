<?php

use bedezign\yii2\audit\Audit;
use bedezign\yii2\audit\components\panels\Panel;
use bedezign\yii2\audit\models\AuditEntry;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Audit Module');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('canvas {width: 100% !important;height: 400px;}');
?>
<div class="audit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h2><?php echo Html::a(Yii::t('audit', 'Entries'), ['entry/index']); ?></h2>

            <div class="well">
                <?php
                $days = [];
                $count = [];
                foreach (range(-6, 0) as $day) {
                    $date = strtotime($day . 'days');
                    $days[] = date('D: Y-m-d', $date);
                    $count[] = AuditEntry::find()->where(['between', 'created', date('Y-m-d 00:00:00', $date), date('Y-m-d 23:59:59', $date)])->count();
                }
                echo ChartJs::widget([
                    'type' => 'Bar',
                    'data' => [
                        'labels' => $days,
                        'datasets' => [
                            [
                                'fillColor' => 'rgba(151,187,205,0.5)',
                                'strokeColor' => 'rgba(151,187,205,1)',
                                'pointColor' => 'rgba(151,187,205,1)',
                                'pointStrokeColor' => '#fff',
                                'data' => $count,
                            ],
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>

        <?php
        foreach (Audit::getInstance()->panels as $panel) {
            /** @var Panel $panel */
            $chart = $panel->getChart();
            if (!$chart) {
                continue;
            }
            $indexUrl = $panel->getIndexUrl();
            ?>
            <div class="col-md-3 col-lg-3">
                <h2><?php echo $indexUrl ? Html::a($panel->getName(), $indexUrl) : $panel->getName(); ?></h2>

                <div class="well">
                    <?php echo $chart; ?>
                </div>
            </div>
        <?php } ?>

    </div>

</div>
