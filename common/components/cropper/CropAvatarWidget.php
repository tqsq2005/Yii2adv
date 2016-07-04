<?php

namespace common\components\cropper;

use Yii;
use yii\base\Widget;

/**
 * 图片裁剪上传
 * 在你想要出现“选择文件”的地方，放下如下代码：
 * <?= CropAvatarWidget::widget() ?>
 * @package common\components\cropper
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class CropAvatarWidget extends Widget
{
	/** @var string $imgSrc 图片地址 */
	public $imgSrc 		= '';
	/** @var string $imgTitle 图片标题 */
	public $imgTitle 	= '修改头像';
	/** @var string $imgClass 图片样式*/
	public $imgClass 	= 'profile-user-img img-responsive img-circle';
	/** @var string $imgSavePath 图片保存路径 */
	public $imgSavePath	= '/uploads/user/avatar/';
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		return $this->render('_crop_avatar', [
			'imgSrc' 		=> $this->imgSrc,
			'imgTitle'		=> $this->imgTitle,
			'imgClass'		=> $this->imgClass,
			'imgSavePath'	=> $this->imgSavePath,
		]);
	}

	/**
	 * Registers Webuploader assets
	 */
	protected function registerClientScript()
	{
		$view = $this->getView();
		CropAvatarAsset::register($view);
	}
}
