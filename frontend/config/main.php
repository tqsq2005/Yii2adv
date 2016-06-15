<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'populac'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        //yii2-user
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
        ],
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
                'name'     => '_frontendIdentity',
                'path'     => '/',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
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
        //主题
        /*'view' => [
            'theme' => [
                'class' => 'yii\base\Theme',
                'basePath' => 'themes/metro',
                'baseUrl' => 'themes/metro',
                'pathMap' => [
                    '@app/views' => 'themes/metro',
                ],
            ],
        ],*/
        'view' =>array(
            /*'theme' => array(
                'pathMap' => array('@app/views' => '@webroot/themes/earth2'),
                'baseUrl'   => '@web/themes/earth2'
            ),
            'theme' => array(
                'pathMap' => array('@app/views' => '@webroot/themes/earth2'),
                'baseUrl'   => '@web/themes/earth2'
            )*/
            /*'theme' => array(
                'pathMap' => array('@app/views' => '@webroot/themes/metro'),
                'baseUrl'   => '@web/themes/metro'
            )*/
            /*'theme' => array(
                'pathMap' => array('@app/views' => '@webroot/themes/material-default'),
                'baseUrl'   => '@web/themes/material-default'
            )*/

        ),
    ],
    'params' => $params,
];
