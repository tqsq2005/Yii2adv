<?php

use yii\helpers\Url;

$action = $this->context->action->id;
//$this->registerCss('.nav-tabs-custom { background: #ecf0f5 none repeat scroll 0 0;border-radius: 1px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);margin-bottom: 20px;}');
//$this->registerCss('.content-wrapper { background-color: #fff !important;}');
\common\widgets\CssBlock::begin([
    'options' => [
        'type' => 'text/css',
        'media' => 'print'
    ],
]);
?>
<style type="text/css" media="print">
    ul.populac-content-nav{
        display: none;
    }
</style>
<?php \common\widgets\CssBlock::end(); ?>
<div class="nav-tabs-custom-pop">
    <ul class="nav nav-pills populac-content-nav">
        <?php if(in_array($action, ['index', 'list', 'history', 'data-tables'])) : ?>
            <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
                <a href="<?= Url::to(['index']) ?>">
                    <?php if(in_array($action, ['list', 'history', 'data-tables'])) : ?>
                        <i class="fa fa-chevron-left"></i>
                    <?php endif; ?>
                    日历
                </a>
            </li>
        <?php endif; ?>
        <li <?= ($action === 'list') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['list']) ?>">
                事件管理
            </a>
        </li>
        <li <?= ($action === 'history') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['history']) ?>">
                历史事件
            </a>
        </li>
        <li <?= ($action === 'data-tables') ? 'class="active"' : '' ?>>
            <a href="<?= Url::to(['data-tables']) ?>">
                事件列表
            </a>
        </li>
    </ul>
</div>
<br/>