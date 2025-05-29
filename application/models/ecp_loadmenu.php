<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_loadmenu extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('Ecp_menu', 'MENU', true);
	}
    
	// 回傳功能表的VIEW
	function load_menu()
	{
		$this->load->model('Quick_info_model', 'QIM', true);
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$data = array(
			'users' => $this->MENU->get_user($loginparameters['jec_user_id']),
			'menus' => $this->MENU->get_menu($loginparameters['jec_user_id']),
			'isadmin' => $loginparameters['isadmin'],
			'nowtime' => date("Y-m-d H:i:s")
		);
		$this->QIM->qad_id=$loginparameters['jec_user_id'];
		$s_data=array(
			'undone_task'=>$this->QIM->get_undone_task(),
			'delay_task'=>$this->QIM->get_delay_task(),
			'unconfirm_notice'=>$this->QIM->get_unconfirm_notice(),
			'batchunconfirm_notice'=>$this->QIM->get_batchunconfirm_notice(),
			'alert_notice'=>$this->QIM->get_alert_notice()
		);
		$data=array_merge($data,$s_data);
		//get_quick_model
		
		
		return $this->load->view('index', $data, true);
	}
}