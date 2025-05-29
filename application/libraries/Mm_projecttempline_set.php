<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projecttempline_set
{
    var $mm_tb='jec_projecttempline';
	var $mm_tablename='JEC_Projecttempline';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projecttempline_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projecttempline';	
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'nav'=>array(   //noticetype
						'con'=>array('datatype'=>3)				
				    ),																	
				'def'=>array()
		    );
		
	}
    
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'jec_job_id'=>array(
                        'call_name'=>'任務id',
                        'type'=>'select',
                        'ld'=>'mm_job_set@def',
						'ld_key'=>'jec_job_id',
						'ld_value'=>'name' 
                    ),
                'cp_recover_time'=>array(
                        'call_name'=>'回復時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    )
            );
        return $final;
    }

	function get_projecttempline_row($projecttemplin_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projecttemplin_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function exe_right_check()
	{	//執行的權限設定--不過方向大致已定就是了。= =!ok
		 //model->test-//資料異動權限
		 //->無權限的就銷掉--拉出來，有相關過濾的設在td_checl--
		 switch($type){
		 	case 'save_work':
				//
				break;
			case 'test_work':
				//
				break;
		 }
		 
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}