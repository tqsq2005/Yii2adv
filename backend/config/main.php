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
            'layout' => '@app/views/layouts/main',
            /*'layout' => 'left-menu', // it can be '@path/to/your/layout'.
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\User',
                    'idField' => 'user_id'
                ],
                'other' => [
                    'class' => 'path\to\OtherController', // add another controller
                ],
            ],
            'menus' => [
                'assignment' => [
                    'label' => 'Grand Access' // change label
                ],
                'route' => null, // disable menu route
            ]*/
        ],
        //yii2-user
        'user' => [
            // following line will restrict access to profile, recovery, registration and settings controllers from backend
            'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
        //setting
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'en'
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
        ],
        //adminlte 主题
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],*/
    ],
    'params' => $params,
    /*'on afterAction' => function($event) {
        var_dump($event);//yii2\base\ActionEvent
        echo "<hr>";
    },*/
    //mdmsoft/yii2-admin
    /*'as access' => [
        'class' => 'mdm\admin\classes\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'some-controller/some-action',
            'debug/*',
            'gii/*',
            'user/*',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],*/
];
