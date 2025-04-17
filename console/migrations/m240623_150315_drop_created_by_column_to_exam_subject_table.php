<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%created_by_column_to_exam_subject}}`.
 */
class m240623_150315_drop_created_by_column_to_exam_subject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%exam_subject}}', 'created_by');
        $this->dropColumn('{{%exam_subject}}', 'updated_by');
        $this->addColumn('{{%exam_subject}}', 'updated_by' , $this->integer()->null());
        $this->addColumn('{{%exam_subject}}', 'created_by' , $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%created_by_column_to_exam_subject}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
