<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-27 上午8:43
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\guestbook\models;

use common\behaviors\ARLogBehavior;
use common\populac\components\ActiveRecord;
use Yii;
use common\populac\behaviors\CalculateNotice;
use common\populac\helpers\Mail;
use common\populac\models\Preferences;
use common\populac\validators\ReCaptchaValidator;
use common\populac\validators\EscapeValidator;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%guestbook}}".
 *
 * @property integer $guestbook_id
 * @property string $name
 * @property string $title
 * @property string $text
 * @property string $answer
 * @property string $email
 * @property integer $time
 * @property string $ip
 * @property integer $new
 * @property integer $status
 */
class Guestbook extends ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const FLASH_KEY = 'populac_guestbook_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return '{{%guestbook}}';
    }

    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['name', 'title', 'text'], 'trim'],
            [['name', 'title', 'text'], EscapeValidator::className()],
            ['email', 'email'],
            ['title', 'string', 'max' => 128],
            ['reCaptcha', ReCaptchaValidator::className(), 'on' => 'send', 'when' => function(){
                return Yii::$app->getModule('populac')->activeModules['guestbook']->settings['enableCaptcha'];
            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
                $this->new = 1;
                $this->status = Yii::$app->getModule('populac')->activeModules['guestbook']->settings['preModerate'] ? self::STATUS_OFF : self::STATUS_ON;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert){
            $this->mailAdmin();
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('easyii/guestbook', 'Name'),
            'title' => Yii::t('easyii/guestbook', 'Title'),
            'email' => Yii::t('easyii/guestbook', 'E-mail'),
            'text' => Yii::t('easyii/guestbook', 'Text'),
            'answer' => Yii::t('easyii/guestbook', 'Answer'),
            'reCaptcha' => Yii::t('easyii/guestbook', 'Anti-spam check')
        ];
    }

    public function behaviors()
    {
        return [
            'cn' => [
                'class' => CalculateNotice::className(),
                'callback' => function(){
                    return self::find()->where(['new' => 1])->count();
                }
            ],
            'audit' => [
                'class' => ARLogBehavior::className(),
            ],
        ];
    }

    public function mailAdmin()
    {
        $settings = Yii::$app->getModule('populac')->activeModules['guestbook']->settings;

        if(!$settings['mailAdminOnNewPost']){
            return false;
        }

        return Mail::send(
            Preferences::get('sEmail', 'username'),
            $settings['subjectOnNewPost'],
            $settings['templateOnNewPost'],
            [
                'post' => $this,
                'link' => (Yii::$app->homeUrl == Preferences::get('sSystem', 'backendUrl')) ?
                    Url::to(['/populac/guestbook/a/view', 'id' => $this->primaryKey], true) :
                    Url::to([Preferences::get('sSystem', 'backendUrl') . '/populac/guestbook/a/view', 'id' => $this->primaryKey], true)
            ]
        );
    }

    public function notifyUser()
    {
        $settings = Yii::$app->getModule('populac')->activeModules['guestbook']->settings;

        return Mail::send(
            $this->email,
            $settings['subjectNotifyUser'],
            $settings['templateNotifyUser'],
            [
                'post' => $this,
                'link' => str_replace(Preferences::get('sSystem', 'backendUrl'), '', Url::to([$settings['frontendGuestbookRoute']], true))
            ]
        );
    }
}