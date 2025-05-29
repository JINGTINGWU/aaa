<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 基本資料 - 職稱/人員群組/費用名稱/單位/公司/年度
 * Author: Johnson 2012/06/25
 */
class Ecp_data_title extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_datamodel', 'DATA', true);
 	}
	
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_title';
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
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'title_list' => $this->DATA->get_title_list()
		);
		$this->load->view('ecp_data/ecp_data_title', $data);
	}
	
	// 新增職稱
	function title_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->title_new($data);
		echo $result;
	}
		
	// 修改職稱
	function title_update()
	{
		$data = array(
			'jec_title_id' => $_POST['jec_title_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->title_update($data);
		echo $result;
	}
	
	// 刪除職稱
	function title_delete()
	{
		$jec_title_id = $_POST['jec_title_id'];
		$result = $this->DATA->title_delete($jec_title_id);
		echo $result;
	}
	
	// 人員群組列表
	function user_group()
	{
		// Control名稱
		$control = 'ecp_data_title';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'group_list' => $this->DATA->get_group_list()
		);
		$this->load->view('ecp_data/ecp_data_group', $data);
	}
	
	// 新增群組
	function group_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->group_new($data);
		echo $result;
	}
		
	// 修改群組
	function group_update()
	{
		$data = array(
			'jec_group_id' => $_POST['jec_group_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->group_update($data);
		echo $result;
	}
	
	// 刪除群組
	function group_delete()
	{
		$jec_group_id = $_POST['jec_group_id'];
		$result = $this->DATA->group_delete($jec_group_id);
		echo $result;
	}
	
	// 費用名稱列表
	function charge_item()
	{
		// Control名稱
		$control = 'ecp_data_title';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'charge_list' => $this->DATA->get_charge_list()
		);
		$this->load->view('ecp_data/ecp_data_charge', $data);
	}
	
	// 新增費用名稱
	function charge_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->charge_new($data);
		echo $result;
	}
		
	// 修改費用名稱
	function charge_update()
	{
		$data = array(
			'jec_chargeitem_id' => $_POST['jec_chargeitem_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->charge_update($data);
		echo $result;
	}
	
	// 刪除費用名稱
	function charge_delete()
	{
		$jec_chargeitem_id = $_POST['jec_chargeitem_id'];
		$result = $this->DATA->charge_delete($jec_chargeitem_id);
		echo $result;
	}
	
	// 單位列表
	function unit_measure()
	{
		// Control名稱
		$control = 'ecp_data_title';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'uom_list' => $this->DATA->get_uom_list()
		);
		$this->load->view('ecp_data/ecp_data_uom', $data);
	}
	
	// 新增單位
	function uom_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->uom_new($data);
		echo $result;
	}
		
	// 修改單位
	function uom_update()
	{
		$data = array(
			'jec_uom_id' => $_POST['jec_uom_id'],
			'name' => $_POST['name'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->uom_update($data);
		echo $result;
	}
	
	// 刪除單位
	function uom_delete()
	{
		$jec_uom_id = $_POST['jec_uom_id'];
		$result = $this->DATA->uom_delete($jec_uom_id);
		echo $result;
	}
	
	// 公司列表
	function company_setup()
	{
		// Control名稱
		$control = 'ecp_data_title';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'company_list' => $this->DATA->get_company_list()
		);
		$this->load->view('ecp_data/ecp_data_company', $data);
	}
	
	// 新增公司
	function company_new()
	{
		$data = array(
			'name' => $_POST['name'],
			'dbsetup' => $_POST['dbsetup'],
			'iseasyflow' => $_POST['iseasyflow'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->company_new($data);
		echo $result;
	}
		
	// 修改公司
	function company_update()
	{
		$data = array(
			'jec_company_id' => $_POST['jec_company_id'],
			'name' => $_POST['name'],
			'dbsetup' => $_POST['dbsetup'],
			'iseasyflow' => $_POST['iseasyflow'],
			'description' => $_POST['description']
		);
		$result = $this->DATA->company_update($data);
		echo $result;
	}
	
	// 刪除公司
	function company_delete()
	{
		$jec_company_id = $_POST['jec_company_id'];
		$result = $this->DATA->company_delete($jec_company_id);
		echo $result;
	}
	
//	// 新增採購報支單草稿測試用
//	function mssql_test()
//	{
//		$mssqlef = $this->load->database('mssqlef', true);  // 連接EasyFlow資料庫
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'resda');
//		$mssqlef->set('FieldName', 'ScriptSubj');
//		$mssqlef->set('RecordIndex', '1');
//		$data = '2012/08/15-履約系統新建工程-合約審查-資訊採購';
//		//$data = iconv("utf-8", "big5//IGNORE", $data);
//		$mssqlef->set('FieldValue', $data);
//		$mssqlef->insert('ressa');
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'rstAD005');
//		$mssqlef->set('FieldName', 'ad005006');
//		$mssqlef->set('RecordIndex', '1');
//		$mssqlef->set('FieldValue', 'ecplant');
//		$mssqlef->insert('ressa');
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'rstAD005');
//		$mssqlef->set('FieldName', 'ad005007');
//		$mssqlef->set('RecordIndex', '1');
//		$mssqlef->set('FieldValue', '荃聯科技');
//		$mssqlef->insert('ressa');
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'rstAD005');
//		$mssqlef->set('FieldName', 'ad005008');
//		$mssqlef->set('RecordIndex', '1');
//		$mssqlef->set('FieldValue', '資訊管理');
//		$mssqlef->insert('ressa');
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'rstAD005');
//		$mssqlef->set('FieldName', 'ad005053');
//		$mssqlef->set('RecordIndex', '1');
//		$mssqlef->set('FieldValue', 'B流程');
//		$mssqlef->insert('ressa');
//		
//		$mssqlef->set('strFormID', 'AD005');
//		$mssqlef->set('ScriptSheetNo', '2012/08/15 10:00:00');
//		$mssqlef->set('Owner', 'ecplant');
//		$mssqlef->set('RecordsetName', 'rstAD005');
//		$mssqlef->set('FieldName', 'ad005059');
//		$mssqlef->set('RecordIndex', '1');
//		$mssqlef->set('FieldValue', '一般報支');
//		$mssqlef->insert('ressa');
//		echo true;
//	}
}
