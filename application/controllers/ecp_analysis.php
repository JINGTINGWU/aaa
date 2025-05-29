<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_analysis extends CI_Controller 
{
    var $mm_base_url='';
    var $m_controller='ecp_analysis';
    var $m_pp=30; //統一的每頁筆數  
    var $var_to_array='common/var_to_array.php';
    var $def_info=array(
            'MDST'=>'ECPM'
        );
    var $df_array=array('tag','ac','np','key_id','ob','ot','pp','seg','s_cate','MDST','chinfo');    
    var $mm_init_set=array();  
    var $mm_content_id="ecp_content";  
    var $mm_acbk_div='ecp_content';
    var $ad_id=1;//管理者id
	var $role_id=0;//
	
	//var $m_menu_id=0;
	var $m_menu_right=array();
    var $ad_rolerange=2;

    
    function __construct() 
    {   
        parent::__construct();
		@session_start();
		$this->load->model('ecp_logincheck2');
		if (! $this->ecp_logincheck2->login_check()) header('Location: '.base_url());
		$this->load->model('Get_model','GM',True);
		$this->load->model('Common_model','CM',True);
		$this->load->model('Mm_admin_model','MAD',True);
		global $_G;

		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->ad_id=$loginparameters['jec_user_id'];
		$this->role_id=$loginparameters['jec_role_id'];
		$this->isadmin=$loginparameters['isadmin'];
        $_G['admin_menu']=$this->MAD->get_admin_menu();
        $_G['mm_js']=array('jquery');
        $_G['L_CS']='mm_common_set'; $this->CM->Unique_Load_Lib($_G['L_CS']);
        $this->mm_init_set=$this->MAD->save_init_set();
		$this->load->model('ecp_loadmenu');
		$this->navigation=$this->ecp_loadmenu->load_menu();
		
    }
	
    function index($tag='project_list_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='progress_analysis';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
		
        include ('tools/common/bk_ac.php');
    }	
	
    function progress_analysis_mng($tag='project_list_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='progress_analysis';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');		
    }	
	
    function cost_analysis_mng($tag='project_list_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='cost_analysis';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');		
    }
    function invoice_analysis_mng($tag='invoice_statistic_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='invoice_analysis';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');		
    }
    function work_analysis_mng($tag='work_analysis_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='work_analysis';
	
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');		
    }	
	
    function prepare_item_mng($tag='item_list_index',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='prepare_item';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');
    } 
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */