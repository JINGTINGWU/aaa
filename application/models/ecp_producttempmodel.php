<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 料品範本
 * Author: Johnson 2012/07/06
 */
class Ecp_producttempmodel extends CI_Model {
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
	function get_producttemp_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*');
		$this->db->from('jec_producttemp a');
		$this->db->where('a.isactive', 'Y');
		if ($id != 0)
		{
			$this->db->where('a.jec_producttemp_id', $id);
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
	function producttemp_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_producttemp');
		return true;
	}
	
	// 修改範本
	function producttemp_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_producttemp_id', $data['jec_producttemp_id']);
 		$this->db->update('jec_producttemp');
 		return true;
	}
	
	// 刪除範本
	function producttemp_delete($jec_producttemp_id=0)
	{
		// 先刪除範本料品
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->select('a.jec_producttempline_id');
		$this->db->from('jec_producttempline a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_producttemp_id', $jec_producttemp_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->db->set('updated', $nowtime);
			$this->db->set('updatedby', $loginparameters['jec_user_id']);
			$this->db->set('isactive', 'N');
			$this->db->where('jec_producttempline_id', $row['jec_producttempline_id']);
			$this->db->update('jec_producttempline');
		}
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_producttemp_id', $jec_producttemp_id);
		$this->db->update('jec_producttemp');
		return true;
	}
	
	// 範本內容DATAMODEL--------------------------------------------------------------------------------
	// 讀取範本內容列表
	// $id: 範本ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// 目前暫不做分頁
	function get_producttemp_edit($id=0, $pagesize=0, $offset=0, $getcount=false)
	{
		$sql = "SELECT a.jec_producttempline_id, a.jec_product_id, a.prodtype, a.jec_productopen_id, a.seqno, ";
		$sql .= "b.value, b.name, b.specification, b.description, b.jec_uom_id, b.price, b.jec_vendor_id, c.name AS unit, g.name AS vendor ";
		$sql .= "FROM jec_producttempline a LEFT JOIN jec_product b ON a.jec_product_id=b.jec_product_id ";
		$sql .= "LEFT JOIN jec_uom c ON b.jec_uom_id=c.jec_uom_id ";
		$sql .= "LEFT JOIN jec_vendor g ON b.jec_vendor_id=g.jec_vendor_id ";
		$sql .= "WHERE a.jec_producttemp_id=" . $id . " AND a.prodtype!='8' AND a.isactive='Y'";
		$sql .= "UNION ";
		$sql .= "SELECT d.jec_producttempline_id, d.jec_product_id, d.prodtype, d.jec_productopen_id, d.seqno, ";
		$sql .= "e.value, e.name, e.specification, e.description, e.jec_uom_id, e.price, '' AS jec_vendor_id, f.name AS unit, '' AS vendor ";
		$sql .= "FROM jec_producttempline d LEFT JOIN jec_productopen e ON d.jec_productopen_id=e.jec_productopen_id ";
		$sql .= "LEFT JOIN jec_uom f ON e.jec_uom_id=f.jec_uom_id ";
		$sql .= "WHERE d.jec_producttemp_id=" . $id . " AND d.prodtype='8' AND d.isactive='Y'";
		$sql .= "ORDER BY seqno";
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
	
	// 讀取料品範本資料
	function get_producttemp_data($jec_producttemp_id=0)
	{
		$this->db->select('*');
		$this->db->from('jec_producttemp');
		$this->db->where('jec_producttemp_id', $jec_producttemp_id);
		return $this->db->get('')->result_array();
	}
	
	// 讀取查詢的料品選擇清單
	function get_prod_select($kwstring='')
	{
		if (empty($kwstring))
		{
			$this->db->where('jec_product_id', 0);
		}
		else
		{
			$this->db->where('isactive', 'Y');
			$where = "(value LIKE '%";
			$where .= trim($kwstring) . "%' OR ";
			$where .= "name LIKE '%";
			$where .= trim($kwstring) . "%' OR ";
			$where .= "specification LIKE '%";
			$where .= trim($kwstring) . "%' OR ";
			$where .= "description LIKE '%";
			$where .= trim($kwstring) . "%')";
			$this->db->where($where);
		}
		$this->db->order_by('name, specification');
		$row = $this->db->get('jec_product')->result_array();
		return $row;
	}
	
	// 新增勾選的料品或工作明細, 新增前需先檢查是否已存在
	function keyword_select($data)
	{
		$jec_producttemp_id = $_POST['jec_producttemp_id'];
		$check_list = explode(';', $data['checklist']);
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		foreach ($check_list as $checklist)
		{
			if (! empty($checklist))
			{
				$row = explode('/', $checklist);
				$jec_product_id = $row[0];
				$prodtype = $row[1];
				$checked = $row[2];
				if ($checked == 'Y')
				{
					// 若為開放料品, 不需檢查, 直接新增一筆資料到jec_productopen後, 再將ID寫回來
					if ($prodtype == '8')
					{
						// 先讀取jec_product中的資料, 再填入jec_productopen
						$this->db->where('jec_product_id', $jec_product_id);
						$row = $this->db->get('jec_product')->result_array();
						$this->db->set('isactive', 'Y');
						$this->db->set('created', $nowtime);
						$this->db->set('createdby', $loginparameters['jec_user_id']);
						$this->db->set('updatedby', 0);
						$this->db->set('value', $row[0]['value']);
						$this->db->set('name', $row[0]['name']);
						$this->db->set('specification', $row[0]['specification']);
						$this->db->set('description', $row[0]['description']);
						$this->db->set('jec_uom_id', $row[0]['jec_uom_id']);
						$this->db->set('price', $row[0]['price']);
						$this->db->insert('jec_productopen');
						$jec_productopen_id = $this->db->insert_id();
						// 新增jec_producttempline
						$this->db->set('isactive', 'Y');
						$this->db->set('created', $nowtime);
						$this->db->set('createdby', $loginparameters['jec_user_id']);
						$this->db->set('updatedby', 0);
						$this->db->set('jec_producttemp_id', $jec_producttemp_id);
						$this->db->set('jec_product_id', $jec_product_id);
						$this->db->set('prodtype', $prodtype);
						$this->db->set('jec_productopen_id', $jec_productopen_id);
						$seqno = $this->SORT->get_maxseqno('jec_producttempline', 'jec_producttemp_id', $jec_producttemp_id);
						$this->db->set('seqno', $seqno);
						$this->db->insert('jec_producttempline');
					}
					else
					{
						$this->db->where('jec_producttemp_id', $jec_producttemp_id);
						$this->db->where('jec_product_id', $jec_product_id);
						$query = $this->db->get('jec_producttempline');
						if ($query->num_rows() <= 0)
						{
							// 新增jec_producttempline
							$this->db->set('isactive', 'Y');
							$this->db->set('created', $nowtime);
							$this->db->set('createdby', $loginparameters['jec_user_id']);
							$this->db->set('updatedby', 0);
							$this->db->set('jec_producttemp_id', $jec_producttemp_id);
							$this->db->set('jec_product_id', $jec_product_id);
							$this->db->set('prodtype', $prodtype);
							$seqno = $this->SORT->get_maxseqno('jec_producttempline', 'jec_producttemp_id', $jec_producttemp_id);
							$this->db->set('seqno', $seqno);
							$this->db->insert('jec_producttempline');
						}
						$query->free_result();
					}
				}
			}
		}
		return true;
	}
	
	// 刪除料品範本內容
	function producttemp_product_delete($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->set('seqno', 0);
		$this->db->where('jec_producttempline_id', $data['jec_producttempline_id']);
		$this->db->update('jec_producttempline');
		// 後續序號補上來
		$this->SORT->upgrade_seqno('jec_producttempline', 'jec_producttempline_id', 'jec_producttemp_id', $data['jec_producttemp_id'], $data['seqno']);
		return true;
	}
}
