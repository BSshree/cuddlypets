<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pet_details`.
 */
class m180717_093355_create_pet_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     const PET_DETAILS_TABLE = '{{%pet_details}}';
    const USERS_TABLE = '{{%users}}';
    const PET_CATEGORY_TABLE = '{{%pet_category}}';
    const BREEDS_TABLE = '{{%breeds}}';

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::PET_DETAILS_TABLE, [
            'pet_id' => $this->primaryKey(),
            'pet_category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'pet_name' => $this->string(25)->Null(),
            'breed_id' => $this->integer()->notNull(),
            'secondary_breed' => $this->string(25)->Null(),
            'pet_height' => $this->string(25)->Null(),
            'pet_weight' => $this->string(25)->Null(),
            'pet_image' => $this->string(25)->Null(),
            'gender' => $this->string(25)->Null(),
            'birthday' => $this->string(25)->Null(),
            'adopt_date' => $this->string(25)->Null(),
            'sleep_time' => $this->string(25)->Null(),
            'play' => $this->string(25)->Null(),
            'sports' => $this->string(25)->Null(),
            'shelter' => $this->string(25)->Null(),
            'bath' => $this->string(25)->Null(),
            'created_at' => $this->string(25)->Null(),
            'updated_at' => $this->string(25)->Null(),
                
            ], $tableOptions);

        $this->createIndex(
                'idx-pet_details-pet_category_id', self::PET_DETAILS_TABLE, 'pet_category_id'
        );
        $this->addForeignKey(
                'fk-pet_details-pet_category_id', self::PET_DETAILS_TABLE, 'pet_category_id', self::PET_CATEGORY_TABLE, 'pet_category_id', 'CASCADE'
        );


        $this->createIndex(
                'idx-pet_details-user_id', self::PET_DETAILS_TABLE, 'user_id'
        );
        $this->addForeignKey(
                'fk-pet_details-user_id', self::PET_DETAILS_TABLE, 'user_id', self::USERS_TABLE, 'id', 'CASCADE'
        );


        $this->createIndex(
                'idx-breeds-breed_id', self::PET_DETAILS_TABLE, 'breed_id'
        );
        $this->addForeignKey(
                'fk-breeds-breed_id', self::PET_DETAILS_TABLE, 'breed_id', self::BREEDS_TABLE, 'breed_id', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::PET_DETAILS_TABLE);

        $this->dropIndex(
                'idx-pet_details-pet_category_id', self::PET_DETAILS_TABLE
        );
        $this->dropTable(self::PET_DETAILS_TABLE);


        $this->dropIndex(
                'idx-pet_details-user_id', self::PET_DETAILS_TABLE
        );
        $this->dropTable(self::PET_DETAILS_TABLE);


        $this->dropIndex(
                'idx-pet_details-breed_id', self::PET_DETAILS_TABLE
        );
        $this->dropTable(self::PET_DETAILS_TABLE);
    }

}
