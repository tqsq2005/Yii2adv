<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "NewsController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class NewsController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\models\News';
}
