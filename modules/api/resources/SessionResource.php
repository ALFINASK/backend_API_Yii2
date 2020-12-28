<?php


namespace app\modules\api\resources;


use app\models\Session;

class SessionResource extends Session
{
    public function fields()
    {
        return ['name','description','start','duration'];
    }

    public function extraFields()
    {
        return ['userID','created','updated'];
    }
}