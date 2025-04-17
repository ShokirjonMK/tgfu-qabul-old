<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%constalting}}`.
 */
class m240715_073714_add_bank_column_to_constalting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('filial' , 'univer_name_uz' , $this->string(255)->null());
        $this->addColumn('filial' , 'address_uz' , $this->string(255)->null());
        $this->addColumn('filial' , 'address_link' , $this->string(255)->null());
        $this->addColumn('filial' , 'phone' , $this->string(255)->null());
        $this->addColumn('filial' , 'h_r' , $this->string(255)->null());
        $this->addColumn('filial' , 'bank_uz' , $this->string(255)->null());
        $this->addColumn('filial' , 'mfo' , $this->string(255)->null());
        $this->addColumn('filial' , 'stir' , $this->string(255)->null());
        $this->addColumn('filial' , 'oked' , $this->string(255)->null());
        $this->addColumn('filial' , 'prorektor_uz' , $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
