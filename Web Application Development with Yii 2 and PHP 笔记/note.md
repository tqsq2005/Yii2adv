Web Application Development with Yii 2 and PHP 笔记
========================
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

    $this->render($view, $params = [], $context = null);