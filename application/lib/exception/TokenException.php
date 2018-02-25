<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 1:12
 */

namespace app\lib\exception;


class TokenException extends BaseException {
    public $code=401;
    public $msg='token已过期或无效token';
    public $errorCode=10001;
}