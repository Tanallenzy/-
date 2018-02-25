<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 19:05
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException {
    public $code=201;
    public $msg='success';
    public $errorCode=0;
}