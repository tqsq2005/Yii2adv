<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-7 下午2:32
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\components\validators;

use common\models\Unit;
use Yii;
use yii\helpers\Url;
use yii\validators\Validator;
use common\models\MapUnit;

/**
 * Class UnitAccessible : 校验当前用户是否取得单位编码的完全访问权限
 * @package common\components\validators
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class UnitAccessible extends Validator
{
    /**
     * (void) validateAttribute : 校验当前用户是否取得单位编码的完全访问权限
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        /** @var integer $user_id 当前用户ID */
        $user_id  = Yii::$app->user->identity->id;
        /** @var string $unitcode 校验单位编码 */
        $unitcode = $model->$attribute;
        switch( $attribute ) {
            case 'unitcode'://修改
                if( Unit::findOne(['unitcode' => $unitcode]) && MapUnit::getUserPower( $user_id, $unitcode ) != MapUnit::USER_POWER_ALLOW ) {
                    $this->addError($model, $attribute, '你没有单位(部门)『'. $unitcode .'』的『完全访问』权限.');
                }
                break;
            case 'upunitcode'://新增
                if( !Unit::findOne(['upunitcode' => $unitcode]) && MapUnit::getUserPower( $user_id, $unitcode ) < MapUnit::USER_POWER_VIEW_DEPT ) {
                    $this->addError($model, $attribute, '你没有单位(部门)『'. $unitcode .'』的『完全访问』权限.');
                }
                break;
        }
    }

    /**
     * @inheritDoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $checkURL = Yii::$app->homeUrl.Url::to('/map-unit/check-unit-accessible');
        return <<<JS
        deferred.push($.post('$checkURL', {value: value, attribute: '$attribute'}).done(function(data) {
            if ('' !== data) {
                messages.push(data);
            }
        }));
JS;
    }


}