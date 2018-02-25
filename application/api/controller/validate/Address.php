<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 17:23
 */

namespace app\api\controller\validate;


class Address extends BaseValidate {
    protected $rule=[
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];
}