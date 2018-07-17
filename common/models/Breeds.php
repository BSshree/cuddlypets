<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "breeds".
 *
 * @property int $breed_id
 * @property string $breed_name
 * @property int $pet_category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PetCategory $petCategory
 */
class Breeds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'breeds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['breed_name', 'pet_category_id'], 'required'],
            [['pet_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['breed_name'], 'string', 'max' => 88],
            [['pet_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PetCategory::className(), 'targetAttribute' => ['pet_category_id' => 'pet_category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'breed_id' => 'Breed ID',
            'breed_name' => 'Breed Name',
            'pet_category_id' => 'Pet Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetCategory()
    {
        return $this->hasOne(PetCategory::className(), ['pet_category_id' => 'pet_category_id']);
    }
}
