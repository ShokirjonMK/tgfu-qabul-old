<?php

use yii\db\Migration;

/**
 * Class m240610_130044_add_edu_year_type_id_to_student_table
 */
class m240610_130044_add_edu_year_type_id_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $this->addColumn('student' , 'edu_year_type_id' , $this->integer()->null());
        $this->addForeignKey('ik_student_table_edu_year_type_table', 'student', 'edu_year_type_id', 'edu_year_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240610_130044_add_edu_year_type_id_to_student_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240610_130044_add_edu_year_type_id_to_student_table cannot be reverted.\n";

        return false;
    }
    */
}
