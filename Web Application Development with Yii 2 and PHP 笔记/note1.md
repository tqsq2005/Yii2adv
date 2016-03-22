Web Application Development with Yii 2 and PHP 笔记1
==================================================
1. p82 log组件
------------
php:
    
    'log' => [
        'traceLevel' => 3,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ]
        ],
    ]

等价于：

    $log = new yii\log\Logger;
    $fileTarget = new yii\log\FileTarget;
    $fileTarget -> levels = ['error', 'warning'];
    $log->traceLevel = 3;
    $log->targets = [$fileTarget];
    Yii::$app->log = $log;

Yii::$app->log比较少用,比较常用的是：

    Yii::info();
    Yii::error();
    Yii::warning();
    Yii::trace();
    
2. 要查看内建的组件，可以查看 yii\base\Application 的coreComponents()方法的源码
------------------------------------------------------------
    
    /**
     * Returns the configuration of core application components.
     * @see set()
     */
    public function coreComponents()
    {
        return [
            'log' => ['class' => 'yii\log\Dispatcher'],
            'view' => ['class' => 'yii\web\View'],
            'formatter' => ['class' => 'yii\i18n\Formatter'],
            'i18n' => ['class' => 'yii\i18n\I18N'],
            'mailer' => ['class' => 'yii\swiftmailer\Mailer'],
            'urlManager' => ['class' => 'yii\web\UrlManager'],
            'assetManager' => ['class' => 'yii\web\AssetManager'],
            'security' => ['class' => 'yii\base\Security'],
        ];
    }
    
2.1 yii\console\Application 的 coreComponents():

    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'request' => ['class' => 'yii\web\Request'],
            'response' => ['class' => 'yii\web\Response'],
            'session' => ['class' => 'yii\web\Session'],
            'user' => ['class' => 'yii\web\User'],
            'errorHandler' => ['class' => 'yii\web\ErrorHandler'],
        ]);
    }
    
2.2 yii\web\Application 的 coreComponents():

    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'request' => ['class' => 'yii\console\Request'],
            'response' => ['class' => 'yii\console\Response'],
            'errorHandler' => ['class' => 'yii\console\ErrorHandler'],
        ]);
    }
    
3.View组件
--------
3.1 View组件是内建组件，所以允许你这样调用

    Yii::$app->view->render($view, params = [], $context = null);
    
3.2 Controller类有一个类似的方法，但是会多渲染layout文件

    $this->render($view, $params = []);
    
---

4.'@web' 等价于 Yii::$app->getHomeUrl();

>以下都没有 尾斜杠 '/'

 1.  '@common' => 'E:\\xampp\\htdocs\\Yii2Adv\\common'
 2.  '@frontend' => 'E:\\xampp\\htdocs\\Yii2Adv/frontend'
 3.  '@backend' => 'E:\\xampp\\htdocs\\Yii2Adv/backend'
 4.  '@console' => 'E:\\xampp\\htdocs\\Yii2Adv/console'
 5.  '@app' => 'E:\\xampp\\htdocs\\Yii2Adv\\backend'
 6.  '@vendor' => 'E:\\xampp\\htdocs\\Yii2Adv/vendor'
 7.  '@bower' => 'E:\\xampp\\htdocs\\Yii2Adv/vendor\\bower'
 8.  '@npm' => 'E:\\xampp\\htdocs\\Yii2Adv/vendor\\npm'
 9.  '@runtime' => 'E:\\xampp\\htdocs\\Yii2Adv\\backend\\runtime'
 10. '@webroot' => 'E:/xampp/htdocs/Yii2Adv/backend/web'
 11. '@web' => '/admin'
 
 ---
 5.视图名可以依据以下规则到对应的视图文件路径
 
- 视图名可省略文件扩展名，这种情况下使用 .php 作为扩展， 视图名 about 对应到 about.php 文件名；
- **视图名以双斜杠 // 开头，对应的视图文件路径为 @app/views/ViewName， 也就是说视图文件在 yii\base\Application::viewPath 路径下找， 
例如 //site/about 对应到 @app/views/site/about.php。**
- 视图名以单斜杠/开始，视图文件路径以当前使用模块 的yii\base\Module::viewPath开始， 如果不存在模块，使用@app/views/ViewName开始，
例如，如果当前模块为user， /user/create 对应成 @app/modules/user/views/user/create.php, 如果不在模块中，/user/create对应
@app/views/user/create.php。
- 如果 yii\base\View::context 渲染视图 并且上下文实现了 yii\base\ViewContextInterface, 视图文件路径由上下文的 
yii\base\ViewContextInterface::getViewPath() 开始， 这种主要用在控制器和小部件中渲染视图，例如 如果上下文为控制器SiteController，
site/about 对应到 @app/views/site/about.php。
- 如果视图渲染另一个视图，包含另一个视图文件的目录以当前视图的文件路径开始， 例如被视图@app/views/post/index.php 渲染的 item 
对应到 @app/views/post/item。

 
根据以上规则，在控制器中 app\controllers\PostController 调用 $this->render('view')， 实际上渲染 @app/views/post/view.php 视图文件，
当在该视图文件中调用 $this->render('_overview') 会渲染 @app/views/post/_overview.php 视图文件。

---
6.视图文件渲染顺序

- beginPage(): 该方法应在布局的开始处调用， 它触发表明页面开始的 yii\base\View::EVENT_BEGIN_PAGE 事件。
- head(): 该方法应在HTML页面的`<head>`标签中调用， 它生成一个占位符，在页面渲染结束时会被注册的头部HTML代码 View::POS_HEAD （如，link标签, meta标签）替换。
- beginBody(): 该方法应在`<body>`标签的开始处调用， 它触发 yii\web\View::EVENT_BEGIN_BODY 事件并生成一个占位符， 
会被注册的HTML代码 View::POS_BEGIN （如JavaScript）在页面主体开始处替换。
- endBody(): 该方法应在`<body>`标签的结尾处调用， 它触发 yii\web\View::EVENT_END_BODY 事件并生成一个占位符， 
会被注册的HTML代码 View::POS_END View::POS_READY View::POS_LOAD（如JavaScript）在页面主体结尾处替换。
- endPage(): 该方法应在布局的结尾处调用， 它触发表明页面结尾的 yii\base\View::EVENT_END_PAGE 事件。
 
---
7.response组件输出JSON格式数据，以Preferences为例 `$data = array_map(function($model) { return $model->attributes; }, $models);`有没有这一句都一样

    public function actionJson($classmark = '')
    {
        if($classmark) {
            $models = Preferences::find()->andFilterWhere(['classmark' => $classmark])->all();
            $data = array_map(function($model) { return $model->attributes; }, $models);

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $data;

            $response->send(); //等同于 return $response;
        }

        return '';
    }
    