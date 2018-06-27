<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reminders".
 *
 * @property int $reminder_id
 * @property int $user_id
 * @property int $pet_id
 * @property string $reminder_for
 * @property string $reminder_date
 * @property string $event
 * @property string $set_time_before
 * @property string $timings
 * @property string $note
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PetDetails $pet
 * @property Users $user
 */
class Reminders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reminders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['user_id', 'pet_id'], 'required'],
            [['user_id', 'pet_id', 'status'], 'integer'],
            [['reminder_for', 'reminder_date', 'event', 'created_at', 'updated_at'], 'string', 'max' => 25],
            [['set_time_before', 'timings'], 'string', 'max' => 125],
            [['note'], 'string', 'max' => 525],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => PetDetails::className(), 'targetAttribute' => ['pet_id' => 'pet_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reminder_id' => 'Reminder ID',
            'user_id' => 'User ID',
            'pet_id' => 'Pet ID',
            'reminder_for' => 'Reminder For',
            'reminder_date' => 'Reminder Date',
            'event' => 'Event',
            'set_time_before' => 'Set Time Before',
            'timings' => 'Timings',
            'note' => 'Note',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPet()
    {
        return $this->hasOne(PetDetails::className(), ['pet_id' => 'pet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
