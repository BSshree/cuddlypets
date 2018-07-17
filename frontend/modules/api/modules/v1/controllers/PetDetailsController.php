<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetDetails;
use common\models\BreedDetails;
use common\models\Breeds;
use common\models\PetCategory;
use common\models\Users;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
//use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\filters\AccessControl;

class PetDetailsController extends \yii\web\Controller {

    public $modelClass = 'common\models\PetDetails';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['petdetails', 'editpetdetails', 'deletepet', 'petcategorylist'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['petdetails', 'editpetdetails', 'deletepet', 'petcategorylist'],
            'rules' => [
                    [
                    'actions' => ['petdetails', 'editpetdetails', 'deletepet', 'petcategorylist'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionPetdetails() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {
            $pet_details = new PetDetails();
            if ($pet_image = UploadedFile::getInstancesByName("pet_image")) {
                foreach ($pet_image as $file) {

                    $file_name = str_replace(' ', '-', $file->name);
                    $randno = rand(11111, 99999);
                    $path = Yii::$app->basePath . '/web/uploads/images/' . $randno . $file_name;
                    $file->saveAs($path);
                    $flz = $randno . $file_name;
                    $pet_details->pet_image = $randno . $file_name;
                }
            } else {
                $pet_details->pet_image = 'image_default.png';
            }

            $pet_details->user_id = $post['user_id'];
            $pet_details->pet_name = $post['pet_name'];
            $pet_details->pet_category_id = $post['pet_category_id'];
            $pet_details->breed_id = $post['breed_id'];
            $pet_details->secondary_breed = $post['secondary_breed'];
            $pet_details->pet_height = $post['pet_height'];
            $pet_details->pet_weight = $post['pet_weight'];
            $pet_details->gender = $post['gender'];
            $pet_details->birthday = $post['birthday'];
            $pet_details->adopt_date = $post['adopt_date'];
            $pet_details->play = $post['play'];
            $pet_details->sports = $post['sports'];
            $pet_details->shelter = $post['shelter'];
            $pet_details->bath = $post['bath'];
            $pet_details->sleep_time = $post['sleep_time'];
            $pet_details->created_at = time();
            $pet_details->updated_at = time();

            if ($pet_details->save(false)) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Pet cannot be added',
                ];
            }
        }
    }

    public function actionEditpetdetails() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {
            $pet_details = new PetDetails();
            $pet_details = PetDetails::find()->where(['pet_id' => $post['pet_id']])->one();
            $oldimage = $pet_details['pet_image'];
            if ($pet_image = UploadedFile::getInstancesByName("pet_image")) {
                foreach ($pet_image as $file) {

                    $file_name = str_replace(' ', '-', $file->name);
                    $randno = rand(11111, 99999);
                    $path = Yii::$app->basePath . '/web/uploads/images/' . $randno . $file_name;
                    $file->saveAs($path);
                    $flz = $randno . $file_name;
                    $pet_details->pet_image = $randno . $file_name;
                }
                if ($oldimage != 'image_default.png') {

                    unlink(Yii::$app->basePath . '/web/uploads/images/' . $oldimage);
                }
            }

            $pet_details->user_id = $post['user_id'];
            $pet_details->pet_name = $post['pet_name'];
            $pet_details->pet_category_id = $post['pet_category_id'];
            $pet_details->breed_id = $post['breed_id'];
            $pet_details->secondary_breed = $post['secondary_breed'];
            $pet_details->pet_height = $post['pet_height'];
            $pet_details->pet_weight = $post['pet_weight'];
            $pet_details->gender = $post['gender'];
            $pet_details->birthday = $post['birthday'];
            $pet_details->adopt_date = $post['adopt_date'];
            $pet_details->play = $post['play'];
            $pet_details->sports = $post['sports'];
            $pet_details->shelter = $post['shelter'];
            $pet_details->bath = $post['bath'];
            $pet_details->sleep_time = $post['sleep_time'];
            $pet_details->created_at = time();
            $pet_details->updated_at = time();

            if ($pet_details->save(false)) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Pet cannot be edited',
                ];
            }
        }
    }

    public function actionMyalbum() {

        $post = Yii::$app->request->getBodyParams();
        $pet_details = PetDetails::find()->where(['user_id' => $post['user_id']])->andWhere(['pet_category_id' => $post['pet_category_id']])->all();

        foreach ($pet_details as $pets):

            $breed_details = Breeds::find()->where(['breed_id' => $pets['breed_id']])->one();
            $pet_category = PetCategory::find()->where(['pet_category_id' => $pets['pet_category_id']])->one();
            $values[] = [
                'pet_id' => $pets->pet_id,
                'pet_name' => $pets->pet_name,
                'breed' => $breed_details['breed_name'],
                'secondary_breed' => $pets->secondary_breed,
                'pet_height' => $pets->pet_height,
                'pet_weight' => $pets->pet_weight,
                'gender' => $pets->gender,
            ];
        endforeach;

        if ($pet_details != NULL) {
            return [
                'success' => true,
                'message' => 'Success',
                'pet_category_id' => $post['pet_category_id'],
                'pet_category_name' => $pet_category['category_name'],
                'data' => $values
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No Pets Exists',
            ];
        }
    }

    public function actionListpet() {

        $post = Yii::$app->request->getBodyParams();
        $pet_details = PetDetails::find()->where(['user_id' => $post['user_id']])->all();

        foreach ($pet_details as $pets):

            $breed_details = Breeds::find()->where(['breed_id' => $pets['breed_id']])->one();
            //$pet_category = PetCategory::find()->where(['pet_category_id' => $pets['pet_category_id']])->one();
            $values[] = [
                'pet_id' => $pets->pet_id,
                'pet_name' => $pets->pet_name,
                'breed' => $breed_details['breed_name'],
                'secondary_breed' => $pets->secondary_breed,
                'pet_height' => $pets->pet_height,
                'pet_weight' => $pets->pet_weight,
                'gender' => $pets->gender,
            ];
        endforeach;

        if ($pet_details != NULL) {
            return [
                'success' => true,
                'message' => 'Success',
                // 'pet_category_id' => $post['pet_category_id'],
                // 'pet_category_name' => $pet_category['category_name'],
                'data' => $values
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No Pets Exists',
            ];
        }
    }

    public function actionDeletepet() {

        $post = Yii::$app->request->getBodyParams();
        $pet_details = PetDetails::find()->where(['pet_id' => $post['pet_id']])->one();
        if ($post['pet_id'] == $pet_details['pet_id']) {
            $pet_details->delete();
            return [
                'success' => true,
                'message' => 'Success',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No Contact Exists',
            ];
        }
    }

    public function actionPetcategorylist() {

        $post = Yii::$app->request->getBodyParams();
        $pet_category = PetCategory::find()->all();
        foreach ($pet_category as $pets):

            $values[] = [
                'pet_category_id' => $pets->pet_category_id,
                'category_name' => $pets->category_name,
            ];

        endforeach;

        if ($pet_category != NULL) {
            return [
                'success' => true,
                'message' => 'Success',
                'data' => $values
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No category Exists',
            ];
        }
    }

}
