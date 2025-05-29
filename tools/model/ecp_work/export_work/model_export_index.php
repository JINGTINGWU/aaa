<?php
$final['pg_tag']='w4e_pd'; //work_4_export@w4e /Don't bother me.
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'ASC',
			'ob'=>'seqno',
			'pp'=>$this->m_pp
		);//project_1_project ->default -
	$df_ip['np']=0;
	$df_ip['ot']='ASC';
	$df_ip['ob']='seqno';
	$df_ip['pp']=$this->m_pp;
}
//$pd_pp=10;	

//無-1預設-Grab//change
        switch($df_ip['ac']):
            case 'list': //choose
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];			
				//$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['prod_list_url']=base_url($final['var_purl'].$df_ip['tag'].'/list_div/0/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/');
				$final['export_url']=base_url($final['var_purl'].$df_ip['tag'].'/export_ac/0/');
				
				
				$final['assign_view']='model_export_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				
				
				$this->load->library('form_input');
				$this->load->model('Mm_search_obj','SOBJ',True);
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_export');
				$final['ip_info']['s_producttemp']['onchange']="PG_BK_Action('search_prod_list',{'producttemp_id':this.value})";
                $final['main_data']=$_SESSION[$final['pg_tag']]; 
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				$final['main_list']=array();	
				$final['tcate_url']=array(

					);
            break;
			case 'list_div'://
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$final['assign_view']='prod_list_div';
				$this->load->library('form_input');
				if(isset($_POST['producttemp_id'])):
					$df_ip['key_id']=(int)$_POST['producttemp_id'];
				endif;
				$prodtl_v_set=$this->CM->Init_TB_Set('mm_producttempline_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodtl_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_producttemp_id'=>$df_ip['key_id'],'ob_seqno'=>'ASC','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //=
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_specification_url'=>'specification@@@'.$df_ip['ob'],'ob_jec_uom_id_url'=>'jec_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_vendor_name_url'=>'vendor_name@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
			break;
			case 'export_ac':
				$df_ip['key_id']=$_POST['s_producttemp'];
				$excel_type=$_POST['excel_type'];
				//@header("Content-type:application/vnd.ms-excel");
				//@header("Content-Disposition:filename=excel.xls");
				$final['assign_view']='export_ac';
				$final['show_tcate']='N';
				$final['show_plate']='N';
				$prodtl_v_set=$this->CM->Init_TB_Set('mm_producttempline_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodtl_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_producttemp_id'=>$df_ip['key_id'],'ob_seqno'=>'ASC')));
				
	
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Product")
							 ->setSubject("Product")
							 ->setDescription("Product")
							 ->setKeywords("Product")
							 ->setCategory("Product");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '編號')
            				->setCellValue('B1', 'ID')
            				->setCellValue('C1', '料品品名/工作明細')
            				->setCellValue('D1', '規格')
							->setCellValue('E1', '預估單價')
							->setCellValue('F1', '數量')
							->setCellValue('G1', '供應廠商')
							->setCellValue('H1', '資料分類')
							;

				// Miscellaneous glyphs, UTF-8
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $no+1)
           				 ->setCellValue('B'.$eno, $value['jec_product_id'])
						 ->setCellValue('C'.$eno, $value['name'])
						 ->setCellValue('D'.$eno, $value['specification'])
						 ->setCellValue('E'.$eno, $value['price'])
						 ->setCellValue('F'.$eno, 0)
						 ->setCellValue('G'.$eno, $value['vendor_name'])
						 ->setCellValue('H'.$eno, $value['prodtype']==9?'工作明細':'料品')
						 ;	
				endforeach;
				/*$objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A4', 'Miscellaneous glyphs')
           				 ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');*/

				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Product');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="product.'.$excel_type.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type):
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				
				$objWriter->save('php://output');
				exit;
			break;
        endswitch;
?>