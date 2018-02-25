<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/22
 * Time: 18:06
 */

namespace app\api\controller\validate;


class IDMustBePositiveArray extends BaseValidate {
    protected $rule=[
      'id'=>'require|isPositiveArray'
    ];

    protected $message=[
        'id'=>'id必须是以多个逗号分隔的正整数'
    ];

    protected function isPositiveArray($value){
        $ids=explode(',',$value);
        if(empty($ids)){
            return false;
        }
        foreach ($ids as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}