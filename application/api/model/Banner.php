<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/17
 * Time: 17:55
 */

namespace app\api\model;


use think\Model;

class Banner extends BaseModel {
    protected $hidden = ['delete_time', 'update_time'];

    public function bannerItem() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerById($id) {
        $banner = self::with(['bannerItem', 'bannerItem.image'])->find($id);
        return $banner;
    }
}