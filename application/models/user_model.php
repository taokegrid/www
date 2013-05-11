<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * 用户相关操作接口
 */
class User_model extends CI_Model
{
	var $user_table = '';
	public function __construct()
	{
		parent::__construct();
		$this->user_table = $this->db->dbprefix('user');
	}

	public function  is_user_exist($oauth_uid, $oauth_via)
	{
		$this->db->select('*');
		$this->db->from($this->user_table);
		$this->db->where('oauth_uid', $oauth_uid);
		$this->db->where('oauth_via', $oauth_via);
		$query = $this->db->get();
		return ($query->num_rows() == 1);
	}

	public function  add_new_user($data)
	{
		if(!isset($data['oauth_uid']) || !isset($data['oauth_via'])) {
			return false;
		}
		if(is_user_exist($data['oauth_uid'], $data['oauth_via'])){
			return false;
		}
	   
		$this->db->insert($this->user_table, $data);
		return ($this->db->affected_rows() > 0);
	}

	public function get_user_info($oauth_uid, $oauth_via)
	{
		$this->db->select('*');
		$this->db->from($this->user_table);
		$this->db->where('oauth_uid', $oauth_uid);
		$this->db->where('oauth_via', $oauth_via);
		$this->db->order_by("add_time", "desc"); 
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return  $query->result_array();
		}
		return null;
	}
}
