<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 系統權限管理
 * Author: Johnson 2012/05/25
 */
class Ecp_authority extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->model('Ecp_authoritymodel', 'AUTHORITY', true);
 	}
	
	public function index()
	{
		// 檢查登入資訊是否正確
		$this->load->model('ecp_logincheck');
		if (! $this->ecp_logincheck->login_check()) return;
		// 載入系統作業權限
		$this->load->model('ecp_authoritycheck');
		$authority = $this->ecp_authoritycheck->authority_check('ecp_authority');
		if ($authority['isaccess']=='N') return;
		// 載入功能表
		$this->load->model('ecp_loadmenu');
		$data = array (
			'navigation' => $this->ecp_loadmenu->load_menu(),
			'authority' => $authority
		);
		$this->load->view('ecp_authority/ecp_authority_list', $data);
	}
}
