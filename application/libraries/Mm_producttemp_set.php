<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_producttemp_set
{
    var $mm_tb='jec_producttemp';
	var $mm_tablename='JEC_Producttemp';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_producttemp_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_producttemp';
			
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
                        'call_name'=>'料品編號',
                        'type'=>'text',
                        'readonly'=>'Y'//系統給定 
                    ),
                'prodtype'=>array(
                        'call_name'=>'料品類別',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('prodtype'),
                        'ld_key'=>'id',
                        'ld_value'=>'name',
						'full_selected'=>'N'              
                    )
            );
        return $final;
    }
	
	function get_product_row($product_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$product_id)->get($this->mm_tb)->result_array();
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