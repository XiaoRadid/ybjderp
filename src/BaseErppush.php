<?php
/**
 *
 * 版权所有：原本简单
 * 作    者：wangguanxiao
 * 日    期：2020-11-19
 * 功能说明：BaseErppush
 *
 **/
namespace Erppush;
use Erppush\Services\Curl;
use Erppush\Exception\WeException;

class BaseErppush
{
    
    const APIHOST = 'http://erp-platform.beta.xiaoyuchaoshi.com/';//请求API域名
    const DIR = __DIR__; //所在目录

    protected static $token; //token
    protected $username; //账号
    protected $password; //密码
    protected $signKey; //接口密钥
    protected $checkSign = 0; //密钥验证开关 默认关闭

    public function __construct($config = array())
    {   
        $this->username  = $config['username'];
        $this->password  = $config['password'];
        $this->signKey   = $config['signKey'];
        $this->checkSign = $config['checkSign'] ? 1 : 0;
    }
    /**
     * getMillisecond 获取毫秒级别的时间戳
     * @return float
     */
    protected function getMillisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }

    /**
     * generateErpSigned 生成签名
     * @param $params
     * @return string
     */
    private function generateErpSigned($params=array()) {

        ksort($params);
        $encreptStr = [];
        foreach($params as $key => $val) {

            if($key == "signed") continue;

            if($key != "goods") {
                $encreptStr[]= "$key=$val";
            }else {
                ksort($val);
                $encreptStr[] = "$key=" . json_encode($val);
            }
                
        }
        $encreptStr[] = "key=" . $this->signKey;
        return md5(implode("&", $encreptStr));
    }


    /**
     * @param WxPayConfigInterface $config 配置对象
     * 检测签名
     */
    protected function checkSign($data)
    {
        if ($this->generateErpSigned($data) == $data['signed']) {
            return true;
        }
        throw new WeException(102);
    }

    /**
     * 获取TOKEN
     * @return string
     */
    protected function getToken($data=array()) {
        if(!empty(self::$token)){
            return self::$token;
        }
        if(empty($this->username) && empty($this->password))
            throw new WeException(105, 'username或password未配置');

        $url   = self::APIHOST . 'index.php?controller=admin&action=login_act';
        $param = array(
            'admin_name' => $this->username,
            'password'   => $this->password,
        );
        $curlClass = new Curl();
        $res = $curlClass->httpRequest($url, 'post', $param);
        $res = json_decode($res, 1);
        
        if($res['code'] != 200)
            throw new WeException(104, $res['msg']);

        self::$token = $res['data']['token'];
        return self::$token;
    }

    protected function mkdirs($path) {

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        return is_dir($path);
    }


}