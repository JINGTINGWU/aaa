<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 部門及人員
 * Author: Johnson 2012/07/13
 */
class Ecp_data_deptuser extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_deptusermodel', 'DEPTUSER', true);
 	}
	
 	// 部門列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_deptuser';
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
		// 分頁設定
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
        if (!($this->uri->segment($sort_field_para)))
       		$sort_field = 'name';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_deptuser/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DEPTUSER->get_dept_list(0, 0, 0, true, '', 'asc');
		$config['per_page'] = $pagesize;
		$this->pagination->initialize($config);
		if (is_null($this->uri->segment($config['uri_segment'])))
        	$pageno = 0;
        else
        	$pageno = $this->uri->segment($config['uri_segment']);
        // 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $pageno,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_user' => $this->DEPTUSER->get_user(),
			'select_deptuplayer' => $this->DEPTUSER->get_deptuplayer(),
			'dept_list' => $this->DEPTUSER->get_dept_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_dept', $data);
	}
	
	// 新增部門
	function dept_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'jec_deptuplayer_id' => $_POST['jec_deptuplayer_id'],
			'jec_user_id' => $_POST['jec_user_id']
		);
		$result = $this->DEPTUSER->dept_new($data);
		echo $result;
	}
		
	// 修改部門
	function dept_update()
	{
		$data = array(
			'jec_dept_id' => $_POST['jec_dept_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'jec_deptuplayer_id' => $_POST['jec_deptuplayer_id'],
			'jec_user_id' => $_POST['jec_user_id']
		);
		$result = $this->DEPTUSER->dept_update($data);
		echo $result;
	}
	
	// 刪除部門
	function dept_delete()
	{
		$jec_dept_id = $_POST['jec_dept_id'];
		$result = $this->DEPTUSER->dept_delete($jec_dept_id);
		echo $result;
	}
	
	// 重新載入部門列表
	function reload_dept_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_deptuser/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DEPTUSER->get_dept_list(0, 0, 0, true, '', 'asc');
		$config['per_page'] = $pagesize;
		if ($pagesize==0)
			$gopage = 0;
		else
			$gopage = (ceil($config['total_rows']/$pagesize)-1)*$pagesize;
		if ($_POST['opertype'] == "NEW")
		{
			$config['cur_page'] = $gopage;  // 最後一頁
		}
		elseif ($_POST['opertype'] == "SORT")
		{
			$gopage = 0; // 重新排序回到第一頁
		}
		else
		{
			$gopage = $pagestart;  // 目前頁次
			$config['cur_page'] = $gopage;
		}
		$this->pagination->initialize($config);
		$data = array(
			'authority' => $authority,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $gopage,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_user' => $this->DEPTUSER->get_user(),
			'select_deptuplayer' => $this->DEPTUSER->get_deptuplayer(),
			'dept_list' => $this->DEPTUSER->get_dept_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_dept_list', $data);
	}
	
	// 部門展開-----------------------------------------------------------------------------------------
	function dept_expand()
	{
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'dept_expand' => $this->DEPTUSER->get_dept_expand()
		);
		$this->load->view('ecp_data/ecp_data_dept_expand', $data);
	}
	
	// 人員列表---------------------------------------------------------------------------------------
	function user_list()
	{
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 分頁設定
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
        if (!($this->uri->segment($sort_field_para)))
       		$sort_field = 'value';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_deptuser/user_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DEPTUSER->get_user_list(0, 0, 0, true, '', 'asc');
		$config['per_page'] = $pagesize;
		$this->pagination->initialize($config);
		if (is_null($this->uri->segment($config['uri_segment'])))
        	$pageno = 0;
        else
        	$pageno = $this->uri->segment($config['uri_segment']);
        // 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $pageno,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_dept' => $this->DEPTUSER->get_deptuplayer(),
			'select_title' => $this->DEPTUSER->get_title(),
			'select_costtype' => $this->DEPTUSER->get_costtype(),
			'user_list' => $this->DEPTUSER->get_user_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_user', $data);
	}
	
	// 新增人員
	function user_new()
	{
		$data = array(
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'password' => $_POST['password'],
			'jec_dept_id' => $_POST['jec_dept_id'],
			'jec_title_id' => $_POST['jec_title_id'],
			'email' => $_POST['email']
		);
		$result = $this->DEPTUSER->user_new($data);
		echo $result;
	}
	
	// 修改人員
	function user_update()
	{
		$data = array(
			'jec_user_id' => $_POST['jec_user_id'],
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'password' => $_POST['password'],
			'jec_dept_id' => $_POST['jec_dept_id'],
			'jec_title_id' => $_POST['jec_title_id'],
			'email' => $_POST['email'],
			'costtype' => $_POST['costtype']
		);
		$result = $this->DEPTUSER->user_update($data);
		echo $result;
	}
	
	// 刪除人員
	function user_delete()
	{
		$jec_user_id = $_POST['jec_user_id'];
		$result = $this->DEPTUSER->user_delete($jec_user_id);
		echo $result;
	}
	
	// 重新載入人員列表
	function reload_user_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_deptuser/user_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DEPTUSER->get_user_list(0, 0, 0, true, '', 'asc');
		$config['per_page'] = $pagesize;
		if ($pagesize==0)
			$gopage = 0;
		else
			$gopage = (ceil($config['total_rows']/$pagesize)-1)*$pagesize;
		if ($_POST['opertype'] == "NEW")
		{
			$config['cur_page'] = $gopage;  // 最後一頁
		}
		elseif ($_POST['opertype'] == "SORT")
		{
			$gopage = 0; // 重新排序回到第一頁
		}
		else
		{
			$gopage = $pagestart;  // 目前頁次
			$config['cur_page'] = $gopage;
		}
		$this->pagination->initialize($config);
		$data = array(
			'authority' => $authority,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $gopage,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_dept' => $this->DEPTUSER->get_deptuplayer(),
			'select_title' => $this->DEPTUSER->get_title(),
			'select_costtype' => $this->DEPTUSER->get_costtype(),
			'user_list' => $this->DEPTUSER->get_user_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_user_list', $data);
	}
	
	// 人員群組列表---------------------------------------------------------------------------------------
	function usergroup_list()
	{
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'select_user' => $this->DEPTUSER->get_user(),
			'usergroup_list' => $this->DEPTUSER->get_usergroup_list()
		);
		$this->load->view('ecp_data/ecp_data_usergroup', $data);
	}
	
	// 新增群組中的人員
	function usergroup_new()
	{
		$data = array(
			'jec_group_id' => $_POST['jec_group_id'],
			'jec_user_id' => $_POST['jec_user_id']
		);
		$result = $this->DEPTUSER->usergroup_new($data);
		echo $result;
	}
	
	// 刪除群組中的人員
	function usergroup_delete()
	{
		$jec_usergroup_id = $_POST['jec_usergroup_id'];
		$result = $this->DEPTUSER->usergroup_delete($jec_usergroup_id);
		echo $result;
	}
	
	// 重新載入群組人員列表
	function reload_usergroup_list()
	{
		// Control名稱
		$control = 'ecp_data_deptuser';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 傳入相關資料
		$data = array (
			'authority' => $authority,
			'function_name' => $function_name,
			'select_user' => $this->DEPTUSER->get_user(),
			'usergroup_list' => $this->DEPTUSER->get_usergroup_list()
		);
		$this->load->view('ecp_data/ecp_data_usergroup_list', $data);
	}
}
