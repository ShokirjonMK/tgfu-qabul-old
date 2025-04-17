<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%flayer}}`.
 */
class m240709_111913_create_flayer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $tableName = Yii::$app->db->tablePrefix . 'flayer';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('flayer');
        }

        $this->createTable('{{%flayer}}', [
            'id' => $this->primaryKey(),
            'count' => $this->integer()->defaultValue(0),
            'ip' => $this->string()->null(),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%flayer}}');
    }
}
