<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;

$backTo = null;
$indexUrl = Url::to(['/populac/'.$module]);
$noanswerUrl = Url::to(['/populac/'.$module.'/a/noanswer']);

?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $indexUrl ?>">
            <i class="fa fa-th font-12"></i>
            <?= Yii::t('easyii', 'All') ?>
        </a>
    </li>
    <li <?= ($action === 'noanswer') ? 'class="active"' : '' ?>>
        <a href="<?= $noanswerUrl ?>">
            <i class="fa fa-low-vision font-12"></i>
            <?= Yii::t('easyii/guestbook', 'No answer') ?>
            <?php if($this->context->noAnswer > 0) : ?>
                <span class="badge"><?= $this->context->noAnswer ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li class="pull-right">
        <?php if($action === 'view') : ?>
            <a href="<?= Url::to(['/populac/'.$module.'/a/setnew', 'id' => Yii::$app->request->get('id')]) ?>" class="text-warning"><span class="glyphicon glyphicon-eye-close"></span> <?= Yii::t('easyii/guestbook', 'Mark as new') ?></a>
        <?php else : ?>
            <a href="<?= Url::to(['/populac/'.$module.'/a/viewall']) ?>" class="text-warning"><span class="glyphicon glyphicon-eye-open"></span> <?= Yii::t('easyii/guestbook', 'Mark all as viewed') ?></a>
        <?php endif; ?>
    </li>
</ul>
<br/>
