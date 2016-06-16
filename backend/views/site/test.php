<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Test';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/plus/jsTree/themes/default/style.min.css');
$this->registerJsFile('@web/plus/jsTree/jstree.min.js', ['depends' => 'yii\web\JqueryAsset',]);
?>
<div class="site-test">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
    <?= Yii::getAlias('@web/storage'); ?>
    <?= Yii::getAlias('@webroot/storage'); ?>
</div>
<span role="presentation" class="dropdown">
                                        <i id="dropdownMenu9" data-toggle="dropdown" aria-expanded="true" title="Actions" class="glyphicon glyphicon-menu-hamburger"></i>
                                        <ul id="menu3" class="dropdown-menu" aria-labelledby="drop6">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                    </span>

<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <div class="unit-index container-fluid" role="main">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="fa fa-asterisk fa-spin"></i>
                                单位列表
                                <div class="pull-right">
                                    <i class="fa fa-refresh fa-spin" id="unit-refresh" style="cursor: pointer"
                                       title="点击更新单位列表"></i>&nbsp;
                                    <i class="fa fa-question-circle" id="unit-help" style="cursor: pointer"
                                       title="点击查看帮助"></i>
                                    <span role="presentation" class="dropdown">
                                        <i id="dropdownMenu9" data-toggle="dropdown" aria-expanded="true" title="Actions" class="glyphicon glyphicon-menu-hamburger"></i>
                                        <ul id="menu3" class="dropdown-menu" aria-labelledby="drop6">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                    </span>
                                </div>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="unit-search" style="margin-bottom: 10px;">
                                <input type="text" value="" style="box-shadow:inset 0 0 4px #eee; width:150px; margin:0; padding:6px 12px; border-radius:4px; border:1px solid silver; font-size:1.1em;"
                                       id="unit_q" placeholder="搜索.." />
                            </div>
                            <div id="unit-tree"></div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
                <div class="col-md-9 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> 资料列表 </h3>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="unit-detail"></div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



