<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 17:36
 */

namespace app\api\controller\validate;


class TokenGet extends BaseValidate {
    protected $rule=[
        'code'=>'require|isNotEmpty'
    ];

    protected $message=[
        'code'=>'传入的code不能为空'
    ];
}