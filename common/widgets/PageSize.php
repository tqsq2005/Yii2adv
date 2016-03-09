<?php

/**
 * PageSize.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-3-8
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\widgets;
use yii\base\Widget;
use yii\helpers\Html;
/**
 * PageSize widget is an addition to the \yii\grid\GridView that enables
 * changing the size of a page on GridView.
 *
 * To use this widget with a GridView, add this widget to the page:
 *
 * ~~~
 * <?php echo \nterms\PageSize::widget(); ?>
 * ~~~
 *
 * and set the `filterSelector` property of GridView as shown in
 * following example.
 *
 * ~~~
 * <?= GridView::widget([
 *      'dataProvider' => $dataProvider,
 *      'filterModel' => $searchModel,
 * 		'filterSelector' => 'select[name="per-page"]',
 *      'columns' => [
 *          ...
 *      ],
 *  ]); ?>
 * ~~~
 *
 * Please note that `per-page` here is the string you use for `pageSizeParam` setting of the PageSize widget.
 *
 * @author Saranga Abeykoon <amisaranga@gmail.com>
 * @since 1.0
 */

class PageSize extends Widget
{
    /**
     * @var string the label text.
     */
    public $label = '每页显示条数';

    /**
     * @var integer the defualt page size. This page size will be used when the $_GET['per-page'] is empty.
     */
    public $defaultPageSize = 10;

    /**
     * @var string the name of the GET request parameter used to specify the size of the page.
     * This will be used as the input name of the dropdown list with page size options.
     */
    public $pageSizeParam = 'per-page';

    /**
     * @var array the list of page sizes
     */
    public $sizes = [
        2 => 2, 5 => 5, 7 => 7, 9 => 9, 10 => '请选择显示条数',
        11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15,
        16 => 16, 17 => 17, 18 => 18, 20 => 20,
        25 => 25,
        50 => 50,
        100 => 100,
        200 => 200
    ];

    /**
     * @var string the template to be used for rendering the output.
     */
    //public $template = '<span class="col-md-3">{list} {label}</span>';
    public $template = '<span class="col-md-2">{list}</span>';

    /**
     * @var array the list of options for the drop down list.
     */
    public $options;

    /**
     * @var array the list of options for the label
     */
    public $labelOptions;

    /**
     * @var boolean whether to encode the label text.
     */
    public $encodeLabel = true;

    /**
     * Runs the widget and render the output
     */
    public function run()
    {
        if(empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        if(empty($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }

        if($this->encodeLabel) {
            $this->label = Html::encode($this->label);
        }

        $perPage = !empty($_GET[$this->pageSizeParam]) ? $_GET[$this->pageSizeParam] : $this->defaultPageSize;

        $listHtml = Html::dropDownList($this->pageSizeParam, $perPage, $this->sizes, $this->options);
        $labelHtml = Html::label($this->label, $this->options['id'], $this->labelOptions);

        //$output = str_replace(['{list}', '{label}'], [$listHtml, $labelHtml], $this->template);
        $output = str_replace(['{list}'], [$listHtml], $this->template);

        return $output;
    }
}