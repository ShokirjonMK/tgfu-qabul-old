<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_year_type}}`.
 */
class m240609_063726_create_edu_year_type_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'edu_year_type';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('edu_year_type');
        }

        $this->createTable('{{%edu_year_type}}', [
            'id' => $this->primaryKey(),

            'edu_year_id' => $this->integer()->notNull(),
            'edu_type_id' => $this->integer()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_edu_year_type_table_edu_year_table', 'edu_year_type', 'edu_year_id', 'edu_year', 'id');
        $this->addForeignKey('ik_edu_year_type_table_edu_type_table', 'edu_year_type', 'edu_type_id', 'edu_type', 'id');

        $this->insert('{{%edu_year_type}}', [
            'edu_year_id' => 1,
            'edu_type_id' => 1,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%edu_year_type}}');
    }
}
