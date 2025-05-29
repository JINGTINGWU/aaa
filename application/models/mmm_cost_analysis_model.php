<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_cost_analysis_model extends CI_Model 
{   //成本分析
    var $m_base_scate='cost_analysis';//*
    var $m_function='cost_analysis_mng';
	var $m_lib_folder='tools/model/cost_analysis/';
    var $m_index='project_list_index';
	var $m_menu_id=MM_menu_cost_analysis;
	var $m_right_tag=array();
	//var $m_menu_right=array();
    var $m_tcate=array(
			'title'=>'專案成本分析表',
            'project_list_index'=>array(
                    'title'=>'專案列表',
                    'index'=>'list'
                ),
            'work_overview_index'=>array(
                    'title'=>'所有工作清單',
                    'index'=>'list'
                ),/*
            'gantt_view_index'=>array(
                    'title'=>'工作項目甘特圖',
                    'index'=>'list'
                ),*/
            'cost_analysis_index'=>array(
                    'title'=>'成本差異分析',
                    'index'=>'list'
                ),
            'prepare_item_index'=>array(
                    'title'=>'履約備品清單分析',
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
    
    function project_list_index($df_ip=array())   //
    {   global $_G; 
		//$this->QIM->menu_right_check($this->m_menu_right,array('insert'),array('url'=>base_url($this->m_controller.'/'.$this->m_function.'/project_list_index/list/-1/value/')));
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."project_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function work_overview_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."work_overview_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function gantt_view_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."gantt_view_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
	
    function cost_analysis_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."cost_analysis_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
    function prepare_item_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."prepare_item_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	
	function project_init_full_view($project_id=0)
	{	//overall data adjust
		$final=array();
		
		$job_list=$this->db->where('jec_project_id',$project_id)->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projjob_search_view')->result_array();
		foreach($job_list as $value):
			$final[$value['jec_projjob_id']]=array('row'=>$value,'data'=>array());
			$task_list=$this->db->where('jec_project_id',$project_id)->where('jec_projjob_id',$value['jec_projjob_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('project_init_full_view')->result_array();
			foreach($task_list as $vv):
				//要join_productprep.
				$prod_list=$this->db->where('jec_projprod_search_view.jec_project_id',$project_id)->where('jec_projprod_search_view.jec_projtask_id',$vv['jec_projtask_id'])->where('jec_projprod_search_view.isactive','Y')->join('jec_productprep', 'jec_productprep.jec_productprep_id = jec_projprod_search_view.jec_productprep_id', 'left')->select('jec_projprod_search_view.*')->select('jec_productprep.price AS prep_price')->select('jec_productprep.quantity AS prep_quantity')->select('jec_productprep.total AS prep_total')->get('jec_projprod_search_view')->result_array();
				$final[$value['jec_projjob_id']]['data'][$vv['jec_projtask_id']]=array('row'=>$vv,'data'=>$prod_list);
			endforeach;
		endforeach;
		return $final;
	}	
}

?>