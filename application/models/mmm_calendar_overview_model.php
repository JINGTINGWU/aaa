<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_calendar_overview_model extends CI_Model 
{   //場地管理->MMMM
    //var $m_controller='ecp_area';
    var $m_function='calendar_overview_mng';
	var $m_lib_folder='tools/model/calendar_overview/';
    var $m_index='info';
    var $m_tcate=array(
			'title'=>'首頁',
            'info'=>array(
                    'title'=>'行事曆',
                    'index'=>'list'
                )
        );
    function __construct() 
    {   global $_G;
        parent::__construct();
        //$_G['img_folder']=$this->m_folder;
    }
    
    //test
    
    function info($df_ip=array())   //基本資料
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        //$mm_set='mm_areabase_set';//,"jec_citydistrict_id"
        $up_f=array("");//,"c_bpartner_id","jec_brand_id"//,"activitylongterm"
        $search_array_f=array("fs_islongterm"); 
        $final=$this->CM->get_df_url($final,$df_ip);
        // $p_data=explode("_",$df_ip['chinfo']);
        
        include $this->m_lib_folder."info.php";

        $final['df_ip']=$df_ip;
        return $final;
    }


}

?>