<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/23
 * Time: 16:10
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends BaseToken {
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config('wx.AppID');
        $this->wxAppSecret = config('wx.AppSecret');
        $this->wxLoginUrl = sprintf(config('wx.LoginUrl'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    /*
     * 使用curl方法通过微信api获取用户信息(openid,session_key)
     * 通过openid获取用户的token令牌，并将用户信息存入缓存中，缓存使用tp5默认驱动
     * */
    public function get() {
        $result = curl_get($this->wxLoginUrl);
        $result = json_decode($result, true);
        if (empty($result)) {
            throw new Exception('获取session_key及openID时异常');
        } else {
            if (isset($result['errcode'])) {
                throw new WeChatException([
                    'errorCode' => $result['errcode'],
                    'msg'       => $result['errmsg'],
                ]);
            } else {
                return $this->getTokenByOpenId($result);
            }
        }
    }

    /*
     * 获取openid
     * 判断用户的openid是否存在于user表中，若不存在则新建用户，并获取用户id
     * 准备写入缓存的数据：微信服务器放回的用户信息，用户id，用户权限scope
     * 创建token令牌，并以token令牌为key，上述数据为value写入缓存
     * 返回token令牌
     * */
    private function getTokenByOpenId($result) {
        $openId = $result['openid'];
        $user = UserModel::getUserByOpenId($openId);
        if ($user) {
            $uid = $user->id;
        } else {
            $user = UserModel::createUser(['openid' => $openId]);
            $uid = $user->id;
        }
        $cacheValue = $this->prepareCacheValue($result, $uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
    }

    private function prepareCacheValue($result, $uid) {
        $cacheValue = $result;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
    }

    /*
     * key为token令牌
     * cacheValue为用户数据
     * tokenExpire为缓存过期时间
     * */
    private function saveToCache($cacheValue) {
        $key = $this->makeToken();
        $cacheValue = json_encode($cacheValue);
        $tokenExpire = config('setting.token_expire_in');
        $request = cache($key, $cacheValue, $tokenExpire);
        if ( !$request) {
            throw new TokenException([
                'code'      => '500',
                'msg'       => '缓存错误',
                'errorCode' => 10005,
            ]);
        }
        return $key;
    }
}