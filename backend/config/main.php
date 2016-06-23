<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'admin'],
    'modules' => [
        'filemanager' => [
            'class' => 'pendalf89\filemanager\Module',
            // Upload routes
            'routes' => [
                // Base absolute path to web directory
                'baseUrl' => '',
                // Base web directory url
                'basePath' => '@backend/web',
                // Path for uploaded files in web directory
                'uploadPath' => 'uploads',
            ],
            // Thumbnails info
            'thumbs' => [
                'small' => [
                    'name' => '小图',
                    'size' => [100, 100],
                ],
                'medium' => [
                    'name' => '中图',
                    'size' => [300, 200],
                ],
                'large' => [
                    'name' => '大图',
                    'size' => [500, 400],
                ],
            ],
        ],
        //mdmsoft/yii2-admin
        'admin' => [
            'class' => 'mdm\admin\Module',
            //'layout' => '@app/views/layouts/main',
            //'layout' => 'left-menu', // it can be '@path/to/your/layout'.
            //'layout' => 'left-menu',//left-menu, right-menu, top-menu
            'mainLayout' => '@app/views/layouts/main.php',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => \dektrium\user\models\User::className(),
                    'idField' => 'id'
                ],
                /*'other' => [
                    'class' => 'path\to\OtherController', // add another controller
                ],*/
            ],
            'menus' => [
                'assignment' => [
                    'label' => '用户权限' // change label
                ],
                //'route' => null, // disable menu route
            ]
        ],
        //dektrium/yii2-user
        'user' => [
            // following line will restrict access to profile, recovery, registration and settings controllers from backend
            'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
        //dektrium/yii2-rbac
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
        ],
        //setting
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'en'
        ],
        //Yii2-audit
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            // the layout that should be applied for views within this module
            'layout' => '@backend/views/layouts/main',
            // Name of the component to use for database access
            'db' => 'db',
            // List of actions to track. '*' is allowed as the last character to use as wildcard
            'trackActions' => ['*'],
            // Actions to ignore. '*' is allowed as the last character to use as wildcard (eg 'debug/*')
            'ignoreActions' => ['audit/*', 'debug/*', 'site/qrcode'],
            // Maximum age (in days) of the audit entries before they are truncated
            'maxAge' => '9999',
            // IP address or list of IP addresses with access to the viewer, null for everyone (if the IP matches)
            'accessIps' => ['127.0.0.1', '192.168.*'],
            // Role or list of roles with access to the viewer, null for everyone (if the user matches)
            'accessRoles' => [],
            // User ID or list of user IDs with access to the viewer, null for everyone (if the role matches)
            //'accessUsers' => [1, 2],
            // Compress extra data generated or just keep in text? For people who don't like binary data in the DB
            //'compressData' => true,
            // The callback to use to convert a user id into an identifier (username, email, ...). Can also be html.
            //'userIdentifierCallback' => ['app\models\User', 'userIdentifierCallback'],
            // If the value is a simple string, it is the identifier of an internal to activate (with default settings)
            // If the entry is a '<key>' => '<string>|<array>' it is a new panel. It can optionally override a core panel or add a new one.
//            'panels' => [
//                'audit/request',
//                'audit/error',
//                'audit/trail',
//                'app/views' => [
//                    'class' => 'app\panels\ViewsPanel',
//                    // ...
//                ],
//            ],
//            'panelsMerge' => [
//                // ... merge data (see below)
//            ]
        ],
        //preferences
        'sysini' => [
            'class' => 'common\modules\preferences\Preferences',
        ],
        //database
        'database' => [
            'class' => \backend\modules\database\Module::className(),
        ],
        //wechat
        /*'wechat' => [ // 指定微信模块
            'class' => \callmez\wechat\Module::className(),// 'callmez\wechat\Module',
            'adminId' => 4 // 填写管理员ID, 该设置的用户将会拥有wechat最高权限, 如多个请填写数组 [1, 2]
        ],*/
        //request-log
        /*'requestlog' => [
            'class' => \Zelenin\yii\modules\RequestLog\behaviors\RequestLogBehavior::className(),
            'usernameAttribute' => 'email',
        ],*/
        //populac module
        'populac' => [
            'class' => 'common\populac\Populac',
        ],
    ],
    'components' => [
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],*/
        /* 高级模板下，如果FRONTEND 和 backend 在同一个domain：Yii2-user 的session配置 */
        'user' => [
            'identityCookie' => [
                'name'     => '_backendIdentity',
                'path'     => '/admin',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'BACKENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/admin',
            ],
        ],
        /* --END-- */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        //adminlte 主题
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],*/
        'request' => [
            'parsers' => [ // 因为模块中有使用angular.js  所以该设置是为正常解析angular提交post数据
                'application/json' => 'yii\web\JsonParser',
          ],
        ],
    ],
    'params' => $params,
    /*'on afterAction' => function($event) {
        var_dump($event);//yii2\base\ActionEvent
        echo "<hr>";
    },*/
    //mdmsoft/yii2-admin
    'as access' => [
        'class' => \mdm\admin\components\AccessControl::className(),
        'allowActions' => [
            'site/qrcode',
            //'admin/*',
            //'some-controller/some-action',
            'debug/*',
            'gii/*',
            //'user/*',
            //'audit/*'

            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
