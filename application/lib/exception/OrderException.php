<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/25
 * Time: 17:15
 */

namespace app\lib\exception;


class OrderException extends BaseException {
    public $code=404;
    public $msg='商品不存在，请检查id';
    public $errorCode=80000;
}