<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-18 上午10:58
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\helpers;

use Yii;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class Upload
{
    public static $UPLOADS_DIR = 'uploads';

    public static function file(UploadedFile $fileInstance, $dir = '', $namePostfix = true)
    {
        $fileName = Upload::getUploadPath($dir) . DIRECTORY_SEPARATOR . Upload::getFileName($fileInstance, $namePostfix);

        if(!$fileInstance->saveAs($fileName)){
            throw new HttpException(500, 'Cannot upload file "'.$fileName.'". Please check write permissions.');
        }
        return Upload::getLink($fileName);
    }

    static function getUploadPath($dir)
    {
        $uploadPath = Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.self::$UPLOADS_DIR.($dir ? DIRECTORY_SEPARATOR.$dir : '');
        if(!FileHelper::createDirectory($uploadPath)){
            throw new HttpException(500, 'Cannot create "'.$uploadPath.'". Please check write permissions.');
        }
        return $uploadPath;
    }

    static function getLink($fileName)
    {
        return str_replace('\\', '/', str_replace(Yii::getAlias('@webroot'), '', $fileName));
        //return str_replace('\\', '/', str_replace(Yii::getAlias('@webroot'), Yii::$app->homeUrl, $fileName));
    }

    static function getFileName($fileInstanse, $namePostfix = true)
    {
        $baseName = str_ireplace('.'.$fileInstanse->extension, '', $fileInstanse->name);
        $fileName =  StringHelper::truncate(Inflector::slug($baseName), 32, '');
        if($namePostfix || !$fileName) {
            $fileName .= ($fileName ? '-' : '') . substr(uniqid(md5(rand()), true), 0, 10);
        }
        $fileName .= '.' . $fileInstanse->extension;

        return $fileName;
    }
}