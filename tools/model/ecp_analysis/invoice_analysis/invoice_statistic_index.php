<?php
$final['pg_tag']='i1p_pd';
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'value',
			'pp'=>$this->m_pp,
			's_proj_jec_company_id'=>'',
			's_proj_name'=>'',
			's_year'=>'',
			's_proj_customer_title'=>'',
			's_proj_jec_salesuser_id'=>'',
			's_proj_salesuser_title'=>'',
			's_statistic_type'=>2
		);//project_1_project ->default 
	$df_ip['np']=0;
	$df_ip['ot']='DESC';
	$df_ip['ob']='created';
	$df_ip['pp']=$this->m_pp;
}	
		//
        switch($df_ip['ac']):
            case 'list': 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					//echo '<br><br><br><br><br><br><br><br><br><br><br><br>'.$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
					//echo '<br><br><br><br><br><br><br><br><br><br><br><br>'.$_SESSION[$final['pg_tag']]['ob'];	
				elseif($df_ip['chinfo']=='N'):
					
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'value':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;

				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/0/'.$df_ip['ob'].'/'.$df_ip['ot'].'/');
				//$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				
				$final['assign_view']='invoice_statistic_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				//$pd_pp=10;
				$pd_pp=$df_ip['pp']; 
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_ana_invoice');
	
					$ip_data=array('pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
				
					if($_SESSION[$final['pg_tag']]['s_year']==''):
						$_SESSION[$final['pg_tag']]['s_year']=date('Y');
					endif;
					
					if($_SESSION[$final['pg_tag']]['s_proj_salesuser_title']!=''):
						//$ip_data['like_sales_name']=$_SESSION[$final['pg_tag']]['s_proj_salesuser_title'];
						array_push($ip_data['orwhere'],"jec_project_search_view.sales_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_salesuser_title']."%' OR jec_project_search_view.incharge_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_salesuser_title']."%'");
					endif;
					/*
					if($_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']!=''):
					 	array_push($ip_data['orwhere'],"jec_user_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."' OR jec_usersales_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."'");
						 $_SESSION[$final['pg_tag']]['s_proj_salesuser_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']);
					endif;*/

					if($_SESSION[$final['pg_tag']]['s_proj_jec_company_id']!='') $ip_data['con_jec_project_search_view.jec_company_id']=$_SESSION[$final['pg_tag']]['s_proj_jec_company_id'];
					if($_SESSION[$final['pg_tag']]['s_year']!='') $ip_data['con_jec_projinvoice.invoiceyear']=$_SESSION[$final['pg_tag']]['s_year'];
					if($_SESSION[$final['pg_tag']]['s_proj_customer_title']!=''):
						array_push($ip_data['orwhere'],"jec_project_search_view.customer_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%' OR jec_project_search_view.customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%'");
					endif;
					if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_jec_project_search_view.name']=$_SESSION[$final['pg_tag']]['s_proj_name'];

				
				
               		$final['main_data']=$_SESSION[$final['pg_tag']];
					//$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
					$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				//save session
					if($_SESSION[$final['pg_tag']]['s_statistic_type']==2):
						$ip_data['group_by']=array('jec_projinvoice.jec_project_id','jec_projinvoice.invoiceyear');	
						$ip_data['jsql']=array('jec_project_search_view.*','SUM(invoiceamount) AS invoice_amount','jec_projinvoice.invoiceyear');				
					else:
						$ip_data['jsql']=array('SUM(invoiceamount) AS invoice_amount');
					endif;
					
					$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>'invoice_d','data'=>$ip_data));
					
					if($_SESSION[$final['pg_tag']]['s_statistic_type']==1):
						$final['main_list'][0]['company_name']=$final['main_list'][0]['customername']=$final['main_list'][0]['customer_name']=$final['main_list'][0]['name']=$final['main_list'][0]['startdate']=$final['main_list'][0]['enddate']='-';
						$final['main_list'][0]['invoiceyear']=$_SESSION[$final['pg_tag']]['s_year'];
					endif;
					$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_jec_company_id_url'=>'jec_company_id@@@'.$df_ip['ob'],'ob_jec_usersales_id_url'=>'jec_usersales_id@@@'.$df_ip['ob'],'ob_projstatus_url'=>'projstatus@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_customer_name_url'=>'customer_name@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_projyear_url'=>'projyear@@@'.$df_ip['ob'])));
					$final['pd']['ot']=$df_ip['ot'];
					$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
					
				
				
				
				
				$final['projtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projtype'),'key'=>'id','vf'=>'name'),'page_db',1);
				//$ip_data=array();
				$final['dept_pdb']=$this->CM->FormatData(array('db'=>"mm_dept_set@def",'key'=>'jec_dept_id','vf'=>'name'),'page_db',1);
				
				$final['tcate_url']=array(
						'project_new_index'=>site_url($final['var_purl'].'project_new_index/edit/')
					);//
            break;
            case 'update'://只放此處有編的
				
				$gv=array("value","jec_company_id","projyear","name","description","jec_customer_id","jec_user_id","jec_usersales_id","startdate","enddate","projtype"); $gv=$this->CM->GPV($gv);
				
				$upd=array_merge($gv,array('isactive'=>'Y','projstatus'=>1));
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('insert',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$final['acbk_url']=site_url($final['var_purl'].'project_list_index/');

            break;
			
            case 'delete_proj':
               //->
			   $proj_set=$this->CM->Init_TB_Set('mm_project_set');
			   $this->$proj_set['mm_set']->delete_project($df_ip['key_id']);
			   //refresh.
                $ajo=array(
					'refresh_url'=>site_url($final['var_purl'].'project_list_index/list/0/'.$final['var_surl']),
                    'pass'=>1
                );
				if($_G['err_msg']!=''):
					unset($ajo['refresh_url']);
					$ajo['msg']=$_G['err_msg'];
				endif;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;
			case 'export_excel':
				//
				$excel_type=$_POST['pg_var_1'];
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                //$final['ip_info']=$this->SOBJ->get_search_info();
				//$final['ip_data']=$this->SOBJ->get_search_item('def_ana_invoice');
	
					$ip_data=array('ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
				
					if($_SESSION[$final['pg_tag']]['s_year']==''):
						$_SESSION[$final['pg_tag']]['s_year']=date('Y');
					endif;
					
					if($_SESSION[$final['pg_tag']]['s_proj_salesuser_title']!=''):
						//$ip_data['like_sales_name']=$_SESSION[$final['pg_tag']]['s_proj_salesuser_title'];
						array_push($ip_data['orwhere'],"jec_project_search_view.sales_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_salesuser_title']."%' OR jec_project_search_view.incharge_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_salesuser_title']."%'");
					endif;

					if($_SESSION[$final['pg_tag']]['s_proj_jec_company_id']!='') $ip_data['con_jec_project_search_view.jec_company_id']=$_SESSION[$final['pg_tag']]['s_proj_jec_company_id'];
					if($_SESSION[$final['pg_tag']]['s_year']!='') $ip_data['con_jec_projinvoice.invoiceyear']=$_SESSION[$final['pg_tag']]['s_year'];
					if($_SESSION[$final['pg_tag']]['s_proj_customer_title']!=''):
						array_push($ip_data['orwhere'],"jec_project_search_view.customer_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%' OR jec_project_search_view.customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%'");
					endif;
					if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_jec_project_search_view.name']=$_SESSION[$final['pg_tag']]['s_proj_name'];

				
				
               		$final['main_data']=$_SESSION[$final['pg_tag']];
					//$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
					
				//save session
					if($_SESSION[$final['pg_tag']]['s_statistic_type']==2):
						$ip_data['group_by']=array('jec_projinvoice.jec_project_id','jec_projinvoice.invoiceyear');	
						$ip_data['jsql']=array('jec_project_search_view.*','SUM(invoiceamount) AS invoice_amount','jec_projinvoice.invoiceyear');				
					else:
						$ip_data['jsql']=array('SUM(invoiceamount) AS invoice_amount');
					endif;
					
					$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>'invoice_d','data'=>$ip_data));
					
					if($_SESSION[$final['pg_tag']]['s_statistic_type']==1):
						$final['main_list'][0]['company_name']=$final['main_list'][0]['customername']=$final['main_list'][0]['customer_name']=$final['main_list'][0]['name']=$final['main_list'][0]['startdate']=$final['main_list'][0]['enddate']='-';
						$final['main_list'][0]['invoiceyear']=$_SESSION[$final['pg_tag']]['s_year'];
					endif;
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
            				->setCellValue('A1', '公司')
            				->setCellValue('B1', '年度')
            				->setCellValue('C1', '客戶名稱')
            				->setCellValue('D1', '專案名稱')
							->setCellValue('E1', '專案日期')
							->setCellValue('F1', '發票金額合計');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['company_name'])
           				 ->setCellValue('B'.$eno, $value['invoiceyear'])
						 ->setCellValue('C'.$eno, $value['jec_customer_id']==0?$value['customername']:$value['customer_name'])
						 ->setCellValue('D'.$eno, $value['name'])
						 ->setCellValue('E'.$eno, substr($value['startdate'],0,10).'~'.substr($value['enddate'],0,10))
						 ->setCellValue('F'.$eno, number_format($value['invoice_amount']))
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