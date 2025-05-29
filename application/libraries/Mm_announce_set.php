<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_announce_set
{
    var $mm_tb='jec_announce';
	var $mm_tablename='JEC_announce';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_announce_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_announce';
			
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'view'=>array(   //noticetype
						'join'=>array('type'=>'left','jtb'=>'jec_user','jkey'=>'jec_user_id','mkey'=>'jec_user_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*','jec_user.name AS issue_name'),
						'glt'=>4				
				    ),																	
				'def'=>array()
		    );
		
	}
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'value'=>array(
                        'call_name'=>'專案編號',
                        'type'=>'text',
                        'readonly'=>'Y'//系統給定 
                    ),
                'description3'=>array(
                        'call_name'=>'備註說明3',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:300px;'            
                    )
            );
        return $final;
    }    
	
	function get_project_series()
	{
		$def_num=(date('Y')-1911).date('md');
		$min=(int)$def_num.'000';
		$max=(int)$def_num.'999';
		$sql="SELECT MAX(value)+1 AS max_value FROM ".$this->mm_tb." WHERE value>'".$min."' AND value<'".$max."' AND isactive='Y'";
		
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:$def_num.'001';
	}
	
	
	function get_announce_row($announce_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$announce_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}