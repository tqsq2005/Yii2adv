<?php

use common\populac\modules\article\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('easyii/article', 'Articles');
\common\populac\assets\AdminAsset::register($this);
$module = $this->context->module->id;
$i_no = 1
?>
<?= $this->render('_menu', ['category' => $model]) ?>
<div class="box box-primary">
    <div class="box-body" id="admin-body">
        <?php if(count($model->items)) : ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="50">序号</th>
                    <th><?= Yii::t('easyii', 'Title') ?></th>
                    <th width="120"><?= Yii::t('easyii', 'Views') ?></th>
                    <th width="100"><?= Yii::t('easyii', 'Status') ?></th>
                    <th width="120"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($model->items as $item) : ?>
                    <tr data-id="<?= $item->primaryKey ?>">
                        <td><?= $i_no++ ?></td>
                        <td><a href="<?= Url::to(['/populac/'.$module.'/items/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                        <td><?= $item->views ?></td>
                        <td class="status">
                            <?= Html::checkbox('', $item->status == Item::STATUS_ON, [
                                'class' => 'switch',
                                'data-id' => $item->primaryKey,
                                'data-link' => Url::to(['/populac/'.$module.'/items']),
                            ]) ?>
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?= Url::to(['/populac/'.$module.'/items/up', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                                <a href="<?= Url::to(['/populac/'.$module.'/items/down', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                                <a href="<?= Url::to(['/populac/'.$module.'/items/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?= Yii::t('easyii', 'No records found') ?></p>
        <?php endif; ?>
    </div>
</div>
