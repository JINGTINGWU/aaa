<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_inform_item_model extends CI_Model 
{   //通知事項管理
    var $m_base_scate='inform_item';//*
    var $m_function='inform_item_mng';
	var $m_lib_folder='tools/model/inform_item/';
    var $m_index='inform_list_index';
	var $m_menu_id=MM_menu_inform_item;
	var $m_right_tag=array();
    var $m_tcate=array(
			'title'=>'我的通知事項管理',
            'inform_list_index'=>array(
                    'title'=>'通知列表',
                    'index'=>'list'
                ),
            'confirm_list_index'=>array(
                    'title'=>'工作確認',
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
    function inform_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."inform_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
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
	function adjusttask_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."adjusttask_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	function deletetask_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."deletetask_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function confirm_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."confirm_list_index.php";
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
	
		function project_init_full_view($project_id=0)
	{	//overall data adjust
		$final=array();
		
		$job_list=$this->db->where('jec_project_id',$project_id)->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projjob_search_view')->result_array();
		foreach($job_list as $value):
			$final[$value['jec_projjob_id']]=array('row'=>$value,'data'=>array());
			$task_list=$this->db->where('jec_project_id',$project_id)->where('jec_projjob_id',$value['jec_projjob_id'])->where('isactive','Y')->where_in('noticetype',array(4,5,6,7,8,9,10,31))->where('description','批次展期')->order_by('seqno','ASC')->get('jec_adjusttask_search_view')->result_array();
			foreach($task_list as $vv):
				$prod_list=$this->db->where('jec_project_id',$project_id)->where('jec_projtask_id',$vv['jec_projtask_id'])->where('isactive','Y')->get('jec_projprod_search_view')->result_array();
				$final[$value['jec_projjob_id']]['data'][$vv['jec_projtask_id']]=array('row'=>$vv,'data'=>$prod_list);
			endforeach;
		endforeach;
		/*
		$final=array();
		
		$job_list=$this->db->where('jec_project_id',$project_id)->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projjob_search_view')->result_array();
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
	function project_init_full_view_deltask($project_id=0)
	{	//overall data adjust
		$final=array();
		
		$job_list=$this->db->where('jec_project_id',$project_id)->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projjob_search_view')->result_array();
		foreach($job_list as $value):
			$final[$value['jec_projjob_id']]=array('row'=>$value,'data'=>array());
			$task_list=$this->db->where('jec_project_id',$project_id)->where('jec_projjob_id',$value['jec_projjob_id'])->where('isactive','Y')->where_in('noticetype',array(4,5,6,7,8,9,10,31))->where('description','批次刪除')->order_by('seqno','ASC')->get('jec_adjusttask_search_view')->result_array();
			foreach($task_list as $vv):
				$prod_list=$this->db->where('jec_project_id',$project_id)->where('jec_projtask_id',$vv['jec_projtask_id'])->where('isactive','Y')->get('jec_projprod_search_view')->result_array();
				$final[$value['jec_projjob_id']]['data'][$vv['jec_projtask_id']]=array('row'=>$vv,'data'=>$prod_list);
			endforeach;
		endforeach;
		
		return $final;
	}
}

?>