<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_logincheck2 extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    
	// 回傳是否正確登入
	function login_check()
	{
		$loginstatus = true;
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		if (! $loginparameters)
		{
			$loginstatus = false;
		}
		else
		{
		    $loginparameters = $this->session->userdata(LOGIN_SESSION);
		    if (! $loginparameters['login'])
			{
				$loginstatus = false;
			}
			else
			{
				if (! $loginparameters['jec_user_id'])
				{
					$loginstatus = false;
				}
				else
				{
					if (! $loginparameters['password'])
					{
						$loginstatus = false;
					}
					else
					{
						$row = $this->db->select('password')->where('jec_user_id', $loginparameters['jec_user_id'])->get('jec_user')->result_array();
						if ($loginparameters['password'] != $row[0]['password'])
						{
							$loginstatus = false;
						}
					}
				}
			}
		}
		if (! $loginstatus)
		{
			$this->session->sess_destroy();
			echo '<script type="text/javascript">parent.location.href="'.base_url().'"</script>';
			return false;
		}
		else
		{
			return true;
		}
	}
}