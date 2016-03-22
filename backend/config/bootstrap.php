<?php
Yii::$container->set(\common\models\RequestLog::className(), [
    //例外的规则
    'excludeRules' => [
        function () {
            list ($route, $params) = Yii::$app->getRequest()->resolve();
            return $route === 'debug/default/toolbar';
        }
    ]
]);