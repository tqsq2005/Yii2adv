<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-19 下午12:34
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\article\api;

use Yii;
use yii\data\ActiveDataProvider;
use common\populac\components\API;
use common\populac\models\Tag;
use common\populac\modules\article\models\Item;
use yii\helpers\Url;
use yii\widgets\LinkPager;

class CategoryObject extends \common\populac\components\ApiObject
{
    public $slug;
    public $image;
    public $tree;
    public $depth;

    private $_adp;
    private $_items;

    public function getTitle(){
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function pages($options = []){
        return $this->_adp ? LinkPager::widget(array_merge($options, ['pagination' => $this->_adp->pagination])) : '';
    }

    public function pagination(){
        return $this->_adp ? $this->_adp->pagination : null;
    }

    public function items($options = [])
    {
        if(!$this->_items){
            $this->_items = [];

            //$with = ['seo'];
            $with = [];
            if(Yii::$app->getModule('populac')->activeModules['article']->settings['enableTags']){
                $with[] = 'tags';
            }

            //$query = Item::find()->with('seo')->where(['category_id' => $this->id])->status(Item::STATUS_ON)->sortDate();
            $query = Item::find()->where(['category_id' => $this->id])->status(Item::STATUS_ON)->sort();

            if(!empty($options['where'])){
                $query->andFilterWhere($options['where']);
            }
            if(!empty($options['tags'])){
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new Item())->filterTagValues($options['tags'])])
                    ->addGroupBy('item_id');
            }

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => !empty($options['pagination']) ? $options['pagination'] : []
            ]);

            foreach($this->_adp->models as $model){
                $this->_items[] = new ArticleObject($model);
            }
        }
        return $this->_items;
    }

    public function getEditLink(){
        return Url::to(['/populac/article/a/edit/', 'id' => $this->id]);
    }
}