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

class UserClient extends CurlAbstract
{

    protected static $self;
    /**
     * @return UserClient
     * 用于静态方式 单例方式调用类
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
     * 通过col=》val 获取用户信息
     * @param $col string
     *          uid|username|email|mobile|qq|wx
     * @param $val string
     *          col字段对应的值
     * @return bool|mixed|string
     */
    public function info($col,$val){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'col'=>$col,'val'=>$val
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * 帐号注册接口
     * @param $username
     * @param $password
     * @param null $email
     * @return bool|mixed|string
     */
    public function reg($username,$password,$email=null){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'username'=>$username,'password'=>$password,'email'=>$email
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * 手机帐号注册接口
     * @param $username
     * @param $password
     * @param null $email
     * @return bool|mixed|string
     */
    public function mobileReg($mobile,$password){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'mobile'=>$mobile,'password'=>$password
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }


    //type 0:uid 1:用户名 2:邮箱 3:qq 4:wx 5:手机
    public function login($account,$password,$type,$ignorepw=0,$nick='',$head=''){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'account'=>$account,
            'password'=>$password,
            'type'=>$type,
            'ignorepw'=>$ignorepw,
            'nick'=>$nick,
            'head'=>$head,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * @param $uid
     * @param $openid string 第三方登录唯一id
     * @param $action int 1:绑定 2:解绑
     * @param $type 3:qq 4:wx
     * @param string $nick
     * @param string $head
     * @return bool|mixed|string
     */
    public function bind($uid,$openid,$action,$type,$nick='',$head=''){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'openid'=>$openid,
            'action'=>$action,
            'type'=>$type,
            'nick'=>$nick,
            'head'=>$head,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }


    /**
     * @param $uid int
     * @param $condition array
     *          支持以下的一种操作
     *          修改头像
     *              img_id
     *              head
     *          修改昵称
     *              nick
     *          修改手机号
     *              mobile
     *          修改邮箱
     *              email
     *          修改密码
     *              oldpassword
     *              password
     *              ignoreoldpw
     * @return bool|mixed|string
     */
    public function updateUserDetail($uid,$condition = []){
        $predefine_list = [
            'uid','nick','head','img_id','mobile','email','oldpassword','password','ignoreoldpw'
        ];
        $tmp = $condition;
        foreach ($condition as $key=>$val){
            if(!in_array($key,$predefine_list)){
                throw new \Exception('the paramter:'.$key.' unfound in predefine variable');
            }
        }
        if(isset($condition['head']) && !isset($condition['img_id'])){
            throw new \Exception('the col head,img_id must coexist');
        }
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'nick'=>$condition['nick'],
            'head'=>$condition['head'],
            'img_id'=>$condition['img_id'],
            'mobile'=>$condition['mobile'],
            'email'=>$condition['email'],
            'oldpassword'=>$condition['oldpassword'],
            'password'=>$condition['password'],
            'ignoreoldpw'=>$condition['ignoreoldpw']
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}