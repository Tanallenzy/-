<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/25
 * Time: 17:41
 */

namespace app\api\controller\v1;


use think\Controller;

class TestAll extends Controller   {
    public function test(){
        $category=\app\api\model\Category::all();
        return json($category[1]->id);
    }
}