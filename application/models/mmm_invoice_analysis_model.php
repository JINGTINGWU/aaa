<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_invoice_analysis_model extends CI_Model 
{   //已開發票額度
    var $m_base_scate='invoice_analysis';//*
    var $m_function='invoice_analysis_mng';
	var $m_lib_folder='tools/model/invoice_analysis/';
    var $m_index='project_list_index';
	var $m_menu_id=MM_menu_invoice_analysis;
	var $m_right_tag=array();
	//var $m_menu_right=array();
    var $m_tcate=array(
			'title'=>'公司別年度已開發票額度',
            'invoice_statistic_index'=>array(
                    'title'=>'發票統計',
                    'index'=>'list'
                ),
            'invoice_detail_index'=>array(
                    'title'=>'發票明細',
                    'index'=>'list'
                )
        );
    function __construct() 
    {   global $_G;
        parent::__construct();
		//$this->m_menu_id=MM_menu_create_project;
		$this->m_function=$this->m_base_scate.'_mng';
		$this->m_lib_folder='tools/model/'.$this->m_controller.'/'.$this->m_base_scate.'/';
		$this->m_menu_right=$this->QIM->get_menu_right($this->m_menu_id,$this->role_id);
		$this->ad_menu_show();
		$this->QIM->menu_right_check($this->m_menu_right,array('access'),array('url'=>base_url()));
		$this->m_right_tag=$this->QIM->get_right_tag($this->m_menu_right);
    }
	
	function ad_menu_show()
	{
		if($this->m_menu_right['isaccess']=='N'):
			$this->m_tcate=array(
			'title'=>'專案立案建檔'
			);
		endif;
		if($this->m_menu_right['isinsert']=='N'):
			unset($this->m_tcate['project_list_index']);
		endif;
	}
    
    function invoice_statistic_index($df_ip=array())   //
    {   global $_G; 
		//$this->QIM->menu_right_check($this->m_menu_right,array('insert'),array('url'=>base_url($this->m_controller.'/'.$this->m_function.'/project_list_index/list/-1/value/')));
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."invoice_statistic_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function invoice_detail_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."invoice_detail_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
}

?>