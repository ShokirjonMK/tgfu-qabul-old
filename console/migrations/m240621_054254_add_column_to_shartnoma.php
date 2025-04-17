<?php

use yii\db\Migration;

/**
 * Class m240621_054254_add_column_to_shartnoma
 */
class m240621_054254_add_column_to_shartnoma extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('exam', 'down_time' , $this->integer()->null());
        $this->addColumn('student_perevot', 'down_time' , $this->integer()->null());
        $this->addColumn('student_dtm', 'down_time' , $this->integer()->null());

        $this->addColumn('student_perevot', 'direction_course_id' , $this->integer()->null());
        $this->addColumn('student_perevot', 'course_id' , $this->integer()->null());
        $this->addForeignKey('ik_student_perevot_table_direction_course_table', 'student_perevot', 'direction_course_id', 'direction_course', 'id');
        $this->addForeignKey('ik_student_perevot_table_course_table', 'student_perevot', 'course_id', 'course', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240621_054254_add_column_to_shartnoma cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240621_054254_add_column_to_shartnoma cannot be reverted.\n";

        return false;
    }
    */
}
