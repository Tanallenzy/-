<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function imgPrefixUrl($value,$data){
        $imgUrl=$value;
        if($data['from']==1){
            $imgUrl=config('setting.img_prefix').$value;
        }
        return $imgUrl;
    }
}
