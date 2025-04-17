<?php

use yii\db\Migration;

/**
 * Class m240611_120614_add_edu_durection_to_direction_table
 */
class m240611_120614_add_edu_durection_to_direction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('direction' , 'edu_duration' , $this->float()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240611_120614_add_edu_durection_to_direction_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240611_120614_add_edu_durection_to_direction_table cannot be reverted.\n";

        return false;
    }
    */
}
