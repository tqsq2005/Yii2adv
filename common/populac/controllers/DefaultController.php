<?php

namespace common\populac\controllers;

use common\populac\models\Preferences;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Default controller for the `populac` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['modules/index']);
    }

    /**
     * (void) actionLogRetrieve :
     */
    public function actionLogRetrieve()
    {
        /** @var string $model eg:'common\models\Marry' */
        $model  = Yii::$app->request->post('model');
        /** @var string $action eg:delete create update */
        $action = Yii::$app->request->post('action');
        /** @var array $pkey $model primaryKey */
        $pkey   = Yii::$app->request->post('pkey');
        /** @var array $field $model field */
        $field  = Yii::$app->request->post('field');
        /** @var array $value $model value */
        $value  = Yii::$app->request->post('value');
        /** @var array $exceptField 不需要恢复的字段*/
        $exceptField = ['created_at', 'updated_at', 'created_by', 'updated_by'];

        $tranc          = Yii::$app->db->beginTransaction();
        /** @var \yii\db\ActiveRecord $retrieveModel */
        $retrieveModel  = new $model;
        try{
            $data = $retrieveModel->findOne($pkey) ? $retrieveModel->findOne($pkey) : $retrieveModel;
            if( strtolower($action) == 'delete' ) {
                foreach($value as $attr => $val) {
                    if( in_array($attr, $exceptField) )
                        continue;
                    $data->$attr = $val;
                }
            } else {
                foreach($field as $i => $attr) {
                    if( in_array($attr, $exceptField) )
                        continue;
                    $data->$attr = $value[$i];
                }
            }
            $data->save(false);
            $tranc->commit();
        }catch(Exception $e) {
            $tranc->rollBack();
            throw $e;
        }
        return 'retrieve success';
    }

    /**
     * (string) actionHistory : 删除的历史数据
     * @param string $pid personal_id
     * @return string
     */
    public function actionHistory( $pid )
    {
        return $this->render('@bedezign/yii2/audit/views/_audit_trails', [
            // model to display audit trais for, must have a getAuditTrails() method
            'query' => \bedezign\yii2\audit\models\AuditTrail::find()->andFilterWhere(['like', 'old_value', $pid]),
            // params for the AuditTrailSearch::search() (optional)
            'params' => [
                'AuditTrailSearch' => [
                    // can either be a field or an array of fields
                    // in this case we only want to show trails for the "status" field
                    //'field' => 'status',
                ]
            ],
            // which columns to show
            'columns' => ['user_id', 'entry_id', 'action', 'old_value', 'created'],
            // set to false to hide filter
            'filter' => false,
        ]);
    }
}
