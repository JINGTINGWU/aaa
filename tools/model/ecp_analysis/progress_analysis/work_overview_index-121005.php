<?php
        switch($df_ip['ac']):
            case 'list': 
				
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['list_url']=base_url($final['var_purl'].'work_overview_index/list_div/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/');

				$final['assign_view']='work_overview_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['tcate_url']=array( 
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'gantt_view_index'=>base_url($final['var_purl'].'gantt_view_index/list/'.$df_ip['key_id'].'/'),
						'cost_analysis_index'=>base_url($final['var_purl'].'cost_analysis_index/list/'.$df_ip['key_id'].'/')
					);
            break;
			case 'list_div':
				$final['assign_view']='work_overview_div';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['main_op']=$this->form_input->each_op_trans(array('excel_type'),$final['ip_info'],array());
				$final['resda020_pdb']=$this->$_G['L_CS']->resda020_info;
				$final['resda021_pdb']=$this->$_G['L_CS']->resda021_info;					
			break;
			case 'export_excel':
				//
				$excel_type=$_POST['pg_var_1'];

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$proj_data=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$main_list=$this->project_init_full_view($df_ip['key_id']);
				    //
					
				//$this->CM->JS_TMsg($excel_type.'xxxx');
				
				
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();
				
				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Work List")
							 ->setSubject("Work List")
							 ->setDescription("Work List")
							 ->setKeywords("Work List")
							 ->setCategory("Work List");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '項次')
            				->setCellValue('B1', '狀態/比率')
            				->setCellValue('C1', '任務名稱')
            				->setCellValue('D1', '工作項目')
							->setCellValue('E1', '負責人員')
							->setCellValue('F1', '工作日期')
							->setCellValue('G1', '完成狀態')
							->setCellValue('H1', '完成日期')
							->setCellValue('I1', '料品與工作明細')
							->setCellValue('J1', '數量*單價=金額')
							->setCellValue('K1', '需求日期')
							->setCellValue('L1', '採購廠商')
							->setCellValue('M1', '匯出表單')
							->setCellValue('N1', '流程完成')
							;
				// Miscellaneous glyphs, UTF-8
				
				
                $eno=0; $e_task=0; foreach($main_list as $st1=>$sv1): $eno++;
					$xno=$eno+1;
			    	$objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A'.$xno, $eno)
            				->setCellValue('B'.$xno, '')
            				->setCellValue('C'.$xno, $sv1['row']['jobname'])
            				->setCellValue('D'.$xno, '')
							->setCellValue('E'.$xno, '')
							->setCellValue('F'.$xno, '')
							->setCellValue('G'.$xno, '')
							->setCellValue('H'.$xno, '')
							->setCellValue('I'.$xno, '')
							->setCellValue('J'.$xno, '')
							->setCellValue('K'.$xno, '')
							->setCellValue('L'.$xno, '')
							->setCellValue('M'.$xno, '')
							->setCellValue('N'.$xno, '')
							;

        	              foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; 
						  		$xno=$eno+1;
								$task_xno=$xno;
								$task_isfinish=$sv2['row']['isfinish'];
								
			    			$objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A'.$xno, $eno)
            				->setCellValue('B'.$xno, $sv2['row']['isfinish'].'/'.$e_task_v.'%')
            				->setCellValue('C'.$xno, '')
            				->setCellValue('D'.$xno, '')
							->setCellValue('E'.$xno, $sv2['row']['taskname'])
							->setCellValue('F'.$xno, $sv2['row']['sales_name'])
							->setCellValue('G'.$xno, substr($sv2['row']['startdate'],0,10).'~'.substr($sv2['row']['enddate'],0,10))
							->setCellValue('H'.$xno, $sv2['row']['isfinish'])
							->setCellValue('I'.$xno, $sv2['row']['isfinish']=='Y'?substr($sv2['row']['finishdate'],0,10):'')
							->setCellValue('J'.$xno, '')
							->setCellValue('K'.$xno, '')
							->setCellValue('L'.$xno, '')
							->setCellValue('M'.$xno, '')
							->setCellValue('N'.$xno, '')
							;

        						 foreach($sv2['data'] as $sv3): $eno++; 
									$xno=$eno+1;
				 					if($sv3['isworkflow']=='Y') $e_prod_f++;
			    						$objPHPExcel->setActiveSheetIndex(0)
            							->setCellValue('A'.$xno, $eno)
            							->setCellValue('B'.$xno,'')
            							->setCellValue('C'.$xno, '')
            							->setCellValue('D'.$xno, '')
										->setCellValue('E'.$xno, '')
										->setCellValue('F'.$xno, '')
										->setCellValue('G'.$xno, '')
										->setCellValue('H'.$xno, '')
										->setCellValue('I'.$xno, $sv3['prodname'])
										->setCellValue('J'.$xno, (float)$sv3['quantity'].'*'.(float)$sv3['price'].'='.(float)$sv3['total'])
										->setCellValue('K'.$xno, substr($sv3['startdate'],0,10))
										->setCellValue('L'.$xno, $sv3['vendor_name'])
										->setCellValue('M'.$xno, $sv3['isexport']=='Y'?substr($sv3['exporttime'],0,10):'-')
										->setCellValue('N'.$xno, $sv3['isworkflow']=='Y'?substr($sv3['workflowtime'],0,10):'-')
										;
									
 
                 				 endforeach;

				 				 $e_total_prod=count($sv2['data']);
								 if($e_total_prod>0):
				 					$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
								 else:
				 					$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0';
								 endif;
			    				$objPHPExcel->setActiveSheetIndex(0)
            						->setCellValue('B'.$task_xno, $task_isfinish.'/'.$e_task_v.'%')
            						;	

             			  endforeach;       
        			 endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Work List');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="Work List-'.date('Y-m-d').'.'.$excel_type.'"');
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
				exit;//
				
				break;
        endswitch;
?>