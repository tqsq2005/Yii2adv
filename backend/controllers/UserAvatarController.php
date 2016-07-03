<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-1 下午4:05
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace backend\controllers;

use Yii;
use common\models\UserAvatar;
use yii\base\InvalidCallException;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserAvatarController implements the CRUD actions for UserAvatar model.
 */
class UserAvatarController extends Controller
{
    private $_savePath = "@webroot/uploads/user/avatar/";      // 图片存储路径
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserAvatar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;//user model
        //上传头像
        $savePath = Yii::getAlias($this->_savePath);
        if(!is_dir($savePath))
        {
            if(!FileHelper::createDirectory($savePath))
            {
                throw new InvalidCallException("上传目录无法创建！");
            }
        }
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = $user->id . '_' . time() . rand(1 , 10000) . '.' . $extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save($savePath . $fileName, ['quality' => 80]);

            if( $userAvatar = $this->findModel( $user->id ) ) {
                //删除旧头像
                if (file_exists($savePath.$userAvatar->avatar) && (strpos($userAvatar->avatar, 'default') === false))
                    @unlink($savePath.$userAvatar->avatar);
                //更新头像
                $userAvatar->avatar = $fileName;
                $userAvatar->update();
            } else {
                $userAvatar = new UserAvatar;
                $userAvatar->user_id = $user->id;
                $userAvatar->avatar = $fileName;
                $userAvatar->save();
            }
        }

        $avatar = '';
        if( $userAvatar = $this->findModel( $user->id ) ) {
            $avatar = $userAvatar->avatar;
        }

        return $this->render('index', [
            'user' => $user,
            'avatar' => $avatar,
        ]);
    }

    public function actionCropper()
    {
        $user = Yii::$app->user->identity;//user model
        //上传头像
        $savePath = Yii::getAlias($this->_savePath);
        if(!is_dir($savePath))
        {
            if(!FileHelper::createDirectory($savePath))
            {
                throw new InvalidCallException("上传目录无法创建！");
            }
        }
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = $user->id . '_' . time() . rand(1 , 10000) . '.' . $extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save($savePath . $fileName, ['quality' => 80]);

            if( $userAvatar = $this->findModel( $user->id ) ) {
                //删除旧头像
                if (file_exists($savePath.$userAvatar->avatar) && (strpos($userAvatar->avatar, 'default') === false))
                    @unlink($savePath.$userAvatar->avatar);
                //更新头像
                $userAvatar->avatar = $fileName;
                $userAvatar->update();
            } else {
                $userAvatar = new UserAvatar;
                $userAvatar->user_id = $user->id;
                $userAvatar->avatar = $fileName;
                $userAvatar->save();
            }
        }

        $avatar = '';
        if( $userAvatar = $this->findModel( $user->id ) ) {
            $avatar = $userAvatar->avatar;
        }

        return $this->render('_cropper', [
            'user' => $user,
            'avatar' => $avatar,
        ]);
    }

    /**
     * 根据user_id删除头像
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($user_id)
    {
        $this->findModel($user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 根据user_id查找头像
     * @param integer $user_id
     * @return UserAvatar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id)
    {
        if (($model = UserAvatar::findOne(['user_id' => $user_id])) !== null) {
            return $model;
        } else {
            return null;
        }
    }
}