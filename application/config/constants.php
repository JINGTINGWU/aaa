<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('LOGIN_SESSION', 'ecp_login');  // 紀錄使用者登入資訊的session name
define('MM_SY', 2012);
define('MM_UP_Folder','uploads/');
define('MM_Common_Temp','temp_save/');
define('MM_Tmep_File_Dir',MM_UP_Folder.MM_Common_Temp);
define('MM_Proj_File_Path','uploads/project_file/');

define('MM_menu_create_project',7);
define('MM_menu_init_project',8);
define('MM_menu_adjust_project',9);
define('MM_menu_cost_project',10);
define('MM_menu_addendum_project',33);
define('MM_menu_prepare_project',23);


define('MM_menu_self_work',11);
define('MM_menu_inform_item',12);
define('MM_menu_self_calendar',13);
define('MM_menu_export_work',34);

define('MM_menu_cost_analysis',36);
define('MM_menu_progress_analysis',20);
define('MM_menu_invoice_analysis',21);
define('MM_menu_work_analysis',24);

define('MM_menu_projtask_trans',35);
/* End of file constants.php */
/* Location: ./application/config/constants.php */