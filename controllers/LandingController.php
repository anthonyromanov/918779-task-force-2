<?php
namespace app\controllers;
use Yii;
use app\models\LoginForm;
use yii\web\Controller;

class LandingController extends Controller
{

    public function actionLogin()
    {
        $loginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }
    }

    public function actionIndex()
    {

        $this->layout = 'landing';

        $model = new LoginForm;

        if (Yii::$app->request->getIsPost()) {
           $model->load(Yii::$app->request->post());
           if ($model->validate()) {
               $user = $model->getUser();
               Yii::$app->user->login($user);
               return $this->redirect('/tasks');
           }
       }

        return $this->render('index', ['model' => $model]);
    }
}



