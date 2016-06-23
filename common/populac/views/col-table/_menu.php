<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-22 下午3:24
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-27 下午5:04
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Url;
$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/col-table/']) ?>">
            <?php if($action != 'index') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php else : ?>
                <i class="glyphicon glyphicon-th font-12"></i>
            <?php endif; ?>
            <?= Yii::t('easyii', 'List') ?>
        </a>
    </li>
    <li <?= ($action === 'col-missing') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/col-table/col-missing']) ?>">
            <i class="fa fa-exclamation-triangle font-12"></i>
            未配置字段
        </a></li>
    <li <?= ($action === 'history') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/populac/col-table/history']) ?>">
            <i class="glyphicon glyphicon-trash font-12"></i>
            历史数据
        </a></li>
</ul>
<br/>