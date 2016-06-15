<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-19 下午12:30
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace frontend\controllers;

use common\populac\modules\article\api\Article;

class Ji_sheng_gong_zuo_dong_taiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'title' => '计生工作动态',
        ]);
    }

    /**
     * (string) actionCat : 分类
     * @param $slug
     * @param null $tag
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCat($slug, $tag = null)
    {
        $cat = Article::cat($slug);
        if(!$cat){
            throw new \yii\web\NotFoundHttpException('Article category not found.');
        }

        return $this->render('cat', [
            'cat' => $cat,
            'items' => $cat->items(['tags' => $tag, 'pagination' => ['pageSize' => 2]])
        ]);
    }

    public function actionView($slug)
    {
        $article = Article::get($slug);
        if(!$article){
            throw new \yii\web\NotFoundHttpException('Article not found.');
        }

        return $this->render('view', [
            'article' => $article
        ]);
    }

}
