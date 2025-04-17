<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%student}}`.
 */
class m240613_043255_add_std_edu_name_columns_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student' , 'edu_name',  $this->string(255)->null());
        $this->addColumn('student' , 'edu_direction',  $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
