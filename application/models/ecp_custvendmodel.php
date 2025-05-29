<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 基本資料 - 客戶/廠商
 * Author: Johnson 2012/07/10
 */
class Ecp_custvendmodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// ================================================================================
	// 讀取客戶列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_customer_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_customer a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_customer_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'value';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增客戶
	function customer_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('name2', $data['name2']);
		$this->db->set('taxid', $data['taxid']);
		$this->db->set('boss', $data['boss']);
		$this->db->set('contact', $data['contact']);
		$this->db->set('telephone1', $data['telephone1']);
		$this->db->set('telephone2', $data['telephone2']);
		$this->db->set('faxphone', $data['faxphone']);
		$this->db->set('address', $data['address']);
		$this->db->set('email', $data['email']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_customer');
		return true;
	}
	
	// 更新客戶
	function customer_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('name2', $data['name2']);
		$this->db->set('taxid', $data['taxid']);
		$this->db->set('boss', $data['boss']);
		$this->db->set('contact', $data['contact']);
		$this->db->set('telephone1', $data['telephone1']);
		$this->db->set('telephone2', $data['telephone2']);
		$this->db->set('faxphone', $data['faxphone']);
		$this->db->set('address', $data['address']);
		$this->db->set('email', $data['email']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_customer_id', $data['jec_customer_id']);
 		$this->db->update('jec_customer');
 		return true;
	}
	
	// 刪除客戶
	function customer_delete($jec_customer_id=0)
	{
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_customer_id', $jec_customer_id);
		$this->db->update('jec_customer');
		return true;
	}
	
	// ================================================================================
	// 讀取廠商列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_vendor_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_vendor a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_vendor_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'value';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增廠商
	function vendor_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('name2', $data['name2']);
		$this->db->set('taxid', $data['taxid']);
		$this->db->set('vendorkind', $data['vendorkind']);
		$this->db->set('contact', $data['contact']);
		$this->db->set('telephone1', $data['telephone1']);
		$this->db->set('telephone2', $data['telephone2']);
		$this->db->set('faxphone', $data['faxphone']);
		$this->db->set('address', $data['address']);
		$this->db->set('email', $data['email']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_vendor');
		return true;
	}
	
	// 更新廠商
	function vendor_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('value', $data['value']);
		$this->db->set('name', $data['name']);
		$this->db->set('name2', $data['name2']);
		$this->db->set('taxid', $data['taxid']);
		$this->db->set('vendorkind', $data['vendorkind']);
		$this->db->set('contact', $data['contact']);
		$this->db->set('telephone1', $data['telephone1']);
		$this->db->set('telephone2', $data['telephone2']);
		$this->db->set('faxphone', $data['faxphone']);
		$this->db->set('address', $data['address']);
		$this->db->set('email', $data['email']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_vendor_id', $data['jec_vendor_id']);
 		$this->db->update('jec_vendor');
 		return true;
	}
	
	// 刪除廠商
	function vendor_delete($jec_vendor_id=0)
	{
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_vendor_id', $jec_vendor_id);
		$this->db->update('jec_vendor');
		return true;
	}
}
