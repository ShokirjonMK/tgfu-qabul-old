<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%student}}`.
 */
class m240712_140244_add_filial_id_column_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student' , 'filial_id' , $this->integer()->null());
        $this->addForeignKey('ik_student_table_filial_table', 'student', 'filial_id', 'filial', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
