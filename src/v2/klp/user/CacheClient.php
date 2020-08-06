<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace hupfc\k8t\src\v2\klp\user;



use hupfc\k8t\src\Config;
use hupfc\k8t\src\CurlAbstract;

class CacheClient extends CurlAbstract
{

    protected static $self;

    /**
     * @return self
     * 用于静态方式 单例方式调用类
     * @throws \Exception
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['klp']['user'].'/cache/';
        return self::$self;
    }

    public $uri;

    public function clearUserInfo($uid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}