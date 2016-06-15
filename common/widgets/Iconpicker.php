<?php

/**
 * Iconpicker.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-29
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\widgets;

use insolita\iconpicker\IconpickerAsset;
use Yii;
use yii\helpers\Html;

class Iconpicker extends \insolita\iconpicker\Iconpicker
{
    //前缀
    public $prefix = 'fa ';
    public $options = [
        'class' => 'form-control'
    ];
    public $containerOptions = [
        'class' => 'input-group'
    ];
    public $pickerOptions=[
        'class'=>'btn btn-default'
    ];
    private $_default = 'fa-th-list';
    private $_id;

    /**
     * (void) init :
     */
    public function init(){
        if (!isset($this->options['id']) && !$this->hasModel()) {
            $this->options['id'] = 'iconpicker_'.$this->getId();
        }
        parent::init();
        $this->_id=$this->options['id'];
        if($this->hasModel() && !empty($this->model->{$this->attribute})){
            $temArr = explode(' ', $this->model->{$this->attribute});
            if(count($temArr)>1) {
                $this->_default=$this->pickerOptions['data-icon']=$temArr[1];
            }
        }
        if(!$this->hasModel() && !empty($this->value)){
            $this->_default=$this->pickerOptions['data-icon']=$this->value;
        }
        if(!isset($this->pickerOptions['id'])){
            $this->pickerOptions['id']=$this->_id.'_jspicker';
        }
        if($this->removePrefix){
            $this->_default=($this->iconset=='fontawesome')?'fa-'.$this->_default:'glyphicon-'.$this->_default;
        }
        $this->registerAssets();
    }

    /**
     * @return string bootstrap-picker button with hiddenInput field where we put selected value
     */
    public function run()
    {

        if($this->hasModel()) {
            $inp= Html::activeTextInput($this->model, $this->attribute, $this->options);
        }else{
            $inp= Html::textInput($this->name, $this->value, $this->options);
        }
        $picker=Html::button('选择图标',$this->pickerOptions);
        $span = Html::tag('span', $picker, ['class' => 'input-group-btn']);

        return  Html::tag('div',$inp.$span,$this->containerOptions);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $id=$this->_id;
        $pickid=$this->pickerOptions['id'];
        IconpickerAsset::register($view);

        $js[]=<<<JS
           $("#{$pickid}").iconpicker({
                iconset: '{$this->iconset}',
                icon: '{$this->_default}',
                rows: '{$this->rows}',
                cols: '{$this->columns}',
                placement: '{$this->placement}'
            });
JS;
        $js[]=($this->removePrefix)?<<<JS
           $("#{$pickid}").on('change', function(e) {
                var icon=e.icon.replace('fa-','').replace('glyphicon-','');
                $('#$id').val(icon);
            });
JS
            :
            <<<JS
            $("#{$pickid}").on('change', function(e) {
                $('#$id').val('{$this->prefix}' + e.icon);
            });
JS;

        $view->registerJs(implode("\n",$js));
    }
}