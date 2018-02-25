<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 23:07
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\BaseToken as BaseTokenService;

class BaseController extends Controller {

    protected function checkPrimaryScope() {
        BaseTokenService::needPrimaryScope();
    }

    protected function checkUserScope(){
        BaseTokenService::needUserScope();
    }
}