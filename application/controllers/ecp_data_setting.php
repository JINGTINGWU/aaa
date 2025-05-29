<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系統參數設定
 * Author: Johnson 2012/07/18
 */
class Ecp_data_setting extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_datamodel', 'DATA', true);
 	}
	
 	// 參數列表-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_setting';
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
		// 載入公用函數
		$this->load->library('ecp_flag');
		// 傳入相關資料
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'setting_list' => $this->DATA->get_setting_list()
		);
		$this->load->view('ecp_data/ecp_data_setting', $data);
	}
	
	// 修改參數
	function setting_update()
	{
		$data = array(
			'jec_setup_id' => $_POST['jec_setup_id'],
			'content' => $_POST['content'],
			'icon' => $_POST['icon'],
			'value' => $_POST['value']
		);
		$result = $this->DATA->setting_update($data);
		echo $result;
	}
	
	// 定時執行-----------------------------------------------------------------------------------------
	function setting_routine()
	{
		// Control名稱
		$control = 'ecp_data_setting';
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check($control);
		if ($authority['isaccess']=='N') return;
		$function_name = $this->ecp_authoritycheck->function_name($control);
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		// 傳入相關資料
		
		$this->load->model('Routine_model','RM',True);
		
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'setting_list' => $this->DATA->get_routine_list(),
			'switch_on'=>$this->RM->sys_single_setting('get','AW'),
			'status_on'=>$this->RM->sys_single_setting('get','AS')
		);
		$this->load->view('ecp_data/ecp_data_routine', $data);
	}
	
	// 修改參數
	function routine_update()
	{
		$data = array(
			'zrs_id' => $_POST['zrs_id'],
			'zrs_exe_switch' => $_POST['zrs_exe_switch'],
			'zrs_exe_type' => $_POST['zrs_exe_type'],
			'zrs_exe_timespan' => $_POST['zrs_exe_timespan'],
			'zrs_exe_dailytime' => $_POST['zrs_exe_dailytime']
		);
		$result = $this->DATA->routine_update($data);
		echo $result;
	}
}
