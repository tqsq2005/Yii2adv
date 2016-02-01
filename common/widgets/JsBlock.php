<?php
/**
  * JsBlock.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 15-12-30
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2015
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace common\widgets;

use yii\web\View;
use yii\widgets\Block;

class JsBlock extends Block {
    /**
     * @var null
     */
    public $key = null;
    /**
     * @var int
     */
    public $pos = View::POS_END;
    /**
     * (void) run : Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     * eg:
     * <?php \year\widgets\JsBlock::begin() ?>
     *  <script >
     *      $(function(){
     *          jQuery(".company_introduce").slide({mainCell:".bd ul",effect:"left",autoPlay:true,mouseOverStop:true});
     *      });
     *  </script>
     * <?php \year\widgets\JsBlock::end()?>
     * @throws \Exception
     */
    public function run()
    {
        $block = ob_get_clean();
        if ($this->renderInPlace) {
            throw new \Exception("not implemented yet ! ");
            // echo $block;
        }
        $block = trim($block) ;
        /*
        $jsBlockPattern  = '|^<script[^>]*>(.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block)){
            $block =  preg_replace ( $jsBlockPattern , '${1}'  , $block );
        }
        //Thanks to yiqing
        //http://www.yiiframework.com/wiki/752/embedded-javascript-block-in-your-view-with-ide-checking-or-intellisense/
        */
        $jsBlockPattern  = '|^<script[^>]*>(?P<block_content>.+?)</script>$|is';
        if(preg_match($jsBlockPattern,$block,$matches)){
            $block =  $matches['block_content'];
        }

        $this->view->registerJs($block, $this->pos,$this->key) ;
    }
}