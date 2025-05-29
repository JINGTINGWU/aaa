<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_productopen_set
{
    var $mm_tb='jec_productopen';
	var $mm_tablename='JEC_Productopen';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_productopen_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_productopen';//
			
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
                        'call_name'=>'料品編號-',
                        'type'=>'text'
                    ),
                'jec_uom_id'=>array(
                        'call_name'=>'單位',
                        'type'=>'select',
                        'ld'=>'mm_uom_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_uom_id',
                        'full_selected'=>'N',
						'style'=>'width:150px;'
                    ),
                'name'=>array(
                        'call_name'=>'品名',
                        'type'=>'text'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:90%;'
                    ),
                'specification'=>array(
                        'call_name'=>'規格',
                        'type'=>'text',
						'style'=>'width:90%;'
                    ),
                'price'=>array(
                        'call_name'=>'預估單價',
                        'type'=>'text',
						'pii'=>array('nod')
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
	function get_productopen_row($jec_productopen_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$jec_productopen_id)->get($this->mm_tb)->result_array();
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