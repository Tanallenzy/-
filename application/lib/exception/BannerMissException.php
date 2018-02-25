<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/18
 * Time: 18:46
 */

namespace app\lib\exception;


class BannerMissException extends BaseException {
    public $code=404;
    public $msg='请求的Banner不存在';
    public $errorCode=40000;
}