<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%exam}}`.
 */
class m240623_140050_add_confirm_date_column_to_exam_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('exam' , 'confirm_date' , $this->integer()->defaultValue(0));
        $this->addColumn('student_perevot' , 'confirm_date' , $this->integer()->defaultValue(0));
        $this->addColumn('student_dtm' , 'confirm_date' , $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
