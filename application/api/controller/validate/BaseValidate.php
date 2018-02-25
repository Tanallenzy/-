<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/16
 * Time: 21:28
 */

namespace app\api\controller\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function goCheck() {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if ( !$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value) {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value) {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    protected function isMobile($value) {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}