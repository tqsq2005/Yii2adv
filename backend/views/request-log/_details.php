<?php

use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\RequestLog $model
 */
$this->title = '其他信息';
?>
<div class="request-log-details">
    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>$this->title,
                'type'=>DetailView::TYPE_INFO,
            ],
            'attributes' => [
                /*[
                    'group'=>true,
                    'label'=>'其他信息：',
                    'rowOptions'=>['class'=>'info']
                ],*/
                [
                    'columns' => [
                        [
                            'attribute'=>'app_id',
                        ],
                        [
                            'attribute'=>'ip',
                        ],
                    ]
                ],
                [
                    'attribute'=>'user_agent',
                    'format'=>'raw',
                    'value'=>'<span class="text-justify"><em>' . $model->user_agent . '</em></span>',
                    'options'=>['rows'=>4]
                ],
            ],
            'enableEditMode'=>false,
    ]) ?>

</div>
