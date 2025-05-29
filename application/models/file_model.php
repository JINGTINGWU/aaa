<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_model extends CI_Model {

    var $title   = '';
	var $pd=array('pp','np','m');
    var $action_file='';
    var $def_temp_path='';
    var $xm_max_item=0; //??????/0???
    var $xm_cre_type=1; //1-brand_new/2->edit
    
    function __construct()
    {
        parent::__construct();
        $this->def_temp_path="uploads/".MM_Common_Temp;
    }
	 
    function prepare_temp_folder($folder_name='')
	{
		if(!file_exists($this->def_temp_path.$folder_name.'/')):
			mkdir($this->def_temp_path.$folder_name.'/',0777);//Linus-0777
		endif;
	}
	
	function delete_temp_folder($folder_name='')
	{
		$del_folder=$this->def_temp_path.$folder_name.'/';
		if(file_exists($del_folder)):
			$this->load->library('Clean_trash');
			$this->clean_trash->time_period=0;
			$this->clean_trash->dir_root=$del_folder;
			$this->clean_trash->del($del_folder);
		endif;
	}						
}
?>