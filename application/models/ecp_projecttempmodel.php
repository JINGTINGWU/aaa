<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 專案範本
 * Author: Johnson 2012/07/03
 */
class Ecp_projecttempmodel extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('Ecp_sort_utility', 'SORT', true);
	}
	
	// 範本DATAMODEL----------------------------------------------------------------------------------
	// 讀取範本列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_projecttemp_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_projecttemp a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_projecttemp_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'name';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增範本
	function projecttemp_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_projecttemp');
		return true;
	}
	
	// 修改範本
	function projecttemp_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('jec_dept_id', $data['jec_dept_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_projecttemp_id', $data['jec_projecttemp_id']);
 		$this->db->update('jec_projecttemp');
 		return true;
	}
	
	// 刪除範本
	function projecttemp_delete($jec_projecttemp_id=0)
	{
		// 先刪除範本任務及工作項目
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->select('a.jec_projecttempjob_id');
		$this->db->from('jec_projecttempjob a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_projecttemp_id', $jec_projecttemp_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->db->set('updated', $nowtime);
			$this->db->set('updatedby', $loginparameters['jec_user_id']);
			$this->db->set('isactive', 'N');
			$this->db->where('jec_projecttempjob_id', $row['jec_projecttempjob_id']);
			$this->db->update('jec_projecttempjob');
		}
		$this->db->select('a.jec_projecttemptask_id');
		$this->db->from('jec_projecttemptask a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_projecttemp_id', $jec_projecttemp_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->db->set('updated', $nowtime);
			$this->db->set('updatedby', $loginparameters['jec_user_id']);
			$this->db->set('isactive', 'N');
			$this->db->where('jec_projecttemptask_id', $row['jec_projecttemptask_id']);
			$this->db->update('jec_projecttemptask');
		}
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_projecttemp_id', $jec_projecttemp_id);
		$this->db->update('jec_projecttemp');
		return true;
	}
	
	// 範本內容DATAMODEL--------------------------------------------------------------------------------
	// 讀取範本內容列表
	// $id: 範本ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// 目前暫不做分頁
	function get_projecttemp_edit($id=0, $pagesize=0, $offset=0, $getcount=false)
	{
		$sql = "SELECT b.jec_projecttempjob_id AS id, b.jec_job_id AS jobid, f.name AS jobname, b.seqno AS jobseqno, null AS taskid, '' AS taskname, ";
		$sql .= "null AS taskseqno, ".$id." AS parentid, null AS startdays, null AS workdays, null AS user, null AS superuser FROM jec_projecttempjob b ";
		$sql .= "LEFT JOIN jec_projecttemp a ON b.jec_projecttemp_id=a.jec_projecttemp_id ";
		$sql .= "LEFT JOIN jec_job f ON b.jec_job_id=f.jec_job_id ";
		$sql .= "WHERE a.jec_projecttemp_id=".$id." AND b.isactive='Y' ";
		$sql .= "UNION ";
		$sql .= "SELECT c.jec_projecttemptask_id AS id, d.jec_job_id AS jobid, '' AS jobname, d.seqno AS jobseqno, c.jec_task_id AS taskid, ";
		$sql .= "g.name AS taskname, c.seqno AS taskseqno, c.jec_projecttempjob_id AS parentid, c.startdays, c.workdays, c.user, c.superuser FROM jec_projecttemptask c ";
		$sql .= "LEFT JOIN jec_projecttempjob d ON c.jec_projecttempjob_id=d.jec_projecttempjob_id ";
		$sql .= "LEFT JOIN jec_projecttemp e ON c.jec_projecttemp_id=e.jec_projecttemp_id ";
		$sql .= "LEFT JOIN jec_task g ON c.jec_task_id=g.jec_task_id ";
		$sql .= "WHERE e.jec_projecttemp_id=".$id." AND c.isactive='Y' ";
		$sql .= "ORDER BY jobseqno, taskseqno";
		if ($getcount)
		{
			return $this->db->query($sql)->num_rows();
		}
		else
		{
//			if ($offset == 0)
//			{
//				$sql .= " LIMIT 0, " . $pagesize;
//			}
//			else
//			{
//				$sql .= " LIMIT " . $offset . ", " . $pagesize;
//			}
			return $this->db->query($sql)->result_array();
		}
	}
	
	// 讀取專案範本資料
	function get_projecttemp_data($jec_projecttemp_id=0)
	{
		$this->db->select('*');
		$this->db->from('jec_projecttemp');
		$this->db->where('jec_projecttemp_id', $jec_projecttemp_id);
		return $this->db->get('')->result_array();
	}
	
	// 讀取任務清單
	function get_select_job()
	{
		$this->db->select('*');
		$this->db->from('jec_job a');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('jec_job_id');
		return $this->db->get('')->result_array();
	}
	
	// 讀取工作項目清單
	function get_select_task()
	{
		$this->db->select('*');
		$this->db->from('jec_task a');
		$this->db->where('a.isactive', 'Y');
		$this->db->order_by('jec_task_id');
		return $this->db->get('')->result_array();
	}
	
	// 讀取任務序號最大值, 回傳該值
	function get_max_job_seqno($jec_projecttemp_id)
	{
		$this->db->select('MAX(seqno) AS maxseqno', false);
		$this->db->from('jec_projecttempjob');
		$this->db->where('isactive', 'Y');
		$this->db->where('jec_projecttemp_id', $jec_projecttemp_id);
		$row = $this->db->get('')->result_array();
		if (empty($row))
			return 0;
		else
			return $row[0]['maxseqno'];
	}
	
	// 讀取各任務中工作項目序號最大值, 回傳一個陣列
	function get_max_task_seqno($jec_projecttemp_id)
	{
		$sql = "SELECT jec_projecttempjob_id, MAX(seqno) AS maxseqno FROM jec_projecttemptask ";
		$sql .= "WHERE jec_projecttemp_id=".$jec_projecttemp_id." AND isactive='Y' GROUP BY jec_projecttempjob_id";
		$row = $this->db->query($sql)->result_array();
		$row1 = array();
		foreach ($row as $key => $row2)
		{
			$maxseqno = $row2['jec_projecttempjob_id'].'/'.$row2['maxseqno'];
			array_push($row1, $maxseqno);
		}
		return $row1;
	}
	
	// 新增範本中的任務
	// 連同任務中預設的工作項目一起帶進來
	function job_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('jec_projecttemp_id', $data['jec_projecttemp_id']);
		$this->db->set('jec_job_id', $data['jec_job_id']);
		$seqno = $this->SORT->get_maxseqno('jec_projecttempjob', 'jec_projecttemp_id', $data['jec_projecttemp_id']);
		$this->db->set('seqno', $seqno);
		$this->db->insert('jec_projecttempjob');
		$jec_projecttempjob_id = $this->db->insert_id();
		// 讀取任務中預設的工作項目
		$this->db->select('jec_task_id, seqno');
		$this->db->from('jec_jobtask');
		$this->db->where('isactive', 'Y');
		$this->db->where('jec_job_id', $data['jec_job_id']);
		$this->db->order_by('seqno');
		$rowinsert = $this->db->get('')->result_array();
		foreach ($rowinsert as $key => $row)
		{
			$this->db->set('isactive', 'Y');
			$this->db->set('created', $nowtime);
			$this->db->set('createdby', $loginparameters['jec_user_id']);
			$this->db->set('updatedby', 0);
			$this->db->set('jec_projecttemp_id', $data['jec_projecttemp_id']);
			$this->db->set('jec_projecttempjob_id', $jec_projecttempjob_id);
			$this->db->set('jec_task_id', $row['jec_task_id']);
			$this->db->set('seqno', $row['seqno']);
			$this->db->insert('jec_projecttemptask');
		}
		return true;
	}
	
	// 新增範本任務中的工作項目
	function task_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('jec_projecttemp_id', $data['jec_projecttemp_id']);
		$this->db->set('jec_projecttempjob_id', $data['jec_projecttempjob_id']);
		$this->db->set('jec_task_id', $data['jec_task_id']);
		$seqno = $this->SORT->get_maxseqno('jec_projecttemptask', 'jec_projecttempjob_id', $data['jec_projecttempjob_id']);
		$this->db->set('seqno', $seqno);
		$this->db->insert('jec_projecttemptask');
		return true;
	}
	
	// 刪除範本中的任務, 連同其中包含的工作項目也要一起刪除
	function job_delete($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		// 先刪除其中包含的工作項目
		$this->db->select('jec_projecttemptask_id');
		$this->db->from('jec_projecttemptask');
		$this->db->where('isactive', 'Y');
		$this->db->where('jec_projecttempjob_id', $data['jec_projecttempjob_id']);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->db->set('updated', $nowtime);
			$this->db->set('updatedby', $loginparameters['jec_user_id']);
			$this->db->set('isactive', 'N');
			$this->db->set('seqno', 0);
			$this->db->where('jec_projecttemptask_id', $row['jec_projecttemptask_id']);
			$this->db->update('jec_projecttemptask');
		}
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->set('seqno', 0);
		$this->db->where('jec_projecttempjob_id', $data['jec_projecttempjob_id']);
		$this->db->update('jec_projecttempjob');
		// 後續序號補上來
		$this->SORT->upgrade_seqno('jec_projecttempjob', 'jec_projecttempjob_id', 'jec_projecttemp_id', $data['jec_projecttemp_id'], $data['seqno']);
		return true;
	}
	
	// 刪除範本任務中的工作項目
	function task_delete($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->set('seqno', 0);
		$this->db->where('jec_projecttemptask_id', $data['jec_projecttemptask_id']);
		$this->db->update('jec_projecttemptask');
		// 後續序號補上來
		$this->SORT->upgrade_seqno('jec_projecttemptask', 'jec_projecttemptask_id', 'jec_projecttempjob_id', $data['jec_projecttempjob_id'], $data['seqno']);
		return true;
	}
	
	// 編輯工作項目
	function task_edit($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);		
		$this->db->set('startdays', $data['startdays']);	
		$this->db->set('workdays', $data['workdays']);		
		$this->db->set('user', $data['user']);		
		$this->db->set('superuser', $data['superuser']);			
		$this->db->where('jec_projecttemptask_id', $data['jec_projecttemptask_id']);
		$this->db->update('jec_projecttemptask');
		return true;
	}
}
