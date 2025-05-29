<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_self_work_model extends CI_Model 
{   //我的工作項目管理
    var $m_base_scate='self_work';//*
    var $m_function='self_work_mng';
	var $m_lib_folder='tools/model/self_work/';
    var $m_index='work_list_index';
	var $m_menu_id=MM_menu_self_work;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'我的工作項目管理',
            'work_list_index'=>array(
                    'title'=>'工作列表',
                    'index'=>'list'
                ),
            'work_detail_index'=>array(
                    'title'=>'工作明細',
                    'index'=>'list'
                ),
            'work_report_index'=>array(
                    'title'=>'工作回報',
                    'index'=>'list'
                ),
            'work_record_index'=>array(
                    'title'=>'工作紀錄',
                    'index'=>'list'
                )
        );
    function __construct() 
    {   global $_G;
        parent::__construct();
		$this->m_function=$this->m_base_scate.'_mng';
		$this->m_lib_folder='tools/model/'.$this->m_controller.'/'.$this->m_base_scate.'/';
		$this->m_menu_right=$this->QIM->get_menu_right($this->m_menu_id,$this->role_id);
		//$this->ad_menu_show();
		$this->QIM->menu_right_check($this->m_menu_right,array('access'),array('url'=>base_url()));
		$this->m_right_tag=$this->QIM->get_right_tag($this->m_menu_right);
    }
	function ad_menu_show()
	{

	}
    function work_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	
    function work_detail_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
		
        include $this->m_lib_folder."work_detail_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }

    function work_report_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_report_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	
	
    function work_record_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_record_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	function file_info_div($df_ip=array())   //
    {   
		$this->load->view($this->m_controller.'/self_work/file_info_div',array('dir'=>$df_ip['ac']));
    }
}

?>