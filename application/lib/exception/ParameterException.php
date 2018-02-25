<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/20
 * Time: 1:00
 */

namespace app\lib\exception;


class ParameterException extends BaseException {
    public $code=400;
    public $msg='参数错误';
    public $errorCode=10000;
}