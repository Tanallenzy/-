<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/22
 * Time: 17:58
 */

namespace app\api\controller\v1;


use app\api\controller\validate\IDMustBePositiveArray;
use app\api\controller\validate\IDMustBePositiveInt;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeMissException;

class Theme {
    /*
     * @url /theme?id=1,2,3
     * @return 一组theme模型数据集合
     * */
    public function getThemes($id=''){
        if($id!=''){
            (new IDMustBePositiveArray())->goCheck();
            $themes=ThemeModel::getThemesById($id);
        }else{
            $themes=ThemeModel::getThemesById($id);
        }
        if(!$themes){
            throw new ThemeMissException();
        }
        return json($themes);
    }

    /*
     * @url /theme/:id
     * @return mixed
     * */
    public function getProducts($id){
        (new IDMustBePositiveInt())->goCheck();
        $products=ThemeModel::getProductsByThemeId($id);
        if(!$products){
            throw new ThemeMissException();
        }
        return json($products);
    }
}