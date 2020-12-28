<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppController extends Controller
{
    public function actionRegister($name, $email, $password)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = \Yii::$app->security->generatePasswordHash($password);

        if ($user->save()){
            Console::output("Saved");
        }else{
            var_dump($user->errors);
            Console::output("Not Saved");
        }
    }
}
