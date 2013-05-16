<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 格子相关操作接口
 */
class Grid_model extends CI_Model
{
	var $max_grids_in_user = 5;
	var $grid_table = '';
	var $user_grid_table= '';
	public function __construct()
	{
		parent::__construct();
		$this->grid_table = $this->db->dbprefix('grid');
		$this->user_grid_table = $this->db->dbprefix('user_grid');
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

	public function  add_grid($user_id, $data)
	{
		if(!isset($data['name'])){
			return false;
		}

		if($this->is_grid_exist($data['name'])) {
			return false;
		}
		if($this->has_too_many_grids($user_id)){
			return false;
		}

		$this->db->insert($this->grid_table, $data);
		$grid_id=$this->db->insert_id();

		$user_grid_data = array(
			'user_id' => $user_id,
			'grid_id' => $grid_id
		);
		$this->db->insert($this->user_grid_table, $user_grid_data);
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
		return ($this->db->affected_rows() > 0);
	}


	public function get_hotest_grid($limit = 10)
	{
		// 热门格子的定义;  商品hot值总和
	}

	public function get_newest_grid($limit = 10)
	{
		$this->db->select($grid_id);
		$this->db->from($this->user_grid_table);
		$this->db->order_by("add_time", "desc"); 
		$this->db->limit($limit);
		$query = $this->db->get();
		$grid_ids= $query->result_array();
		if($query->num_rows() == 0){
			return  array();
		}

		$this->db->select('*');
		$this->db->from($this->grid_table);
		$this->db->where_in('grid_id', $grid_ids);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_grid_by_user($user_id)
	{
		// get the grids in the grid.
		$this->db->select('grid_id');
		$this->db->from($this->user_grid_table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_products_by_user($user_id)
	{
		$grid_ids = $this->get_grid_by_user($user_id);
		if(empty($grid_ids)){
			return  array();
		}

		$result = array();
		foreach ($grid_ids as $grid_id){
			$result[$grid_id]["grid_info"]  = $this->get_grid_info($grid_id);
			$result[$grid_id]["product"] = $this->get_products_by_grid($grid_id);
		}
		return $result;
	}

	public function has_too_many_grids($user_id)
	{
		$this->db->select('COUNT(1) as count');
		$this->db->from($this->user_grid_table);
		$this->db->where_in('user_id', $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$row = $query->row();
			return ($row->count > $max_grids_in_user);
		}
		return false;
	}

}
