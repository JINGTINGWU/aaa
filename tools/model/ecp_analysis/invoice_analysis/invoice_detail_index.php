<?php
$final['pg_tag']='i2i_pd';//reduce
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'invoicedate',
			'pp'=>$this->m_pp
		);//project_1_project ->default 
}
//$pd_pp=5;
        switch($df_ip['ac']):
            case 'list': 
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
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_invoice/'.$df_ip['key_id'].'/');
				$final['add_invoice_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_invoice_div/'.$df_ip['key_id'].'/');
				$final['invoice_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['update_invoice_url']=site_url($final['var_purl'].$df_ip['tag'].'/update_invoice/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/created/ASC/0/N/');

				
				$final['assign_view']='invoice_detail_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');//34
				$mm_tb=$proji_set['mm_tb'];
					//read_session
					$ip_data=array('gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
					$con_sess=$_SESSION['i1p_pd'];
					
					if($con_sess['s_year']==''):
						$con_sess['s_year']=date('Y');
					endif;
					/*
					if($con_sess['s_proj_jec_salesuser_id']!=''):
					 	array_push($ip_data['orwhere'],"jec_project.jec_user_id='".$con_sess['s_proj_jec_salesuser_id']."' OR jec_project.jec_usersales_id='".$con_sess['s_proj_jec_salesuser_id']."'");
					endif;*/
					if($con_sess['s_proj_salesuser_title']!=''):
						array_push($ip_data['orwhere'],"jec_user.name LIKE '%".$con_sess['s_proj_salesuser_title']."%' OR jec_user2.name LIKE '%".$con_sess['s_proj_salesuser_title']."%'");
					endif;

					if($con_sess['s_proj_jec_company_id']!='') $ip_data['con_jec_project.jec_company_id']=$con_sess['s_proj_jec_company_id'];
					if($con_sess['s_year']!='') $ip_data['con_'.$mm_tb.'.invoiceyear']=$con_sess['s_year'];
					if($con_sess['s_proj_customer_title']!=''):
						array_push($ip_data['orwhere'],"jec_customer.name LIKE '%".$con_sess['s_proj_customer_title']."%' OR jec_project.customername LIKE '%".$con_sess['s_proj_customer_title']."%'");
					endif;
					if($con_sess['s_proj_name']!='') $ip_data['like_jec_project.name']=$con_sess['s_proj_name'];
					if($df_ip['key_id']>0) $ip_data['con_'.$mm_tb.'.jec_project_id']=$df_ip['key_id'];
					$final['main_list']=$this->GM->common_ac('list',array('info'=>$proji_set['mm_set'],'type'=>'cus_proj','data'=>$ip_data));
				
				
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_invoiceyear_url'=>'invoiceyear@@@'.$df_ip['ob'],'ob_invoicedate_url'=>'invoicedate@@@'.$df_ip['ob'],'ob_invoiceamount_url'=>'invoiceamount@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_customername_url'=>'customername@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proji_set['mm_set']->load_mm_field_check();
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				//$final['ip_info']['jec_chargeitem_id']['ld']=$this->db->where('isactive','Y')->get('jec_chargeitem')->result_array();
                $final['main_data']=array('invoicedate'=>date('Y-m-d')); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				
				$final['tcate_url']=array(
						'invoice_statistic_index'=>base_url($final['var_purl'].'invoice_statistic_index/list/0/created/asc/0/N/')
					);
            break;
			case 'list_div':
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
				$final['assign_view']='invoice_list_div';
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
				
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');//34
				$mm_tb=$proji_set['mm_tb'];
				$final['ip_info']=$this->$proji_set['mm_set']->load_mm_field_check();
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['main_op']=$this->form_input->each_op_trans(array('excel_type'),$final['ip_info'],array());
				//$final['ip_info']['jec_chargeitem_id']['ld']=$this->db->where('isactive','Y')->get('jec_chargeitem')->result_array();
				
					$ip_data=array('gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
					$con_sess=$_SESSION['i1p_pd'];
					
					if($con_sess['s_year']==''):
						$con_sess['s_year']=date('Y');
					endif;
					if($con_sess['s_proj_salesuser_title']!=''):
						//$ip_data['like_jec_user.name']=$con_sess['s_proj_salesuser_title'];
						array_push($ip_data['orwhere'],"jec_user.name LIKE '%".$con_sess['s_proj_salesuser_title']."%' OR jec_user2.name LIKE '%".$con_sess['s_proj_salesuser_title']."%'");
					endif;

					if($con_sess['s_proj_jec_company_id']!='') $ip_data['con_jec_project.jec_company_id']=$con_sess['s_proj_jec_company_id'];
					if($con_sess['s_year']!='') $ip_data['con_'.$mm_tb.'.invoiceyear']=$con_sess['s_year'];
					if($con_sess['s_proj_customer_title']!=''):
						array_push($ip_data['orwhere'],"jec_customer.name LIKE '%".$con_sess['s_proj_customer_title']."%' OR jec_project.customername LIKE '%".$con_sess['s_proj_customer_title']."%'");
					endif;
					if($con_sess['s_proj_name']!='') $ip_data['like_jec_project.name']=$con_sess['s_proj_name'];
					if($df_ip['key_id']>0) $ip_data['con_'.$mm_tb.'.jec_project_id']=$df_ip['key_id'];
					$final['main_list']=$this->GM->common_ac('list',array('info'=>$proji_set['mm_set'],'type'=>'cus_proj','data'=>$ip_data));
				
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_invoiceyear_url'=>'invoiceyear@@@'.$df_ip['ob'],'ob_invoicedate_url'=>'invoicedate@@@'.$df_ip['ob'],'ob_invoiceamount_url'=>'invoiceamount@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_customername_url'=>'customername@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';

			break;
			case 'add_invoice_div':
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_invoice/'.$df_ip['key_id'].'/');
				$final['add_invoice_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_invoice_div/'.$df_ip['key_id'].'/');
				$final['invoice_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				
				$final['assign_view']='add_invoice_div';
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proji_set['mm_set']->load_mm_field_check();
                $final['main_data']=array('invoicedate'=>date('Y-m-d')); 
				
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);

				
			break;
			case 'add_invoice'://
			
				$gv=array("invoiceyear","description",'invoicedate','invoiceamount'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());//
				$upd=array_merge($upd,array('jec_project_id'=>$df_ip['key_id']));
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');
				$this->GM->common_ac('insert',array('info'=>$proji_set['mm_set'],'upt'=>'def','upd'=>$upd));
			
                $ajo=array(
					'bk_action'=>'after_add_invoice',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'update_invoice':
				$gv=array("projinvoice_id","description",'invoiceamount','invoiceyear','invoicedate','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');
				//
				$upd=$gv;
				unset($upd['projinvoice_id']);
				unset($upd['no']);
				$this->GM->common_ac('update',array('info'=>$proji_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projinvoice_id']));

                $ajo=array(
					'msg'=>'已修改',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			case 'delete_invoice':
			    $proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');//
			   
			    $this->$proji_set['mm_set']->delete_projinvoice($df_ip['key_id']);//delete_projjob($projjob=0)
                $ajo=array(
					'bk_action'=>'after_add_invoice',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'export_excel':
				//
				$excel_type=$_POST['pg_var_1'];
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				//$final['assign_view']='invoice_list_div';
				//$this->load->model('Mm_search_obj','SOBJ',True);
				//$this->load->library('form_input');
				
				$proji_set=$this->CM->Init_TB_Set('mm_projinvoice_set');//34
				$mm_tb=$proji_set['mm_tb'];
				$final['ip_info']=$this->$proji_set['mm_set']->load_mm_field_check();
				//$final['ip_info']['jec_chargeitem_id']['ld']=$this->db->where('isactive','Y')->get('jec_chargeitem')->result_array();
				
					$ip_data=array('ob_'.$df_ip['ob']=>$df_ip['ot']);
					$con_sess=$_SESSION['i1p_pd'];
					
					if($con_sess['s_year']==''):
						$con_sess['s_year']=date('Y');
					endif;
					if($con_sess['s_proj_salesuser_title']!=''):
						//$ip_data['like_jec_user.name']=$con_sess['s_proj_salesuser_title'];
						array_push($ip_data['orwhere'],"jec_user.name LIKE '%".$con_sess['s_proj_salesuser_title']."%' OR jec_user2.name LIKE '%".$con_sess['s_proj_salesuser_title']."%'");
					endif;

					if($con_sess['s_proj_jec_company_id']!='') $ip_data['con_jec_project.jec_company_id']=$con_sess['s_proj_jec_company_id'];
					if($con_sess['s_year']!='') $ip_data['con_'.$mm_tb.'.invoiceyear']=$con_sess['s_year'];
					if($con_sess['s_proj_customer_title']!=''):
						array_push($ip_data['orwhere'],"jec_customer.name LIKE '%".$con_sess['s_proj_customer_title']."%' OR jec_project.customername LIKE '%".$con_sess['s_proj_customer_title']."%'");
					endif;
					if($con_sess['s_proj_name']!='') $ip_data['like_jec_project.name']=$con_sess['s_proj_name'];
					if($df_ip['key_id']>0) $ip_data['con_'.$mm_tb.'.jec_project_id']=$df_ip['key_id'];
					$final['main_list']=$this->GM->common_ac('list',array('info'=>$proji_set['mm_set'],'type'=>'cus_proj','data'=>$ip_data));

				    //
					
					//$this->CM->JS_TMsg($excel_type.count($final['main_list']));
				
				
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Invoice")
							 ->setSubject("Invoice")
							 ->setDescription("Invoice")
							 ->setKeywords("Invoice")
							 ->setCategory("Invoice");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '發票年度')
            				->setCellValue('B1', '發票日期')
            				->setCellValue('C1', '客戶名稱')
            				->setCellValue('D1', '專案名稱')
							->setCellValue('E1', '發票金額')
							->setCellValue('F1', '備註說明');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['invoiceyear'])
           				 ->setCellValue('B'.$eno, substr($value['invoicedate'],0,10))
						 ->setCellValue('C'.$eno, $value['jec_customer_id']==0?$value['customername']:$value['customer_name'])
						 ->setCellValue('D'.$eno, $value['name'])
						 ->setCellValue('E'.$eno, number_format($value['invoiceamount']))
						 ->setCellValue('F'.$eno, $value['description'])
						 ;	
				endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Invoice');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="invoice-'.date('Y-m-d').'.'.$excel_type.'"');
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