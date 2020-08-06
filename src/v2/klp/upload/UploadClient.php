<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace hupfc\k8t\src\v2\klp\upload;



use hupfc\k8t\src\Config;
use hupfc\k8t\src\CurlAbstract;

class UploadClient extends CurlAbstract
{

    protected static $self;
    /**
     * @return self
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['klp']['upload'].'/img/';
        return self::$self;
    }

    public $uri;

    public function checkMd5($md5){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'md5'=>$md5,
        ];
        $params = array_merge($this->params,$options);
        return $this->post($url,$params);
    }


    public function uploadByFile(
        $max_size=5242880,
        $allow_type=array(
            'image/gif',
            'image/jpg',
            'image/bmp',
            'image/png',
            'image/jpeg')
    ){
        $url = $this->uri . 'upload?'.http_build_query($this->params);
        if(!$_FILES){
            throw new \Exception('图片不存在');
        }
        $curlFiles=[];
        if(!function_exists('exif_imagetype')){
            throw new \Exception('服务器缺少exif扩展');
        }
        foreach ($_FILES as $key=>$val){
            if($val['size'] > $max_size){
                throw new \Exception('图片太大');
            }
            $mime = exif_imagetype($val['tmp_name']);
            $mime = image_type_to_mime_type($mime);
            if(!in_array($mime,$allow_type)){
                throw new \Exception('只允许上传jpg,bmp,jpg,png格式的图片');
            }
            $curlFiles[$key]=new \CURLFile($val['tmp_name']);
        }
        $rs = $this->postImage($url,$curlFiles);
        return $rs;
    }
}