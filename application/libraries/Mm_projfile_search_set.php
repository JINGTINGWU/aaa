<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projfile_search_set
{
    var $mm_tb='jec_projfile_search_view';
	var $mm_tablename='JEC_Projfile_search_view';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projfile_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projfile_search_view';
			
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
				'join_task'=>array(
						'join'=>array('type'=>'right','jtb'=>'jec_projtask','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'group_by'=>array($this->mm_tb.'.jec_project_id'),	
						'glt'=>4	
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
                'description'=>array(
                        'call_name'=>'備註',
                        'type'=>'text'
                    )
            );
        return $final;
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