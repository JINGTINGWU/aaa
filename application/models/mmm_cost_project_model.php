<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_cost_project_model extends CI_Model 
{   //專案費用/發票
    var $m_base_scate='cost_project';//*
    var $m_function='cost_project_mng';
	var $m_lib_folder='tools/model/cost_project/';
    var $m_index='project_list_index';
	var $m_menu_id=MM_menu_cost_project;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'專案費用與發票管理',
            'project_list_index'=>array(
                    'title'=>'專案列表',
                    'index'=>'list'
                ),
            'project_cost_index'=>array(
                    'title'=>'專案費用',
                    'index'=>'list'
                ),
            'project_invoice_index'=>array(
                    'title'=>'專案發票',
                    'index'=>'list'
                )
        );//
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
    function project_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."project_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	
    function project_cost_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."project_cost_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	
	
    function project_invoice_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."project_invoice_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }		

}

?>