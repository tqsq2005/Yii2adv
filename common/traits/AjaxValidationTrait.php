<?php
/**
  * AjaxValidationTrait.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-11
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace common\traits;

use Yii;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class AjaxValidationTrait : activeForm ajax验证trait
 * @package common\traits
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
trait AjaxValidationTrait
{
    /**
     * (void) performAjaxValidation : activeForm ajax验证
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation(Model $model)
    {
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }

}