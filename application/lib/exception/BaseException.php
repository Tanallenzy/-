<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/17
 * Time: 23:33
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception {
    public $code;
    public $msg;
    public $errorCode;

    public function __construct($arr=[]){
        if(!is_array($arr)){
            return false;
        }else{
            if(isset($arr['code'])){
                $this->code=$arr['code'];
            }
            if(isset($arr['msg'])){
                $this->msg=$arr['msg'];
            }
            if(isset($arr['errorCode'])){
                $this->errorCode=$arr['errorCode'];
            }
        }
    }
}