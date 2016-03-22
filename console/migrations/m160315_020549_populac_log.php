<?php

use yii\db\Migration;

class m160315_020549_populac_log extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT="后台操作记录"';
        }

        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey() . ' COMMENT "自增ID"',
            'user_id' => $this->integer()->notNull() . ' COMMENT "操作用户ID"',
            'user_name'=>$this->string(30)->notNull() . ' COMMENT "操作用户名"',
            'user_ip'=>$this->string(30)->notNull() . ' COMMENT "操作用户IP"',
            'user_agent'=>$this->string(200)->notNull() . ' COMMENT "操作用户浏览器代理商"',
            'title'=>$this->string(80)->notNull() . ' COMMENT "记录描述"',
            'model'=>$this->string(30)->notNull() . ' COMMENT "操作模型（例：\common\models\Log）"',
            'controller'=>$this->string(30)->notNull() . ' COMMENT "操作模块（例：文章）"',
            'action'=>$this->string(30)->notNull() . ' COMMENT "操作类型（例：添加）"',
            'handle_id'=>$this->integer()->notNull() . ' COMMENT "操作对象对应表的ID"',
            'result'=>$this->text()->notNull() . ' COMMENT "操作结果"',
            'describe'=>$this->text()->notNull() . ' COMMENT "备注"',
            'created_at' => $this->integer()->notNull() . ' COMMENT "创建时间"',
            'updated_at' => $this->integer()->notNull() . ' COMMENT "修改时间"',
        ], $tableOptions);

        $this->addForeignKey('FK_POPULAC_LOG_1', '{{%log}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->createIndex('IX_POPULAC_LOG_1', '{{%log}}', 'user_name');
        $this->createIndex('IX_POPULAC_LOG_2', '{{%log}}', 'controller');
    }

    public function down()
    {
        $this->dropForeignKey('FK_POPULAC_LOG_1', '{{%log}}');
        $this->dropIndex('IX_POPULAC_LOG_1', '{{%log}}');
        $this->dropIndex('IX_POPULAC_LOG_2', '{{%log}}');
        $this->dropTable('{{%log}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
