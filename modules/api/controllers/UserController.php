<?php


namespace app\modules\api\controllers;

use app\modules\api\models\LoginForm;
use app\modules\api\models\RegisterForm;
use Yii;
use yii\rest\Controller;


class UserController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode=422;
        return [
            'errors'=>$model->errors
        ];
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->_user;
        }

        Yii::$app->response->statusCode=422;
        return [
            'errors'=>$model->errors
        ];
    }

}