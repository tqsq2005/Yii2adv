<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-18 下午10:44
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;

use common\populac\helpers\Image;
use common\populac\components\Controller;
use common\populac\models\Photo;
use common\populac\behaviors\SortableController;

class PhotosController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            [
                'class' => SortableController::className(),
                'model' => Photo::className(),
            ]
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $photo = new Photo;
        $photo->class = $class;
        $photo->item_id = $item_id;
        $photo->image = UploadedFile::getInstance($photo, 'image');

        if($photo->image && $photo->validate(['image'])){
            $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);

            if($photo->image){
                if($photo->save()){
                    $success = [
                        'message' => Yii::t('easyii', 'Photo uploaded'),
                        'photo' => [
                            'id' => $photo->primaryKey,
                            'image' => $photo->image,
                            'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT),
                            'description' => ''
                        ]
                    ];
                }
                else{
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $photo->image));
                    $this->error = Yii::t('easyii', 'Create error. {0}', $photo->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
            }
        }
        else{
            $this->error = Yii::t('easyii', 'File is incorrect');
        }
        if($this->error) {
            Yii::error($this->error, 'File upload');
        }
        return $this->formatResponse($success);
    }

    public function actionDescription($id)
    {
        if(($model = Photo::findOne($id)))
        {
            if(Yii::$app->request->post('description'))
            {
                $model->description = Yii::$app->request->post('description');
                if(!$model->update()) {
                    $this->error = Yii::t('easyii', 'Update error. {0}', $model->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'Bad response');
            }
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse(Yii::t('easyii', 'Photo description saved'));
    }

    public function actionImage($id)
    {
        $success = null;

        if(($photo = Photo::findOne($id)))
        {
            $oldImage = $photo->image;

            $photo->image = UploadedFile::getInstance($photo, 'image');

            if($photo->image && $photo->validate(['image'])){
                $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);
                if($photo->image){
                    if($photo->save()){
                        @unlink(Yii::getAlias('@webroot').$oldImage);

                        $success = [
                            'message' => Yii::t('easyii', 'Photo uploaded'),
                            'photo' => [
                                'image' => $photo->image,
                                'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT)
                            ]
                        ];
                    }
                    else{
                        @unlink(Yii::getAlias('@webroot').$photo->image);

                        $this->error = Yii::t('easyii', 'Update error. {0}', $photo->formatErrors());
                    }
                }
                else{
                    $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
                }
            }
            else{
                $this->error = Yii::t('easyii', 'File is incorrect');
            }

        }
        else{
            $this->error =  Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse($success);
    }

    public function actionDelete($id)
    {
        if(($model = Photo::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Photo deleted'));
    }

    public function actionUp($id, $class, $item_id)
    {
        return $this->move($id, 'up', ['class' => $class, 'item_id' => $item_id]);
    }

    public function actionDown($id, $class, $item_id)
    {
        return $this->move($id, 'down', ['class' => $class, 'item_id' => $item_id]);
    }
}