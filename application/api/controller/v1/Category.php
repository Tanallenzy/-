<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 12:55
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryMissException;

class Category {
    /*
     * @url /category/all
     * @return mixed
     * */
    public function getCategories(){
        $categories=CategoryModel::getAllCategories();
        if(!$categories){
            throw new CategoryMissException();
        }
        return json($categories);
    }
}