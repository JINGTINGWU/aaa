<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_work_analysis_model extends CI_Model 
{   //工作查詢
    var $m_base_scate='work_analysis';//*
    var $m_function='work_analysis_mng';
	var $m_lib_folder='tools/model/work_analysis/';
    var $m_index='work_analysis_index';
	var $m_menu_id=MM_menu_work_analysis;
	var $m_right_tag=array();
	//var $m_menu_right=array();
    var $m_tcate=array(
			'title'=>'工作狀態查詢',
            'work_analysis_index'=>array(
                    'title'=>'工作列表',
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
    
    function work_analysis_index($df_ip=array())   //
    {   global $_G; 
		
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_analysis_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function work_record_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_record_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
}

?>