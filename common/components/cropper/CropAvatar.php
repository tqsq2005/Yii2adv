<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-4 上午9:43
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\components\cropper;

use Yii;
use yii\helpers\FileHelper;

/**
 * Class CropAvatar : 图片处理类，支持旋转及翻转
 * @package common\components\cropper
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class CropAvatar {
    private $src;
    private $data;
    private $dst;
    private $type;
    private $extension;
    private $msg;
    private $_saveFileName; //保存的图片名
    public  $savaPath = '/uploads/user/avatar/' ; //注意 结尾一定要有反斜杠 '/'

    function __construct($src, $savePath, $data, $file) {
        $this -> setSrc($src);
        $this -> setSavePath($savePath);
        $this -> setData($data);
        $this -> setFile($file);
        $this -> checkFile($this->src, $this -> data);
        $this -> crop($this -> src, $this -> dst, $this -> data);
    }

    private function setSrc($src) {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
                $this -> src = $src;
                $this -> type = $type;
                $this -> extension = image_type_to_extension($type);
                $this -> setDst();
            } else {
                $this->savaPath = $src;
            }
        }
    }

    /**
     * (void) setSavePath : 设置保存路径
     * @param $savePath
     */
    private function setSavePath($savePath) {
        if (!empty($savePath)) {
            $this->savaPath = $savePath;
        }
    }

    private function setData($data) {
        if (!empty($data)) {
            $this -> data = json_decode(stripslashes($data));
        }
    }

    private function setFile($file) {
        $errorCode = $file['error'];

        if ($errorCode === UPLOAD_ERR_OK) {
            $type = exif_imagetype($file['tmp_name']);

            if ($type) {
                //$extension = image_type_to_extension($type);
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
                    $this -> src = $file['tmp_name'];
                    $this -> type = $type;
                    $this -> extension = $extension;
                    $this -> setDst();
                } else {
                    $this -> msg = '上传图片格式不正确，请上传格式为 JPG, PNG, GIF 的图片文件。';
                }
            } else {
                $this -> msg = '上传的文件不是图片类型，请上传图片文件。';
            }
        } else {
            $this -> msg = $this -> codeToMessage($errorCode);
        }
    }

    private function setDst() {
        //检查文件夹是否存在
        $savePath = Yii::getAlias('@webroot'.$this->savaPath);
        if(!is_dir($savePath))
        {
            if(!FileHelper::createDirectory($savePath))
            {
                throw new \Exception("上传目录无法创建！");
            }
        }
        $this->_saveFileName = date('YmdHis') . rand(1 , 10000) .'.' . $this->extension;
        $this -> dst = $savePath . $this->_saveFileName;
    }

    private function checkFile($src, $data) {
        //处理垂直翻转
        if( $data->scaleX == -1 ) {
            $this->trun_y($src);
        }
        //处理水平翻转
        if( $data->scaleY == -1 ) {
            $this->trun_x($src);
        }
    }

    //处理垂直翻转
    private function trun_x($src){
        switch ($this -> type) {
            case IMAGETYPE_GIF:
                $src_img = imagecreatefromgif($src);
                break;

            case IMAGETYPE_JPEG:
                $src_img = imagecreatefromjpeg($src);
                break;

            case IMAGETYPE_PNG:
                $src_img = imagecreatefrompng($src);
                break;
        }

        $width = imagesx($src_img);
        $height = imagesy($src_img);

        //创建一个新的图片资源，用来保存沿Y轴翻转后的图片
        $new = imagecreatetruecolor($width, $height);
        //沿y轴翻转就是将原图从右向左按一个像素宽度向新资源中逐个复制
        for($x=0 ;$x<$height; $x++){
            //逐条复制图片本身高度，1个像素宽度的图片到薪资源中
            imagecopy($new, $src_img,0, $height-$x-1, 0, $x, $width,1);
        }

        //保存翻转后的图片
        imagejpeg($new,$src);
        imagedestroy($src_img);
        imagedestroy($new);
    }

    //处理水平翻转
    private function trun_y($src){
        switch ($this -> type) {
            case IMAGETYPE_GIF:
                $src_img = imagecreatefromgif($src);
                break;

            case IMAGETYPE_JPEG:
                $src_img = imagecreatefromjpeg($src);
                break;

            case IMAGETYPE_PNG:
                $src_img = imagecreatefrompng($src);
                break;
        }

        $width = imagesx($src_img);
        $height = imagesy($src_img);

        //创建一个新的图片资源，用来保存沿Y轴翻转后的图片
        $new = imagecreatetruecolor($width, $height);
        //沿y轴翻转就是将原图从右向左按一个像素宽度向新资源中逐个复制
        for($y=0 ;$y<$width; $y++){
            //逐条复制图片本身高度，1个像素宽度的图片到薪资源中
            imagecopy($new, $src_img, $width-$y-1, 0, $y, 0, 1, $height);
        }

        //保存翻转后的图片
        imagejpeg($new,$src);
        imagedestroy($src_img);
        imagedestroy($new);
    }

    private function crop($src, $dst, $data) {
        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this -> type) {
                case IMAGETYPE_GIF:
                    $src_img = imagecreatefromgif($src);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = imagecreatefromjpeg($src);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = imagecreatefrompng($src);
                    break;
            }

            if (!$src_img) {
                $this -> msg = "Failed to read the image file";
                return;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data -> rotate;

            // Rotate the source image
            if (is_numeric($degrees) && $degrees != 0) {
                // PHP's degrees is opposite to CSS's degrees
                $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

                imagedestroy($src_img);
                $src_img = $new_img;

                $deg = abs($degrees) % 180;
                $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                // Fix rotated image miss 1px issue when degrees < 0
                $src_img_w -= 1;
                $src_img_h -= 1;
            }

            $tmp_img_w = $data -> width;
            $tmp_img_h = $data -> height;
            $dst_img_w = 160;
            $dst_img_h = 160;

            $src_x = $data -> x;
            $src_y = $data -> y;

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } else if ($src_x <= 0) {
                $dst_x = -$src_x;
                $src_x = 0;
                $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
            } else if ($src_x <= $src_img_w) {
                $dst_x = 0;
                $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } else if ($src_y <= 0) {
                $dst_y = -$src_y;
                $src_y = 0;
                $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
            } else if ($src_y <= $src_img_h) {
                $dst_y = 0;
                $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
            }

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

            if ($result) {
                if (!imagepng($dst_img, $dst)) {
                    $this -> msg = "Failed to save the cropped image file";
                }
            } else {
                $this -> msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    private function codeToMessage($code) {
        $errors = array(
            UPLOAD_ERR_INI_SIZE =>'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE =>'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL =>'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE =>'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR =>'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE =>'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION =>'File upload stopped by extension',
        );

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return 'Unknown upload error';
    }

    public function getResult() {
        return !empty($this -> data) ? Yii::$app->homeUrl.$this->savaPath.$this->_saveFileName : $this -> src;
    }

    public function getMsg() {
        return $this -> msg;
    }

    public  function getSaveFileName() {
        return $this->_saveFileName;
    }
}