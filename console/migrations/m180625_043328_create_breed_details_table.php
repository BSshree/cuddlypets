<?php

use yii\db\Migration;

/**
 * Handles the creation of table `breed_details`.
 */
class m180625_043328_create_breed_details_table extends Migration {

    /**
     * {@inheritdoc}
     */
    const BREED_DETAILS_TABLE = '{{%breed_details}}';
    const USERS_TABLE = '{{%users}}';

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::BREED_DETAILS_TABLE, [
            'breed_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'breed_height' => $this->string(25)->Null(),
            'breed_weight' => $this->string(25)->Null(),
            'country_origin' => $this->string(25)->Null(),
            'created_at' => $this->string(25)->Null(),
            'updated_at' => $this->string(25)->Null(),
                
            ], $tableOptions);

        $this->createIndex(
                'idx-breed_details-user_id', self::BREED_DETAILS_TABLE, 'user_id'
        );

        $this->addForeignKey(
                'fk-breed_details-user_id', self::BREED_DETAILS_TABLE, 'user_id', self::USERS_TABLE, 'id', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::BREED_DETAILS_TABLE);

        $this->dropIndex(
                'idx-breed_details-user_id', self::BREED_DETAILS_TABLE
        );
        $this->dropTable(self::BREED_DETAILS_TABLE);
    }

}
