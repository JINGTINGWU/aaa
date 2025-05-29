<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_self_calendar_model extends CI_Model 
{   //我的日曆
    var $m_base_scate='self_calendar';//*
    var $m_function='self_calendar_mng';
	var $m_lib_folder='tools/model/self_calendar/';
    var $m_index='calendar_list_index';
	var $m_menu_id=MM_menu_self_calendar;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'我的工作行事曆管理',
            'calendar_list_index'=>array(
                    'title'=>'行事曆列表',
                    'index'=>'list'
                ),
            'new_calendar_index'=>array(
                    'title'=>'新增行事曆',
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
    function calendar_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."calendar_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function new_calendar_index($df_ip=array())   //基本資料
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        //$mm_set='mm_areabase_set';//,"jec_citydistrict_id"
        $up_f=array("");//,"c_bpartner_id","jec_brand_id"//,"activitylongterm"
        $search_array_f=array("fs_islongterm"); 
        $final=$this->CM->get_df_url($final,$df_ip);
        // $p_data=explode("_",$df_ip['chinfo']);
        
        include $this->m_lib_folder."new_calendar_index.php";

        $final['df_ip']=$df_ip;
        return $final;
    }	
}

?>