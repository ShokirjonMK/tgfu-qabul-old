<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%step_id_column_to_user}}`.
 */
class m240624_130846_drop_step_id_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('ik_user_table_constalting_table', 'user');
        $this->dropColumn('{{%user}}', 'cons_id');

        $this->addColumn('user' , 'cons_id' , $this->integer()->defaultValue(1));
        $this->addForeignKey('ik_user_table_constalting_table', 'user', 'cons_id', 'constalting', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%step_id_column_to_user}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
