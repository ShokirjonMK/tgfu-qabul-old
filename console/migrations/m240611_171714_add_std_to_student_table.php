<?php

use yii\db\Migration;

/**
 * Class m240611_171714_add_std_to_student_table
 */
class m240611_171714_add_std_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student' , 'direction_id' , $this->integer()->null());
        $this->addColumn('student' , 'language_id' , $this->integer()->null());
        $this->addColumn('student' , 'edu_year_form_id' , $this->integer()->null());
        $this->addColumn('student' , 'edu_form_id' , $this->integer()->null());
        $this->addColumn('student' , 'edu_type_id' , $this->integer()->null());
        $this->addColumn('student' , 'direction_course_id' , $this->integer()->null());
        $this->addColumn('student' , 'course_id' , $this->integer()->null());
        $this->addForeignKey('ik_student_table_direction_table', 'student', 'direction_id', 'direction', 'id');
        $this->addForeignKey('ik_student_table_language_table', 'student', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_student_table_edu_year_form_table', 'student', 'edu_year_form_id', 'edu_year_form', 'id');
        $this->addForeignKey('ik_student_table_edu_form_table', 'student', 'edu_form_id', 'edu_form', 'id');
        $this->addForeignKey('ik_student_table_edu_type_table', 'student', 'edu_type_id', 'edu_type', 'id');
        $this->addForeignKey('ik_student_table_direction_course_table', 'student', 'direction_course_id', 'direction_course', 'id');
        $this->addForeignKey('ik_student_table_course_table', 'student', 'course_id', 'course', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240611_171714_add_std_to_student_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240611_171714_add_std_to_student_table cannot be reverted.\n";

        return false;
    }
    */
}
