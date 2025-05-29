<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_projtask_trans_model extends CI_Model 
{   //工作移 轉
    var $m_base_scate='projtask_trans';//*
    var $m_function='projtask_trans_mng';
	var $m_lib_folder='tools/model/projtask_trans/';
    var $m_index='projtask_trans_index';
	var $m_menu_id=MM_menu_projtask_trans;
	var $m_right_tag=array();
	//var $m_menu_right=array();
    var $m_tcate=array(
			'title'=>'人員未完工作移轉',
            'projtask_trans_index'=>array(
                    'title'=>'人員未完工作移轉',
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
			unset($this->m_tcate['project_new_index']);
		endif;
	}
    
    function projtask_trans_index($df_ip=array())   //
    {   global $_G; 
		//$this->QIM->menu_right_check($this->m_menu_right,array('insert'),array('url'=>base_url($this->m_controller.'/'.$this->m_function.'/project_list_index/list/-1/value/')));
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $up_f=array("");//,
        $search_array_f=array(""); 
        $final=$this->CM->get_df_url($final,$df_ip);
        
        include $this->m_lib_folder."projtask_trans_index.php";
		$final['df_ip']=$df_ip;
        return $final;
    }
}

?>