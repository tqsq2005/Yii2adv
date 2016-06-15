<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-27 上午8:42
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\guestbook\controllers;

use Yii;
use yii\data\ActiveDataProvider;

use common\populac\behaviors\StatusController;
use common\populac\components\Controller;
use common\populac\modules\guestbook\models\Guestbook;

class AController extends Controller
{
    public $new = 0;
    public $noAnswer = 0;

    public function behaviors()
    {
        return [
            [
                'class' => StatusController::className(),
                'model' => Guestbook::className()
            ]
        ];
    }

    public function init()
    {
        parent::init();

        $this->new = Yii::$app->getModule('populac')->activeModules['guestbook']->notice;
        $this->noAnswer = Guestbook::find()->where(['answer' => ''])->count();
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Guestbook::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionNoanswer()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Guestbook::find()->where(['answer' => ''])->desc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = Guestbook::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/populac/'.$this->module->id]);
        }

        if($model->new > 0){
            $model->new = 0;
            $model->update();
        }

        if (Yii::$app->request->post('Guestbook')) {
            $model->answer = trim(Yii::$app->request->post('Guestbook')['answer']);
            if($model->save($model)){
                if(Yii::$app->request->post('mailUser')){
                    $model->notifyUser();
                }
                $this->flash('success', Yii::t('easyii/guestbook', 'Answer successfully saved'));
            }
            else{
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }
        else {
            return $this->render('view', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Guestbook::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/guestbook', 'Entry deleted'));
    }

    public function actionViewall()
    {
        Guestbook::updateAll(['new' => 0]);
        $module = \common\populac\models\Module::findOne(['name' => 'guestbook']);
        $module->notice = 0;
        $module->save();

        $this->flash('success', Yii::t('easyii/guestbook', 'Guestbook updated'));

        return $this->back();
    }

    public function actionSetnew($id)
    {
        $model = Guestbook::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
        }
        else{
            $model->new = 1;
            if($model->update()) {
                $this->flash('success', Yii::t('easyii/guestbook', 'Guestbook updated'));
            }
            else{
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->redirect($this->getReturnUrl(['/populac/'.$this->module->id]));
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, Guestbook::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Guestbook::STATUS_OFF);
    }
}