<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m240623_052253_add_cons_type_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user' , 'cons_id' , $this->integer()->null());
        $this->addForeignKey('ik_user_table_constalting_table', 'user', 'cons_id', 'constalting', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
