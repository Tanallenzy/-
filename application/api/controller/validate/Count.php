<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 0:45
 */

namespace app\api\controller\validate;


class Count extends BaseValidate {
    protected $rule=[
        'count'=>'isPositiveInteger|between:1,16'
    ];
}