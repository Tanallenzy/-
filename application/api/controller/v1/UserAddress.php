<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 17:25
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\controller\validate\Address;
use app\api\model\User as UserModel;
use app\api\service\BaseToken as BaseTokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Request;

class UserAddress extends BaseController {
    protected $beforeActionList = [
        'checkPrimaryScope' => [
            'only' => 'createOrUpdateAddress',
        ],
    ];

    /*
     * @url /address
     * @method POST
     * @params 'name','mobile','province','city','country','detail'
     * 通过用户携带的token令牌获取用户的id
     * 通过用户id查找用户是否存在
     * 通过用户查找用户地址是否已创建，如果没有创建则创建，如果创建则更新
     * */
    public function createOrUpdateAddress() {
        (new Address())->goCheck();
        $uid = BaseTokenService::getUserIdByToken();
        $user = UserModel::get($uid);
        if (empty($user)) {
            throw new UserException();
        }
        $dataArr = Request::instance()->only(['name', 'mobile', 'province', 'city', 'country', 'detail']);
        $userAddress = $user->address;
        if ( !$userAddress) {
            $user->address()->save($dataArr);
        } else {
            $user->address->save($dataArr);
        }
        return json(new SuccessMessage(), 201);

    }
}