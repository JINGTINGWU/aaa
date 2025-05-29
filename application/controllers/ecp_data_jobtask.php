<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 任務及工作項目
 * Author: Johnson 2012/06/25
 */
class Ecp_data_jobtask extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_jobtaskmodel', 'JOBTASK', true);
		$this->load->model('Ecp_productmodel', 'PROD', true);
		$this->load->model('Ecp_sort_utility', 'SORT', true);
 	}
	
 	// 任務列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_jobtask';
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
       		$sort_field = 'deptname';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_jobtask/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->JOBTASK->get_job_list(0, 0, 0, true, '', 'asc');
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
			'select_jobtype' => $this->JOBTASK->get_jobtype(),
			'job_list' => $this->JOBTASK->get_job_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_job', $data);
	}
	
	// 新增任務
	function job_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'jobtype' => $_POST['jobtype']
		);
		$result = $this->JOBTASK->job_new($data);
		echo $result;
	}
		
	// 修改任務
	function job_update()
	{
		$data = array(
			'jec_job_id' => $_POST['jec_job_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'jobtype' => $_POST['jobtype']
		);
		$result = $this->JOBTASK->job_update($data);
		echo $result;
	}
	
	// 刪除任務
	function job_delete()
	{
		$jec_job_id = $_POST['jec_job_id'];
		$result = $this->JOBTASK->job_delete($jec_job_id);
		echo $result;
	}
	
	// 重新載入任務列表
	function reload_job_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_jobtask';
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
		$config['base_url'] = base_url().'ecp_data_jobtask/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->JOBTASK->get_job_list(0, 0, 0, true, '', 'asc');
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
			'select_jobtype' => $this->JOBTASK->get_jobtype(),
			'job_list' => $this->JOBTASK->get_job_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_job_list', $data);
	}
	
	// 任務&工作項目--------------------------------------------------------------------------------------
	function jobtask_list()
	{
		$jec_job_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_job_id
		$pagestart = $this->uri->segment(6);  // 第6個參數傳來目前的頁次
		$sort_field = $this->uri->segment(4);  // 第4個參數傳來排序欄位
		$sort_sequence = $this->uri->segment(5);  // 第5個參數傳來排列順序
		// Control名稱
		$control = 'ecp_data_jobtask';
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
			'select_task' => $this->JOBTASK->get_task_list(0, 0, 0, false),
			'job_data' => $this->JOBTASK->get_job_list($jec_job_id, 0, 0, false),
			'jobtask_list' => $this->JOBTASK->get_jobtask_list($jec_job_id)
		);
		$this->load->view('ecp_data/ecp_data_jobtask', $data);
	}
	
	// 排序向上下移動
	// 先在陣列中排序完後，再丟到model去更新seqno
	function jobtask_updown()
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
		$seqno = $this->SORT->get_table_seqno('jec_jobtask', 'jec_jobtask_id', 'jec_job_id', $parentid);
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
			$this->SORT->update_seqno('jec_jobtask', 'jec_jobtask_id', $row['id'], ($key+1)*10);
		}
		echo true;
	}
	
	// 新增任務中預設的工作項目
	function jobtask_new()
	{
		$data = array(
			'jec_job_id' => $_POST['jec_job_id'],
			'jec_task_id' => $_POST['jec_task_id']
		);
		$result = $this->JOBTASK->jobtask_new($data);
		echo $result;
	}
	
	// 刪除任務中預設的工作項目
	function jobtask_delete()
	{
		$data = array(
			'jec_job_id' => $_POST['jec_job_id'],
			'jec_jobtask_id' => $_POST['jec_jobtask_id'],
			'seqno' => $_POST['seqno']
		);
		$result = $this->JOBTASK->jobtask_delete($data);
		echo $result;
	}
	
	// 重新載入任務中現有預設的工作項目列表
	function reload_jobtask_list()
	{
		$jec_job_id = $_POST['jec_job_id'];
		$pagestart = $_POST['pagestart'];
		// Control名稱
		$control = 'ecp_data_jobtask';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$data = array(
			'authority' => $authority,
			'pagestart' => $pagestart,
			'jobtask_list' => $this->JOBTASK->get_jobtask_list($jec_job_id)
		);
		$this->load->view('ecp_data/ecp_data_jobtask_list', $data);
	}
	
	// 工作項目列表---------------------------------------------------------------------------------------
	function task_list()
	{
		// Control名稱
		$control = 'ecp_data_jobtask';
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
       		$sort_field = 'deptname';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_jobtask/task_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->JOBTASK->get_task_list(0, 0, 0, true, '', 'asc');
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
			'select_tasktype' => $this->JOBTASK->get_tasktype(),
			'select_workweight' => $this->JOBTASK->get_workweight(),
			'select_processtype' => $this->JOBTASK->get_processtype(),
			'select_confirmtype' => $this->JOBTASK->get_confirmtype(),
			'select_usergroup' => $this->JOBTASK->get_select_usergroup(),
			'select_daynotice' => $this->JOBTASK->get_selectday(30, false),
			'select_daydelay' => $this->JOBTASK->get_selectday(30, true),
			'task_list' => $this->JOBTASK->get_task_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_task', $data);
	}
	
	// 新增工作項目
	// 若user或group沒有資料時要改null值, 否則FK會出問題
	function task_new()
	{
		// 承辦人VALUE需先拆解
		$usergroup = explode(',', $_POST['usergroup']);
		if ($usergroup[0] == '1')
		{
			$usertype = '1';
			$jec_user_id = $usergroup[1];
			$jec_group_id = null;
		}
		else if ($usergroup[0] == '2')
		{
			$usertype = '2';
			$jec_user_id = null;
			$jec_group_id = $usergroup[1];
		}
		else
		{
			$usertype = '1';
			$jec_user_id = null;
			$jec_group_id = null;
		}
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'tasktype' => $_POST['tasktype'],
			'daywork' => $_POST['daywork'],
			'daynotice' => $_POST['daynotice'],
			'daydelay' => $_POST['daydelay'],
			'workweight' => $_POST['workweight'],
			'processtype' => $_POST['processtype'],
			'confirmtype' => $_POST['confirmtype'],
			'usertype' => $usertype,
			'jec_user_id' => $jec_user_id,
			'jec_group_id' => $jec_group_id
		);
		$result = $this->JOBTASK->task_new($data);
		echo $result;
	}
	
	// 修改工作項目
	function task_update()
	{
		// 承辦人VALUE需先拆解
		$usergroup = explode(',', $_POST['usergroup']);
		if ($usergroup[0] == '1')
		{
			$usertype = '1';
			$jec_user_id = $usergroup[1];
			$jec_group_id = null;
		}
		else if ($usergroup[0] == '2')
		{
			$usertype = '2';
			$jec_user_id = null;
			$jec_group_id = $usergroup[1];
		}
		else
		{
			$usertype = '1';
			$jec_user_id = null;
			$jec_group_id = null;
		}
		$data = array(
			'jec_task_id' => $_POST['jec_task_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'tasktype' => $_POST['tasktype'],
			'daywork' => $_POST['daywork'],
			'daynotice' => $_POST['daynotice'],
			'daydelay' => $_POST['daydelay'],
			'workweight' => $_POST['workweight'],
			'processtype' => $_POST['processtype'],
			'confirmtype' => $_POST['confirmtype'],
			'usertype' => $usertype,
			'jec_user_id' => $jec_user_id,
			'jec_group_id' => $jec_group_id
		);
		$result = $this->JOBTASK->task_update($data);
		echo $result;
	}
	
	// 刪除工作項目
	function task_delete()
	{
		$jec_task_id = $_POST['jec_task_id'];
		$result = $this->JOBTASK->task_delete($jec_task_id);
		echo $result;
	}
	
	// 重新載入工作項目列表
	function reload_task_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_jobtask';
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
		$config['base_url'] = base_url().'ecp_data_jobtask/task_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->JOBTASK->get_task_list(0, 0, 0, true, '', 'asc');
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
			'select_tasktype' => $this->JOBTASK->get_tasktype(),
			'select_workweight' => $this->JOBTASK->get_workweight(),
			'select_processtype' => $this->JOBTASK->get_processtype(),
			'select_confirmtype' => $this->JOBTASK->get_confirmtype(),
			'select_usergroup' => $this->JOBTASK->get_select_usergroup(),
			'select_daynotice' => $this->JOBTASK->get_selectday(30, false),
			'select_daydelay' => $this->JOBTASK->get_selectday(30, true),
			'task_list' => $this->JOBTASK->get_task_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_task_list', $data);
	}
	
	// 工作項目檢核表--------------------------------------------------------------------------------------
	function task_check()
	{
		$jec_task_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_task_id
		$pagestart = $this->uri->segment(6);  // 第6個參數傳來目前的頁次
		$sort_field = $this->uri->segment(4);  // 第4個參數傳來排序欄位
		$sort_sequence = $this->uri->segment(5);  // 第5個參數傳來排列順序
		// Control名稱
		$control = 'ecp_data_jobtask';
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
			'select_task' => $this->JOBTASK->get_task_list(0, 0, 0, false),
			'select_checktype' => $this->JOBTASK->get_checktype(),
			'task_data' => $this->JOBTASK->get_task_list($jec_task_id, 0, 0, false),
			'taskcheck_list' => $this->JOBTASK->get_taskcheck_list($jec_task_id)
		);
		$this->load->view('ecp_data/ecp_data_taskcheck', $data);
	}
	
	// 新增檢核工作項目
	function taskcheck_new()
	{
		$data = array(
			'jec_task_id' => $_POST['jec_task_id'],
			'jec_task_check_id' => $_POST['jec_task_check_id'],
			'checktype' => $_POST['checktype'],
			'description' => $_POST['description']
		);
		$result = $this->JOBTASK->taskcheck_new($data);
		echo $result;
	}
	
	// 刪除檢核工作項目
	function taskcheck_delete()
	{
		$jec_taskcheck_id = $_POST['jec_taskcheck_id'];
		$result = $this->JOBTASK->taskcheck_delete($jec_taskcheck_id);
		echo $result;
	}
	
	// 工作明細列表---------------------------------------------------------------------------------------
	function work_list()
	{
		// Control名稱
		$control = 'ecp_data_jobtask';
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
       		$sort_field = 'deptname';
        else
        	$sort_field = $this->uri->segment($sort_field_para);
        if (!($this->uri->segment($sort_sequence_para)))
       		$sort_sequence = 'asc';
        else
        	$sort_sequence = $this->uri->segment($sort_sequence_para);
		$config['base_url'] = base_url().'ecp_data_jobtask/work_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROD->get_work_list(0, 0, 0, true, '', 'asc');
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
			'select_uom' => $this->PROD->get_uom(),
			'work_list' => $this->PROD->get_work_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_product_work', $data);
	}
	
	// 新增工作明細
	function work_new()
	{
		$data = array(
			//'value' => $_POST['value'],
			'jec_uom_id' => $_POST['jec_uom_id'],
			'name' => $_POST['name'],
			'price' => $_POST['price'],
			'daywork' => $_POST['daywork'],
			'description' => $_POST['description']
		);
		$result = $this->PROD->work_new($data);
		echo $result;
	}
	
	// 修改工作明細
	function work_update()
	{
		$data = array(
			'jec_product_id' => $_POST['jec_product_id'],
			//'value' => $_POST['value'],
			'jec_uom_id' => $_POST['jec_uom_id'],
			'name' => $_POST['name'],
			'price' => $_POST['price'],
			'daywork' => $_POST['daywork'],
			'description' => $_POST['description']
		);
		$result = $this->PROD->work_update($data);
		echo $result;
	}
	
	// 刪除工作明細
	function work_delete()
	{
		$jec_product_id = $_POST['jec_product_id'];
		$result = $this->PROD->work_delete($jec_product_id);
		echo $result;
	}
	
	// 重新載入工作明細列表
	function reload_work_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_jobtask';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 0;
         $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_jobtask/work_list/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROD->get_work_list(0, 0, 0, true, '', 'asc');
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
			'select_uom' => $this->PROD->get_uom(),
			'work_list' => $this->PROD->get_work_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_product_work_list', $data);
	}	
}
