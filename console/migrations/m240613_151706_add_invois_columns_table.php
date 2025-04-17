<?php

use yii\db\Migration;

/**
 * Class m240613_151706_add_invois_columns_table
 */
class m240613_151706_add_invois_columns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('exam' , 'contract_type' , $this->float()->null());
        $this->addColumn('exam' , 'contract_price' , $this->float()->null());
        $this->addColumn('exam' , 'contract_second' , $this->string(255)->null());
        $this->addColumn('exam' , 'contract_third' , $this->string(255)->null());
        $this->addColumn('exam' , 'contract_link' , $this->string(255)->null());

        $this->addColumn('student_dtm' , 'contract_second' , $this->string(255)->null());
        $this->addColumn('student_dtm' , 'contract_third' , $this->string(255)->null());
        $this->addColumn('student_dtm' , 'contract_link' , $this->string(255)->null());

        $this->addColumn('student_perevot' , 'contract_second' , $this->string(255)->null());
        $this->addColumn('student_perevot' , 'contract_third' , $this->string(255)->null());
        $this->addColumn('student_perevot' , 'contract_link' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240613_151706_add_invois_columns_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240613_151706_add_invois_columns_table cannot be reverted.\n";

        return false;
    }
    */
}
