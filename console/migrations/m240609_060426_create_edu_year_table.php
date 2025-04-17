<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_year}}`.
 */
class m240609_060426_create_edu_year_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'edu_year';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('edu_year');
        }

        $this->createTable('{{%edu_year}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->insert('{{%edu_year}}', [
            'name' => '2024-2025',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%edu_year}}', [
            'name' => '2025-2026',
            'status' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%edu_year}}', [
            'name' => '2026-2027',
            'status' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%edu_year}}');
    }
}
