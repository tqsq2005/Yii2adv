<?php

use yii\helpers\Html;

//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Baza Arxivi - Admin';

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <?php
        echo
        kartik\grid\GridView::widget([
            'id' => 'install-grid',
            'export' => false,
            'dataProvider' => $dataProvider,
            'resizableColumns' => false,
            'showPageSummary' => false,
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title"> Database Backup Files</h3>',
                'type' => 'primary',
                'showFooter' => false
            ],
            // set your toolbar
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>  Create Backup ', ['create'], ['class' => 'btn btn-success create-backup margin-right5'])
                ],
            ],
            'columns' => array(
                'name',
                'size:size',
                'create_time',
                'modified_time:relativeTime',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{restore_action}',
                    'header' => 'Restore',
                    'buttons' => [
                        'restore_action' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-import"></span>', $url, [
                                'title' => 'Restore','class'=>'restore'
                            ]);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'restore_action') {
							$url = Url::to(['backuprestore/restore', 'filename' => $model['name']]);
                            return $url;
                        }
                    }
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{delete_action}',
                    'header' => 'Delete',
                    'buttons' => [
                        'delete_action' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Delete Database'),'class'=>'delete',
                            ]);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete_action') {
                            $url = Url::to(['backuprestore/delete', 'filename' => $model['name']]);
                            return $url;
                        }
                    }
                ],
            ),
        ]);
        ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
