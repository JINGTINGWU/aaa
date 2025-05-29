<?php
$final['pg_tag']='i5w_pd'; //work_1_work@w1w/work_1_reocord@w1r/work_1_recordf@w1rf/work_1_prod@w1p
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'startdate',
			'pp'=>$this->m_pp,
			's_proj_name'=>'',
			's_proj_jec_customer_id'=>'',
			's_proj_customer_title'=>'',
			's_task_taskprogress'=>'',
			's_task_name'=>'',
			's_task_tasktype'=>'',
			's_dept_id'=>'',
			's_user_id'=>'',
			's_user_id_title'=>''
		);//project_1_project ->default -
	$df_ip['np']=0;
	$df_ip['ot']='DESC';
	$df_ip['ob']='startdate';
	$df_ip['pp']=$this->m_pp;
}

        switch($df_ip['ac']):
            case 'list': 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];	
				elseif($df_ip['chinfo']=='N'):
					
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'startdate':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/0/');
				//$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				
				$final['assign_view']='work_analysis_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				//$pd_pp=10;
				$pd_pp=$df_ip['pp'];
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';

				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				
				//$group_id=
				$mm_tb=$projt_v_set['mm_tb'].'.';
				$ug_tb='jec_usergroup.';
				$ip_data=array('pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());//     ,'con_'.$mm_tb.'jec_user_id'=>$this->ad_id//$mm_tb."jec_user_id='".$this->ad_id."' OR ".$ug_tb."jec_user_id='".$this->ad_id."'"
				//QQ.真麻煩吶：鳴鳴
				//+where
				//
				/*
				if($_SESSION[$final['pg_tag']]['s_task_proj_user_id']!=''):
					 $ip_data['con_'.$mm_tb.'proj_jec_user_id']=$_SESSION[$final['pg_tag']]['s_task_proj_user_id'];
					 $_SESSION[$final['pg_tag']]['s_task_proj_user_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_task_proj_user_id']);
				endif;*/
				if((int)$_SESSION[$final['pg_tag']]['s_task_tasktype']>0) $ip_data['con_'.$mm_tb.'projtasktype']=$_SESSION[$final['pg_tag']]['s_task_tasktype'];
				if((int)$_SESSION[$final['pg_tag']]['s_task_taskprogress']>0):
					switch((int)$_SESSION[$final['pg_tag']]['s_task_taskprogress']):
						case 1://未完成
								$ip_data['con_'.$mm_tb.'isfinish']='N';
							break;
						case 2://已完成
								$ip_data['con_'.$mm_tb.'isfinish']='Y';
							break;
						case 3://已逾期
								$ip_data['con_'.$mm_tb.'enddate <']=date('Y-m-d 00:00:00');
							break;
					endswitch;
				endif;
				/*
				if($_SESSION[$final['pg_tag']]['s_task_startdate']!=''):
					if($_SESSION[$final['pg_tag']]['s_task_enddate']!=''):
						//array_push($ip_data['orwhere'],$mm_tb."enddate <='".$_SESSION[$final['pg_tag']]['s_task_enddate']."' AND ".$mm_tb."startdate >='".$_SESSION[$final['pg_tag']]['s_task_startdate']."'");
						array_push($ip_data['orwhere'],"( (startdate<='".$_SESSION[$final['pg_tag']]['s_task_startdate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_task_enddate'].' 00:00:00'."') OR (startdate>='".$_SESSION[$final['pg_tag']]['s_task_startdate'].' 00:00:00'."' AND enddate<='".$_SESSION[$final['pg_tag']]['s_task_enddate'].' 00:00:00'."') OR (startdate<='".$_SESSION[$final['pg_tag']]['s_task_enddate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_task_startdate'].' 00:00:00'."') )");
					else:
						//$ip_data['con_'.$mm_tb.'startdate >=']=$_SESSION[$final['pg_tag']]['s_task_startdate'];
						array_push($ip_data['orwhere'],$mm_tb."enddate >='".$_SESSION[$final['pg_tag']]['s_task_startdate'].' 00:00:00'."' OR ".$mm_tb."startdate >='".$_SESSION[$final['pg_tag']]['s_task_startdate'].' 00:00:00'."'");
					endif;//
				else:
					if($_SESSION[$final['pg_tag']]['s_task_enddate']!=''):
						//$ip_data['con_'.$mm_tb.'enddate <=']=$_SESSION[$final['pg_tag']]['s_task_enddate'];
						array_push($ip_data['orwhere'],$mm_tb."enddate <='".$_SESSION[$final['pg_tag']]['s_task_enddate'].' 23:59:59'."' OR ".$mm_tb."startdate <='".$_SESSION[$final['pg_tag']]['s_task_enddate'].' 23:59:59'."'");
					endif;
				endif;*/
				
				//if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_'.$mm_tb.'proj_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_'.$mm_tb.'proj_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_task_name']!='') $ip_data['like_'.$mm_tb.'name']=$_SESSION[$final['pg_tag']]['s_task_name'];
				/*
				if($_SESSION[$final['pg_tag']]['s_task_keyword']!=''): //
					 array_push($ip_data['orwhere'],"proj_name LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR name LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%'");
				endif;*/
				
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_ana_work');

                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
				
			    //+group_id......
				$final['btn_allow']=$this->$projt_v_set['mm_set']->btn_allow;
				
				
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_proj_name_url'=>'proj_name@@@'.$df_ip['ob'],'ob_isconfirm_url'=>'isconfirm@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_super_name_url'=>'super_name@@@'.$df_ip['ob'],'ob_delaydate_url'=>'delaydate@@@'.$df_ip['ob'],'ob_finishdate_url'=>'finishdate@@@'.$df_ip['ob'],'ob_confirmdate_url'=>'confirmdate@@@'.$df_ip['ob'],'ob_isfinish_url'=>'isfinish@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];//
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
								
				$final['tcate_url']=array(
						//'project_new_index'=>site_url($final['var_purl'].'project_new_index/edit/')
					);
            break;
			
			case 'export_excel':
				$excel_type=$_POST['pg_var_1'];//
				//$this->CM->JS_TMsg($excel_type);//
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';

				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				
				//$group_id=
				$mm_tb=$projt_v_set['mm_tb'].'.';
				$ug_tb='jec_usergroup.';
				$ip_data=array('ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
				if((int)$_SESSION[$final['pg_tag']]['s_task_tasktype']>0) $ip_data['con_'.$mm_tb.'projtasktype']=$_SESSION[$final['pg_tag']]['s_task_tasktype'];
				if((int)$_SESSION[$final['pg_tag']]['s_task_taskprogress']>0):
					switch((int)$_SESSION[$final['pg_tag']]['s_task_taskprogress']):
						case 1://未完成
								$ip_data['con_'.$mm_tb.'isfinish']='N';
							break;
						case 2://已完成
								$ip_data['con_'.$mm_tb.'isfinish']='Y';
							break;
						case 3://已逾期
								$ip_data['con_'.$mm_tb.'enddate <']=date('Y-m-d 00:00:00');
							break;
					endswitch;
				endif;
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_'.$mm_tb.'proj_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_task_name']!='') $ip_data['like_'.$mm_tb.'name']=$_SESSION[$final['pg_tag']]['s_task_name'];

				
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_ana_work');

                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
				    //
				
				//$final['main_list']=array();	
					//$this->CM->JS_TMsg($excel_type.count($final['main_list']));
				
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
            				->setCellValue('A1', '逾期')
            				->setCellValue('B1', '完成')
            				->setCellValue('C1', '確認')
            				->setCellValue('D1', '專案名稱')
							->setCellValue('E1', '工作名稱')
							->setCellValue('F1', '負責人')
							->setCellValue('G1', '工作日期')
							->setCellValue('H1', '完成日期')
							->setCellValue('I1', '確認日期')
							->setCellValue('J1', '督導人員');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['delaydate']>0?$value['delaydate'].'天':'-')
           				 ->setCellValue('B'.$eno, $value['isfinish'])
						 ->setCellValue('C'.$eno, $value['isconfirm'])
						 ->setCellValue('D'.$eno, $value['proj_name'])
						 ->setCellValue('E'.$eno, $value['taskname'])
						 ->setCellValue('F'.$eno, $value['sales_name'].$value['group_name'])
						 ->setCellValue('G'.$eno, substr($value['startdate'],0,10).'~'.substr($value['enddate'],0,10))
						 ->setCellValue('H'.$eno, $value['isfinish']=='Y'?substr($value['finishdate'],0,10):'')
						 ->setCellValue('I'.$eno, $value['confirmdate']=='0000-00-00 00:00:00'?'':substr($value['confirmdate'],0,10))
						 ->setCellValue('J'.$eno, $value['super_name'])
						 ;	
				endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Invoice');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="WorkList-'.date('Y-m-d').'.'.$excel_type.'"');
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