<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_magistr}}`.
 */
class m240713_060203_create_student_magistr_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'student_magistr';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('student_magistr');
        }

        $this->createTable('{{%student_magistr}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'student_id' => $this->integer()->notNull(),

            'direction_id' => $this->integer()->notNull(),
            'file' => $this->string(255)->null(),
            'file_status' => $this->tinyInteger(1)->defaultValue(0),

            'contract_type' => $this->tinyInteger()->defaultValue(1),
            'contract_price' => $this->float()->defaultValue(0),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),

            'contract_second' => $this->string(255)->null(),
            'contract_third' => $this->string(255)->null(),
            'contract_link' => $this->string(255)->null(),
            'down_time' => $this->integer()->null(),
            'confirm_date' => $this->integer()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_student_magistr_table_user_table', 'student_magistr', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_student_magistr_table_student_table', 'student_magistr', 'student_id', 'student', 'id');
        $this->addForeignKey('ik_student_magistr_table_direction_table', 'student_magistr', 'direction_id', 'direction', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_magistr}}');
    }
}
