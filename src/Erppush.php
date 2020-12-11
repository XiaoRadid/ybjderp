<?php
/**
 *
 * 版权所有：原本简单
 * 作    者：wangguanxiao
 * 日    期：2020-11-19
 * 功能说明：Erppush
 *
 **/
namespace Erppush;
use Erppush\Services\Curl;
use Erppush\Exception\WeException;

class Erppush extends BaseErppush{

	/**
	 * 订单推送
	 * @return array
	 */
	public function pushOrder($data=array()) {
		if(!is_array($data) || empty($data)){
			throw new WeException(103);
		}
		$order = array();
		foreach ($data as $k => $v) {
			$order[$v['order_no']][] = $v;
		}

		$param = array();
		foreach ($order as $ov) {
			$goods = array();
			foreach ($ov as $gk) {
				$goods[] = array(
					'goods_sku'  => $gk['goods_sku'],
					'goods_name' => $gk['goods_name'],
					'goods_nums' => $gk['goods_nums'],
					'remarks' 	 => $gk['remarks'],
				);
			}
			$param[] = array(
				'order_no' => $gk['order_no'],
				'goods'    => $goods,
				'accept_name' => $gk['accept_name'],
				'telphone'    => $gk['telphone'],
				'province'    => $gk['province'],
				'city'    => $gk['city'],
				'area'    => $gk['area'],
				'address' => $gk['address'],
			);
		}
		$url   = self::APIHOST . 'index.php?controller=order&action=third_push_order';
		$curlClass = new Curl();
		$postData  = array('order_data' => json_encode($param));
		$res = $curlClass->httpRequest($url, 'post', $postData, array('token:' . $this->getToken()));
		$res = json_decode($res, 1);
		
		if(empty($res))
			throw new WeException(-1);
		if(!in_array($res['code'], [200,202]))
			throw new WeException($res['code'], $res['msg']);
		return $res;
	}

	/**
	 * 批量订单推送
	 */
	public function batchPushOrder($data=array()) {
		
		if(!is_array($data) || empty($data)){
			throw new WeException(103);
		}
		$order = array();
		foreach ($data as $k => $v) {
			$order[$v['order_no']][] = $v;
		}

		$param = array();
		foreach ($order as $ov) {
			$goods = array();
			foreach ($ov as $gk) {
				$goods[] = array(
					'goods_sku'  => $gk['goods_sku'],
					'goods_name' => $gk['goods_name'],
					'goods_nums' => $gk['goods_nums'],
					'remarks' 	 => $gk['remarks'],
				);
			}
			$param[] = array(
				'order_no' => $gk['order_no'],
				'goods'    => $goods,
				'accept_name' => $gk['accept_name'],
				'telphone'    => $gk['telphone'],
				'province'    => $gk['province'],
				'city'    => $gk['city'],
				'area'    => $gk['area'],
				'address' => $gk['address'],
			);
		}
		$url   = self::APIHOST . 'index.php?controller=order&action=third_asynchpush_order';
		$curlClass = new Curl();
		$postData  = array('order_data' => json_encode($param));
		$res = $curlClass->httpRequest($url, 'post', $postData, array('token:' . $this->getToken()));
		$res = json_decode($res, 1);
		
		if(empty($res))
			throw new WeException(-1);
		if($res['code'] != 200)
			throw new WeException($res['code'], $res['msg']);
		return $res;
	}
	
	/**
	 * 检测订单是否推送成功
	 * array
	 */
	public function checkOrderImport($data=array()) {
		if(!is_array($data) || empty($data)){
			throw new WeException(103);
		}
		$url   = self::APIHOST . 'index.php?controller=order&action=check_order_import';
		$curlClass = new Curl();
		$postData  = array('orderno' => json_encode($data));
		$res = $curlClass->httpRequest($url, 'post', $postData, array('token:' . $this->getToken()));
		$res = json_decode($res, 1);
	
		if($res['code'] != 200)
			throw new WeException($res['code'], $res['msg']);

		return $res;
	}


	/**
	 * 获取推送过来的数据
	 * @return array
	 */
	public function getPushData() {
		$body = file_get_contents('php://input');
        file_put_contents('log.txt', date ( "Y-m-d H:i:s" ) . "  " . var_export($body,1)."\r\n",FILE_APPEND);
        $data = json_decode($body,1);

        if(empty($data)) {
            throw new WeException(101);
        }
        //校验签名
        if($this->checkSign) {
            $this->checkSign($data);
        }
        return $data;
	}

	/**
     * 图片保存
     * @param  [type] $source   要保存的文件
     * @param  string $dir      保存目录
     * @param  string $filename 文件名
     * @return string $url   
     */
    public function downImages($source='', $dir='', $filename='') {
   		if(empty($source)) return false;

   		$dir = !empty($dir) ? $dir : 'data/image/';

        if(!$this->mkdirs($dir)) return false;
		if(substr($source, 0,4)=='http') {

			if(empty($filename)) {
				$ext = pathinfo($source, PATHINFO_EXTENSION);
				$ext = $ext ? $ext : 'jpg';
				$filename = md5(basename($source)) . '.' . $ext;
			}

			$path = $dir . $filename;
			if(!file_exists($path)) {
				$curlClass = new Curl();
				$content   = $curlClass->httpRequest($source, 'get', [], array('user-agent:'.'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36'));
	            if($content) {
					file_put_contents($path, $content);

					if(file_exists($path)) {
						return $path;
					}
	            }
			}else{
				return $path;
			}
        }
        return false;
    }

   /**
    * 订单完成
    * @param  array  
    * @return [type]
    */
	public function orderFinish($data=array()) {
		if(empty($data['order_no']) && empty($data['goods_sku']))
			throw new WeException(103,'缺少必要参数');
		
		$url   = self::APIHOST . 'index.php?controller=order&action=third_push_order_finish';
		$curlClass = new Curl();

		$res = $curlClass->httpRequest($url, 'post', json_encode($data), array('token:' . $this->getToken()));
		$res = json_decode($res, 1);
		if(empty($res))
			throw new WeException(-1);

		return $res;
	}

	/**
    * 订单退款
    * @param  array  
    * @return [type]
    */
	public function orderRefund($data=array()) {
		
		if(empty($data['order_no']) || (empty($data['goods']) && empty($data['full_refund'])) )
			throw new WeException(103,'缺少必要参数');
		
		$url   = self::APIHOST . 'index.php?controller=order&action=third_push_order_refund';
		$curlClass = new Curl();
	
		$res = $curlClass->httpRequest($url, 'post', json_encode($data), array('token:' . $this->getToken()));
		return json_decode($res, 1);
	}

}
