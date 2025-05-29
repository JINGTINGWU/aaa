<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 基本資料
 * Author: Johnson 2012/06/25
 */
class Ecp_datamodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// 職稱===========================================================================================
	// 讀取職稱列表
	function get_title_list()
	{
		$this->db->where('isactive', 'Y');
		$this->db->order_by('jec_title_id');
		return $this->db->get('jec_title')->result_array();
	}
	
	// 新增職稱
	function title_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_title');
		return true;
	}
	
	// 更新職稱
	function title_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_title_id', $data['jec_title_id']);
 		$this->db->update('jec_title');
 		return true;
	}
	
	// 刪除職稱
	function title_delete($jec_title_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_title_id', $jec_title_id);
		$this->db->update('jec_title');
		return true;
	}
	
	// 群組===========================================================================================
	// 讀取群組列表
	function get_group_list()
	{
		$this->db->where('isactive', 'Y');
		$this->db->order_by('jec_group_id');
		return $this->db->get('jec_group')->result_array();
	}
	
	// 新增群組
	function group_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_group');
		return true;
	}
	
	// 更新群組
	function group_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_group_id', $data['jec_group_id']);
 		$this->db->update('jec_group');
 		return true;
	}
	
	// 刪除群組, 連同群組人員一起刪除
	function group_delete($jec_group_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_group_id', $jec_group_id);
		$this->db->update('jec_usergroup');
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_group_id', $jec_group_id);
		$this->db->update('jec_group');
		return true;
	}
	
	// 費用===========================================================================================
	// 讀取費用名稱列表
	function get_charge_list()
	{
		$this->db->where('isactive', 'Y');
		$this->db->order_by('jec_chargeitem_id');
		return $this->db->get('jec_chargeitem')->result_array();
	}
	
	// 新增費用名稱
	function charge_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_chargeitem');
		return true;
	}
	
	// 更新費用名稱
	function charge_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_chargeitem_id', $data['jec_chargeitem_id']);
 		$this->db->update('jec_chargeitem');
 		return true;
	}
	
	// 刪除費用名稱
	function charge_delete($jec_chargeitem_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_chargeitem_id', $jec_chargeitem_id);
		$this->db->update('jec_chargeitem');
		return true;
	}
	
	// 單位===========================================================================================
	// 讀取單位列表
	function get_uom_list()
	{
		$this->db->where('isactive', 'Y');
		$this->db->order_by('jec_uom_id');
		return $this->db->get('jec_uom')->result_array();
	}
	
	// 新增單位
	function uom_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_uom');
		return true;
	}
	
	// 更新單位
	function uom_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_uom_id', $data['jec_uom_id']);
 		$this->db->update('jec_uom');
 		return true;
	}
	
	// 刪除單位
	function uom_delete($jec_uom_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_uom_id', $jec_uom_id);
		$this->db->update('jec_uom');
		return true;
	}
	
	// 片語===========================================================================================
	// 讀取片語列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	// $jec_user_id: 登入使用者ID
	function get_phrase_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc', $jec_user_id=0)
	{
		$this->db->select('a.*');
		$this->db->from('jec_phrase a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('(a.phrasetype="1" OR a.createdby='.$jec_user_id.')');
		if ($id != 0)
		{
			$this->db->where('a.jec_phrase_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'phrasetype';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增片語
	function phrase_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('phrasetype', $data['phrasetype']);
		$this->db->insert('jec_phrase');
		return true;
	}
	
	// 更新片語
	function phrase_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->where('jec_phrase_id', $data['jec_phrase_id']);
 		$this->db->update('jec_phrase');
 		return true;
	}
	
	// 刪除片語
	function phrase_delete($jec_phrase_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_phrase_id', $jec_phrase_id);
		$this->db->update('jec_phrase');
		return true;
	}
	
	// 讀取使用者名稱
	function get_user_name($jec_user_id=0)
	{
		$this->db->select('a.name');
		$this->db->from('jec_user a');
		$this->db->where('a.jec_user_id', $jec_user_id);
		$row = $this->db->get('')->result_array();
		if (empty($row))
			return '';
		else
			return $row[0]['name'];
	}
	
	// 公告===========================================================================================
	// 讀取公告列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_announce_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*, b.name AS user_name');
		$this->db->from('jec_announce a');
		$this->db->join('jec_user b', 'a.jec_user_id=b.jec_user_id', 'left');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_announce_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field))
			{
				$sort_field = 'startdate';
				$sort_sequence = 'desc';
			}
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增公告
	function announce_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->set('startdate', $data['startdate']);
		$this->db->set('enddate', $data['enddate']);
		$this->db->insert('jec_announce');
		return true;
	}
	
	// 更新公告
	function announce_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->where('jec_announce_id', $data['jec_announce_id']);
 		$this->db->update('jec_announce');
 		return true;
	}
	
	// 刪除公告
	function announce_delete($jec_announce_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_announce_id', $jec_announce_id);
		$this->db->update('jec_announce');
		return true;
	}
	
	// 讀取使用者清單
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
	
	// 參數===========================================================================================
	// 讀取系統參數設定 jec_setup
	function get_setting_list()
	{
		$this->db->select('a.*');
		$this->db->from('jec_setup a');
		$this->db->where('a.isactive', 'Y');
		//$this->db->order_by('jec_setup_id');
		$this->db->order_by('noticetype');
		return $this->db->get('')->result_array();
	}
	
	// 讀取系統參數設定 routine_schedule
	function get_routine_list()
	{
		$this->db->select('a.*');
		$this->db->from('routine_schedule a');
		$this->db->where('a.zrs_isactive', 'Y');
		$this->db->order_by('zrs_id');
		return $this->db->get('')->result_array();
	}
	
	// 修改參數
	function setting_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('content', $data['content']);
		$this->db->set('icon', $data['icon']);
		$this->db->set('value', $data['value']);
		$this->db->where('jec_setup_id', $data['jec_setup_id']);
 		$this->db->update('jec_setup');
 		return true;
	}
	
	// 修改參數
	function routine_update($data)
	{
		$this->db->set('zrs_exe_switch', $data['zrs_exe_switch']);
		$this->db->set('zrs_exe_type', $data['zrs_exe_type']);
		$this->db->set('zrs_exe_timespan', $data['zrs_exe_timespan']);
		$this->db->set('zrs_exe_dailytime', $data['zrs_exe_dailytime']);
		$this->db->where('zrs_id', $data['zrs_id']);
 		$this->db->update('routine_schedule');
 		return true;
	}
	
	// 變更密碼=========================================================================================
	// 讀取使用者資料
	function get_user_data($jec_user_id=0)
	{
		$this->db->select('a.*');
		$this->db->from('jec_user a');
		$this->db->where('a.jec_user_id', $jec_user_id);
		return $this->db->get('')->result_array();
	}
	
	// 修改密碼
	function password_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('password', $data['password']);
		$this->db->where('jec_user_id', $data['jec_user_id']);
 		$this->db->update('jec_user');
 		return 'OK';
	}
	
	// 公司===========================================================================================
	// 讀取公司列表
	function get_company_list()
	{
		$this->db->where('isactive', 'Y');
		$this->db->order_by('jec_company_id');
		return $this->db->get('jec_company')->result_array();
	}
	
	// 新增公司
	function company_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('dbsetup', $data['dbsetup']);
		$this->db->set('iseasyflow', $data['iseasyflow']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_company');
		return true;
	}
	
	// 更新公司
	function company_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('dbsetup', $data['dbsetup']);
		$this->db->set('iseasyflow', $data['iseasyflow']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_company_id', $data['jec_company_id']);
 		$this->db->update('jec_company');
 		return true;
	}
	
	// 刪除公司
	function company_delete($jec_company_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_company_id', $jec_company_id);
		$this->db->update('jec_company');
		return true;
	}
}
