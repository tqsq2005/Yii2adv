<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午10:15
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Url;

$this->title = Yii::t('easyii/page', 'Pages');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>
<div class="box box-primary">
    <div class="box-body">
        <?php if($data->count > 0) : ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <?php if(IS_ROOT) : ?>
                        <th width="50">#</th>
                    <?php endif; ?>
                    <th><?= Yii::t('easyii', 'Title')?></th>
                    <?php if(IS_ROOT) : ?>
                        <th><?= Yii::t('easyii', 'Slug')?></th>
                        <th width="30"></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data->models as $item) : ?>
                    <tr>
                        <?php if(IS_ROOT) : ?>
                            <td><?= $item->primaryKey ?></td>
                        <?php endif; ?>
                        <td><a href="<?= Url::to(['/populac/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                        <?php if(IS_ROOT) : ?>
                            <td><?= $item->slug ?></td>
                            <td><a href="<?= Url::to(['/populac/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('easyii', 'Delete item')?>"></a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?= yii\widgets\LinkPager::widget([
                'pagination' => $data->pagination
            ]) ?>
        <?php else : ?>
            <p><?= Yii::t('easyii', 'No records found') ?></p>
        <?php endif; ?>
    </div>
</div>