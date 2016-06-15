<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
?>
<div class="nav-tabs-custom">
    <?= $this->render('_menu') ?>
    <?= $this->render('_submenu', ['model' => $model]) ?>
    <div class="row">
        <div class="col-md-12" style="margin-left: 20px; margin-bottom: 20px;">
            <?php if(sizeof($model->settings) > 0) : ?>
                <?= Html::beginForm(); ?>
                <?php foreach($model->settings as $key => $value) : ?>
                    <?php if(!is_bool($value)) : ?>
                        <div class="form-group">
                            <label><?= $key; ?></label>
                            <?= Html::input('text', 'Settings['.$key.']', $value, ['class' => 'form-control']); ?>
                        </div>
                    <?php else : ?>
                        <div class="checkbox">
                            <label>
                                <?= Html::checkbox('Settings['.$key.']', $value, ['uncheck' => 0])?> <?= $key ?>
                            </label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
                <?php Html::endForm(); ?>
            <?php else : ?>
                <?= $model->title ?> <?= Yii::t('easyii', 'module doesn`t have any settings.') ?>
            <?php endif; ?>
            <a href="<?= Url::to(['/populac/modules/restore-settings', 'id' => $model->module_id]) ?>" class="pull-right text-warning"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('easyii', 'Restore default settings') ?></a>
        </div>
    </div>

</div>
