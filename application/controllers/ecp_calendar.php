<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_calendar extends CI_Controller 
{
    var $mm_base_url='';
    var $m_controller='ecp_calendar';
    var $m_pp=30; //統一的每頁筆數  
    var $var_to_array='common/var_to_array.php';
    var $def_info=array(
            'MDST'=>'ECPM'
        );
    var $df_array=array('tag','ac','np','key_id','ob','ot','pp','seg','s_cate','MDST','chinfo');    
    var $mm_init_set=array();  
    var $mm_content_id="ecp_content";  
    var $mm_acbk_div='ecp_content';
    var $ad_id=1000000;//管理者id
	var $role_id=0;
	
	//var $m_menu_id=0;
	var $m_menu_right=array();
	
    //var $ad_client_id=MM_Client_Id;
    var $ad_org_id=1000000;//商店 id
    var $ad_right_number=6;
    var $ad_rolerange=2;

    
    function __construct() 
    {   
        parent::__construct();
		$this->load->model('ecp_logincheck2');
		if (! $this->ecp_logincheck2->login_check()) header('Location: '.base_url());
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
		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->ad_id=$loginparameters['jec_user_id'];
		$this->role_id=$loginparameters['jec_role_id'];
        $_G['admin_menu']=$this->MAD->get_admin_menu();
        $_G['mm_js']=array('jquery');
        $_G['L_CS']='mm_common_set'; $this->CM->Unique_Load_Lib($_G['L_CS']);
        $this->mm_init_set=$this->MAD->save_init_set();
		$this->load->model('ecp_loadmenu');
		$this->navigation=$this->ecp_loadmenu->load_menu();
    }
    
    function index($tag='info',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='calendar_overview';
        //$mm='Mmm_base_prod_model';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');
    }

    function prodcust_info_div($pdc_id=0)
    {
        $pc_set=$this->CM->Init_TB_Set('mm_prodcust_set'); 
        $_G['pdc_data']=$this->GM->common_ac('list',array('info'=>$pc_set['mm_set'],'upt'=>'def','kid'=>$pdc_id));
        $_G['pdc_data']['cus_num']=$this->CM->db->where('jec_prodcust_id',$pdc_id)->where('isactive','Y')->get('jec_prodcustline')->num_rows();
        
        $this->load->view("admin/".$this->m_controller."/prodcust_info_div",$_G);         
    }

    
    function calendar_overview_mng($tag='info',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=7; $s_cate='calendar_overview';
        //$mm='Mmm_base_prod_model';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        //echo $chinfo.'<br><br><br><br><br>====';
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');
    }

    
    function prod_brand_mng($tag='info',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=9; $s_cate='prod_brand';
        //$mm='Mmm_base_prod_model';
        if(isset($_POST['kid'])) $key_id=$_POST['kid'];
        
        $this->load->model('Mmm_'.$s_cate.'_model',$MDST,True);
        $df_array=$this->df_array;
        include ('tools/'.$this->var_to_array);
        $_G=$this->$MDST->$tag($df_ip); //out put
        $this->MAD->refresh_page_check();
        include ('tools/common/bk_ac.php');
    }
    
    function prodproject_new_mng($tag='info',$ac='list',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; $MDST=$this->def_info['MDST']; $pp=$this->m_pp; $seg=9; $s_cate='prodproject_new';
        //$mm='Mmm_base_prod_model';
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