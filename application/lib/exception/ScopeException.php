<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 20:59
 */

namespace app\lib\exception;


class ScopeException extends BaseException {
    public $code=403;
    public $msg='您的权限不足，请联系管理员';
    public $errorCode=10001;
}