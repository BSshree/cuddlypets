<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pet_category".
 *
 * @property int $pet_category_id
 * @property string $category_name
 *
 * @property PetDetails[] $petDetails
 */
class PetCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['category_name'], 'string', 'max' => 88],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pet_category_id' => 'Pet Category ID',
            'category_name' => 'Category Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPetDetails()
    {
        return $this->hasMany(PetDetails::className(), ['pet_category_id' => 'pet_category_id']);
    }
}
