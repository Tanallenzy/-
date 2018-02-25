<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/16
 * Time: 20:53
 */

namespace app\api\controller\validate;


class IDMustBePositiveInt extends BaseValidate {
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message=[
        'id'=>'id必须为正整数'
    ];
}