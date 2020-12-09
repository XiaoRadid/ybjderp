<?php
/**
 *
 * 版权所有：原本简单
 * 作    者：wangguanxiao
 * 日    期：2020-11-19
 * 功能说明：异常类
 *
 **/
namespace Erppush\Exception;
class WeException extends \Exception
{
    public static $errorMessage = [
        '-1'  => '系统繁忙，请稍后重试',
        '0'   => '操作失败',
        '1'   => '操作成功',
        '101' => '接口返回数据异常！',
        '102' => '签名错误',
        '103' => '参数错误',
        '104' => '获取token失败',
        '105' => '配置有误',
        '106' => '目录创建失败',
        '201' => '请求失败',
        '203' => '用户验证失败，请重新登录',
        '204' => '请求失败',
        '205' => '缺少必要参数TOKEN',
        '206' => '账号不存在',
        '207' => '没有访问权限',
    ];

    public static $defaultMessage = '未知错误';

    public function __construct($code = 0, $message = "")
    {
        if ($message === "") {
            $message = static::$errorMessage[$code] ? static::$errorMessage[$code] : static::$defaultMessage;
        }
        parent::__construct($message, $code);
    }
}