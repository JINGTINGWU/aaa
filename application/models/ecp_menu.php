<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 讀取功能表設定
 * Author: Johnson 2012/05/22
 */
class Ecp_menu extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// 目前功能表只設計2層
	function get_menu($jec_user_id=0)
	{
		$this->db->select('a.jec_menu_id, a.isinsert, a.isupdate, a.isdelete, a.isprint, c.seqno');
		$this->db->select('c.menutype, c.name, c.control, c.parentid, c.seqno');
		$this->db->from('jec_rolemenu a');
		$this->db->join('jec_user b', 'a.jec_role_id=b.jec_role_id', 'left');
		$this->db->join('jec_menu c', 'a.jec_menu_id=c.jec_menu_id', 'left');
		$this->db->where('b.jec_user_id', $jec_user_id);
		$this->db->where('a.isaccess', 'Y');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('seqno');
		return $this->db->get('')->result_array();
	}
	
	// 檢查帳號&密碼是否正確
	// 正確時回傳jec_user相關資料, 否則傳回0
	// 當切換帳號時, 只檢查帳號, 不檢查密碼
	function check_user($data, $ischeckpassword=true)
	{
		$value = $data['value'];
		$password = $data['password'];
		$this->db->where('value', $value);
		if ($ischeckpassword) $this->db->where('password', $password);
		$row = $this->db->get('jec_user')->result_array();
		if (count($row) <= 0)
			return 0;
		else
		{
			if ($row[0]['acctstatus'] == 'N')  // 停權
				return 0;
			else if (empty($row[0]['jec_role_id']))  // 沒有設定權限
				return 0;
			else if($row[0]['isactive'] == 'N') //被刪除
				return 0;
			else
				return $row;
		}
	}
	
	// 讀取使用者資料
	function get_user($jec_user_id=0)
	{
		$this->db->select('a.*, b.name as deptname');
		$this->db->from('jec_user a');
		$this->db->join('jec_dept b', 'a.jec_dept_id=b.jec_dept_id', 'left');
		$this->db->where('a.jec_user_id', $jec_user_id);
		return $this->db->get('')->result_array();
	}
	
	// 讀取參數設定中的OS參數
	function get_os_setup()
	{
		$this->db->select('value');
		$this->db->from('jec_setup');
		$this->db->where('noticetype', 'OS');
		$row = $this->db->get('')->result_array();
		if (! empty($row))
			return $row[0]['value'];
		else
			return 'WIN';
	}
}
