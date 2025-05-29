<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 後台管理主控程式
 * 顯示功能表以及後台首頁
 * Author: Johnson 2012/05/23
 */
class Ecp_admin extends CI_Controller {

	// 建構
	function __construct() 
    {
        parent::__construct();
        $this->load->model('Ecp_menu', 'MENU', true);
    }
	
	// 登入系統
	public function index($type='',$info='',$uid=0)
	{
		
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->load->model('Common_model', 'CM', true);
		$this->load->model('Quick_info_model', 'QIM', true);
		$redirect_url=$this->QIM->get_redirect_url($type,$info,$uid,$loginparameters);
		if (! $loginparameters)
		{
			// 清除session資料
			$this->session->sess_destroy();
			$this->load->view('login');
		}
		else
		{
			$loginparameters = $this->session->userdata(LOGIN_SESSION);
			if (! $loginparameters['login']) return false;
		}
		// 已登入, 直接顯示功能表
		$this->ecp_mainmenu();
	}
	
	function ecp_login()
	{
		// 清除session資料
		$this->session->unset_userdata(LOGIN_SESSION);
		$data = array(
			'value' => $_POST['value'],
			'password' => $_POST['password']
		);
		$result = $this->MENU->check_user($data);
		if ($result == 0)
		{
			return false;
		}
		// 儲存登入資訊
		$loginparameters = array (
			'jec_user_id' => $result[0]['jec_user_id'],
			'value' => $result[0]['value'],
			'name' => $result[0]['name'],
			'password' => $result[0]['password'],
			'email' => $result[0]['email'],
			'jec_title_id' => $result[0]['jec_title_id'],
			'jec_dept_id' => $result[0]['jec_dept_id'],
			'jec_role_id' => $result[0]['jec_role_id'],
			'login' => 'Y'
        );
        $this->session->set_userdata(LOGIN_SESSION, $loginparameters);
		echo true;
	}
	
	// 允許登入系統, 依權限顯示功能表
	function ecp_mainmenu()
	{
		// 檢查登入資訊是否正確
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		if (! $loginparameters)
		{
			return false;
		}
		else
		{
			$loginparameters = $this->session->userdata(LOGIN_SESSION);
			if (! $loginparameters['login']) return false;
		}
		// 後台功能表
		$data = array(
			'users' => $this->MENU->get_user($loginparameters['jec_user_id']),
			'menus' => $this->MENU->get_menu($loginparameters['jec_user_id']),
			'nowtime' => date("Y-m-d H:i:s")
		);
		?><script>
        	location.href="<?php echo base_url('ecp_calendar/');?>";
        </script><?php
		$this->load->view('index', $data);
	}
	
	// 登出系統
	function ecp_logout()
	{
		// 清除session資料
		$this->session->sess_destroy();
		return true;
	}
}
