<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Task;
use app\models\Category;
use app\models\Response;
use app\models\TaskFilterForm;
use app\models\City;
use app\models\SettingsForm;
use app\models\ChangePasswordForm;
use app\models\Specialization;
use app\models\Auth;
use yii\authclient\clients\VKontakte;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionView($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с ID $id не найден");
        }

        return $this->render('view', [
            'user' => $user,
            ]);
    }

    public function actionSettings()
    {

        $type = !empty(Yii::$app->request->get('type')) ? Yii::$app->request->get('type') : SettingsForm::PROFILE;
  
        $model = ($type === SettingsForm::SECURITY) ? new ChangePasswordForm() : new SettingsForm();
        $categories = Category::find()->all();

        if (Yii::$app->request->getIsPost()) 
        {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) 
            {
                $settings = ($type === SettingsForm::SECURITY) ? $model->changePassword() : $model->editProfile();               
                $this->redirect(['user/view', 'id' => Yii::$app->user->getId()]);
            }
        }
    
        return $this->render('settings', ['model' => $model, 'categories' => $categories, 'type' => $type]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/landing');
    }

 }
