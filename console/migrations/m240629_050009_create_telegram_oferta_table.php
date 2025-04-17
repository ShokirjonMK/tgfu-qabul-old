<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_oferta}}`.
 */
class m240629_050009_create_telegram_oferta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $tableName = Yii::$app->db->tablePrefix . 'telegram_oferta';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('telegram_oferta');
        }

        $this->createTable('{{%telegram_oferta}}', [
            'id' => $this->primaryKey(),
            'telegram_id' => $this->integer()->notNull(),
            'file' => $this->string(255)->null(),
            'file_status' => $this->integer()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_telegram_oferta_table_telegram_table', 'telegram_oferta', 'telegram_id', 'telegram', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_oferta}}');
    }
}
