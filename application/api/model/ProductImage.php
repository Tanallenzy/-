<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 15:39
 */

namespace app\api\model;


class ProductImage extends BaseModel {
    protected $hidden=['img_id','delete_time','product_id'];
    public function image(){
        return $this->belongsTo('Image','img_id','id');
    }
}