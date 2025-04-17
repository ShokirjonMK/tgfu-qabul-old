<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%constalting}}`.
 */
class m240622_120111_create_constalting_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'constalting';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('constalting');
        }

        $this->createTable('{{%constalting}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'h_r' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->insert('{{%constalting}}', [
            'name' => 'IKboljon',
            'h_r' => 'IKboljon',
            'code' => 'IKboljon',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%constalting}}');
    }
}
