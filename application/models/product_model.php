<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 商品相关操作接口
 */
class Product_model extends CI_Model
{
	var $product_table= '';
	public function __construct()
	{
		parent::__construct();
		$this->product_table = $this->db->dbprefix('product');
	}

	public function get_newest_product($limit = 10)
	{
		$this->db->select('*');
		$this->db->from($this->product_table);
		$this->db->order_by("add_time", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get();
		return  $query->result_array();
	}

	public function get_hotest_product($limit = 10)
	{
		$this->db->select('*');
		$this->db->from($this->product_table);
		$this->db->order_by("hot", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get();
		return  $query->result_array();
	}

	public function down_product($taobao_id)
	{
		$data = array(
			'status' => 1
		);

		$this->db->where("taobao_id", $taobao_id);
		$this->db->update($this->product_table, $data);
	}

	public function delete_product($product_id)
	{
		$this->db->where("taobao_id", $taobao_id);
		$this->db->delete($this->product_table);
	}

	public function get_product_info($product_id)
	{
		$this->db->select('*');
		$this->db->from($this->product_table);
		$this->db->where("product_id", $product_id);
		$query = $this->db->get();
		return  $query->result_array();
	}

	public function update_product ($product_id, $data)
	{
		if(empty($data)){
			return false;
		}
		$this->db->where("product_id", $product_id);
		$this->db->update($this->product_table, $data);
		return ($this->db->affected_rows() > 0);
	}

	public function add_product ($data)
	{
		if(!isset($data['taobao_id']) || !isset($data['name']) ){
			return false;
		}

		$this->db->insert($this->product_table, $data);
		return ($this->db->affected_rows() > 0);
	}

	public function add_product_click ($product_id)
	{
		$this->db->set('click', 'click+1', FALSE);

		$this->db->where('product_id', $product_id);
		$this->db->update($this->product_table); 
	}
}
