<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_perevot}}`.
 */
class m240613_041036_create_student_perevot_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'student_perevot';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('student_perevot');
        }

        $this->createTable('{{%student_perevot}}', [
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
        ], $tableOptions);
        $this->addForeignKey('ik_student_perevot_table_user_table', 'student_perevot', 'user_id', 'user', 'id');
        $this->addForeignKey('ik_student_perevot_table_student_table', 'student_perevot', 'student_id', 'student', 'id');
        $this->addForeignKey('ik_student_perevot_table_direction_table', 'student_perevot', 'direction_id', 'direction', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_perevot}}');
    }
}
