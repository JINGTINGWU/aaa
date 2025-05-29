<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_test extends CI_Controller 
{
    var $mm_base_url='';
    var $m_controller='ecp_test';
    var $m_pp=10; //統一的每頁筆數  
    var $var_to_array='common/var_to_array.php';
    var $def_info=array(
            'MDST'=>'ECPM'
        );
    var $df_array=array('tag','ac','np','key_id','ob','ot','pp','seg','s_cate','MDST','chinfo');    
    var $mm_init_set=array();  
    var $mm_content_id="ecp_content";  
    var $mm_acbk_div='ecp_content';
    var $ad_id=1000000;//管理者id
    //var $ad_client_id=MM_Client_Id;
    var $ad_org_id=1000000;//商店 id
    var $ad_right_number=6;
    var $ad_rolerange=2;

    
    function __construct() 
    {   
        parent::__construct();
		$this->load->model('ecp_logincheck2');
		if (! $this->ecp_logincheck2->login_check()) return;
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
		$_G['header']='card_header';
		$_G['img_folder']='card';
		$_G['css']='card_style';
        $_G['footer']='card_footer';
		//$_G['site_set']=$this->FB->get_site_fb_data();
		//$this->ECM->GVLoginMem(); //傳遞登入session
		//$this->cust_id=$_G['LM_jec_customer_id'];
        $_G['admin_menu']=$this->MAD->get_admin_menu();
        $_G['mm_js']=array('jquery');
        $_G['L_CS']='mm_common_set'; $this->CM->Unique_Load_Lib($_G['L_CS']);
        $this->mm_init_set=$this->MAD->save_init_set();
		$this->load->model('ecp_loadmenu');
		$this->navigation=$this->ecp_loadmenu->load_menu();
    }
	
	function blank()
	{
		
	}
	
	function trans_jtp()
	{	/*
		$job_list=$this->CM->db->get('jec_job')->result_array();
		$job_info=$this->CM->FormatData(array('db'=>$job_list,'key'=>'jec_job_id'),'page_db','key_db');
		$projjob_list=$this->CM->db->where('jobname',NULL)->where('isactive','Y')->get('jec_projjob')->result_array();
		//$this->CM->JS_TMsg(count($projjob_));
		foreach($projjob_list as $value):
			if(isset($job_info[$value['jec_job_id']])):
				$e_info=$job_info[$value['jec_job_id']];
				$upd=array(
						'jobname'=>$e_info['name'],
						'jobjobtype'=>$e_info['jobtype']
					);
				$this->CM->db->where('jec_projjob_id',$value['jec_projjob_id'])->update('jec_projjob',$upd);
			endif;
		endforeach;

		$task_list=$this->CM->db->get('jec_task')->result_array();
		$task_info=$this->CM->FormatData(array('db'=>$task_list,'key'=>'jec_task_id'),'page_db','key_db');
		$projtask_list=$this->CM->db->where('taskname',NULL)->where('isactive','Y')->get('jec_projtask')->result_array();
		foreach($projtask_list as $value):
			if(isset($task_info[$value['jec_task_id']])):
				$e_info=$task_info[$value['jec_task_id']];
				$upd=array(
						'taskname'=>$e_info['name'],
						'taskdaynotice'=>$e_info['daynotice'],
						'taskdaydelay'=>$e_info['daydelay'],
						'taskworkweight'=>$e_info['workweight'],
						'taskprocesstype'=>$e_info['processtype'],
						'taskconfirmtype'=>$e_info['confirmtype']
					);
				$this->CM->db->where('jec_projtask_id',$value['jec_projtask_id'])->update('jec_projtask',$upd);
			endif;
		endforeach;		
		
		
		$prod_list=$this->CM->db->get('jec_product')->result_array();
		$prod_info=$this->CM->FormatData(array('db'=>$prod_list,'key'=>'jec_product_id'),'page_db','key_db');
		$projprod_list=$this->CM->db->where('prodname',NULL)->where('isactive','Y')->get('jec_projprod')->result_array();
		foreach($projprod_list as $value):
			if(isset($prod_info[$value['jec_product_id']])):
				$e_info=$prod_info[$value['jec_product_id']];
				if($value['prodtype']==8)://取product_open的值
					$open_prod=$this->CM->db->where('jec_productopen_id',$value['jec_productopen_id'])->get('jec_productopen')->result_array();
					$open_prod=$open_prod[0];
					$e_info['name']=$open_prod['name'];
					$e_info['specification']=$open_prod['specification'];
					$e_info['jec_uom_id']=$open_prod['jec_uom_id'];
				endif;
				$upd=array(
						'prodname'=>$e_info['name'],
						'prodspec'=>$e_info['specification'],
						'prod_uom_id'=>$e_info['jec_uom_id']
					);
				$this->CM->db->where('jec_projprod_id',$value['jec_projprod_id'])->update('jec_projprod',$upd);
			endif;
		endforeach;	*/
	}

	function input_example()
	{	global $_G;
		$this->load->view("input_example",$_G); 
	}	
                     
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */