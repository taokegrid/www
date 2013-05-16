<?php

class Taobaoke_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->config->load('site_info');
		define('APPKEY',    $this->config->item('appkey'));
		define('SECRETKEY',    $this->config->item('secretkey'));
		define('PID',    $this->config->item('taobaoke_pid'));

		include APPPATH.'libraries/taobaoapi/TopSdk.php';
	}


	/**
	 * 搜索条目
	 *
	 * @param string $keyword  搜索关键词
	 * @param integer $cid  淘宝的后台类目ID
	 * @return String $resp XML字符串
	 */
	function searchItem($keyword, $cid){
		$c = new TopClient;
		$c->appkey = APPKEY;
		$c->secretKey = SECRETKEY;

		$req = new TaobaokeItemsGetRequest;
		$req->setFields("num_iid,title,click_url,pic_url,price,commission,commission_num,volume,nick");
		$req->setPid(PID);
		$req->setCid($cid);
		$req->setKeyword($keyword);
		$req->setSort("commissionVolume_desc");
		$req->setGuarantee("true");
		$req->setStartCommissionRate("1000");
		$req->setEndCommissionRate("5000");
		$req->setMallItem("true");
		$req->setPageNo(1);
		$req->setPageSize(40);
		$req->setOuterCode("abc");
		$resp = $c->execute($req);
		return $resp;
	}

	/**
	 * 根据条目ID获取更详细的信息，包括图片列表
	 *
	 * @param integer $item_id  条目ID
	 * @return string $resp 包含图片列表的XML
	 */
	function getItemInfo($item_id){
		$c = new TopClient;
		$c->appkey = APPKEY;
		$c->secretKey = SECRETKEY;
		$req = new ItemGetRequest;
		$req->setFields("prop_img.url,item_img.url,nick");
		//	$req->setFields("detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual");
		$req->setNumIid($item_id);
		$resp = $c->execute($req);
		return $resp;
	}

	function getCats($cid){
		$c = new TopClient;
		$c->appkey = APPKEY;
		$c->secretKey = SECRETKEY;
		$req = new ItemcatsGetRequest;
		$req->setFields("cid,parent_cid,name,is_parent");
		$req->setCid($cid);
		return $c->execute($req);
	}

	// 必须为淘宝帐号推广
	function get_bill_report(){
		$c = new TopClient;
		$c->appkey = APPKEY;
		$c->secretKey = SECRETKEY;
		$req = new TaobaokeReportGetRequest;
		$req->setFields("trade_id,pay_time,pay_price,commission,outer_code,item_title");
		$req->setDate("20090520");
		$req->setPageNo(1);
		$req->setPageSize(100);
		$resp = $c->execute($req);
	}
}
