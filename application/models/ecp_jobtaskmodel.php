<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 任務與工作項目
 * Author: Johnson 2012/06/28
 */
class Ecp_jobtaskmodel extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('Ecp_sort_utility', 'SORT', true);
	}
	
	// 任務DATAMODEL----------------------------------------------------------------------------------
	// 任務特性選項
	function get_jobtype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'工作項目需逐項完成'),
			array('datatype'=>'2', 'name'=>'所有工作項目可一起完成')
		);
		return $row;
	}
	
	// 讀取任務列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_job_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*, b.jec_dept_id, c.name as deptname');
		$this->db->from('jec_job a');
		$this->db->join('jec_user b', 'a.createdby=b.jec_user_id', 'left');
		$this->db->join('jec_dept c', 'b.jec_dept_id=c.jec_dept_id', 'left');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_job_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'deptname';
			//$this->db->order_by("convert($sort_field using big5)".' '.$sort_sequence);
			$this->db->order_by($sort_field.' '.$sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增任務
	function job_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('jobtype', $data['jobtype']);
		$this->db->insert('jec_job');
		return true;
	}
	
	// 修改任務
	function job_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('jobtype', $data['jobtype']);
		$this->db->where('jec_job_id', $data['jec_job_id']);
 		$this->db->update('jec_job');
 		return true;
	}
	
	// 刪除任務
	function job_delete($jec_job_id=0)
	{
		// 先刪除任務中預設的工作項目
		$this->db->select('a.jec_jobtask_id, a.seqno');
		$this->db->from('jec_jobtask a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_job_id', $jec_job_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$data = array(
				'jec_job_id' => $jec_job_id,
				'jec_jobtask_id' => $row['jec_jobtask_id'],
				'seqno' => $row['seqno']
			);
			$this->jobtask_delete($data);
		}
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_job_id', $jec_job_id);
		$this->db->update('jec_job');
		return true;
	}
	
	// 任務&工作項目DATAMODEL-----------------------------------------------------------------------------
	// 讀取任務中預設的工作項目列表
	function get_jobtask_list($jec_job_id)
	{
		$this->db->select('a.*, b.name');
		$this->db->from('jec_jobtask a');
		$this->db->join('jec_task b', 'a.jec_task_id=b.jec_task_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_job_id', $jec_job_id);
		$this->db->order_by('seqno');
		return $this->db->get('')->result_array();
	}
	
	// 新增任務中預設的工作項目
	function jobtask_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('jec_job_id', $data['jec_job_id']);
		$this->db->set('jec_task_id', $data['jec_task_id']);
		$seqno = $this->SORT->get_maxseqno('jec_jobtask', 'jec_job_id', $data['jec_job_id']);
		$this->db->set('seqno', $seqno);
		$this->db->insert('jec_jobtask');
		return true;
	}
	
	// 刪除任務中預設的工作項目
	// 此序號後面的序號要自動補回來, 否則排序時會有一點小問題
	function jobtask_delete($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->set('seqno', 0);
		$this->db->where('jec_jobtask_id', $data['jec_jobtask_id']);
		$this->db->update('jec_jobtask');
		// 後續序號補上來
		$this->SORT->upgrade_seqno('jec_jobtask', 'jec_jobtask_id', 'jec_job_id', $data['jec_job_id'], $data['seqno']);
		return true;
	}
	
	// 工作DATAMODEL----------------------------------------------------------------------------------
	// 工作類別選項
	function get_tasktype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'行政'),
			array('datatype'=>'2', 'name'=>'採購'),
			array('datatype'=>'3', 'name'=>'生產'),
			array('datatype'=>'4', 'name'=>'領用'),
			array('datatype'=>'5', 'name'=>'施工')
		);
		return $row;
	}
	
	// 工作權重選項
	function get_workweight()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'1'),
			array('datatype'=>'2', 'name'=>'2'),
			array('datatype'=>'3', 'name'=>'3'),
			array('datatype'=>'4', 'name'=>'4'),
			array('datatype'=>'5', 'name'=>'5'),
			array('datatype'=>'6', 'name'=>'6'),
			array('datatype'=>'7', 'name'=>'7'),
			array('datatype'=>'8', 'name'=>'8'),
			array('datatype'=>'9', 'name'=>'9')
		);
		return $row;
	}
	
	// 天數選項, 傳入要產生的天數($days), 以及是否包含0天($iszero)
	function get_selectday($days=0, $iszero=false)
	{
		if ($days == 0) return null;
		$row = array();
		if ($iszero)
			$start = 0;
		else
			$start = 1;
		for ($i=$start; $i<=$days; $i++)
		{
			$row[] = array('datatype' => $i, 'name' => $i.' 天');
		}
		return $row;
	}
	
	// 工作處理原則選項
	function get_processtype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'重要'),
			array('datatype'=>'2', 'name'=>'正常'),
			array('datatype'=>'3', 'name'=>'輔助')
		);
		return $row;
	}
	
	// 工作確認方式選項
	function get_confirmtype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'強制'),
			array('datatype'=>'2', 'name'=>'自動'),
			array('datatype'=>'3', 'name'=>'不需確認')
		);
		return $row;
	}
	
	// 檢核類型選項
	function get_checktype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'開始前'),
			array('datatype'=>'2', 'name'=>'完成前'),
		);
		return $row;
	}
	
	// 讀取承辦人及群組選單
	function get_select_usergroup()
	{
		// value值改由1或2再加上id組合的字串(以逗號分隔), 以利判斷由哪個table取資料
		// 1取jec_user, 2取jec_group
		$where = "SELECT CONCAT('1,',jec_user_id) AS id, name, '1' AS datafrom FROM jec_user WHERE isactive='Y' ";
		$where .= "UNION ";
		$where .= "SELECT CONCAT('2,',jec_group_id) AS id, name, '2' AS datafrom FROM jec_group WHERE isactive='Y' ";
		$where .= "ORDER BY datafrom, name";
		$row = $this->db->query($where)->result_array();
		// 增加一筆空白選項
		$row_empty = array(
			'id' => '', 'name' => '', 'datafrom' => '');
		array_unshift($row, $row_empty);
		return $row;
	}
	
	// 讀取工作項目列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_task_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$select = "a.*, CASE WHEN a.usertype='1' THEN (SELECT name FROM jec_user WHERE jec_user_id=a.jec_user_id) ";
		$select .= "WHEN a.usertype='2' THEN (SELECT name FROM jec_group WHERE jec_group_id=a.jec_group_id) ";
		$select .= "END AS usergroup, b.jec_dept_id, c.name as deptname";
		$this->db->select($select, false);
		$this->db->from('jec_task a');
		$this->db->join('jec_user b', 'a.createdby=b.jec_user_id', 'left');
		$this->db->join('jec_dept c', 'b.jec_dept_id=c.jec_dept_id', 'left');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_task_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'deptname';
			if ($sort_field == 'jec_user_id')
			{
				$this->db->order_by('usertype '.$sort_sequence.',jec_user_id '.$sort_sequence.',jec_group_id '.$sort_sequence);
			}
			else
			{
				$this->db->order_by($sort_field . ' ' . $sort_sequence);
			}
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增工作項目
	function task_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('tasktype', $data['tasktype']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('daynotice', $data['daynotice']);
		$this->db->set('daydelay', $data['daydelay']);
		$this->db->set('workweight', $data['workweight']);
		$this->db->set('processtype', $data['processtype']);
		$this->db->set('confirmtype', $data['confirmtype']);
		$this->db->set('usertype', $data['usertype']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->set('jec_group_id', $data['jec_group_id']);
		$this->db->insert('jec_task');
		return true;
	}
	
	// 修改工作項目
	function task_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('tasktype', $data['tasktype']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('daynotice', $data['daynotice']);
		$this->db->set('daydelay', $data['daydelay']);
		$this->db->set('workweight', $data['workweight']);
		$this->db->set('processtype', $data['processtype']);
		$this->db->set('confirmtype', $data['confirmtype']);
		$this->db->set('usertype', $data['usertype']);
		$this->db->set('jec_user_id', $data['jec_user_id']);
		$this->db->set('jec_group_id', $data['jec_group_id']);
		$this->db->where('jec_task_id', $data['jec_task_id']);
 		$this->db->update('jec_task');
 		return true;
	}
	
	// 刪除工作項目
	function task_delete($jec_task_id=0)
	{
		// 先刪除工作項目檢核表
		$this->db->select('a.jec_taskcheck_id');
		$this->db->from('jec_taskcheck a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_task_id', $jec_task_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->taskcheck_delete($row['jec_taskcheck_id']);
		}
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_task_id', $jec_task_id);
 		$this->db->update('jec_task');
 		return true;
	}
	
	// 工作檢核表DATAMODEL-------------------------------------------------------------------------------
	// 讀取工作檢核表
	function get_taskcheck_list($jec_task_id)
	{
		$this->db->select('a.*, b.name');
		$this->db->from('jec_taskcheck a');
		$this->db->join('jec_task b', 'a.jec_task_check_id=b.jec_task_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_task_id', $jec_task_id);
		$this->db->order_by('checktype, jec_task_check_id');
		return $this->db->get('')->result_array();
	}
	
	// 新增檢核工作項目
	function taskcheck_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('jec_task_id', $data['jec_task_id']);
		$this->db->set('jec_task_check_id', $data['jec_task_check_id']);
		$this->db->set('checktype', $data['checktype']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_taskcheck');
		return true;
	}
	
	// 刪除檢核工作項目
	function taskcheck_delete($jec_taskcheck_id=0)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_taskcheck_id', $jec_taskcheck_id);
 		$this->db->update('jec_taskcheck');
		return true;
	}
}
