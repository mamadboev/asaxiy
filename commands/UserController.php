<?php


namespace app\commands;


use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller
{
    /**
     * @param string $username
     * @param string $password
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionCreate(string $username, string $password)
    {
        if (User::findOne(['username' => $username]) !== null) {
            echo "user {$username} is already exist\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateAuthToken();

        if ($user->save() === false) {
            echo "error " . array_values($user->firstErrors)[0] . "\n" ?? "unknown error\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }

        echo "user {$username} created\n";
        return ExitCode::OK;

    }

}