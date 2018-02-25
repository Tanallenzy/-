<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 12:55
 */

namespace app\api\model;


class Category extends BaseModel {
    protected $hidden = ['delete_time', 'update_time'];

    public function images() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getAllCategories() {
        return self::with('images')->select();
    }
}