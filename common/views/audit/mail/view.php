<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-27 下午3:48
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/** @var View $this */
/** @var AuditMail $model */

use bedezign\yii2\audit\components\Helper;
use bedezign\yii2\audit\models\AuditMail;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = Yii::t('audit', 'Mail #{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Mails'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;
?>
<div class="box box-primary">
    <div class="box-header" style="cursor: pointer;">
        <i class="fa fa-info-circle"></i>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
    <?php
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'entry_id',
                'value' => $model->entry_id ? Html::a($model->entry_id, ['entry/view', 'id' => $model->entry_id]) : '',
                'format' => 'raw',
            ],
            'successful',
            'to',
            'from',
            'reply',
            'cc',
            'bcc',
            'subject',
            [
                'label' => Yii::t('audit', 'Download'),
                'value' => Html::a(Yii::t('audit', 'Download eml file'), ['mail/download', 'id' => $model->id]),
                'format' => 'raw',
            ],
            'created',
        ],
    ]);

    echo Html::tag('h2', Yii::t('audit', 'Text'));
    echo '<div class="well">';
    echo Yii::$app->formatter->asNtext($model->text);
    echo '</div>';

    echo Html::tag('h2', Yii::t('audit', 'HTML'));
    echo '<div class="well">';
    echo Yii::$app->formatter->asHtml($model->html);
    echo '</div>';

    //echo Html::tag('h2', Yii::t('audit', 'Data'));
    //echo '<div class="well">';
    //echo Yii::$app->formatter->asNtext(Helper::uncompress($model->data));
    //echo '</div>';
    ?>
    </div>
</div>
