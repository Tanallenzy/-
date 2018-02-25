<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 13:00
 */

namespace app\lib\exception;


class CategoryMissException extends BaseException {
    public $code=404;
    public $msg='请求的Category不存在';
    public $errorCode=50000;
}