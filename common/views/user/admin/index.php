<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_menu');
?>

<div class="box box-primary">
    <div class="box-header">
        <div class="box-tools pull-right">
            <i class="fa fa-question-circle fa-lg text-warning" data-toggle="tooltip" data-placement="top" id="user-help" style="cursor: pointer" title="查看帮助"></i>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?php Pjax::begin() ?>

        <?= GridView::widget([
            'dataProvider' 	=> $dataProvider,
            'filterModel'  	=> $searchModel,
            'id'            => 'user-gridview',
            'headerRowOptions' => ['class' => 'user-table-header'],
            //'filterRowOptions' => ['id' => 'user-table-filter'],//默认class为.filters
            'layout'  		=> "{items}\n{pager}",
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => '序号',
                ],
                [
                    'attribute' => 'username',
                    'content' => function($model) {
                        return Html::a($model->username, ['/user/admin/update', 'id' => $model->id], [
                            'data-toggle' => 'tooltip',
                            'title' => '修改用户['. $model->username .']的资料',
                            'data-placement' => 'right',
                        ]);
                    },
                    //'format' => 'html',
                ],
                'email:email',
                [
                    'attribute' => 'registration_ip',
                    'value' => function ($model) {
                        return $model->registration_ip == null
                            ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
                            : $model->registration_ip;
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if (extension_loaded('intl')) {
                            return Yii::t('user', '{0, date, Y年M月d日,  HH:mm}', [$model->created_at]);
                        } else {
                            return date('Y-m-d G:i:s', $model->created_at);
                        }
                    },
                    'filter' => DatePicker::widget([
                        'model'      => $searchModel,
                        'attribute'  => 'created_at',
                        'dateFormat' => 'php:Y-m-d',
                        'options' => [
                            'class' => 'form-control',
                        ],
                    ]),
                ],
                [
                    'header' => Yii::t('user', 'Confirmation'),
                    'value' => function ($model) {
                        if ($model->isConfirmed) {
                            return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                        } else {
                            return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                            ]);
                        }
                    },
                    'format' => 'raw',
                    'visible' => Yii::$app->getModule('user')->enableConfirmation,
                ],
                [
                    'header' => Yii::t('user', 'Block status'),
                    'value' => function ($model) {
                        if ($model->isBlocked) {
                            return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-success btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                            ]);
                        } else {
                            return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                                'class' => 'btn btn-xs btn-danger btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                            ]);
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>

        <?php Pjax::end() ?>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#user-help', function() {
                var tour = new Tour({
                    duration: 10000,
                    backdrop: true,
                    template: "<div class='popover tour'>" +
                    "<div class='arrow'></div>" +
                    "<h3 class='popover-title'></h3>" +
                    "<div class='popover-content'></div>" +
                    "<div class='popover-navigation'>" +
                    "<button class='btn btn-default' data-role='prev'><i class='fa fa-hand-o-left'></i>前</button>" +
                    "<span data-role='separator'>|</span>" +
                    "<button class='btn btn-default' data-role='next'><i class='fa fa-hand-o-right'></i>后</button>" +
                    "<button class='btn btn-default' data-role='end'>结束</button>" +
                    "</div>" +
                    "</div>",
                    steps: [
                        {
                            element: "#menu-user-create",
                            title: "如何添加用户",
                            placement: "left",
                            content: "点击该按钮进入添加新用户界面。"
                        },
                        {
                            element: ".user-table-header",
                            title: "用户排序",
                            placement: "bottom",
                            content: "点击蓝色字体可以对用户进行排序。"
                        },
                        {
                            element: '.filters',
                            title: "用户过滤",
                            placement: "bottom",
                            content: "输入框中输入信息后按回车键[<kbd>Enter</kbd>]可以对用户进行过滤。"
                        }
                    ]});

                // Initialize the tour
                tour.init();

                // Start the tour
                tour.restart();
            });
        });

    </script>
<?php \common\widgets\JsBlock::end(); ?>

