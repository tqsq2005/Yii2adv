<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午9:57
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace frontend\controllers;

use common\models\Comment;
use common\populac\modules\gallery\api\Gallery;
use kucha\ueditor\UEditorAction;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class Ji_sheng_feng_caiController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'upload' => [
                'class' => UEditorAction::className(),
            ]
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($slug)
    {
        $album = Gallery::cat($slug);
        if(!$album){
            throw new \yii\web\NotFoundHttpException('无照片.');
        }

        // 评论列表
        $commentDataProvider = new ActiveDataProvider([
            'query' => Comment::find()->andWhere(['article_id' => $album->model->category_id, 'parent_id' => 0, 'comment_type' => 'gallery']),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        //评论数
        $commentNum = Comment::find()->andWhere(['article_id' => $slug, 'parent_id' => 0, 'comment_type' => 'gallery'])->count(1);
        $commentModels = $commentDataProvider->getModels();
        $pages = $commentDataProvider->getPagination();
        // 评论框
        $commentModel = new Comment();

        return $this->render('view', [
            'album' => $album,
            'photos' => $album->photos(['pagination' => ['pageSize' => 10]]),
            'commentModel' => $commentModel,
            'commentModels' => $commentModels,
            'pages' => $pages,
            'commentDataProvider' => $commentDataProvider,
            'commentNum' => $commentNum,
        ]);
    }
}
