<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 10:51
 */

namespace hupfc\k8t\src;

/**
 * Class Config
 * @package hupfc\k8t\src
 * 配置初始化，必须调用Config::setParams  Config::setDomain 其他函数可以不使用
 */
class Config
{
    //客户端类型
    const K8PC =1;
    const K8AQ =2;
    const K8M =3;
    const K8XYX=4;
    const K8M_ADMIN=5;

    //kLP从100开始
    const KLPPC = 100;

    public static $log_options=[
        'env'=>'prod',
        'map'=>[
            'error','warning','info','debug'
        ],
        'type'=>'file',
        'level'=>['error','warning','info','debug'],
        'file'=>[
            'path'=>__DIR__.'/psr.log'
        ]
    ];

    public static $params = [
        'userip'=>'test',//用户ip
        'clientip'=>'test',//客户端服务器ip
        'clienttype'=>0,//客户端业务类型 1:user.mc 2:联机平台
        'key' => '',//key 密钥
        'uid' => 0,//用户uid
    ];

    public static $domain = [
        'k8'=>[
            'user'=>'domain',
            'upload'=>'domain',
        ],
        'klp'=>[
            'user'=>'domain',
            'upload'=>'domain',
        ],
    ];

    public static function setParams($params){
        self::$params = array_merge(self::$params,$params);
    }

    public static function setLogOptions($options){
        self::$log_options = array_merge(self::$log_options,$options);
    }

    public static function setDomain($domain){
        self::$domain = array_merge(self::$domain,$domain);
    }
}