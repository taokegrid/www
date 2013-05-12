<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 商品分类相关操作接口
 */
class Category_model extends CI_Model
{
	var $category_table = '';
	public function __construct()
	{
		parent::__construct();
		$this->category_table = $this->db->dbprefix('category');
	}

	public function add_category($cid,$parent_cid,$name)
	{
		$data= array(
			"cid" => $cid,
			"parent_cid" => $parent_cid,
			"name" => $name
		);

		$insert_query = $this->db->insert_string($this->category_table, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);
		return ($this->db->affected_rows() > 0);
	}

	public function get_parent_category($cid)
	{
		$this->db->select('*');
		$this->db->from($this->category_table);
		$this->db->where('cid', $cid);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return null;
	}
}
