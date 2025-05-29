<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_routine_start extends CI_Controller 
{
    var $mm_base_url='';
    var $m_controller='ecp_work';
    var $m_pp=10; //統一的每頁筆數  
    var $var_to_array='common/var_to_array.php';
    var $def_info=array(
            'MDST'=>'ECPM'
        );
    var $df_array=array('tag','ac','np','key_id','ob','ot','pp','seg','s_cate','MDST','chinfo');    
    var $mm_init_set=array();  
    var $mm_content_id="ecp_content";  
    var $mm_acbk_div='ecp_content';
    var $ad_id=1;//管理者id
	
    //var $ad_client_id=MM_Client_Id;
    var $ad_org_id=1000000;//商店 id
    var $ad_right_number=6;
    var $ad_rolerange=2;

    
    function __construct() 
    {   
        parent::__construct();
		$this->load->model('ecp_logincheck2');
		//if (! $this->ecp_logincheck2->login_check()) return;
        //$this->core->init();
		$this->load->model('Get_model','GM',True);
		$this->load->model('Common_model','CM',True);
		//$this->load->model('Adempiere_model','AM',True);
		//$this->load->model('Ec_common_model','ECM',True);
		//$this->load->model('Ec_div_model','EDM',True);
		$this->load->model('Mm_admin_model','MAD',True);
		
		//$this->load->model('Keyword_model','KM',True);
		//$this->load->model('Buycar_model','BCM',True);
       // $this->load->model('Fb_model','FB',True);
       // $this->mm_base_url=site_url('card/');
        //$this->m_controller='card';
		
		//$ecp_login=$this->CM->AdLoginCheck();
        //echo  $ecp_login['jec_user_id']."-".$ecp_login['value']."-".$ecp_login['password'];
        //$this->ad_id=$ecp_login['jec_user_id'];
        //$this->ad_org_id=$ecp_login['ad_org_id'];
        //$this->ad_rolerange=$ecp_login['rolerange'];
		global $_G;
        //$_G['ad_rolerange']=$this->ad_rolerange;
        //$_G['ad_org_id']=$this->ad_org_id;
		
		/*
		$_G['header']='card_header';
		$_G['img_folder']='card';
		$_G['css']='card_style';
        $_G['footer']='card_footer';*/
		
		//$_G['site_set']=$this->FB->get_site_fb_data();
		//$this->ECM->GVLoginMem(); //傳遞登入session
		//$this->cust_id=$_G['LM_jec_customer_id'];
        $_G['admin_menu']=$this->MAD->get_admin_menu();
        $_G['mm_js']=array('jquery');
        $_G['L_CS']='mm_common_set'; $this->CM->Unique_Load_Lib($_G['L_CS']);
        $this->mm_init_set=$this->MAD->save_init_set();
		$this->load->model('ecp_loadmenu');
		$this->navigation=$this->ecp_loadmenu->load_menu();
		$this->load->model('Routine_model','RM',True);
		
    }
	
	//自動啟動
	function routine_start()
	{		
		// 載入功能表
		$this->load->model('Ecp_datamodel', 'DATA', true);
		$this->load->model('ecp_loadmenu');
		// 傳入相關資料
		
		$this->load->model('Routine_model','RM',True);
		
		
		$this->load->view("ecp_data/ecp_data_routine_start"); 
	}
	
    function index($tag='work_list_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='self_work';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');
    }	
	
	function routine_list()
	{	global $_G; //
		
		//$Routine_obj=$mobj->Load_Class('Routine'); 
		
		//$routine_list=$mobj->db->get(array('table'=>$Routine_obj->main_tb,'condition'=>$Routine_obj->main_mark."='Y'",'row_type'=>2));
		$_G['routine_list']=$this->CM->db->where('zrs_isactive','Y')->get('routine_schedule')->result_array();
		
		$_G['switch_on']=$this->RM->sys_single_setting('get','AW');
		$_G['status_on']=$this->RM->sys_single_setting('get','AS');		
		//$_G['switch_on']=$this->RM->single_setting_ac('get','Routine_Switch');
		//$_G['status_on']=$this->RM->single_setting_ac('get','Routine_Status');
		$this->load->view("routine/routine_list",$_G); 
	}
	
	function routine_edit($routine_id=0)
	{	global $_G; 
		$this->load->library('form_input');
		$ip_info=$this->RM->get_field_info();
		$main_data=$this->RM->get_routine($routine_id);
		$_G['main_op']=$this->form_input->each_op_trans('full',$ip_info,$main_data);
		$_G['routine_id']=$routine_id;
		$this->load->view("routine/routine_edit",$_G); 
	}
	
	function Routine_Lib($key_id=0)
	{
	
		ignore_user_abort(true); //改成抓全部的
		set_time_limit(0);

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>換成UTF-8的</title>
</head>
';	

		echo '<script>window.close();</script>';
		ob_flush();
		sleep(2);
		flush();
		set_time_limit(0);
		global $_G;
		$zrs_id=(int)$key_id;
		$first=1;//
		$ap_min=$this->RM->get_ap_min();
		$interval=60*$ap_min;
		$content=0;//--
		do{
			if($first==1):
				//$on_status=$this->RM->single_setting_ac('get','Routine_Status');
				$on_status=$this->RM->sys_single_setting('get','AS');
				if($on_status=='Y'):
					$content=0;
					break;
				endif;
				//$this->RM->single_setting_ac('update','Routine_Status','Y');
				$this->RM->sys_single_setting('update','AS','Y');
			endif;
			//$Routine_obj->db->DB_Connect();
			if($first==0):
				$this->RM->run_routine_process_once();
			endif;
			$first=0;
			//$Routine_obj->db->DB_Close();-get_next_time And Save
			$nt_ip=array(
					'zrs_id'=>0,
					'zrs_exe_type'=>1,
					'zrs_exe_timespan'=>$ap_min
				);
			$next_time=$this->RM->get_setchange_time($nt_ip);
			$this->RM->update_ap_nt($next_time);

			sleep($interval);
			//$Routine_obj->db->DB_Connect();
			//$exe_switch=$this->RM->single_setting_ac('get','Routine_Switch');
			$exe_switch=$this->RM->sys_single_setting('get','AW');
    		if($exe_switch=='Y'):
       		 	$content=1;
        		//$this->RM->single_setting_ac('update','Routine_Status','Y');//AS
				$this->RM->sys_single_setting('update','AS','Y');
    		else:
       			 $content=0;
       			 //$this->RM->single_setting_ac('update','Routine_Status','N');//AW
				 $this->RM->sys_single_setting('update','AS','N');
   			endif;
			//$Routine_obj->db->DB_Close();
		}while($content==1);
	}
	
	function routine_bk()
	{
		$bk_url='';
		$gv=array('action_type'); $gpv=$this->CM->GTPV($gv,array('type'=>'sarray'));
		log_message('info','action_type:'.$gpv['action_type']);
		switch($gpv['action_type']):
			case 'new_routine': 
				$uv=array('zrs_title'); $upv=$this->CM->GTPV($uv,array('type'=>'sarray'));
				$npv=array(
						'zrs_isactive'=>'Y',
						'zrs_exe_switch'=>'N',
						'zrs_status'=>'N',
						'zrs_exe_type'=>$this->RM->exetype_span,
						'zrs_exe_timespan'=>60 //預設一小時
					);
				$upd=array_merge($upv,$npv);
				$up_id=$this->RM->get_routine_empty_id();
				if($up_id==0):
					$this->CM->db->insert($this->RM->main_tb,$upd);
				else:
					$this->CM->db->where($this->RM->main_key,$up_id)->update($this->RM->main_tb,$upd);
				endif;	
				$bk_url=site_url('ecp_routine/routine_list/');
		
				break;
			case 'edit_routine':
				$key_id=(int)$_POST['key_id'];
				$uv=$this->RM->get_field_info(); $upv=$this->CM->GTPV($uv,array('type'=>'field_set'));
				$this->RM->update_routine_set($key_id,$upv);
				//upload_ upload_file//
				$this->CM->SingleUpload('upload_file',$this->RM->file_path,$upv['zrs_exe_file']);
				$bk_url=site_url('ecp_routine/routine_list/');
		
				break;
			case 'open_switch':
				//start
				$key_id=(int)$_POST['key_id'];
				$_G['bk_url']=site_url('ecp_routine/routine_list/');
				$this->RM->exe_switch($key_id,'Y');
				$bk_url=$_G['bk_url'];				
				break;
			case 'close_switch':
				//
				$key_id=(int)$_POST['key_id'];
				$this->RM->exe_switch($key_id,'N');
				$bk_url=site_url('ecp_routine/routine_list/');
		
				break;
			case 'exe_once'://執行一次-
				$key_id=(int)$_POST['key_id'];
				if($this->RM->exe_routine_once($key_id)):
					$msg="執行完畢";
				else:
					$msg="執行檔案不存在";//
				endif;
		
				break;
			case 'reset_on':
				//$this->RM->reset_routine();
				//$this->RM->single_setting_ac('update','Routine_Switch','N');
				//$this->RM->single_setting_ac('update','Routine_Status','N');
				
				$this->RM->sys_single_setting('update','AW','N');
				$this->RM->sys_single_setting('update','AS','N');
				
				$this->RM->close_exe_status();
				$this->RM->sys_single_setting('update','AW','Y');
				$this->RM->full_reset_changetime();
				break;
			case 'reset':
				//$this->RM->reset_routine();
				//$this->RM->single_setting_ac('update','Routine_Switch','N');
				//$this->RM->single_setting_ac('update','Routine_Status','N');
				
				$this->RM->sys_single_setting('update','AW','N');
				$this->RM->sys_single_setting('update','AS','N');
				
				$this->RM->close_exe_status();
				$bk_url=site_url('ecp_routine/routine_list/');
		
				break;
			case 'SwitchOn':
				$bk_url=site_url('ecp_routine/routine_list/');
				//$this->RM->single_setting_ac('update','Routine_Switch','Y');
				$this->RM->sys_single_setting('update','AW','Y');
				//$this->RM->single_setting_ac('update','Routine_Status','Y');
				$this->RM->full_reset_changetime();
				//change_time的時間全部重新更新-
		
				?>
				   <script>
						//設105sec後前頁翻新視窗關掉。
						function PG_After_Exe(){
							top.location.href='<?php echo $bk_url;?>';
						}//delete msg
						setTimeout('PG_After_Exe()',3000);
						window.open('<?php echo site_url('ecp_routine/Routine_Lib/0/');?>','exe_routine','height=10,width=10');
                    </script>
        		<?php
				break;
			case 'SwitchOff':	
				$bk_url=site_url('ecp_routine/routine_list/');	
				//$this->RM->single_setting_ac('update','Routine_Switch','N');
				$this->RM->sys_single_setting_ac('update','AW','N');
				break;
		endswitch;
		if($msg!='') $this->CM->JS_Msg($msg);
		if($bk_url!='') $this->CM->JS_Link($bk_url,$js_type);
	}	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */