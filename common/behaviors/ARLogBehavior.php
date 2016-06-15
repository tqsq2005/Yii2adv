<?php
/**
 * ARLogBehavior.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-19
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\behaviors;

use bedezign\yii2\audit\Audit;
use bedezign\yii2\audit\AuditTrailBehavior;
use bedezign\yii2\audit\models\AuditTrail;
use yii\helpers\Json;

class ARLogBehavior extends AuditTrailBehavior
{
    /**
     * @param $action
     * @throws \yii\db\Exception
     */
    public function audit($action)
    {
        //前台提交的不记录
        if(\Yii::$app->homeUrl != '/admin') {
            return;
        }
        // Not active? get out of here
        if (!$this->active) {
            return;
        }
        // Lets check if the whole class should be ignored
        if (sizeof($this->ignoredClasses) > 0 && array_search(get_class($this->owner), $this->ignoredClasses) !== false) {
            return;
        }
        // If this is a delete then just write one row and get out of here
        if ($action == 'DELETE') {
            $this->saveAuditTrailDelete();
            return;
        }
        // Now lets actually write the attributes
        $this->auditAttributes($action);
    }
    /**
     * @inheritDoc : Save the audit trails for a delete action
     */
    protected function saveAuditTrailDelete()
    {
        $audit = Audit::getInstance();
        $audit->getDb()->createCommand()->insert(AuditTrail::tableName(), [
            'action' => 'DELETE',
            'entry_id' => $this->getAuditEntryId(),
            'user_id' => $this->getUserId(),
            'model' => $this->owner->className(),
            'model_id' => $this->getNormalizedPk(),
            'created' => date($this->dateFormat),
            'old_value' => \yii\helpers\Json::encode($this->getOldAttributes()),
        ])->execute();
    }

    /**
     * @inheritDoc
     */
    protected function saveAuditTrail($action, $newAttributes, $oldAttributes, $entry_id, $user_id, $model, $model_id, $created)
    {
        // Build a list of fields to log
        $rows = array();
        $fields = array();//字段
        $newVal = array();//新值
        $oldVal = array();//旧值
        foreach ($newAttributes as $field => $new) {
            $old = isset($oldAttributes[$field]) ? $oldAttributes[$field] : '';
            // If they are not the same lets write an audit log
            if ($new != $old) {
                $fields[] = $field;
                $newVal[] = $new;
                $oldVal[] = $old;
                $rows[] = [$entry_id, $user_id, $old, $new, $action, $model, $model_id, $field, $created];
            }
        }
        //保存一条单独的记录
        $rows[] = [$entry_id, $user_id, Json::encode($oldVal), Json::encode($newVal), $action, $model, $model_id, Json::encode($fields), $created];
        // Record the field changes with a batch insert
        if (!empty($rows)) {
            $columns = ['entry_id', 'user_id', 'old_value', 'new_value', 'action', 'model', 'model_id', 'field', 'created'];
            $audit = Audit::getInstance();
            $audit->getDb()->createCommand()->batchInsert(AuditTrail::tableName(), $columns, $rows)->execute();
        }
    }

}