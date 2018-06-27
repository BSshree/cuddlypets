<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetCategory;
use common\models\PetDetails;
use common\models\BreedDetails;
use common\models\Users;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\filters\AccessControl;

class PetController extends \yii\web\Controller {

    public $modelClass = 'common\models\PetCategory';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['petcategory', 'breeddetails', 'petdetails'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['petcategory', 'breeddetails', 'petdetails'],
            'rules' => [
                    [
                    'actions' => ['petcategory', 'breeddetails', 'petdetails'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionPetcategory() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $pet_category = new PetCategory();
            $pet_category->category_name = $post['category_name'];

            if ($pet_category->save()) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failure',
                ];
            }
        }
    }

    public function actionBreeddetails() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $breed_details = new BreedDetails();
            $breed_details->user_id = $post['user_id'];
            $breed_details->breed_name = $post['breed_name'];
            $breed_details->breed_height = $post['breed_height'];
            $breed_details->breed_weight = $post['breed_weight'];
            $breed_details->country_origin = $post['country_origin'];

            if ($breed_details->save()) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failure',
                ];
            }
        }
    }

    public function actionPetdetails() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $pet_details = new PetDetails();
            $pet_details->user_id = $post['user_id'];
            $pet_details->pet_name = $post['pet_name'];
            $pet_details->pet_category_id = $post['pet_category_id'];
            $pet_details->breed_id = $post['breed_id'];
            $pet_details->secondary_breed = $post['secondary_breed'];
            $pet_details->pet_height = $post['pet_height'];
            $pet_details->pet_weight = $post['pet_height'];
            $pet_details->gender = $post['gender'];
            $pet_details->birthday = $post['birthday'];
            $pet_details->adopt_date = $post['adopt_date'];
            $pet_details->play = $post['play'];
            $pet_details->sports = $post['sports'];
            $pet_details->shelter = $post['shelter'];
            $pet_details->bath = $post['bath'];
            $pet_details->sleep_time = $post['sleep_time'];

            if ($pet_details->save(false)) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failure',
                ];
            }
        }
    }

}


