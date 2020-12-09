#### 安装(PHP>=5.3.29)
composer require ybjd/erppush
  
#### 实现的接口
getPushData      获取推送过来的数据  
pushOrder        订单推送  
checkOrderImport 检测订单是否推送成功  
orderFinish      订单完成推送  
orderRefund      订单退款推送  
downImages       图片保存  
  
#### 示例
```php
use ybjd/erppush;

$erpPush = new Erppush([
    'username'  => 'test',//账号名
    'password'  => 'test',//密码
    'signKey'   => 'db8ebff65c0c5050299dc2b35a141e1f',//接口密钥
    'checkSign' => 1,//是否启动验签 0否 1是
]);
try {
    //订单推送示例
    $order = array(
        0 => array(
            'order_no'    => '202004261802062000',//订单编号
            'goods_sku'   => 'S00214140-1',//商品编码
            'goods_name'  => '商品1',//商品名称
            'goods_nums'  => 1,//购买数量
            'remarks'     => '备注1',//备注
            'accept_name' => '张三',//收货人
            'telphone'    => '13025898958',//收货人联系电话
            'province'    => '广东省',//收货人所在省
            'city'        => '深圳市',//收货人所在市
            'area'        => '龙华区',//收货人所在区
            'address'     => '龙华街道油富商城',//收货人详细地址
        ),
        1 => array(
            'order_no'    => '202004261802062000',
            'goods_sku'   => 'S00214140-2',
            'goods_name'  => '商品2',
            'goods_nums'  => 1,
            'remarks'     => '备注2',
            'accept_name' => '张三',
            'telphone'    => '13025898958',
            'province'    => '广东省',
            'city'        => '深圳市',
            'area'        => '龙华区',
            'address'     => '龙华街道油富商城',
        ),
        2 => array(
            'order_no'    => '202004261802062001',
            'goods_sku'   => 'S00214140-3',
            'goods_name'  => '商品3',
            'goods_nums'  => 1,
            'remarks'     => '备注3',
            'accept_name' => '张三3',
            'telphone'    => '130258989583',
            'province'    => '广东省3',
            'city'        => '深圳市3',
            'area'        => '龙华区3',
            'address'     => '龙华街道油富商城3',
        ),
    );
    $res = $erpPush->pushOrder($order);
  
}catch (\Exception $e) {
    echo $e->getCode().'='.$e->getMessage();die;
}
```
#### code集合  
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


