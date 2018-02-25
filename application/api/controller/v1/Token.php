<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 16:09
 */

namespace app\api\controller\v1;


use app\api\controller\validate\TokenGet;
use app\api\service\UserToken;

class Token {
    /*
     * @url /token/user
     * @method POST
     * @return token令牌
     * */
    public function getToken($code) {
        (new TokenGet())->goCheck();
        $userToken = new UserToken($code);
        $token = $userToken->get();
        return json(['token' => $token]);
    }
}