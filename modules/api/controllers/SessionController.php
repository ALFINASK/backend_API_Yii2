<?php


namespace app\modules\api\controllers;


use app\models\User;
use app\models\Session;
use app\modules\api\resources\SessionResource;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class SessionController extends ActiveController
{
    public $modelClass = SessionResource::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors ['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($email, $password) {
                $user = User::findByEmail($email);
                if ($user->validatePassword($password)) {
                    return $user;
                }
                return null;
            },
        ];
        $behaviors ['authenticator']['only'] = ['create', 'update', 'delete'];

        return $behaviors;
    }

    /**
     * @param string $action
     * @param Session $model
     * @param array $params
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['update', 'delete']) && $model->userID !== \Yii::$app->user->id){
            throw new ForbiddenHttpException("Anda tidak memiliki akses untuk menghapus atau mengubah data ini!");
        }
    }
}