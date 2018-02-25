<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/22
 * Time: 17:59
 */

namespace app\api\model;


class Theme extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'topic_img_id', 'head_img_id'];

    public function topicImg() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg() {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products() {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemesById($id) {
        if ($id != '') {
            $ids = explode(',', $id);
            return self::with(['topicImg', 'headImg'])->select($ids);
        } else {
            return self::with(['topicImg', 'headImg'])->select();
        }
    }

    public static function getProductsByThemeId($id) {
        return self::with(['products', 'topicImg', 'headImg'])->find($id);
    }
}