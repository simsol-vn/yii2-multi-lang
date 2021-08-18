<?php

use yii\db\Migration;

/**
 * Class m210814_072755_create_table_translate
 */
class m210814_072755_create_table_translate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('translate',[
            'id_translate'  => $this->primaryKey(),
            'language_code' => $this->string(),
            'id_object'     => $this->integer(),
            'object_class'  => $this->string(),
            'object_field'  => $this->string(),
            'value'         => $this->text(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ],$tableOptions);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('translate');
        
        return false;
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210814_072755_create_table_translate cannot be reverted.\n";

        return false;
    }
    */
}
