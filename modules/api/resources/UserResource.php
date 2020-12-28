<?php


namespace app\modules\api\resources;


use app\models\User;

class UserResource extends User
{
    public function fields()
    {
        return ['ID','name','email','created','updated'];
    }
}