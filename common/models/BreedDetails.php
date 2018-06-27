<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "breed_details".
 *
 * @property int $breed_id
 * @property int $user_id
 * @property string $breed_height
 * @property string $breed_weight
 * @property string $country_origin
 *
 * @property Users $user
 * @property PetDetails[] $petDetails
 */
class BreedDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'breed_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['breed_name','breed_height', 'breed_weight', 'country_origin'], 'string', 'max' => 25],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'breed_id' => 'Breed ID',
            'user_id' => 'User ID',
            'breed_height' => 'Breed Height',
            'breed_weight' => 'Breed Weight',
            'country_origin' => 'Country Origin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetDetails()
    {
        return $this->hasMany(PetDetails::className(), ['breed_id' => 'breed_id']);
    }
}
