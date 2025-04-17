<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram}}`.
 */
class m240628_130324_create_telegram_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'telegram';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('telegram');
        }

        $this->createTable('{{%telegram}}', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->string(255)->null(),
            'step' => $this->integer()->defaultValue(1),
            'lang_id' => $this->integer()->defaultValue(1),
            'first_name' => $this->string(255)->null(),
            'last_name' => $this->string(255)->null(),
            'middle_name' => $this->string(255)->null(),
            'phone' => $this->string(255)->null(),
            'passport_serial' => $this->string(255)->null(),
            'passport_number' => $this->string(255)->null(),
            'passport_pin' => $this->string(255)->null(),
            'gender' => $this->tinyInteger(1)->null(),
            'birthday' => $this->string(255)->null(),
            'passport_issued_date' => $this->string(255)->null(),
            'passport_given_date' => $this->string(255)->null(),
            'passport_given_by' => $this->string(255)->null(),

            'edu_year_type_id' => $this->integer()->null(),
            'edu_year_form_id' => $this->integer()->null(),
            'direction_id' => $this->integer()->null(),
            'language_id' => $this->integer()->null(),

            'direction_course_id' => $this->integer()->null(),
            'exam_type' => $this->integer()->defaultValue(0),

            'edu_name' => $this->string(255)->null(),
            'edu_direction' => $this->string(255)->null(),

            'is_deleted' => $this->integer()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_telegram_table_edu_year_type_table', 'telegram', 'edu_year_type_id', 'edu_year_type', 'id');
        $this->addForeignKey('ik_telegram_table_edu_year_form_table', 'telegram', 'edu_year_form_id', 'edu_year_form', 'id');
        $this->addForeignKey('ik_telegram_table_direction_table', 'telegram', 'direction_id', 'direction', 'id');
        $this->addForeignKey('ik_telegram_table_language_table', 'telegram', 'language_id', 'languages', 'id');
        $this->addForeignKey('ik_telegram_table_direction_course_table', 'telegram', 'direction_course_id', 'direction_course', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram}}');
    }
}
