<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projprod_set
{
    var $mm_tb='jec_projprod';
	var $mm_tablename='JEC_Projprod';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projprod_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projprod';
			
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
						'style'=>'width:40px;'
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
                    ),
					/*
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
						'style'=>"width:60px;"
                    ),
                'jec_vendor_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'hidden'
                    ),
				'import_producttemp'=>array(
						'call_name'=>'producttemp',
						'type'=>'select',
						'ld'=>'mm_producttemp_set@def',
						'ld_value'=>'name',
						'ld_key'=>'jec_producttemp_id',
						'full_selected'=>'N'
					)
            );
        return $final;
    }
	
	function get_projprod_series($jec_projtask_id=0)
	{
		$sql="SELECT MAX(seqno)+1 AS max_value FROM ".$this->mm_tb." WHERE jec_projtask_id='".$jec_projtask_id."' AND isactive='Y'";
		
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:1;
	}
	
	function delete_projprod($projprod=0)
	{
		if(!is_array($projprod)):
			$projprod=$this->get_projprod_row($projprod);
		endif;
		if(is_array($projprod))://	
			$this->ci->db->where($this->mm_kid,$projprod[$this->mm_kid])->update($this->mm_tb,array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	//
			if((int)$projprod['jec_productopen_id']>0):
				$this->ci->db->where('jec_productopen_id',$projprod['jec_productopen_id'])->update('jec_productopen',array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));//
			endif;
			if($projprod['jec_productprep_id']>0):
				$this->ci->db->where('jec_productprep_id',$projprod['jec_productprep_id'])->update('jec_productprep',array('isexport'=>'N','exporttime'=>'0000-00-00 00:00:00'));
			endif;
		endif;
	}
	
	function classify_purchase_check_item_by_db($list=array())
	{	$final=array();
		foreach($list as $value):
			if(isset($final[$value['jec_company_id']])):
				array_push($final[$value['jec_company_id']],$value);
			else:
				
				$final[$value['jec_company_id']]=array($value);
			endif;
		endforeach;
		return $final;
	}
	
	function get_projprod_row($jec_projprod_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$jec_projprod_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function get_erp_cost($prod_id=0,$costtype=0)//若為空時…??
	{	//also_time
		$final=0;
		if((int)$prod_id>0):
			$data=$this->ci->db->query("SELECT AVG(prodprice".(int)$costtype.") AS avg_prodprice FROM jec_producterp WHERE jec_product_id='".$prod_id."' AND isactive='Y'")->result_array();
			$final=$data[0]['avg_prodprice'];
		endif;
		return (float)$final;
	}
	
	
	function seqno_action($type='',$data=array())
	{
		switch($type):
			case 'move_up':
				//find_pre
				$test=$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('isactive','Y')->where('seqno <',$data['seqno'])->order_by('seqno','DESC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'move_down':
				$test=$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('isactive','Y')->where('seqno >',$data['seqno'])->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'reorder':
				$order_list=$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('isactive','Y')->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				foreach($order_list as $no=>$value):
					$this->ci->db->where($this->mm_kid,$value[$this->mm_kid])->update($this->mm_tb,array('seqno'=>($no+1)));
				endforeach;
				break;
		endswitch;
		
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