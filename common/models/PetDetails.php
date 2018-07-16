<?php

namespace common\models;
//use yii2tech\ar\softdelete\SoftDeleteBehavior;

use Yii;

/**
 * This is the model class for table "pet_details".
 *
 * @property int $pet_id
 * @property int $pet_category_id
 * @property int $user_id
 * @property string $pet_name
 * @property int $breed_id
 * @property string $secondary_breed
 * @property string $pet_height
 * @property string $pet_weight
 * @property string $gender
 * @property string $birthday
 * @property string $adopt_date
 * @property string $sleep_time
 * @property string $play
 * @property string $sports
 * @property string $shelter
 * @property string $bath
 *
 * @property BreedDetails $breed
 * @property PetCategory $petCategory
 * @property Users $user
 */
class PetDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet_details';
    }

//     public function behaviors() {
//        return [
//            'softDeleteBehavior' => [
//                'class' => SoftDeleteBehavior::className(),
//                'softDeleteAttributeValues' => [
//                    'isDeleted' => true
//                ],
//                'replaceRegularDelete' => true // mutate native `delete()` method
//            ],
//        ];
//        return [
//            TimestampBehavior::className(),
//        ];
//    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['pet_category_id', 'user_id', 'breed_id'], 'required'],
            [['pet_category_id', 'user_id', 'breed_id'], 'integer'],
            [['pet_image'], 'file'],
            [['pet_name', 'secondary_breed', 'pet_height', 'pet_weight', 'gender', 'birthday', 'adopt_date', 'sleep_time', 'play', 'sports', 'shelter', 'bath'], 'string', 'max' => 25],
            [['breed_id'], 'exist', 'skipOnError' => true, 'targetClass' => BreedDetails::className(), 'targetAttribute' => ['breed_id' => 'breed_id']],
            [['pet_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PetCategory::className(), 'targetAttribute' => ['pet_category_id' => 'pet_category_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pet_id' => 'Pet ID',
            'pet_category_id' => 'Pet Category ID',
            'user_id' => 'User ID',
            'pet_name' => 'Pet Name',
            'breed_id' => 'Breed ID',
            'secondary_breed' => 'Secondary Breed',
            'pet_height' => 'Pet Height',
            'pet_weight' => 'Pet Weight',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'adopt_date' => 'Adopt Date',
            'sleep_time' => 'Sleep Time',
            'play' => 'Play',
            'sports' => 'Sports',
            'shelter' => 'Shelter',
            'bath' => 'Bath',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBreed()
    {
        return $this->hasOne(BreedDetails::className(), ['breed_id' => 'breed_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetCategory()
    {
        return $this->hasOne(PetCategory::className(), ['pet_category_id' => 'pet_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
