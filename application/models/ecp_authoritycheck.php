<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_authoritycheck extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    
	// 回傳系統作業該使用者的操作權限
	function authority_check($name='')
	{
		if (empty($name))
		{
			$data = array ('isaccess' => 'N', 'isinsert' => 'N', 'isupdate' => 'N', 'isdelete' => 'N');
			return $data;
		}
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->select('a.isaccess, a.isinsert, a.isupdate, a.isdelete');
		$this->db->from('jec_rolemenu a');
		$this->db->join('jec_user b', 'a.jec_role_id=b.jec_role_id', 'left');
		$this->db->join('jec_menu c', 'a.jec_menu_id=c.jec_menu_id', 'left');
		$this->db->where('b.jec_user_id', $loginparameters['jec_user_id']);
		$this->db->where('c.control', $name);
		$row = $this->db->get('')->result_array();
		if (empty($row))
		{
			$data = array ('isaccess' => 'N', 'isinsert' => 'N', 'isupdate' => 'N', 'isdelete' => 'N');
		}
		else
		{
			$data = array ('isaccess' => $row[0]['isaccess'], 'isinsert' => $row[0]['isinsert'], 
				'isupdate' => $row[0]['isupdate'], 'isdelete' => $row[0]['isdelete']);
		}
		return $data;
	}
	
	// 回傳系統作業的名稱, 以便顯示在頁面
	function function_name($name='')
	{
		if (empty($name)) return "";
		$this->db->select('name');
		$this->db->from('jec_menu');
		$this->db->where('control', $name);
		$row = $this->db->get('')->result_array();
		if (empty($row))
		{
			$data = "";
		}
		else
		{
			$data = $row[0]['name'];
		}
		return $data;
		
	}
}