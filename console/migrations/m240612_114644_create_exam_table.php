<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam}}`.
 */
class m240612_114644_create_exam_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'exam';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('exam');
        }

        $this->createTable('{{%exam}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'student_id' => $this->integer()->notNull(),
            'direction_id' => $this->integer()->notNull(),

            'language_id' => $this->integer()->null(),
            'edu_year_form_id' => $this->integer()->null(),
            'edu_year_type_id' => $this->integer()->null(),
            'edu_type_id' => $this->integer()->null(),
            'edu_form_id' => $this->integer()->null(),

            'start_time' => $this->integer()->null(),
            'finish_time' => $this->integer()->null(),
            'ball' => $this->float()->defaultValue(0),

            'exam_count' => $this->integer()->defaultValue(1),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_exam_table_user_table', 'exam', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_exam_table_student_table', 'exam', 'student_id', 'student', 'id');
        $this->addForeignKey('ik_exam_table_direction_table', 'exam', 'direction_id', 'direction', 'id');
        $this->addForeignKey('ik_exam_table_language_table', 'exam', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_exam_table_edu_year_form_table', 'exam', 'edu_year_form_id', 'edu_year_form', 'id');
        $this->addForeignKey('ik_exam_table_edu_year_type_table', 'exam', 'edu_year_type_id', 'edu_year_type', 'id');
        $this->addForeignKey('ik_exam_table_edu_type_table', 'exam', 'edu_type_id', 'edu_type', 'id');
        $this->addForeignKey('ik_exam_table_edu_form_table', 'exam', 'edu_form_id', 'edu_form', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exam}}');
    }
}
