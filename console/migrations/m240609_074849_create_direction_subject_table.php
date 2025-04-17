<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%direction_subject}}`.
 */
class m240609_074849_create_direction_subject_table extends Migration
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

        $tableName = Yii::$app->db->tablePrefix . 'direction_subject';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('direction_subject');
        }

        $this->createTable('{{%direction_subject}}', [
            'id' => $this->primaryKey(),

            'direction_id' => $this->integer()->notNull(),
            'subject_id' => $this->integer()->notNull(),
            'ball' => $this->float()->notNull(),
            'question_count' => $this->float()->notNull(),

            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
            'is_deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], $tableOptions);
        $this->addForeignKey('ik_direction_subject_table_direction_table', 'direction_subject', 'direction_id', 'direction', 'id');
        $this->addForeignKey('ik_direction_subject_table_subject_table', 'direction_subject', 'subject_id', 'subjects', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%direction_subject}}');
    }
}
