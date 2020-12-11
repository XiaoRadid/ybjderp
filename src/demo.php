<?php
use Erppush\Erppush;
require './vendor/autoload.php';

$erpPush = new Erppush([
	'username' 	=> 'test',//账号名
	'password' 	=> 'test',//密码
	'signKey'   => 'db8ebff65c0c5050299dc2bo8a141e5f',//接口密钥
	'checkSign' => 1,//是否启动验签 0否 1是
]);
#### 实现的接口
# getPushData      获取推送过来的数据
# pushOrder        订单推送
# checkOrderImport 检测订单是否推送成功
# orderFinish      订单完成推送
# orderRefund      订单退款推送
# downImages       图片保存

try {
	# 订单推送示例
	$order = array(
		0 => array(
			'order_no'    => '202004261802062000',//订单编号
			'goods_sku'   => 'X08514012',//商品编码
			'goods_name'  => '商品1',//商品名称
			'goods_nums'  => 1,//购买数量
			'remarks'     => '备注1',//备注
			'accept_name' => '张三',//收货人
			'telphone'    => '13025898958',//收货人联系电话
			'province'    => '广东省',//收货人所在省
			'city' 	   	  => '深圳市',//收货人所在市
			'area' 	      => '龙华区',//收货人所在区
			'address' 	  => '龙华街道油富商城',//收货人详细地址
		),
		1 => array(
			'order_no'    => '202004261802062000',
			'goods_sku'   => 'X12812023',
			'goods_name'  => '商品2',
			'goods_nums'  => 1,
			'remarks'     => '备注2',
			'accept_name' => '张三',
			'telphone'    => '13025898958',
			'province'    => '广东省',
			'city' 	   	  => '深圳市',
			'area' 	      => '龙华区',
			'address' 	  => '龙华街道油富商城',
		),
		2 => array(
			'order_no'    => '202004261802062001',
			'goods_sku'   => 'S0214140-3',
			'goods_name'  => '商品3',
			'goods_nums'  => 1,
			'remarks'     => '备注3',
			'accept_name' => '张三3',
			'telphone'    => '13025898958',
			'province'    => '广东省3',
			'city' 	   	  => '深圳市3',
			'area' 	      => '龙华区3',
			'address' 	  => '龙华街道油富商城3',
		),
	);
	$res = $erpPush->pushOrder($order);
	echo "<pre>";var_export($res);die;
	//返回示例
	/*
	$res = array (
	  'code' => 202,//200导入成功，无异常订单  202导入成功，有异常订单
	  'msg' => 'ok',
	  'data' => 
	  array (
	    'order' => //异常订单
	    array (
	      0 => 
	      array (
	        'order_no' => '202004261802062000',//订单号
	        'goods' => 
	        array (
	          0 => 
	          array (
	            'status' => 1,//1：商品不存在 2：商品非上架状态 3：库存不足
	            'goods_no' => 'S00214140-1',
	            'hasoption' => 0,
	          ),
	          1 => 
	          array (
	            'status' => 1,
	            'goods_no' => 'S00214140-2',
	            'hasoption' => 0,
	          ),
	        ),
	      ),
	      1 => 
	      array (
	        'order_no' => '202004261802062001',
	        'goods' => 
	        array (
	          0 => 
	          array (
	            'status' => 1,
	            'goods_no' => 'S00214140-3',
	            'hasoption' => 0,
	          ),
	        ),
	      ),
	    ),
	  ),
	)*/

	# 订单批量推送示例
	/*$order = array(
		0 => array(
			'order_no'    => '202004261802062000',//订单编号
			'goods_sku'   => 'X08514012',//商品编码
			'goods_name'  => '商品1',//商品名称
			'goods_nums'  => 1,//购买数量
			'remarks'     => '备注1',//备注
			'accept_name' => '张三',//收货人
			'telphone'    => '13025898958',//收货人联系电话
			'province'    => '广东省',//收货人所在省
			'city' 	   	  => '深圳市',//收货人所在市
			'area' 	      => '龙华区',//收货人所在区
			'address' 	  => '龙华街道油富商城',//收货人详细地址
		),
		1 => array(
			'order_no'    => '202004261802062000',
			'goods_sku'   => 'X12812023',
			'goods_name'  => '商品2',
			'goods_nums'  => 1,
			'remarks'     => '备注2',
			'accept_name' => '张三',
			'telphone'    => '13025898958',
			'province'    => '广东省',
			'city' 	   	  => '深圳市',
			'area' 	      => '龙华区',
			'address' 	  => '龙华街道油富商城',
		),
		2 => array(
			'order_no'    => '202004261802062001',
			'goods_sku'   => 'S0214140-3',
			'goods_name'  => '商品3',
			'goods_nums'  => 1,
			'remarks'     => '备注3',
			'accept_name' => '张三3',
			'telphone'    => '13025898958',
			'province'    => '广东省3',
			'city' 	   	  => '深圳市3',
			'area' 	      => '龙华区3',
			'address' 	  => '龙华街道油富商城3',
		),
	);
	$res = $erpPush->batchPushOrder($order);
	echo "<pre>";var_export($res);die;
	*/
	//返回示例
	/*
	$res = array (
	  'code' => 200,//200：成功，其他：失败
	  'msg' => '已加入任务队列',
	  'data' => 
	  array (
	  ),
	)*/

	# 订单退款推送示例
	/*$order = array(
		'order_no'    => '2020090108494741124',//订单号
		'full_refund' => 0,//是否整个订单退款：0否, 1是
		'full_remark' => '',//整个订单退款原因
		'goods' => array(
			0 => array(
				'goods_no' => 'x187007001',//商品编码（full_refund参数为0时，必须）
				'remark'   => '不想要了',//退款原因
			)
		),
	); 
	$res = $erpPush->orderRefund($order);
	//返回示例
	$res = array (
	  'code' => 200,
	  'msg' => '订单取消成功',
	)*/

	# 订单完成推送示例
	/*$order = array(
		'order_no'  => '2020090108494741124',
		'goods_sku' => 'x187007001',
	); 
	$res = $erpPush->orderFinish($order);
	//返回示例
	$res = array (
	  'code' => 200,
	  'msg' => '操作成功',
	  'data' => 
	  array (
	  ),
	)*/

	# 检测订单是否推送成功示例
	/*
	$res = $erpPush->checkOrderImport(['202004261802062000','202004261802062001']);
	$res = array (
		  'code' => 200,
		  'msg'  => 'ok',
		  'data' => 
		  array (
		    0 => 
		    array (
		      'orderno' => '202004261802062000',
		      'isexists' => true,//bool true：导入成功 false：导入失败
		    ),
		    1 => 
		    array (
		      'orderno' => '202004261802062001',
		      'isexists' => true,
		    ),
		),
	);
	echo "<pre>";var_export($res);die;
	//返回参数说明
	$res = array (
	  'code' => 200,
	  'msg' => 'ok',
	  'data' => 
	  array (
	    0 => 
	    array (
	      'orderno' => '202004261802062000',
	      'isexists' => true,//true存在 false不存在
	    ),
	    1 => 
	    array (
	      'orderno' => '202004261802062001',
	      'isexists' => true,
	    ),
	  ),
	)*/


	# 图片保存示例
	/*
	$path   = 'data/image/';//保存目录
	$imgurl = $erpPush->downImages('https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1607513621953&di=938d0bfa4b5e45a601e136cdf1f3188d&imgtype=0&src=http%3A%2F%2F5b0988e595225.cdn.sohucs.com%2Fimages%2F20180906%2F1926d16a272a49f5b8cbafdc2d68628c.png',$path);
	$imgurl = data/image/20201010115636upload_pic_1602302196011_0.jpg
	*/

	# 获取推送数据
	// $res = $erpPush->getPushData();
	// echo "<pre>";var_export($res);die;

	/**
	 * getPushData将返回以下几种数据
	 */
	
	/*1，库存变更推送
	$res = array (
	  'code'   => 'X17502008',//商品编码
	  'stock'  => '200',//库存
	  'signed' => '0c5809c8eaf3179693cc8b05e7795966',
	)*/

	/*2，商品上下架推送
	$res = array (
	  'code'   => 'X17502008',//商品编码
	  'status' => 0,//0下架 1上架
	  'signed' => 'd4d39660d6152d7c59ba4705092b2ba8',
	)*/

	/*3，商品信息修改推送
	$res = array (
	  'goods' => 
	   array (
	    0 => array (
		      'content' => '<p> <img src="http://img.xiaoyuchaoshi.com/upload/20201022/1603358387211672259.jpg" title="upload/20201022/1603358387211672259.jpg" alt="1603358387211672259.jpg" /></p>',//详情
		      'stock' => '1000',//库存
		      'name'  => '2020新款纯色仿羊绒冬季保暖女士围巾单色围脖流苏披肩 200cm',//标题
		      'img'   => 'http://img.xiaoyuchaoshi.com/upload/20201022171913b97ff59fc92dd7443626af97ecd39d78.image/jpeg',//封面
		      'sell_price' => '23.82',//市场价
		      'cost_price' => '11.00',//不含税供货价
		      'cost_price_hs' => '12.00',//含税供货价
		      'goods_no' => 'test',//编码
		      'barcode'  => '',//条码
		      'marketprice' => '23.82',//市场价
		      'mainImages' => array (//商品主图
		        0 => 'http://img.xiaoyuchaoshi.com/upload/20201022171913b97ff59fc92dd7443626af97ecd39d78.jpeg',
		        1 => 'http://img.xiaoyuchaoshi.com/upload/202010221719133a6d9b1ea3f89691408ffa2ce078181a.jpeg',
		        2 => 'http://img.xiaoyuchaoshi.com/upload/20201022171913ba2a1617dd41cdfb85d6348e25967e0e.jpeg',
		        3 => 'http://img.xiaoyuchaoshi.com/upload/202010221719139609533dbe334901ac05cdc558931362.jpeg',
		      ),
		      'params' =>array ( //商品参数
				  '参数名1' => '参数值',
				  '参数名2' => '参数值2',
				),
		      'specs' => array ( //规格
		        0 => array (
		          'name1' => '颜色',//规格1名称（最多两个规格）
		          'name2'=>'尺寸',//规格2名称
		          'sku1' => 'baby粉',//规格1值
		          'sku2' => '20码（内长19厘米）4-5岁',//规格2值
		          'sell_price' => '23.82',//市场价
		          'cost_price' => '11.00',//成本价
		          'cost_price_hs' => '12.00',
		          'skucode' => 'test-1',//规格编码
		          'barcode' => '',//规格条码
		          'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/upload/20201022/20201022053353261.jpg',//规格图片
		          'stock' => '200',//库存
		          'marketprice' => '23.82',//市场价
		        ),
		        1 => array (
		          'name1' => '颜色',
		          'name2'=>'尺寸',
		          'sku1' => 'baby粉',
		          'sku2' => '20码（内长19厘米）4-5岁',
		          'sell_price' => '23.82',
		          'cost_price' => '11.00',
		          'cost_price_hs' => '12.00',
		          'skucode' => 'test-2',
		          'barcode' => '',
		          'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/upload/20201022/20201022053356756.jpg',
		          'stock' => '200',
		          'marketprice' => '23.82',
		        )
		      ),
		      'status' => 1,//0下架 1上架
		    ),
		),
		  'signed' => '7ca1807f32d0308c9d2b88dada175905',
	  )
	*/

	/*4，商品优选推送
	$res = array (
	  'goods' => 
	   array (
	    0 => array (
		      'content' => '<p> <img src="http://img.xiaoyuchaoshi.com/upload/20201022/1603358387211672259.jpg" title="upload/20201022/1603358387211672259.jpg" alt="1603358387211672259.jpg" /></p>',//详情
		      'stock' => '1000',//库存
		      'name'  => '2020新款纯色仿羊绒冬季保暖女士围巾单色围脖流苏披肩 200cm',//标题
		      'img'   => 'http://img.xiaoyuchaoshi.com/upload/20201022171913b97ff59fc92dd7443626af97ecd39d78.image/jpeg',//封面
		      'sell_price' => '23.82',//市场价
		      'cost_price' => '11.00',//不含税供货价
		      'cost_price_hs' => '12.00',//含税供货价
		      'goods_no' => 'test',//编码
		      'barcode'  => '',//条码
		      'marketprice' => '23.82',//市场价
		      'mainImages' => array (//商品主图
		        0 => 'http://img.xiaoyuchaoshi.com/upload/20201022171913b97ff59fc92dd7443626af97ecd39d78.jpeg',
		        1 => 'http://img.xiaoyuchaoshi.com/upload/202010221719133a6d9b1ea3f89691408ffa2ce078181a.jpeg',
		        2 => 'http://img.xiaoyuchaoshi.com/upload/20201022171913ba2a1617dd41cdfb85d6348e25967e0e.jpeg',
		        3 => 'http://img.xiaoyuchaoshi.com/upload/202010221719139609533dbe334901ac05cdc558931362.jpeg',
		      ),
		      'params' =>array ( //商品参数
				  '参数名1' => '参数值',
				  '参数名2' => '参数值2',
				),
		      'specs' => array ( //规格
		        0 => array (
		          'name1' => '颜色',//规格1名称（最多两个规格）
		          'name2'=>'尺寸',//规格2名称
		          'sku1' => 'baby粉',//规格1值
		          'sku2' => '20码（内长19厘米）4-5岁',//规格2值
		          'sell_price' => '23.82',//市场价
		          'cost_price' => '11.00',//成本价
		          'cost_price_hs' => '12.00',
		          'skucode' => 'test-1',//规格编码
		          'barcode' => '',//规格条码
		          'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/upload/20201022/20201022053353261.jpg',//规格图片
		          'stock' => '200',//库存
		          'marketprice' => '23.82',//市场价
		        ),
		        1 => array (
		          'name1' => '颜色',
		          'name2'=>'尺寸',
		          'sku1' => '水果咖色',
		          'sku2' => '22码（内长20厘米）6-7岁',
		          'sell_price' => '23.82',
		          'cost_price' => '11.00',
		          'cost_price_hs' => '12.00',
		          'skucode' => 'test-2',
		          'barcode' => '',
		          'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/upload/20201022/20201022053356756.jpg',
		          'stock' => '200',
		          'marketprice' => '23.82',
		        )
		      ),
		      'status' => 1,//0下架 1上架
		    ),
		),
		  'signed' => '7ca1807f32d0308c9d2b88dada175905',
	  )*/

	/*5，订单发货推送
	$res = array (
	  'orders' => 
	  array (
	    0 => 
	    array (
	      'orderno' => '2020090108494741124',//订单号
	      'ferights' => 
	      array (
	        0 => 
	        array (
	          'goodsno' => 'x187007001',//商品编码
	          'code' => 'YT9330740382155',//物流单号
	          'expresssn' => 'yuantongkuaiyun',//物流编码（参考快递100）
	          'express' => '圆通快运',//物流公司
	        ),
	      ),
	    ),
	  ),
	  'signed' => '2a7da6c4851217a03690429c5b22780c',
	)*/

	/*6，订单退款推送
	$res = array (
	  'order_no' => '2020090108494741124',//订单号
	  'goods' => 
	  array (
	    0 => 
	    array (
	      'goods_no' => 'x187007001',//商品编码
	      'remark' => '不想要了',//退款原因备注
	    ),
	  ),
	  'signed' => '2323071fe762223bb19dcd45b098ceef',
	)*/

	/*7，订单异常推送
	$res = array (
	  'order' => 
	  array (
	    0 => 
	    array (
	      'order_no' => 'SD20201019162929962617',//订单号
	      'goods' => 
	      array (
	        0 => 
	        array (
	          'goods_no'  => 'X04114009',//商品编码
	          'hasoption' => 1,//是否多规格
	          'isexists'  => 1,//商品是否存在
	        ),
	      ),
	    ),
	  ),
	  'signed' => '9e4022efa5112197a5589b647950e404',
	)*/

	/*8,更换订单商品推送
	$res =  array (
      'isSynch' => 0,//表示商品是否已同步；isSynch=0，返回更换后商品数据newGoodsData
   	  'oldGoodsNo' => 'X22007117',//更换前商品编码
      'newGoodsNo' => 'X22007117-1',//更换后商品编码
	  'newGoodsData' => //字段说明参考 =》 4，商品优选推送
	  array (
	    'content' => '<p><br></p><p><img src="http://img.xiaoyuchaoshi.com/upload/20201019/1603073119152404126.jpg" title="upload/20201019/1603073119152404126.jpg" alt="1603073119152404126.jpg"></p></p><p><br></p>',
	    'stock' => '600',
	    'name' => '【掰掰热暖手宝】学生卡通掰掰乐便携暖宝宝自发热防寒保暖贴暖贴',
	    'img' => 'http://img.xiaoyuchaoshi.com/upload/20201019104412a2eaba1a63b1a99dd8c99cac6c96874.image/png',
	    'sell_price' => '12.00',
	    'cost_price' => '15.30',
	    'cost_price_hs' => '15.60',
	    'goods_no' => 'X22007117',
	    'barcode' => '165665165165',
	    'marketprice' => '12.00',
	    'mainImages' => 
	    array (
	      0 => 'http://img.xiaoyuchaoshi.com/upload/20201019104412a2eaba1a6b1adfd99dd8c99c874.image/png',
	      1 => 'http://img.xiaoyuchaoshi.com/upload/2020101910441caa5b830f1ae6e983866505a0068.image/png',
	    ),
	    'params' => '',
	    'specs' => 
	    array (
	      0 => 
	      array (
	        'name1' => '颜色',
	        'sku1' => '随机款式一个装【不划算】',
	        'sell_price' => '12.00',
	        'cost_price' => '4.30',
	        'cost_price_hs' => '4.60',
	        'skucode' => 'X22007117-1',
	        'barcode' => '85928290247830 ',
	        'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/',
	        'stock' => '200',
	        'marketprice' => '12.00',
	      ),
	      1 => 
	      array (
	        'name1' => '颜色',
	        'sku1' => '随机款式两个装【实惠装】',
	        'sell_price' => '12.00',
	        'cost_price' => '8.80',
	        'cost_price_hs' => '9.20',
	        'skucode' => 'X22007117-2',
	        'barcode' => '45928290268389 ',
	        'thumb' => 'http://fs.beta.xiaouyuchaoshi.com/',
	        'stock' => '200',
	        'marketprice' => '12.00',
	      )
	    ),
	    'status' => 1,
	  ),
	  'signed' => '312eb629cce67f4ab685b8116fb7ca61',
	)*/

}catch (\Exception $e) {
	#### code集合
	#'-1'  => '系统繁忙，请稍后重试',
	#'0'   => '操作失败',
	#'1'   => '操作成功',
	#'101' => '接口返回数据异常！',
	#'102' => '签名错误',
	#'103' => '参数错误',
	#'104' => '获取token失败',
	#'105' => '配置有误',
	#'106' => '目录创建失败',
	#'201' => '请求失败',
	#'203' => '用户验证失败，请重新登录',
	#'204' => '请求失败',
	#'205' => '缺少必要参数TOKEN',
	#'206' => '账号不存在',
	#'207' => '没有访问权限',
	echo $e->getCode().'='.$e->getMessage();die;
}
