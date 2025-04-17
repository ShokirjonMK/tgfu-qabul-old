<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%direction}}`.
 */
class m240609_074833_create_direction_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'direction';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('direction');
        }

        $this->createTable('{{%direction}}', [
            'id' => $this->primaryKey(),

            'name_uz' => $this->string(255)->notNull(),
            'name_ru' => $this->string(255)->notNull(),
            'name_en' => $this->string(255)->notNull(),

            'edu_year_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),

            'edu_year_type_id' => $this->integer()->notNull(),
            'edu_year_form_id' => $this->integer()->notNull(),

            'edu_form_id' => $this->integer()->null(),
            'edu_type_id' => $this->integer()->null(),

            'contract' => $this->integer()->null(),

            'code' => $this->string(255)->notNull(),

            'course_json' => $this->string(255)->null(),

            'oferta' => $this->tinyInteger(1)->defaultValue(0),

            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_direction_table_edu_year_table', 'direction', 'edu_year_id', 'edu_year', 'id');
        $this->addForeignKey('ik_direction_table_language_table', 'direction', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_direction_table_edu_year_type_table', 'direction', 'edu_year_type_id', 'edu_year_type', 'id');
        $this->addForeignKey('ik_direction_table_edu_year_form_table', 'direction', 'edu_year_form_id', 'edu_year_form', 'id');
        $this->addForeignKey('ik_direction_table_edu_form_table', 'direction', 'edu_form_id', 'edu_form', 'id');
        $this->addForeignKey('ik_direction_table_edu_type_table', 'direction', 'edu_type_id', 'edu_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%direction}}');
    }
}
