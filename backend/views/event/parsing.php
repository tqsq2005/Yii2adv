<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;


$this->title='Parsing / Upload  event excel';
$this->params['breadcrumbs'][] = ['label' => 'event', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//log variable
$logId = Yii::$app->session->get($log);

/* @var $this yii\web\View */
/* @var $model app\models\Operator */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="sintret-update">

    <div class="page-header">
        <h1>Parsing Excel event</h1>
    </div>


    <div class="event-form">


        <div class="event-form">
            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'options' => ['enctype' => 'multipart/form-data']   // important, needed for file upload
            ]);
            ?>

            <div class="row">
                <div class="col-md-10">
                    <?php
                    echo $form->field($model, 'fileori')->widget(FileInput::classname(), [
                        'options' => ['accept' => '.xls'],
                    ]);
                    ?>

                </div>


            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?=                    Html::submitButton('Upload ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
                    ?>
                </div>
            </div>
            <div class="notifications" style="display: none">Please wait, while loading.... <img src="/admin/img/loadingAnimation.gif"></div>
            
            <?php
            ActiveForm::end();
            ?>

        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-10">
            Format Sample : <a href="<?php echo Yii::$app->urlManager->createUrl('event/sample');?>">event.xls</a>
        </div>

    </div>
</div>

<?php 
if($logId)
    {
$this->registerJs('$(document).ready(function(){ $.ajax({
        type:"POST",
        url:"' . Yii::$app->urlManager->createUrl([$route,'id'=>Yii::$app->session->get($log)]) . '",
        beforeSend:function(){ $(".notifications").show();},
        success:function(html){
            $(".notifications").html(html);
        }
    });});');
 } 
 Yii::$app->session->set($log,NULL);
?> 
