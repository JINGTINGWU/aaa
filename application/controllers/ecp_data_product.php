<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 料品與工作明細
 * Author: Johnson 2012/07/02
 */
class Ecp_data_product extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_productmodel', 'PROD', true);
 	}
	
 	// 料品列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_product';
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
       		$sort_field = 'name';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_product/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROD->get_prod_list(0, 0, 0, true, '', 'asc');
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
			'select_prodtype' => $this->PROD->get_prodtype(),
			'select_uom' => $this->PROD->get_uom(),
			'select_vendor' => $this->PROD->get_vendor(),
			'prod_list' => $this->PROD->get_prod_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_product', $data);
	}
	
	// 新增料品
	function prod_new()
	{
		$data = array(
			//'value' => $_POST['value'],
			'prodtype' => $_POST['prodtype'],
			'jec_uom_id' => $_POST['jec_uom_id'],
			'name' => $_POST['name'],
			'specification' => $_POST['specification'],
			'price' => $_POST['price'],
			'daywork' => $_POST['daywork'],
			'jec_vendor_id' => $_POST['jec_vendor_id'],
			'description' => $_POST['description']
		);
		$result = $this->PROD->prod_new($data);
		echo $result;
	}
		
	// 修改料品
	function prod_update()
	{
		$data = array(
			'jec_product_id' => $_POST['jec_product_id'],
			//'value' => $_POST['value'],
			'prodtype' => $_POST['prodtype'],
			'jec_uom_id' => $_POST['jec_uom_id'],
			'name' => $_POST['name'],
			'specification' => $_POST['specification'],
			'price' => $_POST['price'],
			'daywork' => $_POST['daywork'],
			'jec_vendor_id' => $_POST['jec_vendor_id'],
			'description' => $_POST['description']
		);
		$result = $this->PROD->prod_update($data);
		echo $result;
	}
	
	// 刪除料品
	function prod_delete()
	{
		$jec_product_id = $_POST['jec_product_id'];
		$result = $this->PROD->prod_delete($jec_product_id);
		echo $result;
	}
	
	// 重新載入料品列表
	function reload_prod_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_product';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 30;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_product/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROD->get_prod_list(0, 0, 0, true, '', 'asc');
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
			'select_prodtype' => $this->PROD->get_prodtype(),
			'select_uom' => $this->PROD->get_uom(),
			'select_vendor' => $this->PROD->get_vendor(),
			'prod_list' => $this->PROD->get_prod_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_product_list', $data);
	}
	
	// ERP對應----------------------------------------------------------------------------------------
	function erp_correspond()
	{
		$jec_product_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_product_id
		$pagestart = $this->uri->segment(6);  // 第6個參數傳來目前的頁次
		$sort_field = $this->uri->segment(4);  // 第4個參數傳來排序欄位
		$sort_sequence = $this->uri->segment(5);  // 第5個參數傳來排列順序
		// Control名稱
		$control = 'ecp_data_product';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 載入公用函數
		$this->load->library('ecp_flag');
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'pagestart' => $pagestart,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'prod_data' => $this->PROD->get_prod_list($jec_product_id, 0, 0, false),
			'proderp_list' => $this->PROD->get_proderp_list($jec_product_id),
			'proderp_select' => $this->PROD->get_proderp_select()
		);
		$this->load->view('ecp_data/ecp_data_product_erp', $data);
	}
	
	// 重新載ERP材料對應清單
	function reload_proderp_list()
	{
		$jec_product_id = $_POST['jec_product_id'];
		$data = array(
			'proderp_list' => $this->PROD->get_proderp_list($jec_product_id)
		);
		$this->load->view('ecp_data/ecp_data_product_proderp_list', $data);
	}
	
	// 依查詢相關詞重新載入ERP材料選擇資料
	function reload_proderp_select()
	{
		$kwstring = $_POST['kwstring'];
		$data = array(
			'proderp_select' => $this->PROD->get_proderp_select($kwstring)
		);
		$this->load->view('ecp_data/ecp_data_product_proderp_select', $data);
	}
	
	// 儲存已選擇的ERP材料
	function keyword_select()
	{
		$data = array(
			'jec_product_id' => $_POST['jec_product_id'],
			'checklist' => $_POST['checklist']
		);
		$result = $this->PROD->keyword_select($data);
		echo $result;
	}
	
	// 移除已選擇的ERP材料
	function keyword_delete()
	{
		$data = array(
			'jec_product_id' => $_POST['jec_product_id'],
			'checklist' => $_POST['checklist']
		);
		$result = $this->PROD->keyword_delete($data);
		echo $result;
	}
}
