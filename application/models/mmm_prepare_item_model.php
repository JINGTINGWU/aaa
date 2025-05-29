<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_prepare_item_model extends CI_Model 
{   //備品清單
    var $m_base_scate='prepare_item';//*
    var $m_function='prepare_item_mng';
	var $m_lib_folder='tools/model/ecp_analysis/prepare_item/';
    var $m_index='item_list_index';
	var $m_menu_id=MM_menu_prepare_project;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'履約購案零配件清單',
            'item_list_index'=>array(
                    'title'=>'備品清單列表',
                    'index'=>'list'
                ),
            'create_item_index'=>array(
                    'title'=>'備品清單建檔',
                    'index'=>'list'
                ),
            'item_detail_index'=>array(
                    'title'=>'備品清單明細',
                    'index'=>'list'
                ),
            'item_submit_index'=>array(
                    'title'=>'聯絡單及簽呈',
                    'index'=>'list'
                )//
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
	
    function create_item_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."create_item_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	
    function item_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."item_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	

    function item_detail_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);        
        include $this->m_lib_folder."item_detail_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	
	
    function item_submit_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."item_submit_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }


	
	
	function project_init_full_view($project_id=0)
	{	//overall data adjust
		$final=array();
		
		$job_list=$this->db->where('jec_project_id',$project_id)->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projjob_search_view')->result_array();
		foreach($job_list as $value):
			$final[$value['jec_projjob_id']]=array('row'=>$value,'data'=>array());
			$task_list=$this->db->where('jec_project_id',$project_id)->where('jec_projjob_id',$value['jec_projjob_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projtask_search_view')->result_array();
			foreach($task_list as $vv):
				$prod_list=$this->db->where('jec_project_id',$project_id)->where('jec_projtask_id',$vv['jec_projtask_id'])->where('isactive','Y')->get('jec_projprod_search_view')->result_array();
				$final[$value['jec_projjob_id']]['data'][$vv['jec_projtask_id']]=array('row'=>$vv,'data'=>$prod_list);
			endforeach;
		endforeach;
		//date
		/*
		foreach($job_list as $value):
			$final[$value['jec_job_id']]=array('row'=>$value,'data'=>array());
			$task_list=$this->db->where('jec_project_id',$project_id)->where('jec_job_id',$value['jec_job_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projtask_search_view')->result_array();
			foreach($task_list as $vv):
				$prod_list=$this->db->where('jec_project_id',$project_id)->where('jec_job_id',$value['jec_job_id'])->where('jec_task_id',$vv['jec_task_id'])->where('isactive','Y')->get('jec_projprod_search_view')->result_array();
				$final[$value['jec_job_id']]['data'][$vv['jec_task_id']]=array('row'=>$vv,'data'=>$prod_list);
			endforeach;
		endforeach;*/
		return $final;
	}
}

?>