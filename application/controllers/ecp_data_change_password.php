<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 變更密碼
 * Author: Johnson 2012/07/18
 */
class Ecp_data_change_password extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ecp_datamodel', 'DATA', true);
 	}
	
 	// 變更密碼-----------------------------------------------------------------------------------------
	public function index()
	{
		// Control名稱
		$control = 'ecp_data_change_password';
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
		// 傳入相關資料
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority,
			'function_name' => $function_name,
			'user_data' => $this->DATA->get_user_data($loginparameters['jec_user_id'])
		);
		$this->load->view('ecp_data/ecp_data_change_password', $data);
	}
	
	// 修改密碼
	function password_update()
	{
		$data = array(
			'jec_user_id' => $_POST['jec_user_id'],
			'password' => $_POST['password']
		);
		$result = $this->DATA->password_update($data);
		echo $result;
	}
}
