<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 部門與人員
 * Author: Johnson 2012/07/13
 */
class Ecp_deptusermodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// 部門DATAMODEL----------------------------------------------------------------------------------
	// 讀取部門列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_dept_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_dept a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_dept_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'name';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 讀取使用者清單, 以供選取部門主管
	function get_user()
	{
		$this->db->select('a.jec_user_id, a.name');
		$this->db->from('jec_user a');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('name');
		$row = $this->db->get('')->result_array();
		// 增加一筆空白選項
		$row_empty = array('jec_user_id' => '', 'name' => '');
		array_unshift($row, $row_empty);
		return $row;
	}
	
	// 讀取部門清單, 以供選取上層部門
	function get_deptuplayer()
	{
		$this->db->select('a.jec_dept_id, a.name');
		$this->db->from('jec_dept a');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('name');
		$row = $this->db->get('')->result_array();
		// 增加一筆空白選項
		$row_empty = array('jec_dept_id' => '', 'name' => '');
		array_unshift($row, $row_empty);
		return $row;
	}
	
	// 新增部門
	function dept_new($data)
	{
		// 檢查名稱是否重覆
		if ($this->check_data_exist('jec_dept', 'name', $data['name'])) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('jec_deptuplayer_id', $data['jec_deptuplayer_id']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->insert('jec_dept');
		return 'OK';
	}
	
	// 修改部門
	function dept_update($data)
	{
		// 檢查名稱是否重覆
		if ($this->check_data_exist('jec_dept', 'name', $data['name'], 'jec_dept_id', $data['jec_dept_id'])) return 'EXIST';
		// 上層部門不能等於目前的部門
		if ($data['jec_deptuplayer_id'] == $data['jec_dept_id']) return 'UNREASON';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('jec_deptuplayer_id', $data['jec_deptuplayer_id']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->where('jec_dept_id', $data['jec_dept_id']);
 		$this->db->update('jec_dept');
 		return 'OK';
	}
	
	// 刪除部門
	function dept_delete($jec_dept_id=0)
	{
		// 先檢查是否為其他部門的上層部門
		$this->db->where('jec_deptuplayer_id', $jec_dept_id);
		$this->db->where('isactive', 'Y');
		$query = $this->db->get('jec_dept');
		if ($query->num_rows() > 0) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_dept_id', $jec_dept_id);
		$this->db->update('jec_dept');
		return 'OK';
	}
	
	// 檢查資料是否重覆
	// $table: 要檢查的表格
	// $field: 要檢查的欄位
	// $name: 要檢查的值
	// $idfield: 若為修改則要傳入目前修改資料的主ID名稱
	// $id: 若為修改則要傳入目前修改資料的ID值
	function check_data_exist($table='', $field='', $name='', $idfield='', $id=0)
	{
		if (empty($table) || empty($field)) return true;
		$this->db->where($field, $name);
		$this->db->where('isactive', 'Y');
		if (!empty($idfield) && $id > 0) $this->db->where($idfield.' != '.$id);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	// 部門展開
	function get_dept_expand()
	{
		// 先取得最高層部門
		global $_DeptExpand;  // 儲存部門展開後的資料陣列
		$_DeptExpand = array();
		$this->db->select('a.jec_dept_id, 0 AS layer, a.name, b.name as username', false);
		$this->db->from('jec_dept a');
		$this->db->join('jec_user b', 'a.jec_user_id=b.jec_user_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_deptuplayer_id', 0);
		$rowuplayer = $this->db->get('')->result_array();
		foreach ($rowuplayer as $key => $row)
		{
			array_push($_DeptExpand, $row);
			$this->dept_expand_recursive($row['jec_dept_id'], 0);
		}
		return $_DeptExpand;
	}
	
	// 部門展開遞迴
	function dept_expand_recursive($jec_dept_id, $layer)
	{
		global $_DeptExpand;
		$select = "a.jec_dept_id, ".($layer+1)." AS layer, a.name, b.name as username";
		$this->db->select($select, false);
		$this->db->from('jec_dept a');
		$this->db->join('jec_user b', 'a.jec_user_id=b.jec_user_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_deptuplayer_id', $jec_dept_id);
		$rowlayer = $this->db->get('')->result_array();
		// 到最底層則返回
		if (empty($rowlayer)) return;
		// 還有下層部門則繼續展開
		foreach ($rowlayer as $key => $row1)
		{
			array_push($_DeptExpand, $row1);
			$this->dept_expand_recursive($row1['jec_dept_id'], $layer+1);
		}
	}
	
	// 人員DATAMODEL----------------------------------------------------------------------------------
	// 讀取職務名稱
	function get_title()
	{
		$this->db->select('a.jec_title_id, a.name');
		$this->db->from('jec_title a');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('name');
		$row = $this->db->get('')->result_array();
		// 增加一筆空白選項
		$row_empty = array('jec_title_id' => '', 'name' => '');
		array_unshift($row, $row_empty);
		return $row;
	}
	
	// 讀取成本來源選項
	function get_costtype()
	{
		$row = array(
			array('datatype'=>'', 'name'=>''),
			array('datatype'=>'1', 'name'=>'售價定價一'),
			array('datatype'=>'2', 'name'=>'售價定價二'),
			array('datatype'=>'3', 'name'=>'售價定價三'),
			array('datatype'=>'4', 'name'=>'售價定價四'),
			array('datatype'=>'5', 'name'=>'售價定價五'),
			array('datatype'=>'6', 'name'=>'售價定價六'),
			array('datatype'=>'7', 'name'=>'業務底價')
		);
		return $row;
	}
	
	// 讀取人員列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_user_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_user a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_user_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'value';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增人員
	function user_new($data)
	{
		// 檢查帳號是否重覆
		if ($this->check_data_exist('jec_user', 'value', $data['value'])) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('password', $data['password']);
		$this->db->set('jec_dept_id', $data['jec_dept_id']);
		$this->db->set('jec_title_id', $data['jec_title_id']);
		$this->db->set('email', $data['email']);
		$this->db->insert('jec_user');
		return 'OK';
	}
	
	// 修改人員
	function user_update($data)
	{
		// 檢查帳號是否重覆
		if ($this->check_data_exist('jec_user', 'value', $data['value'], 'jec_user_id', $data['jec_user_id'])) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('password', $data['password']);
		$this->db->set('jec_dept_id', $data['jec_dept_id']);
		$this->db->set('jec_title_id', $data['jec_title_id']);
		$this->db->set('email', $data['email']);
		$this->db->set('costtype', $data['costtype']);
		$this->db->where('jec_user_id', $data['jec_user_id']);
 		$this->db->update('jec_user');
 		return 'OK';
	}
	
	// 刪除人員
	function user_delete($jec_user_id=0)
	{
		// 先檢查是否為部門主管
		$this->db->where('jec_user_id', $jec_user_id);
		$this->db->where('isactive', 'Y');
		$query = $this->db->get('jec_dept');
		if ($query->num_rows() > 0) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_user_id', $jec_user_id);
 		$this->db->update('jec_user');
 		return 'OK';
	}
	
	// 群組人員DATAMODEL--------------------------------------------------------------------------------
	// 讀取群組人員列表, 不分頁
	function get_usergroup_list()
	{
		$sql = "SELECT null AS jec_usergroup_id, a.jec_group_id, a.name AS groupname, null AS jec_user_id, null AS username ";
		$sql .= "FROM jec_group a WHERE a.isactive='Y' ";
		$sql .= "UNION ";
		$sql .= "SELECT b.jec_usergroup_id, b.jec_group_id, c.name AS groupname, b.jec_user_id, d.name AS username ";
		$sql .= "FROM jec_usergroup b LEFT JOIN jec_group c ON b.jec_group_id=c.jec_group_id ";
		$sql .= "LEFT JOIN jec_user d ON b.jec_user_id=d.jec_user_id WHERE b.isactive='Y' ";
		$sql .= "ORDER BY jec_group_id, username";
		return $this->db->query($sql)->result_array();
	}
	
	// 新增群組中的人員
	function usergroup_new($data)
	{
		// 檢查是否重覆新增
		$this->db->where('jec_group_id', $data['jec_group_id']);
		$this->db->where('jec_user_id', $data['jec_user_id']);
		$this->db->where('isactive', 'Y');
		$query = $this->db->get('jec_usergroup');
		if ($query->num_rows() > 0) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('jec_group_id', $data['jec_group_id']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->insert('jec_usergroup');
		return 'OK';
	}
	
	// 刪除群組中的人員
	function usergroup_delete($jec_usergroup_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_usergroup_id', $jec_usergroup_id);
 		$this->db->update('jec_usergroup');
 		return true;
	}
}
