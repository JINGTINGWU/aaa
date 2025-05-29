<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projaddsub_search_set
{
    var $mm_tb='jec_projaddsub_search_view';
	var $mm_tablename='JEC_projaddsub';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projaddsub_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projaddsub';
			
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
                'addsubdate'=>array(
                        'call_name'=>'追加減日期',
                        'type'=>'text',
						'readonly'=>'Y',
						'style'=>'width:70px;',
						'def_value'=>date('Y-m-d')             
                    ),
					/*
                'jec_product_id'=>array(
                        'call_name'=>'料品id',
                        'type'=>'select',
						'ld'=>'mm_product_set@def',
						'ld_key'=>'jec_product_id',
						'ld_value'=>'name'            
                    ),	*/
                'jec_product_id_title'=>array(
                        'call_name'=>'料品-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('product');",
						'onfocus'=>"PL_ChangePL('product');",
						'style'=>"width:100px;"
                    ),
                'jec_product_id'=>array(
                        'call_name'=>'料品目',
                        'type'=>'hidden'
                    ),
                'quantity'=>array(
                        'call_name'=>'數量',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:50px;'            
                    ),		
                'price'=>array(
                        'call_name'=>'單價',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:50px;'            
                    ),	
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:100px;'         
                    ),
				'oppro_value'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:50px;'
					),
				'oppro_name'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:100px;'
					),
				'oppro_specification'=>array(
						'call_name'=>'spec',
						'type'=>'text',
						'style'=>'width:40px'
					),
				'oppro_uom'=>array(
						'call_name'=>'type',
						'type'=>'select',
						'ld'=>array(),
						'ld_key'=>'jec_uom_id',
						'ld_value'=>'name',
						'full_selected'=>'N',
						'style'=>'width:50px;'
					)
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
		endif;
			$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_actb,array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	
			if((int)$data['jec_productopen_id']>0):
				$this->ci->db->where('jec_productopen_id',$data['jec_productopen_id'])->update('jec_productopen',array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
			endif;
		
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}