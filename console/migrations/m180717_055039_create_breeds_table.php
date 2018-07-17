<?php

use yii\db\Migration;

/**
 * Handles the creation of table `breeds`.
 */
class m180717_055039_create_breeds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
   const BREEDS_TABLE = '{{%breeds}}';
    const PET_CATEGORY_TABLE = '{{%pet_category}}';
    
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::BREEDS_TABLE, [
            'breed_id' => $this->primaryKey(),
            'breed_name' =>  $this->string(88)->notNull(),
            'pet_category_id' =>  $this->integer(28)->notNull(),
            'created_at' =>  $this->timestamp()->notNull(),
            'updated_at' =>  $this->timestamp()->notNull(),
            
        ], $tableOptions);
        
        $this->createIndex(
                'idx-breeds-pet_category_id', self::BREEDS_TABLE, 'pet_category_id'
        );

        $this->addForeignKey(
                'fk-breeds-pet_category_id', self::BREEDS_TABLE, 'pet_category_id', self::PET_CATEGORY_TABLE, 'pet_category_id', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::BREEDLS_TABLE);

        $this->dropIndex(
                'idx-breeds-pet_category_id', self::BREEDS_TABLE
        );
        
        $this->dropTable(self::BREEDS_TABLE);
    }
}
