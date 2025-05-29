<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 客戶/廠商
 * Author: Johnson 2012/07/10
 */
class Ecp_data_customer_vendor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_custvendmodel', 'CUSTVEND', true);
 	}
	
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_customer_vendor';
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
        $pagesize = 30;
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
		$config['base_url'] = base_url().'ecp_data_customer_vendor/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->CUSTVEND->get_customer_list(0, 0, 0, true);
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
			'customer_list' => $this->CUSTVEND->get_customer_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_customer', $data);
	}
	
	// 新增客戶
	function customer_new()
	{
		$data = array(
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'name2' => $_POST['name2'],
			'taxid' => $_POST['taxid'],
			'boss' => $_POST['boss'],
			'contact' => $_POST['contact'],
			'telephone1' => $_POST['telephone1'],
			'telephone2' => $_POST['telephone2'],
			'faxphone' => $_POST['faxphone'],
			'address' => $_POST['address'],
			'email' => $_POST['email'],
			'description' => $_POST['description']
		);
		$result = $this->CUSTVEND->customer_new($data);
		echo $result;
	}
		
	// 修改客戶
	function customer_update()
	{
		$data = array(
			'jec_customer_id' => $_POST['jec_customer_id'],
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'name2' => $_POST['name2'],
			'taxid' => $_POST['taxid'],
			'boss' => $_POST['boss'],
			'contact' => $_POST['contact'],
			'telephone1' => $_POST['telephone1'],
			'telephone2' => $_POST['telephone2'],
			'faxphone' => $_POST['faxphone'],
			'address' => $_POST['address'],
			'email' => $_POST['email'],
			'description' => $_POST['description']
		);
		$result = $this->CUSTVEND->customer_update($data);
		echo $result;
	}
	
	// 刪除客戶
	function customer_delete()
	{
		$jec_customer_id = $_POST['jec_customer_id'];
		$result = $this->CUSTVEND->customer_delete($jec_customer_id);
		echo $result;
	}
	
	// 重新載入客戶列表
	function reload_customer_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_customer_vendor';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 30;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_customer_vendor/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->CUSTVEND->get_customer_list(0, 0, 0, true);
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
		$data = array(
			'authority' => $authority,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $gopage,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'customer_list' => $this->CUSTVEND->get_customer_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_customer_list', $data);
	}
	
	// =============================================================================================
	// 廠商列表
	function vendor_list()
	{
		// Control名稱
		$control = 'ecp_data_customer_vendor';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 分頁設定
        $pagesize = 30;
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
		$config['base_url'] = base_url().'ecp_data_customer_vendor/vendor_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->CUSTVEND->get_vendor_list(0, 0, 0, true);
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
			'vendor_list' => $this->CUSTVEND->get_vendor_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_vendor', $data);
		
	}
	
	// 新增廠商
	function vendor_new()
	{
		$data = array(
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'name2' => $_POST['name2'],
			'taxid' => $_POST['taxid'],
			'vendorkind' => $_POST['vendorkind'],
			'contact' => $_POST['contact'],
			'telephone1' => $_POST['telephone1'],
			'telephone2' => $_POST['telephone2'],
			'faxphone' => $_POST['faxphone'],
			'address' => $_POST['address'],
			'email' => $_POST['email'],
			'description' => $_POST['description']
		);
		$result = $this->CUSTVEND->vendor_new($data);
		echo $result;
	}
		
	// 修改廠商
	function vendor_update()
	{
		$data = array(
			'jec_vendor_id' => $_POST['jec_vendor_id'],
			'value' => $_POST['value'],
			'name' => $_POST['name'],
			'name2' => $_POST['name2'],
			'taxid' => $_POST['taxid'],
			'vendorkind' => $_POST['vendorkind'],
			'contact' => $_POST['contact'],
			'telephone1' => $_POST['telephone1'],
			'telephone2' => $_POST['telephone2'],
			'faxphone' => $_POST['faxphone'],
			'address' => $_POST['address'],
			'email' => $_POST['email'],
			'description' => $_POST['description']
		);
		$result = $this->CUSTVEND->vendor_update($data);
		echo $result;
	}
	
	// 刪除廠商
	function vendor_delete()
	{
		$jec_vendor_id = $_POST['jec_vendor_id'];
		$result = $this->CUSTVEND->vendor_delete($jec_vendor_id);
		echo $result;
	}
	
	// 重新載入廠商列表
	function reload_vendor_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_customer_vendor';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 30;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_customer_vendor/vendor_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->CUSTVEND->get_vendor_list(0, 0, 0, true);
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
		$data = array(
			'authority' => $authority,
			'pagelink' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'pagestart' => $gopage,
			'pagesize' => $pagesize,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'vendor_list' => $this->CUSTVEND->get_vendor_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_vendor_list', $data);
	}
}
