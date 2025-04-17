<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%created_by_column_to_exam}}`.
 */
class m240623_145406_drop_created_by_column_to_exam_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%exam}}', 'created_by');
        $this->dropColumn('{{%exam}}', 'updated_by');
        $this->addColumn('{{%exam}}', 'updated_by' , $this->integer()->null());
        $this->addColumn('{{%exam}}', 'created_by' , $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%created_by_column_to_exam}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
