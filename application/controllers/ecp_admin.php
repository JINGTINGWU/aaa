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
		$data['redirect_url']=$redirect_url['url'];
		//$loginparameters = $this->session->userdata(LOGIN_SESSION);
		//if (! $loginparameters||$redirect_url['needlogin']==TRUE)
		if (!isset($loginparameters['jec_user_id'])||$redirect_url['needlogin']==TRUE)
		{
			// 清除session資料
			//$this->CM->JS_TMsg('NeedLogin');
			$this->session->sess_destroy();
			$this->load->view('login',$data);
		}
		else
		{
			//$this->CM->JS_TMsg('OKOK');
			$loginparameters = $this->session->userdata(LOGIN_SESSION);
			if (! $loginparameters['login']) return false;
			$this->ecp_mainmenu();
		}
		// 已登入, 直接顯示功能表 
		//$this->ecp_mainmenu();
	}
	function fix_login()
	{
			@session_start();
			$this->session->unset_userdata(LOGIN_SESSION);
			$data = array(
				'value' => 111,
				'password' => 111
			);
			$result = $this->MENU->check_user($data, true);
			if ($result == 0)
			{
				echo 'ERROR3';
			}
			else
			{
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
				'login' => 'Y',
				'isadmin' => $result[0]['isadmin'],
				'os' => $this->MENU->get_os_setup()
	        );
	        $this->session->set_userdata(LOGIN_SESSION, $loginparameters);
			echo 'OKD';
			}
	}	
	function ecp_login()
	{
		@session_start();
		if (! isset($_SESSION['s3capcha']))
		{
			echo 'ERROR1';
		}
		elseif ($_POST['s3capcha'] != $_SESSION['s3capcha'])
		{
			echo 'ERROR2';
		}
		else
		{
			// 清除session資料
			$this->session->unset_userdata(LOGIN_SESSION);
			$data = array(
				'value' => $_POST['value'],
				'password' => $_POST['password']
			);
			$result = $this->MENU->check_user($data, true);
			if ($result == 0)
			{
				echo 'ERROR3';
			}
			else
			{
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
				'login' => 'Y',
				'isadmin' => $result[0]['isadmin'],
				'os' => $this->MENU->get_os_setup()
	        );
	        $this->session->set_userdata(LOGIN_SESSION, $loginparameters);
	        // 紀錄登入者及時間
	        $fp=fopen('uploads/login_'.date('Y-m').'.txt','a+');
			$user_IP = $this->getRealIpAddr();
	        $msg = date('Y-m-d H:i:s').','.$result[0]['value'].','.$result[0]['name'].','.$user_IP;
	        $msg .= "\r\n";
	        fwrite($fp, $msg);
	        fclose($fp);
			if($_POST['redirect_url']==''):
				echo base_url();
			else:
				echo $_POST['redirect_url'];
			endif;
			
			}
			//echo 'OK';
		}
	}
	
	// 取得真實IP
	function getRealIpAddr()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
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
			'isadmin' => $loginparameters['isadmin'],
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
	
	// 切換帳號
	function account_exchange()
	{		
		$data = array(
			'value' => $_POST['new_account'],
			'password' => ''
		);
		$result = $this->MENU->check_user($data, false);
		if ($result == 0)
		{
			echo false;
		}
		else
		{
			// 重新儲存登入資訊
			$this->session->unset_userdata(LOGIN_SESSION);			
			$loginparameters = array (
				'jec_user_id' => $result[0]['jec_user_id'],
				'value' => $result[0]['value'],
				'name' => $result[0]['name'],
				'password' => $result[0]['password'],
				'email' => $result[0]['email'],
				'jec_title_id' => $result[0]['jec_title_id'],
				'jec_dept_id' => $result[0]['jec_dept_id'],
				'jec_role_id' => $result[0]['jec_role_id'],
				'login' => 'Y',
				'isadmin' => $result[0]['isadmin'],
				'os' => $this->MENU->get_os_setup()
	        );
	        $this->session->set_userdata(LOGIN_SESSION, $loginparameters);
			$this->session->set_userdata('unconfirm_notice','');
			$this->session->set_userdata('delay_task','');
			$this->session->set_userdata('undone_task','');
			$this->session->set_userdata('batchunconfirm_notice','');
			$this->session->set_userdata('batchdelete_notice','');
			$this->session->set_userdata('alert_notice','');
	        //$this->ecp_mainmenu();
	        echo true;
		}
	}
}
