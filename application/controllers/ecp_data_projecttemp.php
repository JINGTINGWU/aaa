<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 專案範本設定
 * Author: Johnson 2012/07/03
 */
class Ecp_data_projecttemp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_projecttempmodel', 'PROJTEMP', true);
		$this->load->model('Ecp_sort_utility', 'SORT', true);
		$this->load->model('Ecp_deptusermodel', 'DEPTUSER', true);
 	}
	
 	// 專案範本列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_projecttemp';
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
		$config['base_url'] = base_url().'ecp_data_projecttemp/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROJTEMP->get_projecttemp_list(0, 0, 0, true, '', 'asc');
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
			'projecttemp_list' => $this->PROJTEMP->get_projecttemp_list(0, $pagesize, $pageno, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_projecttemp', $data);
	}
	
	// 新增範本
	function projecttemp_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->PROJTEMP->projecttemp_new($data);
		echo $result;
	}
		
	// 修改範本
	function projecttemp_update()
	{
		$data = array(
			'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
			'name' => $_POST['name'],
			'jec_dept_id' => $_POST['jec_dept_id'],
			'description' => $_POST['description']
		);
		$result = $this->PROJTEMP->projecttemp_update($data);
		echo $result;
	}
	
	// 刪除範本
	function projecttemp_delete()
	{
		$jec_projecttemp_id = $_POST['jec_projecttemp_id'];
		$result = $this->PROJTEMP->projecttemp_delete($jec_projecttemp_id);
		echo $result;
	}
	
	// 重新載入範本列表
	function reload_projecttemp_list()
	{
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_projecttemp';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
        $pagesize = 0;
        $sort_field_para = 3;  // 第3個參數為目前排序的欄位
        $sort_sequence_para = 4;  // 第4個參數為目前排列的順序
        $config['uri_segment'] = 5;  // 第5個參數為頁數
		$config['base_url'] = base_url().'ecp_data_projecttemp/index/'.$sort_field.'/'.$sort_sequence;
		$config['total_rows'] = $this->PROJTEMP->get_projecttemp_list(0, 0, 0, true, '', 'asc');
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
			'projecttemp_list' => $this->PROJTEMP->get_projecttemp_list(0, $pagesize, $gopage, false, $sort_field, $sort_sequence)
		);
		$this->load->view('ecp_data/ecp_data_projecttemp_list', $data);
	}
	
	// 專案範本內容編輯-------------------------------------------------------------------------------------
	// 此處不再做分頁, 因為上頁範本列表的頁次將會和內容分頁的頁次混在一起, 目前暫不處理這個問題
	function projecttemp_edit()
	{
		$jec_projecttemp_id = $this->uri->segment(3);  // 第3個參數傳來要編輯的jec_projecttemp_id
		$pagestart = $this->uri->segment(6);  // 第6個參數傳來目前的頁次(範本列表)
		$sort_field = $this->uri->segment(4);  // 第4個參數傳來排序欄位
		$sort_sequence = $this->uri->segment(5);  // 第5個參數傳來排列順序
		// Control名稱
		$control = 'ecp_data_projecttemp';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
//		// 分頁設定
//      $pagesize = 12;
//      $config['uri_segment'] = 4;  // 第4個參數為頁數
//		$config['base_url'] = base_url().'ecp_data_projecttemp/projecttemp_edit/'.$jec_projecttemp_id;
//		$config['total_rows'] = $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, 0, 0, true);
//		$config['per_page'] = $pagesize;
//		$this->pagination->initialize($config);
//		if (is_null($this->uri->segment($config['uri_segment'])))
//        	$pageno = 0;
//      else
//        	$pageno = $this->uri->segment($config['uri_segment']);
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
//			'pagelink' => $this->pagination->create_links(),
//			'total_rows' => $config['total_rows'],
//			'pagestart' => $pageno,
//			'pagesize' => $pagesize,
			'pagestart' => $pagestart,
			'sort_field' => 'name',
			'sort_sequence' => 'asc',
			'projecttemp_data' => $this->PROJTEMP->get_projecttemp_data($jec_projecttemp_id),
			'select_job' => $this->PROJTEMP->get_select_job(),
			'select_task' => $this->PROJTEMP->get_select_task(),
			'maxseq_job' => $this->PROJTEMP->get_max_job_seqno($jec_projecttemp_id),
			'maxseq_task' => $this->PROJTEMP->get_max_task_seqno($jec_projecttemp_id),
//			'projecttemp_edit' => $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, $pagesize, $pageno, false)
			'projecttemp_edit' => $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, 0, 0, false)
		);
		$this->load->view('ecp_data/ecp_data_projecttemp_edit', $data);
	}
	
	// 排序向上下移動
	// 先在陣列中排序完後，再丟到model去更新seqno
	function projecttemp_updown()
	{
		// 陣列以序號大小排序, 此function要包在裏面, usort才能呼叫得到
		function sort_by_seqno($a, $b)
		{
		    if($a['seqno'] == $b['seqno']) return 0;
		    return ($a['seqno'] > $b['seqno']) ? 1 : -1;
		}
		// 先找到要調整陣列的ID
		$type = $_POST['type'];  // JOB or TASK
		$id = $_POST['id'];
		$parentid = $_POST['parentid'];
		$updown = $_POST['updown'];
		if ($type == 'JOB')
			$seqno = $this->SORT->get_table_seqno('jec_projecttempjob', 'jec_projecttempjob_id', 'jec_projecttemp_id', $parentid);
		else
			$seqno = $this->SORT->get_table_seqno('jec_projecttemptask', 'jec_projecttemptask_id', 'jec_projecttempjob_id', $parentid);
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
			if ($type == 'JOB')
				$this->SORT->update_seqno('jec_projecttempjob', 'jec_projecttempjob_id', $row['id'], ($key+1)*10);
			else
				$this->SORT->update_seqno('jec_projecttemptask', 'jec_projecttemptask_id', $row['id'], ($key+1)*10);
		}
		echo true;
	}
	
	// 新增任務
	function job_new()
	{
		$data = array(
			'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
			'jec_job_id' => $_POST['jec_job_id']
		);
		$result = $this->PROJTEMP->job_new($data);
		echo $result;
	}
	
	// 新增工作項目
	function task_new()
	{
		$data = array(
			'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
			'jec_projecttempjob_id' => $_POST['jec_projecttempjob_id'],
			'jec_task_id' => $_POST['jec_task_id']
		);
		$result = $this->PROJTEMP->task_new($data);
		echo $result;
	}
	
	// 刪除任務或工作項目
	function jobtask_delete()
	{
		if ($_POST['type'] == 'JOB')
		{
			$data = array(
				'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
				'jec_projecttempjob_id' => $_POST['id'],
				'seqno' => $_POST['seqno']
			);
			$result = $this->PROJTEMP->job_delete($data);
			echo $result;
		}
		else
		{
			$data = array(
				'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
				'jec_projecttempjob_id' => $_POST['jobid'],
				'jec_projecttemptask_id' => $_POST['id'],
				'seqno' => $_POST['seqno']
			);
			$result = $this->PROJTEMP->task_delete($data);
			echo $result;
		}
	}
	// 編輯工作項目
	function jobtask_edit()
	{
		if ($_POST['type'] == 'TASK')		
		{
			$data = array(
				'jec_projecttemp_id' => $_POST['jec_projecttemp_id'],
				'jec_projecttempjob_id' => $_POST['jobid'],
				'jec_projecttemptask_id' => $_POST['id'],
				'seqno' => $_POST['seqno'],
				'startdays'=> $_POST['startdays'],
				'workdays'=> $_POST['workdays'],
				'user'=> $_POST['user'],
				'superuser'=> $_POST['superuser']
			);
			$result = $this->PROJTEMP->task_edit($data);
			echo $result;
		}
	}
	
	// 重新載入範本內容列表
	function reload_projecttemp_edit()
	{
		$jec_projecttemp_id = $_POST['jec_projecttemp_id'];
		$pagestart = $_POST['pagestart'];
		$sort_field = $_POST['sort_field'];
		$sort_sequence = $_POST['sort_sequence'];
		// Control名稱
		$control = 'ecp_data_projecttemp';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
//		// 分頁設定, 新增時自動跳到最後一頁以利顯示新增的資料
//      $pagesize = 12;
//      $config['uri_segment'] = 4;  // 第4個參數為頁數
//		$config['base_url'] = base_url().'ecp_data_projecttemp/projecttemp_edit/'.$jec_projecttemp_id;
//		$config['total_rows'] = $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, 0, 0, true);
//		$config['per_page'] = $pagesize;
//		$gopage = (ceil($config['total_rows']/$pagesize)-1)*$pagesize;
//		if ($_POST['opertype'] == "NEW1")
//		{
//			$config['cur_page'] = $gopage;  // 最後一頁
//		}
//		else
//		{
//			$gopage = $pagestart;  // 目前頁次
//			$config['cur_page'] = $gopage;
//		}
//		$this->pagination->initialize($config);
		$data = array(
			'authority' => $authority,
//			'pagelink' => $this->pagination->create_links(),
//			'total_rows' => $config['total_rows'],
//			'pagestart' => $gopage,
//			'pagesize' => $pagesize,
			'pagestart' => $pagestart,
			'sort_field' => $sort_field,
			'sort_sequence' => $sort_sequence,
			'select_job' => $this->PROJTEMP->get_select_job(),
			'select_task' => $this->PROJTEMP->get_select_task(),
			'maxseq_job' => $this->PROJTEMP->get_max_job_seqno($jec_projecttemp_id),
			'maxseq_task' => $this->PROJTEMP->get_max_task_seqno($jec_projecttemp_id),
//			'projecttemp_edit' => $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, $pagesize, $gopage, false)
			'projecttemp_edit' => $this->PROJTEMP->get_projecttemp_edit($jec_projecttemp_id, 0, 0, false)
		);
		$this->load->view('ecp_data/ecp_data_projecttemp_edit_list', $data);
	}
}
