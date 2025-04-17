<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%student}}`.
 */
class m240813_091123_add_crm_column_to_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student' , 'lead_id' , $this->string(255)->null());
        $this->addColumn('student' , 'pipeline_id' , $this->string(255)->null());
        $this->addColumn('student' , 'status_id' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
