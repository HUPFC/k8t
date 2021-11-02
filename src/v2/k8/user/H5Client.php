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
        self::$self->uri = Config::$domain['k8']['user'].'/h5/';
        return self::$self;
    }

    public $uri;


    /**
     * 获取随机account用于h5账号注册
     * @param string $app_id
     * @param array $params 公共参数(见jira)
     */
    public function getAccount($app_id,$params=[]){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data=[
            'app_id'=>$app_id,
        ];
        $data = array_merge($data,$params);
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

    /*
     * 通过appid 和h5_uid 获取uid
     * @param string $h5_uid
     * @param string $app_id
     * @return array
     */
    public function getInfoByAppIDH5Uid($h5_uid,$app_id){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'h5_uid'=>$h5_uid,
            'app_id'=>$app_id,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * @param $h5_uid int
     * @param $condition array
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function update($h5_uid,$condition = []){
        $predefine_list = [
            'h5_uid','app_id','uid','status','real_info','adult_time','real_daytime'
        ];
        foreach ($condition as $key=>$val){
            if(!in_array($key,$predefine_list)){
                throw new \Exception('the paramter:'.$key.' unfound in predefine variable');
            }
        }
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'h5_uid'=>$h5_uid,
            'app_id'=>$condition['app_id'],
            'uid'=>$condition['uid'],
            'status'=>$condition['status'],
            'real_info'=>$condition['real_info'],
            'adult_time'=>$condition['adult_time'],
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /*
     * 通过clo=>val 获取用户信息
     */
    public function info($col,$val){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'col'=>$col,'val'=>$val
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}