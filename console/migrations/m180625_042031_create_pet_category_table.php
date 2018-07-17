<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pet_category`.
 */
class m180625_042031_create_pet_category_table extends Migration {

    /**
     * {@inheritdoc}
     */
    const PET_CATEGORY_TABLE = '{{%pet_category}}';

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::PET_CATEGORY_TABLE, [
            'pet_category_id' => $this->primaryKey(),
            'category_name' => $this->string(88)->notNull(),
            'pet_category_image' => $this->string(88)->Null(),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::PET_CATEGORY_TABLE);
    }

}
