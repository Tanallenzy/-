<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 0:44
 */

namespace app\api\controller\v1;


use app\api\controller\validate\Count;
use app\api\controller\validate\IDMustBePositiveInt;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductMissException;

class Product {
    /*
     * @url /product/new?count=int int between 1,16
     * @return mixed
     * */
    public function getNewProducts($count = 16) {
        (new Count())->goCheck();
        $products = ProductModel::getNewProductsByCT($count);
        if ( !$products) {
            throw new ProductMissException();
        }
        $products = collection($products)->hidden(['summary']);
        return json($products);
    }

    /*
     * @url /product/byCategory/:id
     * @return 当前分类id对应的商品信息
     * */
    public function getByCategory($id) {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getByCategoryId($id);
        if ( !$products) {
            throw new ProductMissException();
        }
        $products = collection($products)->hidden(['summary']);
        return json($products);
    }

    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $product=ProductModel::getDetailById($id);
        if(!$product){
            throw new ProductMissException();
        }
        $product = $product->hidden(['summary']);
        return json($product);
    }
}