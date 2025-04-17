<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_year_form}}`.
 */
class m240609_063735_create_edu_year_form_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'edu_year_form';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('edu_year_form');
        }

        $this->createTable('{{%edu_year_form}}', [
            'id' => $this->primaryKey(),

            'edu_year_id' => $this->integer()->notNull(),
            'edu_form_id' => $this->integer()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_edu_year_form_table_edu_year_table', 'edu_year_form', 'edu_year_id', 'edu_year', 'id');
        $this->addForeignKey('ik_edu_year_form_table_edu_form_table', 'edu_year_form', 'edu_form_id', 'edu_form', 'id');

        $this->insert('{{%edu_year_form}}', [
            'edu_year_id' => 1,
            'edu_form_id' => 1,
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
        $this->dropTable('{{%edu_year_form}}');
    }
}
