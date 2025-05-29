<?php
        switch($df_ip['ac']):
            case 'list': 
				
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['list_url']=base_url($final['var_purl'].'cost_analysis_index/list_div/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/');

				$final['assign_view']='cost_analysis_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				
				

				
				$final['tcate_url']=array( 
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'gantt_view_index'=>base_url($final['var_purl'].'gantt_view_index/list/'.$df_ip['key_id'].'/'),
						'work_overview_index'=>base_url($final['var_purl'].'work_overview_index/list/'.$df_ip['key_id'].'/')
					);
            break;
			case 'list_div':
				$final['assign_view']='cost_analysis_div';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['main_op']=$this->form_input->each_op_trans(array('excel_type'),$final['ip_info'],array());
				
				
				
			break;
			case 'export_excel':
				//
				$excel_type=$_POST['pg_var_1'];

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$proj_data=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				    //
					
				//$this->CM->JS_TMsg($excel_type.'xxxx');
				
				
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Cost Analysis")
							 ->setSubject("Cost Analysis")
							 ->setDescription("Cost Analysis")
							 ->setKeywords("Cost Analysis")
							 ->setCategory("Cost Analysis");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '項次')
            				->setCellValue('B1', '任務名稱')
            				->setCellValue('C1', '工作項目')
            				->setCellValue('D1', '預估成本')
							->setCellValue('E1', '業務成本')
							->setCellValue('F1', '成本差異')
							;

				// Miscellaneous glyphs, UTF-8
				
				$full_assum_cost=0; $full_sale_cost=0; $now_job=0; $now_task=0; $eno=0; $e_task=0;
				foreach($final['main_list'] as $st1=>$sv1): $eno++;
						$xno=$eno+1;
						$now_job=$eno;
						$e_job_assum=0;
						$e_job_cost=0;
						$job_xno=$xno;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, $eno)
           				 ->setCellValue('B'.$xno, $sv1['row']['jobname'])
						 ->setCellValue('C'.$xno, '')
						 ->setCellValue('D'.$xno, '')
						 ->setCellValue('E'.$xno, '')
						 ->setCellValue('F'.$xno, '')
						 ;
						 
					foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; $now_task=$eno;
						$xno=$eno+1;
						$task_xno=$xno;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, $eno)
           				 ->setCellValue('B'.$xno,"")
						 ->setCellValue('C'.$xno, $sv2['row']['taskname'])
						 ->setCellValue('D'.$xno, '')
						 ->setCellValue('E'.$xno, '')
						 ->setCellValue('F'.$xno, '')
						 ;
						 
						 $e_count_prod_assum=0; $e_count_prod_cost=0; foreach($sv2['data'] as $sv3): //$eno++;
						 	//$xno=$eno+2;
				 			$e_count_prod_assum+=round($sv3['estimcostcalc']);//各別四捨五入
							$e_count_prod_cost+=round($sv3['salecostcalc']);//各別四捨五入
				 			if($sv3['isworkflow']=='Y') $e_prod_f++;

						 endforeach;
						 $e_total_prod=count($sv2['data']);
						 if($e_total_prod>0):
				 			$e_task_assum=$e_count_prod_assum;
							$e_task_cost=$e_count_prod_cost;
							$e_job_assum+=$e_task_assum;
							$e_job_cost+=$e_task_cost;
				 	//$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
						 else:
				 			$e_task_assum=$sv2['row']['price'];
							$e_task_cost=$sv2['row']['price'];
							$e_job_assum+=$e_task_assum;
							$e_job_cost+=$e_task_cost;					
				 	//$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0'; 
				 		 endif;
						 
						 
				 		 $e_task_deff=$e_task_assum-$e_task_cost;
						 $objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('D'.$task_xno, number_format($e_task_assum))
						 ->setCellValue('E'.$task_xno, number_format($e_task_cost))
						 ->setCellValue('F'.$task_xno, number_format($e_task_deff))
						 ;
						 
					endforeach;
					 $full_assum_cost+=$e_job_assum;
					 $full_sale_cost+=$e_job_cost;
						 $objPHPExcel->setActiveSheetIndex(0)
						 ->setCellValue('D'.$job_xno, number_format($e_job_assum))
						 ->setCellValue('E'.$job_xno, number_format($e_job_cost))
						 ->setCellValue('F'.$job_xno, number_format($e_job_assum-$e_job_cost))
						 ;					 
				endforeach;
				$xno++;

						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, "合計")
           				 ->setCellValue('B'.$xno,"")
						 ->setCellValue('C'.$xno, "預估成本合計")
						 ->setCellValue('D'.$xno, number_format($full_assum_cost))
						 ->setCellValue('E'.$xno, '')
						 ->setCellValue('F'.$xno, '')
						 ;
						 
				$xno++;

						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, "")
           				 ->setCellValue('B'.$xno,"")
						 ->setCellValue('C'.$xno, "業務成本合計")
						 ->setCellValue('D'.$xno, number_format($full_sale_cost))
						 ->setCellValue('E'.$xno, '')
						 ->setCellValue('F'.$xno, '')
						 ; 
			    $xno++;
				$multi_sale_cost=$full_sale_cost*(float)$proj_data['costrate'];
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, "")
           				 ->setCellValue('B'.$xno,"")
						 ->setCellValue('C'.$xno, "業務成本*系數比率=".(float)$proj_data['costrate'])
						 ->setCellValue('D'.$xno, '')
						 ->setCellValue('E'.$xno, number_format($multi_sale_cost))
						 ->setCellValue('F'.$xno, '')
						 ; 

			    $xno++;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$xno, "")
           				 ->setCellValue('B'.$xno,"")
						 ->setCellValue('C'.$xno, "成本差異合計")
						 ->setCellValue('D'.$xno, '')
						 ->setCellValue('E'.$xno, number_format(($multi_sale_cost-$full_assum_cost)))
						 ->setCellValue('F'.$xno, '')
				     	 ; 

				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Cost Analysis');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="Cost Analysis-'.date('Y-m-d').'.'.$excel_type.'"');
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