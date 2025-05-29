<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_product_set
{
    var $mm_tb='jec_product';
	var $mm_tablename='JEC_Product';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_product_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_product';
			
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
                'jec_uom_id'=>array(
                        'call_name'=>'單位',
                        'type'=>'select',
                        'ld'=>'mm_uom_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_uom_id',
                        'full_selected'=>'N'
                    ),
                'jec_vendor_id'=>array(
                        'call_name'=>'供應商',
                        'type'=>'select',
                        'ld'=>'mm_vendor_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_vendor_id',
                        'full_selected'=>'N'
                    ),
                'name'=>array(
                        'call_name'=>'品名',
                        'type'=>'text'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:300px;'
                    ),
                'daywork'=>array(
                        'call_name'=>'作業天數',
                        'type'=>'text',
                        'pii'=>array('no')
                    ),
                'specification'=>array(
                        'call_name'=>'規格',
                        'type'=>'text',
						'style'=>'width:300px;'
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
		// 取得ERP成本 by Johnson 2012/11/06
		$loginparameters = $this->ci->session->userdata(LOGIN_SESSION);
		$row = $this->ci->db->where('jec_user_id', $loginparameters['jec_user_id'])->get('jec_user')->result_array();
		if (count($row)<=0 || empty($row[0]['costtype']))
			$costtype = '4';
		else
			$costtype = $row[0]['costtype'];
		$costfield = '';
		switch ($costtype)
		{
			case '0': $costfield = 'prodprice0'; break;
			case '1': $costfield = 'prodprice1'; break;
			case '2': $costfield = 'prodprice2'; break;
			case '3': $costfield = 'prodprice3'; break;
			case '4': $costfield = 'prodprice4'; break;
			case '5': $costfield = 'prodprice5'; break;
			case '6': $costfield = 'prodprice6'; break;
			case '7': $costfield = 'prodprice7'; break;
			default: $costfield = 'prodprice4';
		}
		$this->ci->db->select('AVG('.$costfield.') AS erpcost', false);
		$this->ci->db->where('jec_product_id', $product_id);
		$this->ci->db->where($costfield.' > 0');
		$this->ci->db->group_by('jec_product_id');
		$row = $this->ci->db->get('jec_producterp')->result_array();
		if (count($row)>0) $result[0]['cost'] = round($row[0]['erpcost']);
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