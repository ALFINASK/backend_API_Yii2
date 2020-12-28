<?php

namespace app\modules\api\models;

use app\modules\api\resources\UserResource;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;

    public $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['name', 'email', 'password'], 'required'],
            ['email', 'unique',
                'targetClass' => '\app\modules\api\resources\UserResource',
                'message' => 'This email address has already been taken.'
            ],
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        $this->_user = new UserResource();
        if ($this->validate()) {
            $this->_user->name = $this->name;
            $this->_user->email = $this->email;
            $this->_user->password = \Yii::$app->security->generatePasswordHash($this->password);

            if ($this->_user->save()){
                return true;
            }
            return false;
        }
        return false;
    }
}
