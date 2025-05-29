<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projreply_set
{
    var $mm_tb='jec_projreply';
	var $mm_tablename='JEC_Projreply';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projreply_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projreply';
	var $reply_info=array(
				'rp_finish'=>1,
				'rp_adjust'=>2,
				'rp_transfer'=>3,
				'rp_impossible'=>4,
				'rp_pause'=>5,
				'rp_recover'=>6
			);
			
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
	
	function get_replystatus($index='')
	{
		return isset($this->reply_info[$index])?$this->reply_info[$index]:0;
	}
	
	function reply_action($data=array())
	{	//ac
		$final=0;
		$upd=array_merge($data,$this->ci->CM->Base_New_UPD());
		$this->ci->db->insert($this->mm_tb,$upd);
		$final=mysql_insert_id();
		return $final;
	}
	function get_projreply_row($projreply_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projreply_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function exe_right_check($type='def',$data=array())
	{	

	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}