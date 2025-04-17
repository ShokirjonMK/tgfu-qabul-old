<?php

use yii\db\Migration;

/**
 * Class m240629_131655_add_column_telegram_table
 */
class m240629_131655_add_column_telegram_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram' , 'username' , $this->string(255)->null());
        $this->addColumn('telegram' , 'confirm_date' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240629_131655_add_column_telegram_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240629_131655_add_column_telegram_table cannot be reverted.\n";

        return false;
    }
    */
}
