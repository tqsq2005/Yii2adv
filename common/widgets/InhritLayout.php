<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-5 上午10:33
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\widgets;

use yii\base\InvalidConfigException;

use yii\base\Widget;

class InhritLayout extends Widget
{
    public $viewFile;
    public $params = [];
    public $blocks = [];
    public function init()
    {
        if ($this->viewFile === null)
        {
            throw new InvalidConfigException('InhritLayout::viewFile must be set.');
        }
        ob_start();
        ob_implicit_flush(false);
    }
    public function run()
    {
        $params = $this->params;
        if (! isset($params['content']))
        {
            $params['content'] = ob_get_clean();
        }

        if (count($this->blocks) > 0)
        {
            foreach ($this->blocks as $id)
            {
                if (in_array($id, $this->view->blocks))
                {
                    $params[$id] = $this->view->blocks[$id];
                    unset($this->view->blocks[$id]);
                }
            }
        }
        else
        {
            foreach ($this->view->blocks as $id => $block)
            {
                $params[$id] = $block;
                unset($this->view->blocks[$id]);
            }
        }

        echo $this->view->renderFile($this->viewFile, $params);
    }
}