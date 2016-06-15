<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午8:32
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use common\populac\widgets\Photos;

$this->title = $model->title;
?>

<?= $this->render('@common/populac/views/category/_menu') ?>
<div class="box box-primary">
    <div class="box-body">
        <?= Photos::widget(['model' => $model])?>
    </div>
</div>
