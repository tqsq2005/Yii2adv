<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
    [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Event'),
        'content' => $this->render('_detail', [
            'model' => $model,
        ]),
    ],
    ];
echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'bordered' => true,
    'sideways' => true,
    'class' => 'tes',
    /*'pluginOptions' => [

        'enableCache' => false
        //        'height' => TabsX::SIZE_TINY
    ],*/
    'pluginEvents' => [

    ],
]);
?>
