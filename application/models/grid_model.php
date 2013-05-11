<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 用户相关操作接口
 */
class grid_model extends CI_Model
{
	var $grid_table = '';
	var $user_product_table= '';
	var $product_table= '';
	public function __construct()
	{
		parent::__construct();
		$this->grid_table = $this->db->dbprefix('grid');
		$this->user_product_table = $this->db->dbprefix('user_product');
		$this->product_table = $this->db->dbprefix('product');
	}

	public function get_grid_info($grid_id)
	{
		$this->db->select('*');
		$this->db->from($this->grid_table);
		$this->db->where('grid_id', $grid_id);
		$query = $this->db->get();
		return  $query->result_array();
	}

	public function is_grid_exist($name)
	{
		$this->db->select('*');
		$this->db->from($this->grid_table);
		$this->db->where('name', $name);
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}

	public function  add_new_grid($name, $data)
	{
		if(!isset($data['name'])){
			return false;
		}

		if($this->is_grid_exist($data['name'])) {
			return false;
		}

		$this->db->insert($this->grid_table, $data);
		return ($this->db->affected_rows() > 0);
	}

	public function delete_grid($grid_id)
	{
		$this->db->where('grid_id', $grid_id);
		return $this->db->delete($this->grid_table);
	}

	public function  update_grid($grid_id, $data)
	{
		$this->db->where('grid_id', $grid_id);
		$this->db->update($this->grid_table, $data); 
	}

	public function get_grid_click($grid_id)
	{
		// get the product_ids in the grid.
		$this->db->select('product_id');
		$this->db->from($this->user_product_table);
		$this->db->where('grid_id', $grid_id);
		$query = $this->db->get();
		$product_ids= $query->result_array();
		if($query->num_rows() == 0){
			return 0;
		}

		// get the sum of clicks.
		$this->db->select_sum('click');
		$this->db->from($this->product_table);
		$this->db->where_in('product_id', $product_ids);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$sum_click = $query->row_array();
			return $sum_click[0];
		}
		return 0;
	}

	public function get_hot_grid($userid = '')
	{
	}

	public function get_newest_grid($limit = 10, $userid ='')
	{
		// get the product_ids in the grid.
		$this->db->select($grid_id);
		$this->db->from($this->user_product_table);
		if(isset($userid)){
		$this->db->where('user_id', $userid);
		}
		$this->db->order_by("add_time", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get();
		$grid_ids= $query->result_array();
		if($query->num_rows() == 0){
			return null;
		}

		// get the sum of clicks.
		$this->db->select('*');
		$this->db->from($this->grid_table);
		$this->db->where_in('grid_id', $grid_ids);
		$query = $this->db->get();
		$grid_info= $query->result_array();
		if($query->num_rows() > 0){
			return $grid_info;
		}
		return  null;
	}

	public function get_products_by_grid($grid_id)
	{
		// get the product_ids in the grid.
		$this->db->select('product_id');
		$this->db->from($this->user_product_table);
		$this->db->where('grid_id', $grid_id);
		$query = $this->db->get();
		$product_ids= $query->result_array();
		if($query->num_rows() == 0){
			return null;
		}

		// get the product info
		$this->db->select('*');
		$this->db->from($this->product_table);
		$this->db->where_in('product_id', $product_ids);
		$query = $this->db->get();
		$product_info = $query->result_array();
		if($query->num_rows() > 0){
			return $product_info;
		}
		return null;
	}

	public function get_grid_by_user($user_id)
	{
		// get the grids in the grid.
		$this->db->select('grid_id');
		$this->db->from($this->user_product_table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}

		return null;
	}

	public function get_products_by_user($user_id)
	{
		$grid_ids = $this->get_grid_by_user($user_id);
		if(empty($grid_ids)){
			return null;
		}

		foreach ($grid_ids as $grid_id){
			$result[$grid_id]["grid_info"]  = $this->get_grid_info($grid_id);
			$result[$grid_id]["product"] = $this->get_products_by_grid($grid_id);
		}
		return $result;
	}
}
