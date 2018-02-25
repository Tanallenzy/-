<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 16:09
 */

namespace app\api\model;


class User extends BaseModel {
    public static function getUserByOpenId($openId) {
        return self::where('openid', '=', $openId)->find();
    }

    public static function createUser($arr) {
        return self::create($arr);
    }

    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }

}