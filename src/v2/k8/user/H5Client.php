<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace hupfc\k8t\src\v2\k8\user;



use hupfc\k8t\src\Config;
use hupfc\k8t\src\CurlAbstract;

class H5Client extends CurlAbstract
{

    protected static $self;

    /**
     * @return H5Client
     * 用于静态方式 单例方式调用类
     * @throws \Exception
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['k8']['user'].'/user/';
        return self::$self;
    }

    public $uri;


    /**
     * 获取随机account用于h5账号注册
     */
    public function getAccount(){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data=[];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }


    /**
     *
     * @param string $h5_uid
     * @param string $app_id
     * @param int $uid  没有给0
     * @param array $params=['channel'=>'','subchannel'=>'','source'=>''] 累加等公共参数数组
     * @return bool|mixed|string
     */
    public function bind($h5_uid,$app_id,$uid,$params=[]){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'h5_uid'=>$h5_uid,
            'app_id'=>$app_id,
            'uid'=>$uid,
        ];
        $data = array_merge($data,$params);
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}