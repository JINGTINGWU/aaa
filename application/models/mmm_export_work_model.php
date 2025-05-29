<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_export_work_model extends CI_Model 
{   //我的日曆
    var $m_base_scate='export_work';//*
    var $m_function='export_work_mng';
	var $m_lib_folder='tools/model/export_work/';
    var $m_index='model_export_index';
	var $m_menu_id=MM_menu_export_work;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'料品與工作明細範本匯出',
            'model_export_index'=>array(
                    'title'=>'範本匯出',
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
	{	//

	}
    function model_export_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."model_export_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	
}

?>