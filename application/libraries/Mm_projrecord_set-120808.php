<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projrecord_set
{
    var $mm_tb='jec_projrecord';
	var $mm_tablename='JEC_Projrecord';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projrecord_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projrecord';
	var $record_info=array(
				'rp_finish'=>4,
				'rp_adjust'=>5,
				'rp_transfer'=>6,
				'rp_impossible'=>7,
				'rp_pause'=>8,
				'rp_recover'=>9,
				'rp_progress'=>11,
				'cp_adjust'=>15,
				'cp_adjust_N'=>25,
				'cp_impossible_A'=>15,
				'cp_impossible_T'=>16,
				'cp_impossible_C'=>17,
				'cp_pause_Y'=>18,
				'cp_pause_N'=>28,
				'cp_transfer_Y'=>16,
				'cp_transfer_N'=>26,
				'cp_finish_Y'=>14,
				'cp_finish_N'=>24,
				'delay'=>2,
				'1'=>1 /*
				'rp_finish'=>4,
				'rp_adjust'=>5,
				'rp_transfer'=>6,
				'rp_impossible'=>7,
				'rp_pause'=>8,
				'rp_recover'=>9,
				'cp_finish'=>'A',
				'cp_adjust'=>'B',
				'cp_transfer'=>'C',
				'cp_impossible'=>'D',
				'cp_pause'=>'E',
				'cp_recover'=>'F',
				'delay'=>2,
				'1'=>1*/
			);	//@@@ ->QQ--
			/*
				'rp_finish'=>4,
				'rp_adjust'=>5,
				'rp_transfer'=>6,
				'rp_impossible'=>7,
				'rp_pause'=>8,
				'rp_recover'=>9,
				'cp_adjust'=>15,
				'cp_adjust_N'=>25,
				'cp_impossible_A'=>15,
				'cp_impossible_T'=>16,
				'cp_impossible_C'=>17,
				'cp_pause_Y'=>18,
				'cp_pause_N'=>28,
				'cp_recover_Y'=>19,
				'cp_recover_N'=>29,
				'cp_transfer_Y'=>16,
				'cp_transfer_N'=>26,
				'cp_finish_Y'=>14,
				'cp_finish_N'=>24,
				'delay'=>2 	*/			//
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
                'description'=>array(
                        'call_name'=>'備註',
                        'type'=>'text'
                    )
            );
        return $final;
    }
	
	function get_recordstatus($index='')
	{
		return isset($this->record_info[$index])?$this->record_info[$index]:0;
	}
	
	function record_action($data=array())
	{	//ac
		$final=0;
		$upd=array_merge($data,$this->ci->CM->Base_New_UPD());
		$this->ci->db->insert($this->mm_tb,$upd);
		$final=mysql_insert_id();
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