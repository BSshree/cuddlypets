<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetCategory;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\filters\AccessControl;

class PetCategoryController extends \yii\web\Controller {

    public $modelClass = 'common\models\PetCategory';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['petcategory'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['petcategory'],
            'rules' => [
                    [
                    'actions' => ['petcategory'],
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
            $pet_category->pet_category_image = $post['pet_category_image'];

            if ($profile_img = UploadedFile::getInstancesByName("pet_category_image")) {
                foreach ($profile_img as $file) {
                    $file_name = str_replace(' ', '-', $file->name);
                    $randno = rand(11111, 99999);
                    $path = Yii::$app->basePath . '/web/uploads/images/' . $randno . $file_name;
                    $file->saveAs($path);
                    $flz = $randno . $file_name;
                    //$user->profile_image = $randno . $file_name;
                }
            }

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

    
}
