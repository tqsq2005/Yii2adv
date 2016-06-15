<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午11:51
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */


namespace frontend\controllers;

use common\models\Comment;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreate()
    {
        $model = new Comment();
        $model->load(\Yii::$app->request->post());
        $model->user_id = \Yii::$app->user->identity->getId();
        $returnUrl = \Yii::$app->request->getReferrer();
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', '评论成功！');
        } else {
            \Yii::$app->session->setFlash('error', '评论失败！');
        }

        return $this->redirect($returnUrl);
    }
    // 图文弹幕
    public function actionDm($comment_type = 'article')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $article_id = \Yii::$app->request->post('article_id');
        $time = \Yii::$app->request->post('time');
        $page = \Yii::$app->request->post('page');
        $query = Comment::find()->where(['article_id' => $article_id, 'comment_type' => $comment_type]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->orderBy('created_at desc')
            ->limit($pages->limit)
            ->with('user')
            ->asArray()
            ->all();
        $hasNext = 0;
        if ($page < $pages->pageCount) {
            $hasNext = 1;
        }

        return [
            'list' => $models,
            'hasNext' => $hasNext,
            'time' => $time,
        ];
    }
}
