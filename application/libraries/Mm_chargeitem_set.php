<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_chargeitem_set
{
    var $mm_tb='jec_chargeitem';
	var $mm_tablename='JEC_chargeitem';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_chargeitem_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_chargeitem';
			
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
                'addsubtype'=>array(
                        'call_name'=>'追加減類型 ',
                        'type'=>'select',
                        'ld'=>array(array('id'=>1,'name'=>'業主追加'),array('id'=>2,'name'=>'本案追加'),array('id'=>3,'name'=>'業主追減'),array('id'=>4,'name'=>'本案追減')),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N' 
                    ),
                'chargedate'=>array(
                        'call_name'=>'費用日期',
                        'type'=>'text',
						'readonly'=>'Y',
						'style'=>'width:100px;',
						'def_value'=>date('Y-m-d')              
                    ),
                'jec_chargeitem_id'=>array(
                        'call_name'=>'費用id',
                        'type'=>'select',
						'ld'=>'mm_chargeitem_set@def',
						'ld_key'=>'jec_chargeitem_id',
						'ld_value'=>'name'           
                    ),	
                'chargefee'=>array(
                        'call_name'=>'金額',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:100px;'            
                    ),			
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'maxlength'=>100         
                    ) //
            );
        return $final;
    }
	
	function get_projaddsub_row($projaddsub_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projaddsub_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function delete_projaddsub($data=array())
	{	//del_file
		//
		if(!is_array($data)):
			$data=$this->get_projaddsub_row($data);
		else:
			$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_actb,array('isactive'=>'N'));	
			if((int)$data['jec_productopen_id']>0):
				$this->ci->db->where('jec_productopen_id',$data['jec_productopen_id'])->update('jec_productopen',array('isactive'=>'N'));
			endif;
		endif;
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