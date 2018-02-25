<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 0:53
 */

namespace app\lib\exception;


class ProductMissException extends BaseException {
    public $code=404;
    public $msg='请求的Product不存在';
    public $errorCode=20000;
}