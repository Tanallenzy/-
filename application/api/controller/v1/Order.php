<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 23:16
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\controller\validate\OrderPlace;
use app\api\service\BaseToken as BaseTokenService;

class Order extends BaseController {
    protected $beforeActionList = [
        'checkUserScope' => [
            'only' => 'placeOrder',
        ],
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $oProducts=input('post.products/a');
        $uid=BaseTokenService::getUserIdByToken();
        $order=new \app\api\service\Order();
        $orderStatus=$order->place($uid,$oProducts);
        return json($orderStatus);
    }
}