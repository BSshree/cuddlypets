<?php

namespace app\modules\api\modules\v1\controllers;

use common\models\PetCategory;
use common\models\PetDetails;
use common\models\BreedDetails;
use common\models\Users;
use common\models\Reminders;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use opensooq\firebase\FirebaseNotifications;

class RemindersController extends \yii\web\Controller {

    public $modelClass = 'common\models\Reminders';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['addreminders', 'reminderlist'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['addreminders', 'reminderlist'],
            'rules' => [
                    [
                    'actions' => ['addreminders', 'reminderlist'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionAddreminder() {

        $post = Yii::$app->request->getBodyParams();
        if (!empty($post)) {
            $add_reminder = new Reminders();

            $add_reminder->user_id = $post['user_id'];
            $add_reminder->pet_id = $post['pet_id'];
            $add_reminder->breed_id = $post['breed_id'];
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

    public function actionReminderon() {

        $post = Yii::$app->request->getBodyParams();
        $user = Users::find()->where(['id' => $post['id']])->one();
        $reminders = Reminders::find()->where(['reminder_id' => $post['reminder_id']])->one();
        $auth_key = $user['auth_key'];
        if ($post = Yii::$app->request->getBodyParams()) {
            // if ($model->save(false)) {
            $title = 'Notification Reminder';  //$model->title;
            $body = 'Feed vaccine your pet';  //$model->content;
            $service = new FirebaseNotifications(['authKey' => $auth_key]);

            $all_users = Users::find()->all();
            $tokens = [];
            foreach ($all_users as $users) {
                $tokens[] = $users['id'];
            }
            $message = array('title' => $title, 'body' => $body);
            $service->sendNotification($tokens, $message);

            if ($reminders['status'] == 1) {

                return [
                    'success' => true,
                    'message' => 'Success',
                        //'data' => $title ."<br>". $body,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Reminder off',
                ];
            }
        }
    }

    public function actionDeletereminder() {

        $reminders = Reminders::find()->where(['reminder_id' => $post['reminder_id']])->one();
        $post = Yii::$app->request->getBodyParams();
        if ($post['reminder_id'] == $reminders['reminder_id']) {
            $reminders->delete();
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

    public function actionReminderlist() {
        $post = Yii::$app->request->getBodyParams();
        $reminders = Reminders::find()->where(['user_id' => $post['user_id']])->all();
        if ($reminders != NULL) {

            foreach ($reminders as $reminder):
                $pets = PetDetails::find()->where(['pet_id' => $reminder['pet_id']])->one();
                $breeds = BreedDetails::find()->where(['breed_id' => $reminder['breed_id']])->one();

                $values [] = [
                    'reminder_for' => $reminder['reminder_for'],
                    'timings' => $reminder['timings'],
                    'reminder_date' => $reminder['reminder_date'],
                    'pet_name' => $pets['pet_name'],
                    'breed_name' => $breeds['breed_name'],
                ];

            endforeach;

            return [
                'success' => true,
                'message' => 'Success',
                'data' => $values,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No Reminders Exists',
            ];
        }
    }

}
