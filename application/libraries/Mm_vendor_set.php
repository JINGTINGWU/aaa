<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_vendor_set
{
    var $mm_tb='jec_vendor';
	var $mm_tablename='JEC_Vendor';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_vendor_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_vendor';
			
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
                        'ld'=>array(),
                        'ld_value'=>'name',
                        'ld_key'=>'jec_company_id',
                        'full_selected'=>'N'
                    ),
                'name'=>array(
                        'call_name'=>'專案名稱',
                        'type'=>'text'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'textarea',
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