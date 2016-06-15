<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'overwrite' => true,
            'modelNamespace' => 'app\\modules\\crud\\models',
            'crudTidyOutput' => true,
        ]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'modules' => [
        //php yii audit/cleanup --age=0 删除所有数据， 如果设置age=7则删除一周以外的数据
        /*php yii audit/cleanup [options]
        options:
        --entry - True to cleanup the AuditEntry.
        --panels - Comma separated list of panels to cleanup.
        --age - Max age in days to cleanup, if null then the panel settings are used.
         */
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            // the layout that should be applied for views within this module
            'layout' => '@backend/views/layouts/main',
            // Name of the component to use for database access
            'db' => 'db',
            // List of actions to track. '*' is allowed as the last character to use as wildcard
            'trackActions' => ['*'],
            // Actions to ignore. '*' is allowed as the last character to use as wildcard (eg 'debug/*')
            'ignoreActions' => ['audit/*', 'debug/*', ],
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
    ],
    'params' => $params,
];
