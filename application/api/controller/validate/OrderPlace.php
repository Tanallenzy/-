<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/25
 * Time: 2:00
 */

namespace app\api\controller\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate {
    //OrderPlace验证器类的验证规则
    protected $rule = [
        'products' => 'checkProducts',
    ];
    //独立验证的验证规则
    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count'      => 'require|isPositiveInteger',
    ];

    //自定义验证规则checkProduct
    protected function checkProducts($values) {
        //判断客户端传过来的参数是否为数组
        if ( !is_array($values)) {
            throw new ParameterException([
                'msg' => '商品参数不正确',
            ]);
        }
        //判断数组是否为空
        if (empty($values)) {
            throw new ParameterException([
                'msg' => '商品参数不能为空',
            ]);
        }
        //判断二维数组中的参数是否符合规范
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    //采用独立验证的方式对二维数组中的参数进行校验
    protected function checkProduct($value) {
    $validate = new BaseValidate($this->singleRule);
    $result = $validate->batch()->check($value);
    if ( !$result) {
        throw new ParameterException([
            'msg' => '商品参数不正确',
        ]);
    } else {
        return true;
    }
}
}