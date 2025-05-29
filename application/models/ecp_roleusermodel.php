<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 權限管理
 * Author: Johnson 2012/07/14
 */
class Ecp_roleusermodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// 權限DATAMODEL----------------------------------------------------------------------------------
	// 讀取權限列表
	// $id: ID
	// $addempty: 是否加一筆空白資料
	function get_role_list($id=0, $addempty=false)
	{
		$this->db->select('a.jec_role_id, a.name, a.description, COUNT(b.value) AS usercount');
		$this->db->from('jec_role a');
		$this->db->join('jec_user b', 'a.jec_role_id=b.jec_role_id', 'left');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0) $this->db->where('a.jec_role_id', $id);
		$this->db->group_by('a.jec_role_id');
		$this->db->order_by('name');
		$row = $this->db->get('')->result_array();
		if ($addempty)
		{
			$row_empty = array('jec_role_id'=>'', 'name'=>'', 'a.description'=>'', 'usercount'=>'');
			array_unshift($row, $row_empty);
		}
		return $row;
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
	
	// 新增權限
	function role_new($data)
	{
		// 檢查名稱是否重覆
		if ($this->check_data_exist('jec_role', 'name', $data['name'])) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_role');
		return 'OK';
	}
	
	// 修改權限
	function role_update($data)
	{
		// 檢查名稱是否重覆
		if ($this->check_data_exist('jec_role', 'name', $data['name'], 'jec_role_id', $data['jec_role_id'])) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_role_id', $data['jec_role_id']);
 		$this->db->update('jec_role');
 		return 'OK';
	}
	
	// 刪除權限
	function role_delete($jec_role_id=0)
	{
		// 先檢查是否已設定給USER
		$this->db->where('jec_role_id', $jec_role_id);
		$this->db->where('isactive', 'Y');
		$query = $this->db->get('jec_user');
		if ($query->num_rows() > 0) return 'EXIST';
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_role_id', $jec_role_id);
		$this->db->update('jec_role');
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
	
	// 編輯權限DATAMODEL----------------------------------------------------------------------------------
	// 預先整理jec_rolemenu內容, 比對jec_menu的內容
	function process_rolemenu($jec_role_id=0)
	{
		if ($jec_role_id == 0) return;
		// 先將jec_rolemenu相關資料標記起來
		$update = "UPDATE jec_rolemenu SET processed='N' WHERE isactive='Y' AND jec_role_id=".$jec_role_id;
		$this->db->query($update);
		// 讀取jec_menu比對jec_rolemenu
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->select('jec_menu_id');
		$this->db->from('jec_menu');
		$this->db->where('isactive', 'Y');
		$rowmenu = $this->db->get('')->result_array();
		foreach ($rowmenu as $key => $row)
		{
			$this->db->select('jec_rolemenu_id');
			$this->db->from('jec_rolemenu');
			$this->db->where('jec_role_id', $jec_role_id);
			$this->db->where('jec_menu_id', $row['jec_menu_id']);
			$this->db->where('isactive', 'Y');
			$rowcheck = $this->db->get('')->result_array();
			// 不存在則新增
			if (empty($rowcheck))
			{
				$this->db->set('isactive', 'Y');
				$this->db->set('created', $nowtime);
				$this->db->set('createdby', $loginparameters['jec_user_id']);
				$this->db->set('updatedby', 0);
				$this->db->set('jec_role_id', $jec_role_id);
				$this->db->set('jec_menu_id', $row['jec_menu_id']);
				$this->db->set('processed', 'Y');
				$this->db->insert('jec_rolemenu');
			}
			// 存在則標記已處理
			else
			{
				$this->db->set('processed', 'Y');
				$this->db->where('jec_rolemenu_id', $rowcheck[0]['jec_rolemenu_id']);
				$this->db->update('jec_rolemenu');
			}
		}
		// 刪除沒有被標記的jec_rolemenu, 並回復空白標記
		$update = "UPDATE jec_rolemenu SET isactive='N' WHERE processed='N' AND jec_role_id=".$jec_role_id;
		$this->db->query($update);
		$update = "UPDATE jec_rolemenu SET processed='' WHERE jec_role_id=".$jec_role_id;
		$this->db->query($update);
	}
	
	// 讀取jec_menu+jec_rolemenu
	function get_role_edit($jec_role_id)
	{
		// 先取得最高層選單
		global $_MenuExpand;  // 儲存MENU展開後的資料陣列
		$_MenuExpand = array();
		$sql = "SELECT a.jec_menu_id, 0 AS layer, a.name, b.isaccess, b.isinsert, b.isupdate, b.isdelete ";
		$sql .= "FROM jec_menu a LEFT JOIN jec_rolemenu b ON a.jec_menu_id=b.jec_menu_id AND b.jec_role_id=".$jec_role_id;
		$sql .= " WHERE a.isactive='Y' AND a.menutype='1' AND a.parentid=0 ORDER BY seqno";
		$rowuplayer = $this->db->query($sql)->result_array();
		foreach ($rowuplayer as $key => $row)
		{
			array_push($_MenuExpand, $row);
			$this->menu_expand_recursive($row['jec_menu_id'], 0, $jec_role_id);
		}
		return $_MenuExpand;
	}
	
	// MENU展開遞迴
	function menu_expand_recursive($jec_menu_id, $layer, $jec_role_id)
	{
		global $_MenuExpand;
		$sql = "SELECT a.jec_menu_id, ".($layer+1)." AS layer, a.name, b.isaccess, b.isinsert, b.isupdate, b.isdelete ";
		$sql .= "FROM jec_menu a LEFT JOIN jec_rolemenu b ON a.jec_menu_id=b.jec_menu_id AND b.jec_role_id=".$jec_role_id;
		$sql .= " WHERE a.isactive='Y' AND a.menutype='2' AND a.parentid=".$jec_menu_id." ORDER BY seqno";
		$rowlayer = $this->db->query($sql)->result_array();
		// 到最底層則返回
		if (empty($rowlayer)) return;
		// 還有下層MENU則繼續展開
		foreach ($rowlayer as $key => $row1)
		{
			array_push($_MenuExpand, $row1);
			$this->menu_expand_recursive($row1['jec_menu_id'], $layer+1, $jec_role_id);
		}
	}
	
	// 更新權限設定
	// checklist以字串格式組合: jec_menu_id/isaccess/isinsert/isupdate/isdelete;
	// 例如: 1/Y/Y/Y/Y;2/N/N/N/N;3/Y/Y/N/N;
	function update_rolemenu($data)
	{
		$jec_role_id = $_POST['jec_role_id'];
		$check_list = explode(';', $data['checklist']);
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		foreach ($check_list as $checklist)
		{
			if (! empty($checklist))
			{
				$row = explode('/', $checklist);
				$this->db->set('updated', $nowtime);
				$this->db->set('updatedby', $loginparameters['jec_user_id']);
				$this->db->set('isaccess', $row[1]);
				$this->db->set('isinsert', $row[2]);
				$this->db->set('isupdate', $row[3]);
				$this->db->set('isdelete', $row[4]);
				$this->db->where('jec_role_id', $jec_role_id);
				$this->db->where('jec_menu_id', $row[0]);
		 		$this->db->update('jec_rolemenu');
			}
		}
		return true;
	}
	
	// 人員設定DATAMODEL--------------------------------------------------------------------------------
	// 讀取人員列表
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_user_list($sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_user a');
		$this->db->where('a.isactive', 'Y');
		if (empty($sort_field)) $sort_field = 'value';
		$this->db->order_by($sort_field . ' ' . $sort_sequence);
		return $this->db->get('')->result_array();
	}
	
	// 修改人員設定
	function userrole_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('jec_role_id', $data['jec_role_id']);
		$this->db->set('acctstatus', $data['acctstatus']);
		$this->db->set('isadmin', $data['isadmin']);
		$this->db->where('jec_user_id', $data['jec_user_id']);
 		$this->db->update('jec_user');
 		return true;
	}
}
