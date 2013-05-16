<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 商品相关操作接口
 */
class Product_model extends CI_Model
{
	var $max_products_in_grid =20;
	var $product_table= '';
	var $grid_product_table= '';
	var $user_g= '';
	public function __construct()
	{
		parent::__construct();
		$this->product_table = $this->db->dbprefix('product');
		$this->grid_product_table = $this->db->dbprefix('grid_product');
		$this->user_grid_table= $this->db->dbprefix('user_grid');
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

	public function has_too_many_product($grid_id)
	{
		$this->db->select('COUNT(1) as count');
		$this->db->from($this->grid_product_table);
		$this->db->where_in('grid_id', $grid_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row = $query->row();
			return ($row->count > $max_products_in_grid );
		}
		return false;
	}

	public function add_product ($grid_id, $data)
	{
		if(!isset($data['taobao_id']) || !isset($data['name']) ){
			return false;
		}

		if($this->has_too_many_product($grid_id)){
			return false;
		}

		$this->db->insert($this->product_table, $data);
		$product_id = $this->db->insert_id();

		$grid_product_data = array(
			'grid_id' => $grid_id,
			'product_id' => $product_id,
			'cid' => $data['cid']
		);
		$this->db->insert($this->grid_product_table, $grid_product_data);
		return ($this->db->affected_rows() > 0);
	}

	public function add_product_click ($product_id)
	{
		$this->db->set('click', 'click+1', FALSE);

		$this->db->where('product_id', $product_id);
		$this->db->update($this->product_table); 
	}

	public function get_products_by_grid($grid_id)
	{
		$sql="SELECT * FROM $this->product_table WHERE product_id IN \
				$(SELECT product_id FROM $this->grid_product_table WHERE grid_id=$grid_id)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_grid_click($grid_id)
	{
		$sql="SELECT SUM(click) AS click_total FROM $this->product_table WHERE product_id IN \
				$(SELECT product_id FROM $this->grid_product_table WHERE grid_id=$grid_id)";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->click_total;
		}
		return 0;
	}

	public function get_relate_grid($cid)
	{
		$this->db->select("grid");
		$this->db->from($this->grid_product_table);
		$ths->db->where('cid', $cid);
		$this->db->get();
		return $query->result_array();
	}

	public function get_owner_of_product($product_id)
	{
		$sql = "SELECT user_id FROM $this->user_grid_table a, $this->grid_product_table b \
				WHERE a.grid_id=b.grid_id AND b.product_id = $product_id "
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$row = $query->row();
			return $row->user_id;
		}
		return 0;
	}
}
