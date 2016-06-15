<?php
$config = [
    'sourceLanguage' => 'en-US',
    // 将 log 组件 ID 加入引导让它始终载入  无论处理请求过程有没有访问到 log 组件
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Shanghai', //time zone affect the formatter datetime format
    'language' => 'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            // you will configure your module inside this file
            // or if need different configuration for frontend and backend you may
            // configure in needed configs
            // administrator's list
            'admins' => ['jsadmin', 'sa'],
            'enableFlashMessages' => false,
            //改变注册成功后的跳转页面
            'controllerMap' => [
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\models\User::AFTER_REGISTER => function ($e) {
                        Yii::$app->response->redirect(array('/user/security/login'))->send();
                        Yii::$app->end();
                    }
                ],
            ],
        ],
        //treemanager manager
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        //yii2-kartikgii
        //yii2-kartikgii
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'dynagrid'=> [
            'class'=>'\kartik\dynagrid\Module',
            // other module settings
            'dbSettings' => [
                'tableName' => 'populac_dynagrid',
            ],
            'dbSettingsDtl' => [
                'tableName' => 'populac_dynagrid_dtl',
            ],
        ],

        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],
            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
        ],

    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=populac_adv',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            //表前缀
            'tablePrefix' => 'populac_',
            /*'on afterOpen' => function($event) {
                $event->sender->createCommand("SET time_zone = 'UTC'")->execute();
            },*/
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',           //使用163邮箱
                'username' => 'tqsq2005@163.com',   //163用户名， 建议和 params.php 中的 adminEmail 一致
                'password' => 'owybvyotjrnxfvlu',   //163客户端授权密码
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig' => [
                'from' => ['tqsq2005@163.com' => 'Admin'],
                'charset' => 'UTF-8',
            ],
        ],
        //格式组件 'formatter' => ['class' => 'yii\i18n\Formatter'],
        //http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#$datetimeFormat-detail
        //http://www.yiichina.com/doc/guide/2.0/input-validation
        'formatter' => [
            //推荐在每个环境下安装PHP intl扩展以及相同的ICU库
            //安装PHP intl extension， 打开 php.ini 去掉 extension=php_intl.dll 前的注释
            'dateFormat' => 'php:Y.m.d',
            'datetimeFormat' => 'php:Y.m.d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'Asia/Shanghai',
            //'decimalSeparator' => ',',//小数的分隔符 default to .
            //'thousandSeparator' => ' ',//千位分隔符 default to ,
            //'currencyCode' => 'CNY',
            //'locale' => 'en-US', // if not set default to yii\base\Application::$language will be used.
        ],
        //RBAC
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        //setting
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@common/views/user'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                //修改jui的themes为cupertino
                'yii\jui\JuiAsset' => [
                    'css' => [
                        'themes/cupertino/jquery-ui.css',
                    ]
                ],
                // Styling-DataTables supports several styling solutions,
                // including Bootstrap, jQuery UI, Foundation.
                'nullref\datatable\DataTableAsset' => [
                    'styling' => \nullref\datatable\DataTableAsset::STYLING_JUI,
                ],
            ]
        ],
        'urlManager' => [
            'rules' => [
                'populac/<controller:\w+>-list' => 'populac/<controller>/index',
                'populac/<module:\w+>/<controller:\w+>-list' => 'populac/<module:\w+>/<controller>/index',
                'populac/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'populac/<controller>/<action>',
                'populac/<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'populac/<module>/<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'easyii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'easyii' => 'easyii.php',
                    ]
                ],
                'yii2tech-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'yii2tech-admin' => 'yii2tech-admin.php',
                    ]
                ],
            ],
        ],
    ],
];

//调试模式启用debug及gii
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        //default: public array $allowedIPs = ['127.0.0.1', '::1']
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
    ];

    $config['bootstrap'][] = 'gii';
    //$config['modules']['gii'] = 'yii\gii\Module';
    $config['modules']['gii'] = [
        //'class' => 'yii\gii\Module',
        'class' => 'yii\gii\Module',//yii2-kartikgii
        /*'generators' => [
            'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
        ],*/
        'generators' => [
            'sintret' => [
                'class' => 'sintret\gii\generators\crud\Generator',
            ],
            'sintretModel' => [
                'class' => 'sintret\gii\generators\model\Generator'
            ],
            'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'default' => '@common/components/gii/crud/default'
                ]
            ],
            'adminMainFrame' => [
                'class' => 'yii2tech\admin\gii\mainframe\Generator'
            ],
            'adminCrud' => [
                'class' => 'yii2tech\admin\gii\crud\Generator'
            ],
        ],
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
    ];
}

return $config;
