<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/22
 * Time: 17:59
 */

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden = ['delete_time', 'update_time', 'create_time', 'img_id', 'category_id', 'from', 'pivot'];

    protected function getMainImgUrlAttr($value, $data) {
        return $this->imgPrefixUrl($value, $data);
    }

    public function productImage() {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function productProperty() {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getNewProductsByCT($count) {
        return self::limit($count)->order('create_time desc')->select();
    }

    public static function getByCategoryId($id) {
        return self::where('category_id', '=', $id)->select();
    }

    /*public static function getDetailById($id){
        return self::with(['productImage.image','productProperty'])->find($id);
    }*/

    public static function getDetailById($id) {
        return self::with([
            'productImage' => function ($query) {
                $query->with(['image'])->order('order');
            },
        ])
            ->with(['productProperty'])
            ->find($id);
    }
}