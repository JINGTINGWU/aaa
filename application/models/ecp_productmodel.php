<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 料品與工作明細
 * Author: Johnson 2012/07/02
 */
class Ecp_productmodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	// 料品DATAMODEL----------------------------------------------------------------------------------
	// 料品類別選項
	function get_prodtype()
	{
		$row = array(
			array('datatype'=>'1', 'name'=>'採購'),
			array('datatype'=>'2', 'name'=>'生產'),
			array('datatype'=>'3', 'name'=>'領用'),
			array('datatype'=>'4', 'name'=>'委外'),
			array('datatype'=>'5', 'name'=>'勞務'),
			//array('datatype'=>'8', 'name'=>'開放')
		);
		return $row;
	}
	
	// 單位選項
	function get_uom()
	{
		$this->db->select('jec_uom_id AS datatype, name', false);
		$this->db->from('jec_uom');
		$this->db->order_by('jec_uom_id');
		return $this->db->get('')->result_array();
	}
	
	// 廠商選項
	function get_vendor()
	{
		$this->db->select('jec_vendor_id AS datatype, name', false);
		$this->db->from('jec_vendor');
		$this->db->order_by('name');
		$row = $this->db->get('')->result_array();
		// 增加一筆空白選項
		$row_empty = array('datatype' => '', 'name' => '');
		array_unshift($row, $row_empty);
		return $row;
	}
	
	// 讀取料品列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_prod_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*, b.name as unit');
		$this->db->from('jec_product a');
		$this->db->join('jec_uom b', 'a.jec_uom_id=b.jec_uom_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.prodtype != "9"');
		if ($id != 0)
		{
			$this->db->where('a.jec_product_id', $id);
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
	
	// 新增料品
	function prod_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		//$this->db->set('value', $data['value']);
		$this->db->set('prodtype', $data['prodtype']);
		$this->db->set('jec_uom_id', $data['jec_uom_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('specification', $data['specification']);
		$this->db->set('price', $data['price']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('jec_vendor_id', $data['jec_vendor_id']);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_product');
		return true;
	}
	
	// 修改料品
	function prod_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		//$this->db->set('value', $data['value']);
		$this->db->set('prodtype', $data['prodtype']);
		$this->db->set('jec_uom_id', $data['jec_uom_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('specification', $data['specification']);
		$this->db->set('price', $data['price']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('jec_vendor_id', $data['jec_vendor_id']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_product_id', $data['jec_product_id']);
 		$this->db->update('jec_product');
 		return true;
	}
	
	// 刪除料品
	function prod_delete($jec_product_id=0)
	{
		// 先刪除ERP對應的資料
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->select('a.jec_producterp_id');
		$this->db->from('jec_producterp a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_product_id', $jec_product_id);
		$rowdelete = $this->db->get('')->result_array();
		foreach ($rowdelete as $key => $row)
		{
			$this->db->set('updated', $nowtime);
			$this->db->set('updatedby', $loginparameters['jec_user_id']);
			$this->db->set('isactive', 'N');
			$this->db->where('jec_producterp_id', $row['jec_producterp_id']);
			$this->db->update('jec_producterp');
		}
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_product_id', $jec_product_id);
		$this->db->update('jec_product');
		return true;
	}
	
	// ERP對應DATAMODEL-------------------------------------------------------------------------------
	// 讀取料品已對應的ERP材料列表
	function get_proderp_list($jec_product_id)
	{
		$this->db->select('a.*');
		$this->db->from('jec_producterp a');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.jec_product_id', $jec_product_id);
		$this->db->order_by('prodid');
		return $this->db->get('')->result_array();
	}
	
	// 讀取查詢的ERP材料
	function get_proderp_select($kwstring='')
	{
		$mssqlerp = $this->load->database('mssqlerp', true);  // 連接ERP資料庫
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		if (empty($kwstring))
		{
			$mssqlerp->where('MB001', '');
		}
		else
		{
			// 若主機為LINUX則需轉碼到CP950才能正確設定條件
			if ($loginparameters['os'] == 'LINUX') $kwstring = iconv("UTF-8", "CP950//IGNORE", $kwstring);
			$where = "(MB001 LIKE '%";
			$where .= trim($kwstring) . "%' OR ";
			$where .= "MB002 LIKE '%";
			$where .= trim($kwstring) . "%' OR ";
			$where .= "MB003 LIKE '%";
			$where .= trim($kwstring) . "%')";
			$mssqlerp->where($where);
		}
		$mssqlerp->order_by('MB001');
		$row = $mssqlerp->get('INVMB')->result_array();
		// 若主機為LINUX則需轉碼到UTF-8才能顯示
		if ($loginparameters['os'] == 'LINUX')
		{
			foreach($row as $key => $rowconvert)
			{
				$row[$key]['MB001'] = iconv("CP950", "UTF-8//IGNORE", $rowconvert['MB001']);
				$row[$key]['MB002'] = iconv("CP950", "UTF-8//IGNORE", $rowconvert['MB002']);
				$row[$key]['MB003'] = iconv("CP950", "UTF-8//IGNORE", $rowconvert['MB003']);
				$row[$key]['MB004'] = iconv("CP950", "UTF-8//IGNORE", $rowconvert['MB004']);
			}
		}
		return $row;
	}
	
	// 新增ERP材料對應, 新增前需先檢查是否已存在
	function keyword_select($data)
	{
		$mssqlerp = $this->load->database('mssqlerp', true);  // 連接ERP資料庫
		$jec_product_id = $_POST['jec_product_id'];
		$check_list = explode(';', $data['checklist']);
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		foreach ($check_list as $checklist)
		{
			if (! empty($checklist))
			{
				$row = explode('/', $checklist);
				$prodid = $row[0];
				$checked = $row[1];
				if ($checked == 'Y')
				{
					$this->db->where('jec_product_id', $jec_product_id);
					$this->db->where('prodid', $prodid);
					$this->db->where('isactive', 'Y');
					$query = $this->db->get('jec_producterp');
					if ($query->num_rows() <= 0)
					{
						$prodname = '';
						$prodspec = '';
						$produnit = '';
						$prodprice0 = 0;
						$prodprice1 = 0;
						$prodprice2 = 0;
						$prodprice3 = 0;
						$prodprice4 = 0;
						$prodprice5 = 0;
						$prodprice6 = 0;
						$prodprice7 = 0;
						// 從ERP讀入相關資料
						$prodid1 = $prodid;
						if ($loginparameters['os'] == 'LINUX') $prodid1 = iconv("UTF-8", "CP950//IGNORE", $prodid);
						$mssqlerp->where('MB001', $prodid1);
						$row = $mssqlerp->get('INVMB')->result_array();
						if (! empty($row))
						{
							$prodname = $row[0]['MB002'];
							$prodspec = $row[0]['MB003'];
							$produnit = $row[0]['MB004'];
							$prodprice0 = $row[0]['MB051'];
							$prodprice1 = $row[0]['MB053'];
							$prodprice2 = $row[0]['MB054'];
							$prodprice3 = $row[0]['MB055'];
							$prodprice4 = $row[0]['MB056'];
							$prodprice5 = $row[0]['MB069'];
							$prodprice6 = $row[0]['MB070'];
							$prodprice7 = $row[0]['MB097'];
							if ($loginparameters['os'] == 'LINUX')
							{
								$prodname = iconv("CP950", "UTF-8//IGNORE", $prodname);
								$prodspec = iconv("CP950", "UTF-8//IGNORE", $prodspec);
								$produnit = iconv("CP950", "UTF-8//IGNORE", $produnit);
							}
							// 新增jec_producterp
							$this->db->set('isactive', 'Y');
							$this->db->set('created', $nowtime);
							$this->db->set('createdby', $loginparameters['jec_user_id']);
							$this->db->set('updatedby', 0);
							$this->db->set('jec_product_id', $jec_product_id);
							$this->db->set('prodid', $prodid1);
							$this->db->set('prodname', $prodname);
							$this->db->set('prodspec', $prodspec);
							$this->db->set('produnit', $produnit);
							$this->db->set('prodprice0', $prodprice0);
							$this->db->set('prodprice1', $prodprice1);
							$this->db->set('prodprice2', $prodprice2);
							$this->db->set('prodprice3', $prodprice3);
							$this->db->set('prodprice4', $prodprice4);
							$this->db->set('prodprice5', $prodprice5);
							$this->db->set('prodprice6', $prodprice6);
							$this->db->set('prodprice7', $prodprice7);
							$this->db->insert('jec_producterp');
						}
					}
					$query->free_result();
				}
			}
		}
		return true;
	}
	
	// 移除ERP材料對應
	function keyword_delete($data)
	{
		$jec_product_id = $_POST['jec_product_id'];
		$check_list = explode(';', $data['checklist']);
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		foreach ($check_list as $checklist)
		{
			if (! empty($checklist))
			{
				$row = explode('/', $checklist);
				$jec_producterp_id = $row[0];
				$checked = $row[1];
				if ($checked == 'Y')
				{
					$this->db->set('updated', $nowtime);
					$this->db->set('updatedby', $loginparameters['jec_user_id']);
					$this->db->set('isactive', 'N');
					$this->db->where('jec_producterp_id', $jec_producterp_id);
					$this->db->update('jec_producterp');
				}
			}
		}
		return true;
	}
	
	// 工作明細DATAMODEL--------------------------------------------------------------------------------
	// 讀取工作明細列表
	// $id: ID
	// $pagesize: 每頁筆數
	// $offset: 偏移量
	// $getcount: 是否只取筆數
	// $sort_field: 排序欄位名稱
	// $sort_sequence: 排列順序(asc/desc)
	function get_work_list($id=0, $pagesize=0, $offset=0, $getcount=false, $sort_field='', $sort_sequence='asc')
	{
		$this->db->select('a.*, b.name as unit, c.jec_dept_id, d.name as deptname');
		$this->db->from('jec_product a');
		$this->db->join('jec_uom b', 'a.jec_uom_id=b.jec_uom_id', 'left');
		$this->db->join('jec_user c', 'a.createdby=c.jec_user_id', 'left');
		$this->db->join('jec_dept d', 'c.jec_dept_id=d.jec_dept_id', 'left');
		$this->db->where('a.isactive', 'Y');
		$this->db->where('a.prodtype = "9"');
		if ($id != 0)
		{
			$this->db->where('a.jec_product_id', $id);
		}
		if ($getcount)
		{
			return $this->db->count_all_results('');
		}
		else
		{
			if (empty($sort_field)) $sort_field = 'deptname';
			$this->db->order_by($sort_field . ' ' . $sort_sequence);
			if ($pagesize > 0)
				return $this->db->get('', $pagesize, $offset)->result_array();
			else
				return $this->db->get('')->result_array();
		}
	}
	
	// 新增工作明細
	function work_new($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('isactive', 'Y');
		$this->db->set('created', $nowtime);
		$this->db->set('createdby', $loginparameters['jec_user_id']);
		$this->db->set('updatedby', 0);
		//$this->db->set('value', $data['value']);
		$this->db->set('prodtype', '9');
		$this->db->set('jec_uom_id', $data['jec_uom_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('price', $data['price']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('jec_vendor_id', null);
		$this->db->set('description', $data['description']);
		$this->db->insert('jec_product');
		return true;
	}
	
	// 修改工作明細
	function work_update($data)
	{
		$nowtime = date("Y-m-d H:i:s");
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		//$this->db->set('value', $data['value']);
		$this->db->set('jec_uom_id', $data['jec_uom_id']);
		$this->db->set('name', $data['name']);
		$this->db->set('price', $data['price']);
		$this->db->set('daywork', $data['daywork']);
		$this->db->set('description', $data['description']);
		$this->db->where('jec_product_id', $data['jec_product_id']);
 		$this->db->update('jec_product');
 		return true;
	}
	
	// 刪除工作明細
	function work_delete($jec_product_id=0)
	{
		$this->db->set('updated', $nowtime);
		$this->db->set('updatedby', $loginparameters['jec_user_id']);
		$this->db->set('isactive', 'N');
		$this->db->where('jec_product_id', $jec_product_id);
		$this->db->update('jec_product');
		return true;
	}
}
