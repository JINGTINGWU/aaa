<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_productprep_set
{
    var $mm_tb='jec_productprep';
	var $mm_tablename='JEC_Productprep';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_productprep_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_productprep';
			
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'join_prod'=>array(   //noticetype
						'join'=>array('type'=>'left','jtb'=>'jec_product','jkey'=>'jec_product_id','mkey'=>'jec_product_id','tb'=>$this->mm_tb),
                        'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*','jec_product.prodtype'),
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
                        'type'=>'text'
                    ),
                'jec_product_id_title'=>array(
                        'call_name'=>'料品-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('product');",
						'onfocus'=>"PL_ChangePL('product');",
						'style'=>"width:200px;"
                    ),
                'jec_product_id'=>array(
                        'call_name'=>'料品目',
                        'type'=>'hidden'
                    ),
					/*
                'jec_product_id'=>array(
                        'call_name'=>'料品id',
                        'type'=>'select',
                        'ld'=>'mm_product_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_product_id',
						'style'=>'width:180px;'
                    ),*/
                'quantity'=>array(
                        'call_name'=>'數量',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:40px;'
                    ),
                'price'=>array(
                        'call_name'=>'單價',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:70px;'
                    ),
                'total'=>array(
                        'call_name'=>'合計',
                        'type'=>'text',
						'pii'=>array('nod')
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:100px;'
                    ),
                'startdate'=>array(
                        'call_name'=>'需求日期',
                        'type'=>'text',
                        'readonly'=>'Y',//cal
						'style'=>'width:70px;'
                    ),/*
                'jec_vendor_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'select',
                        'ld'=>'mm_vendor_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_vendor_id',
                        'full_selected'=>'N'
                    ),*/
                'jec_vendor_id_title'=>array(
                        'call_name'=>'採購廠商-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('vendor');",
						'onfocus'=>"PL_ChangePL('vendor');",
						'style'=>"width:120px;"
                    ),
                'jec_vendor_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'hidden'
                    ),
				'prodtype'=>array(
						'call_name'=>'type',
						'type'=>'hidden'
					),
				'oppro_value'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:40px;'
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
					),
				'import_producttemp'=>array(
						'call_name'=>'producttemp',
						'type'=>'select',
						'ld'=>'mm_producttemp_set@def',
						'ld_value'=>'name',
						'ld_key'=>'jec_producttemp_id',
						'full_selected'=>'N'
					),
				'import_excel'=>array(
						'call_name'=>'producttemp',
						'type'=>'file',
						'filetype'=>"xls@xlsx",
						'up_type'=>'S',
						'onchange'=>'',
						'style'=>'width:120px;'
					),
				'extramultiple'=>array(//倍數
						'call_name'=>'extramultiple',
						'type'=>'text',
						'style'=>'width:30px;'
					),
				'extraaddition'=>array(//加乘
						'call_name'=>'extraaddition',
						'type'=>'text',
						'style'=>'width:50px;'
					),
				'prodspec'=>array(//加乘
						'call_name'=>'prodspec',
						'type'=>'text',
						'style'=>'width:180px;'
					),
				'prod_uom_id'=>array(//加乘
						'call_name'=>'prod_uom_id',
						'type'=>'select',
						'ld'=>'mm_uom_set@def',
						'ld_key'=>'jec_uom_id',
						'ld_value'=>'name'
					),
				'prodname'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:100px;'
					)
            );
        return $final;
    }
	
	function get_productprep_series($jec_project_id=0)
	{
		$sql="SELECT MAX(seqno)+1 AS max_value FROM ".$this->mm_tb." WHERE jec_project_id='".$jec_project_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:1;
	}
	function delete_productprep($productprep_id=0)
	{
		$this->ci->db->where($this->mm_kid,$productprep_id)->update($this->mm_tb,array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
	}
	
	function get_prep_jec_user_id($name='')
	{	
		$test=$this->ci->db->where('name',$name)->get('jec_user')->result_array();
		if(count($test)==0):
			return NULL;
		else:
			return $test[0]['jec_user_id'];
		endif;
	}
	
	function classify_purchase_check_item_by_db($list=array())
	{	$final=array();
		foreach($list as $value):
			if(isset($final[$value['jec_company_id']])):
				$final[$value['jec_company_id']]=array($value);
			else:
				array_push($final[$value['jec_company_id']],$value);
			endif;
		endforeach;
		return $final;
	}
	
	function get_productprep_row($jec_productprep_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$jec_productprep_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function get_max_seqno($project_id=0)//
	{	//also_time
		$final=0;
		if((int)$prod_id>0):
			$data=$this->ci->db->query("SELECT MAX(seqno) AS max_seqno FROM ".$this->mm_tb." WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
			$final=$data[0]['max_seqno'];
		endif;
		return (float)$final;
	}
	
	
	function seqno_action($type='',$data=array())
	{
		switch($type):
			case 'move_up':
				//find_pre
				$test=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->where('seqno <',$data['seqno'])->order_by('seqno','DESC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'move_down':
				$test=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->where('seqno >',$data['seqno'])->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'reorder':
				$order_list=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				foreach($order_list as $no=>$value):
					$this->ci->db->where($this->mm_kid,$value[$this->mm_kid])->update($this->mm_tb,array('seqno'=>($no+1)));
				endforeach;
				break;
		endswitch;
		
	}
	
	function clean_project_prep($project_id=0)
	{
		$this->ci->db->where('jec_project_id',$project_id)->update($this->mm_tb,array('isactive'=>'N'));
		$this->ci->db->where('jec_project_id',$project_id)->update('jec_project',array('isproductprep'=>'N'));
	}
	//
	function exe_right_check($type='def',$data=array())
	{	 global $_G;
		 switch($type){
		 	case 'delete_check':
				$_G['err_msg']='';
				$final=true;
				if($data['isexport']=='Y')://
					$_G['err_msg']='此明細已匯出報支單，無法刪除。'; 
				    $final=false;
				endif;
				break;
		 }
		 if($final==false&&isset($data['rd_url'])) $this->ci->CM->JS_Link($data['rd_url']);
		 return $final;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}