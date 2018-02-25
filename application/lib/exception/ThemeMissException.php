<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/22
 * Time: 21:43
 */

namespace app\lib\exception;


class ThemeMissException extends BaseException {
    public $code=404;
    public $msg='请求的Theme不存在';
    public $errorCode=30000;
}