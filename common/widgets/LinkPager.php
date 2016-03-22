<?php
/**
 * Copyright (c) 2016. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/**
 * LinkPager.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-3-15
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\widgets;

use Yii;
use yii\helpers\Html;
/**
 * Description of LinkPager
 *
 * @author liyunfang <381296986@qq.com>
 * @date 2015-09-07
 */
class LinkPager extends \yii\widgets\LinkPager {

    /**
     * {pageButtons} {customPage} {pageSize}
     */
    public $template = '{pageButtons} {pageSize}';

    /**
     * pageSize list
     */
    public $pageSizeList = [1, 2, 3, 5, 7, 8, 9, 10, 11, 12, 13, 15, 18, 20, 25, 30, 50];
    /**
     *
     * Margin style for the  pageSize control
     */
    public $pageSizeMargin = "margin-left:5px;margin-right:5px;";
    /**
     * customPage width
     */
    public $customPageWidth = 50;

    /**
     * Margin style for the  customPage control
     */
    public $customPageMargin = "margin-left:5px;margin-right:5px;";

    /**
     * Jump
     */
    public $customPageBefore = '';
    /**
     * Page
     */
    public $customPageAfter = "";

    /**
     * pageSize style
     */
    public $pageSizeOptions = ['class' => 'form-control','style' => 'display: inline-block;width:auto;margin-top:0px;'];
    /**
     * customPage style
     */
    public $customPageOptions = ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px; ime-mode:disabled;'];


    public function init() {
        parent::init();
        if($this->pageSizeMargin){
            Html::addCssStyle($this->pageSizeOptions, $this->pageSizeMargin);
        }
        if($this->customPageWidth){
            Html::addCssStyle($this->customPageOptions, 'width:'.$this->customPageWidth.'px;');
        }
        if($this->customPageMargin){
            Html::addCssStyle($this->customPageOptions, $this->customPageMargin);
        }
    }


    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageContent();
    }

    protected function renderPageContent(){
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if('customPage' == $name){
                return $this->renderCustomPage();
            }
            else if('pageSize' ==  $name){
                return $this->renderPageSize();
            }
            else if('pageButtons' == $name){
                return $this->renderPageButtons();
            }
            return "";
        }, $this->template);
    }
    protected function renderPageSize(){
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        //$linkurl =  $this->pagination->createUrl($page);
        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    protected function renderCustomPage(){
        $page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if(isset($params[$this->pagination->pageParam])){
            $page = intval($params[$this->pagination->pageParam]);
            if($page < 1){
                $page = 1;
            }
            else if($page > $this->pagination->getPageCount()){
                $page = $this->pagination->getPageCount();
            }
        }
        return $this->customPageBefore.Html::textInput($this->pagination->pageParam, $page,$this->customPageOptions).$this->customPageAfter;
    }
}