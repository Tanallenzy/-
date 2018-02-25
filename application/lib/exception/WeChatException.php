<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 21:36
 */

namespace app\lib\exception;


class WeChatException extends BaseException {
    public $code=400;
    public $msg;
    public $errorCode;
}