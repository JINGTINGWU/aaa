<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_setup_set
{
    var $mm_tb='jec_setup';
	var $mm_tablename='JEC_setup';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_setup_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_setup';
			
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
                'value'=>array(
                        'call_name'=>'專案編號',
                        'type'=>'text',
                        'readonly'=>'Y'//系統給定 
                    ),
                'jec_company_id'=>array(
                        'call_name'=>'公司別',
                        'type'=>'select',
                        'ld'=>'mm_company_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_company_id',
                        'full_selected'=>'N'
                    ),
                'projyear'=>array(
                        'call_name'=>'專案年度',
                        'type'=>'select',
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>date('Y'),'en'=>(date('Y')+4)),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
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
	
	function get_setup_row($setup_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$setup_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}