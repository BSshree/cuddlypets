<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetCategory;
use common\models\PetDetails;
use common\models\BreedDetails;
use common\models\Reminders;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

class RemindersController extends \yii\web\Controller
{
    
     public $modelClass = 'common\models\Reminders';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['addreminders'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['addreminders'],
            'rules' => [
                    [
                    'actions' => ['addreminders'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    
    public function actionAddreminder(){
       
        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {
            $add_reminder = new Reminders();

            $add_reminder->user_id = $post['user_id'];
            $add_reminder->pet_id = $post['pet_id'];
            $add_reminder->reminder_for = $post['reminder_for'];
            $add_reminder->reminder_date = $post['reminder_date'];
            $add_reminder->event = $post['event'];
            $add_reminder->set_time_before = $post['set_time_before'];
            $add_reminder->timings = $post['timings'];
            $add_reminder->note = $post['note'];
            $add_reminder->status = 0;
            $add_reminder->created_at = time();
            $add_reminder->updated_at = time();

            if ($add_reminder->save(false)) {

                return [
                    'success' => true,
                    'message' => 'Success',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Reminder cannot be added',
                ];
            }
        }
    }
    
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
