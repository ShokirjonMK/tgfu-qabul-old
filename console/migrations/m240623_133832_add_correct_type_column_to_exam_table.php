<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%exam}}`.
 */
class m240623_133832_add_correct_type_column_to_exam_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('exam' , 'correct_type' , $this->tinyInteger(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
