<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_create_project_model extends CI_Model 
{   //專案立案建檔
    var $m_base_scate='create_project';//*
    var $m_function='create_project_mng';
	var $m_lib_folder='tools/model/create_project/';
    var $m_index='project_new_index';
	var $m_menu_id=MM_menu_create_project;
	var $m_right_tag=array();
	//var $m_menu_right=array();
    var $m_tcate=array(
			'title'=>'專案立案建檔',
            'project_new_index'=>array(
                    'title'=>'專案立案建檔',
                    'index'=>'edit'
                ),
            'project_list_index'=>array(
                    'title'=>'專案立案列表',
                    'index'=>'list'
                ),
            'mission_list_index'=>array(
                    'title'=>'任務清單',
                    'index'=>'list'
                ),
            'job_list_index'=>array(
                    'title'=>'工作項目',
                    'index'=>'list'
                ),
            'job_detail_index'=>array(
                    'title'=>'工作明細',
                    'index'=>'list'
                )//
        );
    function __construct() 
    {   global $_G;
        parent::__construct();
		//$this->m_menu_id=MM_menu_create_project;
		$this->m_function=$this->m_base_scate.'_mng';
		$this->m_lib_folder='tools/model/'.$this->m_controller.'/'.$this->m_base_scate.'/';
		$this->m_menu_right=$this->QIM->get_menu_right($this->m_menu_id,$this->role_id);
		//echo 'v<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>><br><br><br><br>'.$this->m_menu_right['isupdate'];
        //$_G['img_folder']=$this->m_folder;
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
			unset($this->m_tcate['project_new_index']);
		endif;
	}
    
    function project_new_index($df_ip=array())   //
    {   global $_G; 
		$this->QIM->menu_right_check($this->m_menu_right,array('insert'),array('url'=>base_url($this->m_controller.'/'.$this->m_function.'/project_list_index/list/-1/value/')));
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."project_new_index.php";
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
	
    function mission_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."mission_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }	
	
    function job_list_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."job_list_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }

    function job_detail_index($df_ip=array())   //
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
       // $mm_set='mm_project_set';//
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."job_detail_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
}

?>