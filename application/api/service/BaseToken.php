<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/24
 * Time: 0:47
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ScopeException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class BaseToken {
    /*
     * 用三组字符串合拼后进行md5加密生成token令牌
     * */
    protected function makeToken(){
        //32位随机字符串
        $randChar=getRandChar(32);
        //当前时间戳
        $timeStamp=time();
        //加盐
        $salt=config('secure.token_salt');
        return md5($randChar.$timeStamp.$salt);
    }
    /*
     * 根据用户携带的token令牌从缓存中获取客户端需要的数据
     * token约定要从header中传递
     * $key为token对应的缓存中的值转化为数组后对应的key
     * */
    public static function getUserCacheValue($key){
        $token=Request::instance()->header('token');
        $value=Cache::get($token);
        if(!$value){
            throw new TokenException();
        }else{
            if(!is_array($value)){
                $value=json_decode($value,true);
            }
            if(isset($value[$key])){
                return $value[$key];
            }else{
                throw new Exception('尝试获取的Token用户信息不存在');
            }
        }
    }
    /*
     * 从缓存中获取用户id
     * */
    public static function getUserIdByToken(){
        $uid=self::getUserCacheValue('uid');
        return $uid;
    }

    public static function getUserScopeByToken(){
        $scope=self::getUserCacheValue('scope');
        return $scope;
    }

    public static function needPrimaryScope(){
        $scope = self::getUserScopeByToken();
        if($scope){
            if ($scope < ScopeEnum::User) {
                throw new ScopeException();
            }else{
                return true;
            }
        }else{
            throw new TokenException();
        }
    }

    public static function needUserScope(){
        $scope = self::getUserScopeByToken();
        if($scope){
            if ($scope != ScopeEnum::User) {
                throw new ScopeException();
            }else{
                return true;
            }
        }else{
            throw new TokenException();
        }
    }
}