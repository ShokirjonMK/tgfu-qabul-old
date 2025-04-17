<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%telegram}}`.
 */
class m240701_064053_add_bot_status_column_to_telegram_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram' , 'bot_status' , $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
