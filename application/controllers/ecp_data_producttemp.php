<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 料品範本設定
 * Author: Johnson 2012/07/06
 */
class Ecp_data_producttemp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_producttempmodel', 'PRODTEMP', true);
		$this->load->model('Ecp_sort_utility', 'SORT', true);
 	}
	
 	// 料品範本列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_producttemp';
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
		$config['base_url'] = base_url().'ecp_data_producttemp/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PRODTEMP->get_producttemp_list(0, 0, 0, true, '', 'asc');
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
			'producttemp_list' => $this->PRODTEMP->get_producttemp_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_producttemp', $data);
	}
	
	// 新增範本
	function producttemp_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->PRODTEMP->producttemp_new($data);
		echo $result;
	}
		
	// 修改範本
	function producttemp_update()
	{
		$data = array(
			'jec_producttemp_id' => $_POST['jec_producttemp_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->PRODTEMP->producttemp_update($data);
		echo $result;
	}
	
	// 刪除範本
	function producttemp_delete()
	{
		$jec_producttemp_id = $_POST['jec_producttemp_id'];
		$result = $this->PRODTEMP->producttemp_delete($jec_producttemp_id);
		echo $result;
	}
	
	// 重新載入範本列表
	function reload_producttemp_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_producttemp';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_producttemp/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PRODTEMP->get_producttemp_list(0, 0, 0, true, '', 'asc');
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
			'producttemp_list' => $this->PRODTEMP->get_producttemp_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_producttemp_list', $data);
	}
	
	// 專案範本內容編輯-------------------------------------------------------------------------------------
	// 此處不再做分頁, 因為上頁範本列表的頁次將會和內容分頁的頁次混在一起, 目前暫不處理這個問題
	function producttemp_edit()
	{
		$jec_producttemp_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_producttemp_id
		$pagestart = $this->uri->segment(6);  // 第6個參數傳來目前的頁次(範本列表)
		$sort_field = $this->uri->segment(4);  // 第4個參數傳來排序欄位
		$sort_sequence = $this->uri->segment(5);  // 第5個參數傳來排列順序
		// Control名稱
		$control = 'ecp_data_producttemp';
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
			'pagestart' => $pagestart,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'prod_select' => $this->PRODTEMP->get_prod_select(),
			'producttemp_data' => $this->PRODTEMP->get_producttemp_data($jec_producttemp_id),
			'producttemp_edit' => $this->PRODTEMP->get_producttemp_edit($jec_producttemp_id, 0, 0, false)
		);
		$this->load->view('ecp_data/ecp_data_producttemp_edit', $data);
	}
	
	// 依查詢相關詞重新載入料品選擇清單
	function reload_prod_select()
	{
		$kwstring = $_POST['kwstring'];
		$data = array(
			'prod_select' => $this->PRODTEMP->get_prod_select($kwstring)
		);
		$this->load->view('ecp_data/ecp_data_producttemp_edit_product_select', $data);
	}
	
	// 儲存已選擇的料品或工作明細
	function keyword_select()
	{
		$data = array(
			'jec_producttemp_id' => $_POST['jec_producttemp_id'],
			'checklist' => $_POST['checklist']
		);
		$result = $this->PRODTEMP->keyword_select($data);
		echo $result;
	}
	
	// 排序向上下移動
	// 先在陣列中排序完後，再丟到model去更新seqno
	function producttemp_updown()
	{
		// 陣列以序號大小排序, 此function要包在裏面, usort才能呼叫得到
		function sort_by_seqno($a, $b)
		{
		    if($a['seqno'] == $b['seqno']) return 0;
		    return ($a['seqno'] > $b['seqno']) ? 1 : -1;
		}
		// 先找到要調整陣列的ID
		$id = $_POST['id'];
		$updown = $_POST['updown'];
		$parentid = $_POST['parentid'];
		$seqno = $this->SORT->get_table_seqno('jec_producttempline', 'jec_producttempline_id', 'jec_producttemp_id', $parentid);
		$idx = 0;
		foreach ($seqno as $key => $row)
		{
			if ($row['id'] == $id)
			{
				$idx = $key;
				break;
			}
		}
		// 加減其序號
		$seq = (int)$seqno[$idx]['seqno'];
		if ($updown == 'UP')
			$seq = $seq - 11;
		else
			$seq = $seq + 11;
		$seqno[$idx]['seqno'] = $seq;
		// 陣列重新排序
		usort($seqno, 'sort_by_seqno');
		// 排序結果寫回DB
		foreach ($seqno as $key => $row)
		{
			$this->SORT->update_seqno('jec_producttempline', 'jec_producttempline_id', $row['id'], ($key+1)*10);
		}
		echo true;
	}
	
	// 刪除料品範本內容
	function producttemp_product_delete()
	{
		$data = array(
			'jec_producttempline_id' => $_POST['jec_producttempline_id'],
			'jec_producttemp_id' => $_POST['jec_producttemp_id'],
			'seqno' => $_POST['seqno']
		);
		$result = $this->PRODTEMP->producttemp_product_delete($data);
		echo $result;
	}
	
	// 重新載入範本內容列表
	function reload_producttemp_edit()
	{
		$jec_producttemp_id = $_POST['jec_producttemp_id'];
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_producttemp';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$data = array(
			'authority' => $authority,
			'pagestart' => $pagestart,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'producttemp_edit' => $this->PRODTEMP->get_producttemp_edit($jec_producttemp_id, 0, 0, false)
		);
		$this->load->view('ecp_data/ecp_data_producttemp_edit_list', $data);
	}
}
