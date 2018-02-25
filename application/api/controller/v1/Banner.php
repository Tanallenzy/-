<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/15
 * Time: 16:00
 */

namespace app\api\controller\v1;

use app\api\controller\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner {
    /*
     * @url /banner/:id
     * @return mixed
     * */
    public function getBanner($id) {
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if ( !$banner) {
            throw new BannerMissException;
        }
        return json($banner);

    }
}