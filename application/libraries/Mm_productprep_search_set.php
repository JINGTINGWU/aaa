<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_productprep_search_set
{
    var $mm_tb='jec_productprep_search_view';
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
		        'join_projprod'=>array(   //noticetype
						'join'=>array('type'=>'left','jtb'=>'jec_projprod','jkey'=>'jec_productprep_id','mkey'=>'jec_productprep_id','tb'=>$this->mm_tb,'and'=>" AND jec_projprod.isactive='Y'"),
                        'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*','jec_projprod.totalsubtract AS projprod_totalsubtract','jec_projprod.price AS projprod_price','jec_projprod.quantity AS projprod_quantity','jec_projprod.total AS projprod_total','jec_projprod.cost AS projprod_cost','jec_projprod.extramultiple AS projprod_extramultiple','jec_projprod.extraaddition AS projprod_extraaddition','jec_projprod.jec_projprod_id'),
						//'groupby'=>array('jec_projprod.jec_projprod_id'),
						'glt'=>4		
				    ),																		
				'def'=>array()
		    );
		
	}
    
    function load_mm_field_check()
    {	global $_G;
		//現在是怎樣 
        $final=array(
                'value'=>array(
                        'call_name'=>'料號-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('value');",
						'onfocus'=>"PL_ChangePL('value');",
						'style'=>"width:100px;"
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
                'jec_user_id_title'=>array(
                        'call_name'=>'採購廠商-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('user');",
						'onfocus'=>"PL_ChangePL('user');",
						'style'=>"width:80px;"
                    ),
                'jec_user_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'hidden'
                    ),
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
						'style'=>'width:80px;'
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
						'style'=>'width:250px;'
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
						'style'=>'width:150px;'
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
 		//…
    }   
	//
	function get_projfile_string($proj_data=0)
	{	$final='';
		
		if(!is_array($proj_data)):
			$temp_data=$this->ci->db->where('jec_project_id',$proj_data)->get('jec_project')->result_array();
			if(count($temp_data)>0):
				$proj_data=$temp_data[0];
			endif;
		endif;
		$path=base_url().'uploads/';
		if(is_array($proj_data)):
			
			$final.=$path.'project_file/'.$proj_data['value'].'/履約備品清單-'.$proj_data['value'].'.xls';
			$file_list=$this->ci->db->where('jec_project_id',$proj_data['jec_project_id'])->where('filetype',5)->where('isactive','Y')->get('jec_projfile')->result_array();
			foreach($file_list as $value):
				$final.=';'.base_url().$value['filepath'].$value['filename'];
			endforeach;
		endif;
		return $final;
	}//
	
	function export_excel($ex_type='',$data=array())
	{	//op_type->save/load 
		$excel_type=$data['excel_type'];
		switch($ex_type):
			case 'prepare_item':	//save…………
				//jec_project_id
				if(!isset($data['proj_data'])):
					$proj_data=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->get('jec_project')->result_array();
					$data['proj_data']=$proj_data[0];
				endif;
				//$main_list=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->get('jec_productprep_search_view')->result_array();
				$main_list=array();
				//
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("履約備品清單-".$data['proj_data']['value'])
							 ->setSubject("履約備品清單-".$data['proj_data']['value'])
							 ->setDescription("履約備品清單-".$data['proj_data']['value'].'-'.$data['proj_data']['name'])
							 ->setKeywords("履約備品清單")
							 ->setCategory("履約備品清單");

				
				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '履約備品清單');
							
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A2', '專案名稱：'.$data['proj_data']['name'])
							->setCellValue('B2', '工程編號：'.$data['proj_data']['value2']);							
							
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A3', '料號')
            				->setCellValue('B3', '品名')
            				->setCellValue('C3', '規格')
							->setCellValue('D3', '數量')
							->setCellValue('E3', '預估單價成本')
							->setCellValue('F3', '合計')
							->setCellValue('G3', '採購人員')
							->setCellValue('H3', '採購廠商')
							->setCellValue('I3', '備註說明');

				// Miscellaneous glyphs, UTF-8
				$eno=0;
				foreach($main_list as $no=>$value):
						$eno=$no+4;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 //->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('A'.$eno, $value['value'])
						 ->setCellValue('B'.$eno, $value['prodname'])
						 ->setCellValue('C'.$eno, $value['prodspec'])
						 ->setCellValue('D'.$eno, $value['quantity'])
						 ->setCellValue('E'.$eno, $value['price'])
						 ->setCellValue('F'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('G'.$eno, $value['purchasing_user'])
						 ->setCellValue('H'.$eno, $value['vendor_name'])
						 ->setCellValue('I'.$eno, $value['description'])
						 ;	
				endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('履約備品清單');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				$file_name='履約備品清單-'.$data['proj_data']['name'].'.'.$excel_type;
				//$file_name='pppp-'.$data['proj_data']['name'].'.'.$excel_type;
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$file_name.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type): 
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				
				
				//
				
				
				break;
		endswitch;
		if(isset($data['save_path'])):
			$objWriter->save($data['save_path'].$file_name);
			exit();
		else:
			$objWriter->save('php://output');
		endif;
	}      
}