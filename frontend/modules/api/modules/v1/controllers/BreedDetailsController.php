<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetCategory;
use common\models\PetDetails;
use common\models\BreedDetails;
use common\models\Breeds;
use common\models\Users;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\filters\AccessControl;

class BreedDetailsController extends \yii\web\Controller {

    public $modelClass = 'common\models\BreedDetails';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['breeddetails', 'editbreeddetails'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['breeddetails', 'editbreeddetails'],
            'rules' => [
                    [
                    'actions' => ['breeddetails', 'editbreeddetails'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionBreeddetails() {  //this function not used 

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $breed_details = new BreedDetails();
            $breed_details->user_id = $post['user_id'];
            $breed_details->breed_name = $post['breed_name'];
            $breed_details->breed_height = $post['breed_height'];
            $breed_details->breed_weight = $post['breed_weight'];
            $breed_details->country_origin = $post['country_origin'];
            $breed_details->created_at = time();
            $breed_details->updated_at = time();

            if ($breed_details->save()) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Breed cannot be added',
                ];
            }
        }
    }

    public function actionEditbreeddetails() {  //this function not used 

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $edit_breed_details = new BreedDetails();
            $edit_breed_details = BreedDetails::find()->where(['breed_id' => $post['breed_id']])->one();
            $edit_breed_details->user_id = $post['user_id'];
            $edit_breed_details->breed_name = $post['breed_name'];
            $edit_breed_details->breed_height = $post['breed_height'];
            $edit_breed_details->breed_weight = $post['breed_weight'];
            $edit_breed_details->country_origin = $post['country_origin'];
            $edit_breed_details->updated_at = time();

            if ($edit_breed_details->save()) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Breed cannot be edited',
                ];
            }
        }
    }

    public function actionBreedlists() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {

            $breeds = new Breeds();
            $breeds = Breeds::find()->where(['pet_category_id' => $post['pet_category_id']])->all();

            foreach ($breeds as $breed):

                $values[] = [
                    'breed_id' => $breed->breed_id,
                    'breed_name' => $breed->breed_name,
                ];

            endforeach;

            if ($breed != NULL) {

                return [
                    'success' => true,
                    'message' => 'Success',
                    'breed-details' => $values
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No breeds available'
                ];
            }
        }
    }

}
