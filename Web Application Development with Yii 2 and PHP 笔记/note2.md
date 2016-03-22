Web Application Development with Yii 2 and PHP 笔记2
==================================================
1. AssetManager 组件 yii\web\AssetManager
---------------------------------------
一般的asset

    class AppAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [
            'css/site.css',
        ];
        public $cssOptions = [
            'media' => 'print,aural,tty',
        ];
        public $js = [
            'js/main.js',
        ];        
        public $jsOptions = [
            'position' => View::POS_HEAD,
        ];
        public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'yii\bootstrap\BootstrapPluginAsset',
            'common\assets\PopulacAsset',
        ];
    }

    
> 需要指出的是 `AssetBundle` 类中的三个属性 `$sourcePath`、 `$basePath` 及 `$baseUrl` 如果同时存在的话，发布的时候往往只有 `$sourcePath` 起作用，它的优先权最大，因为`yii\web\AssetManager` 的 `publish($path, $options = [])`方法中的`path`就是`$sourcePath` 。 `$basePath` 及 `$baseUrl` 只有资源`js及css等文件`放在`@web`的时候不需要指定 `$sourcePath` 时再用比较好！

如果需要自行发布资源，调用以下代码

    list($dir, $url) = Yii::$app->assetManager->publish($path);
    
- 其中`$path`是实际文件或文件夹路径，或者可以通过`Yii::getAlias()`访问到的`aliases`
- `yii\web\AssetManager` 的 `publish($path, $options = [])`方法：
    + 如果 `$path` 是 `file` 则会通过检查该文件的`修改时间`来判断是否需要`发布`
    + 如果 `$path` 是 `directory`:
        - 如果 `$forceCopy` 设置为`true`则该`directory`下的所有`文件及子目录`都会直接`发布`
        - 如果 `$forceCopy` 设置为`false`则会先检查`目标directory`是否存在来决定是否需要`发布`
        - `$forceCopy` 默认设置为 `false` , `开发阶段` 可以设置为 `true`， `正式环境`下必须为`false`，因为设置为`true`很影响性能

    + 默认情况下 `$path` 无论是 `file` 还是 `directory` 如果第一个字符是 `.` 则都不发布
- `$dir` 及 `$url` 分别是 `$path` 发布后保存的 `absolute path` 及 `web absolute url`