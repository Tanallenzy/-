<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/18
 * Time: 18:41
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandle extends Handle {
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e) {
        if ($e instanceof BaseException) {
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
            $this->code = $e->code;
        } else {
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->msg = '服务器错误';
                $this->errorCode = 999;
                $this->code = 500;
                $this->recordErrorLog($e);
            }
        }
        $error = [
            'msg'         => $this->msg,
            'errorCode'   => $this->errorCode,
            'request_url' => Request::instance()->url(),
        ];
        return json($error, $this->code);
    }

    private function recordErrorLog(Exception $e) {
        Log::init([
            'type'  => 'File',
            'path'  => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }
}