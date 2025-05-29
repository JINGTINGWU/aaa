<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_loadmenu extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('Ecp_menu', 'MENU', true);
	}
    
	// 回傳功能表的VIEW
	function load_menu()
	{
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$data = array(
			'users' => $this->MENU->get_user($loginparameters['jec_user_id']),
			'menus' => $this->MENU->get_menu($loginparameters['jec_user_id']),
			'nowtime' => date("Y-m-d H:i:s")
		);
		return $this->load->view('index', $data, true);
	}
}