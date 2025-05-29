<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_sort_utility extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    
	// 讀取目前序號的列表
	// $table: 表格名稱
	// $idname: 該表格的主ID名稱
	// $idname1: 該表格的父ID名稱
	// $parentid: 父ID的值
	function get_table_seqno($table, $idname, $idname1, $parentid=0)
	{
		$this->db->select($idname.' as id, seqno', false);
		$this->db->from($table);
		$this->db->where('isactive', 'Y');
		$this->db->where($idname1, $parentid);
		$this->db->order_by('seqno');
		return $this->db->get('')->result_array();
	}
	
	// 更新序號
	// $table: 表格名稱
	// $idname: 該表格的主ID名稱
	// $id: 主ID的值
	// $newseq: 新的seqno值
	function update_seqno($table, $idname, $id, $newseq)
	{
		$this->db->set('seqno', $newseq);
		$this->db->where($idname, $id);
		$this->db->update($table);
	}
	
	// 取得最大序號
	// $table: 表格名稱
	// $idname: 該表格的父ID名稱
	// $id: 父ID的值
	function get_maxseqno($table, $idname, $id)
	{
		$this->db->select('MAX(seqno)+10 AS seqno', false);
		if (!empty($idname))
		{
			$this->db->where($idname, $id);
		}
		$row = $this->db->get($table)->result_array();
		if (is_null($row[0]['seqno']))
			return 10;
		else
			return $row[0]['seqno'];
	}
	
	// 由被刪除的序號處將後續的序號都補上來
	// $table: 表格名稱
	// $idname: 該表格的主ID名稱
	// $idname1: 該表格的父ID名稱
	// $parentid: 父ID的值
	// $seqno: 刪除的seqno值
	function upgrade_seqno($table, $idname, $idname1, $parentid, $seqno)
	{
		$this->db->select($idname.' as id, seqno', false);
		$this->db->from($table);
		$this->db->where('isactive', 'Y');
		$this->db->where($idname1, $parentid);
		$this->db->where('seqno > '.$seqno);
		$this->db->order_by('seqno');
		$seqrow = $this->db->get('')->result_array();
		foreach ($seqrow as $key => $row)
		{
			$this->update_seqno($table, $idname, $row['id'], ($key+intval($seqno/10))*10);
		}
	}
}