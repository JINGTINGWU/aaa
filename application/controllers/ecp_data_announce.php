<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系統公告管理
 * Author: Johnson 2012/07/14
 */
class Ecp_data_announce extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_datamodel', 'DATA', true);
 	}
	
 	// 公告列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_announce';
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
        $pagesize = 11;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
        if (!($this->uri->segment($sort_field_para)))
       		$sort_field = 'startdate';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'desc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_announce/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DATA->get_announce_list(0, 0, 0, true, '', 'desc');
		$config['per_page'] = $pagesize;
		$this->pagination->initialize($config);
		if (is_null($this->uri->segment($config['uri_segment'])))
        	$pageno = 0;
        else
        	$pageno = $this->uri->segment($config['uri_segment']);
        // 傳入相關資料
        $loginparameters = $this->session->userdata(LOGIN_SESSION);
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
			//'select_user' => $this->DATA->get_user(),
			'jec_user_id' => $loginparameters['jec_user_id'],
			'user_name' => $loginparameters['name'],
			'announce_list' => $this->DATA->get_announce_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_announce', $data);
	}
	
	// 新增公告
	function announce_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'jec_user_id' => $_POST['jec_user_id'],
			'startdate' => $_POST['startdate'],
			'enddate' => $_POST['enddate']
		);
		$result = $this->DATA->announce_new($data);
		echo $result;
	}
		
	// 修改公告
	function announce_update()
	{
		$data = array(
			'jec_announce_id' => $_POST['jec_announce_id'],
			'name' => $_POST['name'],
			'jec_user_id' => $_POST['jec_user_id']
		);
		$result = $this->DATA->announce_update($data);
		echo $result;
	}
	
	// 刪除公告
	function announce_delete()
	{
		$jec_announce_id = $_POST['jec_announce_id'];
		$result = $this->DATA->announce_delete($jec_announce_id);
		echo $result;
	}
	
	// 重新載入公告列表
	function reload_announce_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_announce';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
        $pagesize = 11;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_announce/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->DATA->get_announce_list(0, 0, 0, true, '', 'desc');
		$config['per_page'] = $pagesize;
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
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$data = array(
			'authority' => $authority,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $gopage,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			//'select_user' => $this->DATA->get_user(),
			'jec_user_id' => $loginparameters['jec_user_id'],
			'user_name' => $loginparameters['name'],
			'announce_list' => $this->DATA->get_announce_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_announce_list', $data);
	}
}
