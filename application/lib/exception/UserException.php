<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 18:51
 */

namespace app\lib\exception;


class UserException extends BaseException {
    public $code=404;
    public $msg='用户不存在';
    public $errorCode=60000;
}