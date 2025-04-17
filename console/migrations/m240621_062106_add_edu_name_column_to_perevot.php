<?php

use yii\db\Migration;

/**
 * Class m240621_062106_add_edu_name_column_to_perevot
 */
class m240621_062106_add_edu_name_column_to_perevot extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student_perevot' , 'edu_name', $this->string(255)->null());
        $this->addColumn('student_perevot' , 'edu_direction', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240621_062106_add_edu_name_column_to_perevot cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240621_062106_add_edu_name_column_to_perevot cannot be reverted.\n";

        return false;
    }
    */
}
