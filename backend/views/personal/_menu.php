<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-25 上午11:38
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */
/**
 * @var \yii\web\View $this
 * @var integer $id
 * @var string $pid personal_id
*/
use yii\helpers\Url;

$action     = $this->context->action->id;
$controller = $this->context->id;
?>
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li <?= ($controller === 'personal') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/personal/update', 'id' => $id]) ?>">
            <i class="fa fa-chevron-circle-right"></i>
            <?= '员工档案' ?></a>
    </li>
    <li <?= ($controller === 'marry') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/marry/index', 'pid' => $pid]) ?>">
            <i class="fa fa-chevron-circle-right"></i>
            <?= '配偶情况' ?>
        </a>
    </li>
</ul>
