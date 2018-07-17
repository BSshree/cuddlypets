<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reminders`.
 */
class m180629_054204_create_reminders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
     const REMINDERS_TABLE = '{{%reminders}}';
    const USERS_TABLE = '{{%users}}';
    const PET_DETAILS_TABLE = '{{%pet_details}}';
    const BREED_DETAILS_TABLE = '{{%breed_details}}';

    public function safeUp() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(self::REMINDERS_TABLE, [
            'reminder_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'pet_id' => $this->integer()->notNull(),
            'breed_id' => $this->integer()->notNull(),
            'reminder_for' => $this->string(25)->Null(),
            'reminder_date' => $this->string(25)->Null(),
            'event' => $this->string(25)->Null(),
            'set_time_before' => $this->string(125)->Null(),
            'timings' => $this->string(125)->Null(),
            'note' => $this->string(525)->Null(),
            'status' => $this->integer()->null(),
            'created_at' => $this->string(25)->Null(),
            'updated_at' => $this->string(25)->Null(),
            
        ],$tableOptions);
        
         $this->createIndex(
                'idx-reminders-user_id', self::REMINDERS_TABLE, 'user_id'
        );
        $this->addForeignKey(
                'fk-reminders-user_id', self::REMINDERS_TABLE, 'user_id', self::USERS_TABLE, 'id', 'CASCADE'
        );
        
         $this->createIndex(
                'idx-reminders-pet_id', self::REMINDERS_TABLE, 'pet_id'
        );
        $this->addForeignKey(
                'fk-reminders-pet_id', self::REMINDERS_TABLE, 'pet_id', self::PET_DETAILS_TABLE, 'pet_id', 'CASCADE'
        );
        
         $this->createIndex(
                'idx-reminders-breed_id', self::REMINDERS_TABLE, 'breed_id'
        );
        $this->addForeignKey(
                'fk-reminders-breed_id', self::REMINDERS_TABLE, 'breed_id', self::BREED_DETAILS_TABLE, 'breed_id', 'CASCADE'
        );
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable(self::REMINDERS_TABLE);
        
        $this->dropIndex(
                'idx-reminders-user_id', self::REMINDERS_TABLE
        );
        $this->dropTable(self::REMINDERS_TABLE);
        
          $this->dropIndex(
                'idx-reminders-pet_id', self::REMINDERS_TABLE
        );
        $this->dropTable(self::REMINDERS_TABLE);
        
        $this->dropIndex(
                'idx-reminders-breed_id', self::REMINDERS_TABLE
        );
        $this->dropTable(self::REMINDERS_TABLE);
        
        
    }

}
