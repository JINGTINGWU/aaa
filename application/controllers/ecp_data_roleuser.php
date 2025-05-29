<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系統權限管理
 * Author: Johnson 2012/07/14
 */
class Ecp_data_roleuser extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_roleusermodel', 'ROLEUSER', true);
 	}
	
 	// 權限列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_roleuser';
		// 檢查登入資訊是否正確
		$this->load->model('ecp_logincheck');
		if (! $this->ecp_logincheck->login_check()) return;
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'role_list' => $this->ROLEUSER->get_role_list(0)
		);
		$this->load->view('ecp_data/ecp_data_role', $data);
	}
	
	// 新增權限
	function role_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->ROLEUSER->role_new($data);
		echo $result;
	}
		
	// 修改權限
	function role_update()
	{
		$data = array(
			'jec_role_id' => $_POST['jec_role_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->ROLEUSER->role_update($data);
		echo $result;
	}
	
	// 刪除權限
	function role_delete()
	{
		$jec_role_id = $_POST['jec_role_id'];
		$result = $this->ROLEUSER->role_delete($jec_role_id);
		echo $result;
	}
	
	// 重新載入權限列表
	function reload_role_list()
	{
		// Control名稱
		$control = 'ecp_data_roleuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$data = array(
			'authority' => $authority,
			'role_list' => $this->ROLEUSER->get_role_list(0)
		);
		$this->load->view('ecp_data/ecp_data_role_list', $data);
	}
	
	// 編輯權限-----------------------------------------------------------------------------------------
	function role_edit()
	{
		$jec_role_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_role_id
		// Control名稱
		$control = 'ecp_data_roleuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 預先整理jec_rolemenu內容
		$this->ROLEUSER->process_rolemenu($jec_role_id);
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'role_data' => $this->ROLEUSER->get_role_list($jec_role_id),
			'role_edit' => $this->ROLEUSER->get_role_edit($jec_role_id)
		);
		$this->load->view('ecp_data/ecp_data_role_edit', $data);
	}
	
	// 更新權限設定
	function update_rolemenu()
	{
		$data = array(
			'jec_role_id' => $_POST['jec_role_id'],
			'checklist' => $_POST['checklist']
		);
		$result = $this->ROLEUSER->update_rolemenu($data);
		echo $result;
	}
	
	// 人員設定-----------------------------------------------------------------------------------------
	function user_list()
	{
		// Control名稱
		$control = 'ecp_data_roleuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 傳入相關資料
		$sort_field = 'value';
		$sort_sequence = 'asc';
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_role' => $this->ROLEUSER->get_role_list(0, true),
			'user_list' => $this->ROLEUSER->get_user_list($sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_role_user', $data);
	}
	
	// 重新載入人員列表
	function reload_user_list()
	{
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_roleuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 傳入相關資料
		$data = array (
			'authority' => $authority,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_role' => $this->ROLEUSER->get_role_list(0, true),
			'user_list' => $this->ROLEUSER->get_user_list($sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_role_user_list', $data);
	}
	
	// 修改人員設定
	function userrole_update()
	{
		$data = array(
			'jec_user_id' => $_POST['jec_user_id'],
			'jec_role_id' => $_POST['jec_role_id'],
			'acctstatus' => $_POST['acctstatus'],
			'isadmin' => $_POST['isadmin']
		);
		$result = $this->ROLEUSER->userrole_update($data);
		echo $result;
	}
}
