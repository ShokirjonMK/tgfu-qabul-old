<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%exam_subject}}`.
 */
class m240612_114657_create_exam_subject_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'exam_subject';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('exam_subject');
        }

        $this->createTable('{{%exam_subject}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'student_id' => $this->integer()->notNull(),
            'exam_id' => $this->integer()->notNull(),
            'direction_id' => $this->integer()->notNull(),
            'direction_subject_id' => $this->integer()->notNull(),
            'subject_id' => $this->integer()->notNull(),

            'language_id' => $this->integer()->null(),
            'edu_year_form_id' => $this->integer()->null(),
            'edu_year_type_id' => $this->integer()->null(),
            'edu_type_id' => $this->integer()->null(),
            'edu_form_id' => $this->integer()->null(),

            'file' => $this->string(255)->null(),
            'file_status' => $this->tinyInteger(1)->defaultValue(0),
            'ball' => $this->float()->defaultValue(0),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_exam_subject_table_user_table', 'exam_subject', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_exam_subject_table_student_table', 'exam_subject', 'student_id', 'student', 'id');
        $this->addForeignKey('ik_exam_subject_table_exam_table', 'exam_subject', 'exam_id', 'exam', 'id');
        $this->addForeignKey('ik_exam_subject_table_direction_table', 'exam_subject', 'direction_id', 'direction', 'id');
        $this->addForeignKey('ik_exam_subject_table_direction_subject_table', 'exam_subject', 'direction_subject_id', 'direction_subject', 'id');
        $this->addForeignKey('ik_exam_subject_table_subject_table', 'exam_subject', 'subject_id', 'subjects', 'id');
        $this->addForeignKey('ik_exam_subject_table_language_table', 'exam_subject', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_exam_subject_table_edu_year_form_table', 'exam_subject', 'edu_year_form_id', 'edu_year_form', 'id');
        $this->addForeignKey('ik_exam_subject_table_edu_year_type_table', 'exam_subject', 'edu_year_type_id', 'edu_year_type', 'id');
        $this->addForeignKey('ik_exam_subject_table_edu_type_table', 'exam_subject', 'edu_type_id', 'edu_type', 'id');
        $this->addForeignKey('ik_exam_subject_table_edu_form_table', 'exam_subject', 'edu_form_id', 'edu_form', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%exam_subject}}');
    }
}
