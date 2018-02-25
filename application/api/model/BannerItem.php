<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel {
    protected $hidden = ['id','img_id','delete_time','banner_id','update_time'];

    public function image() {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
