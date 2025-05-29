<?php
$final['pg_tag']='a1p_pd';
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'value',
			'pp'=>$this->m_pp,
			's_proj_value'=>'',
			//'s_proj_jec_customer_id_title'=>'',
			's_proj_jec_company_id'=>'',
			's_proj_name'=>'',
			's_proj_projstatus'=>'',
			's_proj_date'=>'',
			's_proj_keyword'=>'',
			's_proj_value2'=>'',
			's_proj_customer_title'=>'',
			's_proj_jec_salesuser_id'=>'',
			's_proj_salesuser_title'=>''
		);//project_1_project ->default -
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
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/0/'.$df_ip['ob'].'/'.$df_ip['ot'].'/N/');
				//$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				
				$final['assign_view']='project_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				//$pd_pp=10;
				$pd_pp=$df_ip['pp']; 
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$mm_tb=$proj_set['mm_tb'];
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_proj');

				
				$ip_data=array('con_'.$mm_tb.'.isactive'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
				
				if($_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']!=''):
					 array_push($ip_data['orwhere'],"".$mm_tb.".jec_user_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."' OR ".$mm_tb.".jec_usersales_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."'");
					 $_SESSION[$final['pg_tag']]['s_proj_salesuser_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']);
				endif;

				if($_SESSION[$final['pg_tag']]['s_proj_jec_company_id']!='') $ip_data['con_'.$mm_tb.'.jec_company_id']=$_SESSION[$final['pg_tag']]['s_proj_jec_company_id'];
				if($_SESSION[$final['pg_tag']]['s_proj_customer_title']!=''):
					array_push($ip_data['orwhere'],"".$mm_tb.".customer_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%' OR ".$mm_tb.".customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%'");
				endif;
				if($_SESSION[$final['pg_tag']]['s_proj_projstatus']!='') $ip_data['con_projstatus']=$_SESSION[$final['pg_tag']]['s_proj_projstatus'];
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_proj_date']!=''){ $ip_data['con_'.$mm_tb.'.startdate <=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 99:99:99'; $ip_data['con_'.$mm_tb.'.enddate >=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 00:00:00'; }
				if($_SESSION[$final['pg_tag']]['s_proj_value2']!='') $ip_data['like_value2']=$_SESSION[$final['pg_tag']]['s_proj_value2'];

				if($_SESSION[$final['pg_tag']]['s_proj_keyword']!=''): //
					 array_push($ip_data['orwhere'],"".$mm_tb.".value LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR ".$mm_tb.".name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR sales_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR incharge_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR address LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR ".$mm_tb.".description LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR description2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR description3 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR value2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR name2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%'");
				endif;
				
				
                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				//save session
				if($this->isadmin=='Y'):
					$type='def';
				else:
					$type='join_task';
					$user_wi=$this->QIM->get_acc_right_id('user_wi',$this->ad_id);
					$group_wi=$this->QIM->get_acc_right_id('group_wi',$this->ad_id);
					// Update by Johnson 2012/12/11 如果只是督導或專案負責人,沒有工作安排, 則看不到該專案
					//array_push($ip_data['orwhere'],"jec_projtask.jec_user_id IN (".$user_wi.") OR ((".$mm_tb.".jec_user_id IN (".$user_wi.") OR ".$mm_tb.".jec_usersales_id IN (".$user_wi.")) AND jec_projtask.jec_user_id is NULL) OR jec_projtask.jec_group_id IN (".$group_wi.") OR ".$mm_tb.".createdby='".$this->ad_id."'");
					array_push($ip_data['orwhere'],"jec_projtask.jec_user_id IN (".$user_wi.") OR jec_projtask.jec_usersuper_id IN (".$user_wi.") OR ((".$mm_tb.".jec_user_id IN (".$user_wi.") OR ".$mm_tb.".jec_usersales_id IN (".$user_wi.")) AND jec_projtask.jec_user_id is NULL) OR jec_projtask.jec_group_id IN (".$group_wi.") OR ".$mm_tb.".createdby='".$this->ad_id."'");

				endif;
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>$type,'data'=>$ip_data));
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_jec_company_id_url'=>'jec_company_id@@@'.$df_ip['ob'],'ob_jec_usersales_id_url'=>'jec_usersales_id@@@'.$df_ip['ob'],'ob_projstatus_url'=>'projstatus@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_customer_name_url'=>'customer_name@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_jec_dept_id_url'=>'jec_dept_id@@@'.$df_ip['ob'],'ob_percent_url'=>'percent@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['projtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projtype'),'key'=>'id','vf'=>'name'),'page_db',1);
				// Update by Johnson 2012/12/04
				$final['projstatus_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projstatus'),'key'=>'id','vf'=>'name'),'page_db',1);
				// Update by Johnson End
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
               //
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
				
				if($df_ip['chinfo']==''):
				elseif($df_ip['chinfo']=='N'):
					
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'value':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$mm_tb=$proj_set['mm_tb'];


				
				$ip_data=array('con_'.$mm_tb.'.isactive'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());
				
				if($_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']!=''):
					 array_push($ip_data['orwhere'],"".$mm_tb.".jec_user_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."' OR ".$mm_tb.".jec_usersales_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."'");
					 $_SESSION[$final['pg_tag']]['s_proj_salesuser_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']);
				endif;

				if($_SESSION[$final['pg_tag']]['s_proj_jec_company_id']!='') $ip_data['con_'.$mm_tb.'.jec_company_id']=$_SESSION[$final['pg_tag']]['s_proj_jec_company_id'];
				if($_SESSION[$final['pg_tag']]['s_proj_customer_title']!=''):
					array_push($ip_data['orwhere'],"".$mm_tb.".customer_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%' OR ".$mm_tb.".customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%'");
				endif;
				if($_SESSION[$final['pg_tag']]['s_proj_projstatus']!='') $ip_data['con_projstatus']=$_SESSION[$final['pg_tag']]['s_proj_projstatus'];
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_proj_date']!=''){ $ip_data['con_'.$mm_tb.'.startdate <=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 99:99:99'; $ip_data['con_'.$mm_tb.'.enddate >=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 00:00:00'; }
				
				if($_SESSION[$final['pg_tag']]['s_proj_keyword']!=''): //
					 array_push($ip_data['orwhere'],"".$mm_tb.".value LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR ".$mm_tb.".name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR sales_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR incharge_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR address LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR ".$mm_tb.".description LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR description2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR description3 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR value2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR name2 LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%'");
				endif;
				
				
                $final['main_data']=$_SESSION[$final['pg_tag']];
				//save session
				if($this->isadmin=='Y'):
					$type='def';
				else:
					$type='join_task';
					$user_wi=$this->QIM->get_acc_right_id('user_wi',$this->ad_id);
					$group_wi=$this->QIM->get_acc_right_id('group_wi',$this->ad_id);
					array_push($ip_data['orwhere'],"jec_projtask.jec_user_id IN (".$user_wi.") OR ((".$mm_tb.".jec_user_id IN (".$user_wi.") OR ".$mm_tb.".jec_usersales_id IN (".$user_wi.")) AND jec_projtask.jec_user_id is NULL) OR jec_projtask.jec_group_id IN (".$group_wi.")");

				endif;
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>$type,'data'=>$ip_data));
				$projtype_pdb=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projtype'),'key'=>'id','vf'=>'name'),'page_db',1);
				// Update by Johnson 2012/12/04
				$projstatus_pdb=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projstatus'),'key'=>'id','vf'=>'name'),'page_db',1);
				// Update by Johnson End
				$dept_pdb=$this->CM->FormatData(array('db'=>"mm_dept_set@def",'key'=>'jec_dept_id','vf'=>'name'),'page_db',1);
				    //
					
					//$this->CM->JS_TMsg($excel_type.count($final['main_list']));
				
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Project List")
							 ->setSubject("Project List")
							 ->setDescription("Project List")
							 ->setKeywords("Project List")
							 ->setCategory("Project List");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				->setCellValue('A1', '進度')
            				->setCellValue('B1', '專案編號')
            				->setCellValue('C1', '狀態')  // Update by Johnson 2012/12/04
            				->setCellValue('D1', '公司別')
							->setCellValue('E1', '部門')
							->setCellValue('F1', '客戶名稱')
							->setCellValue('G1', '專案名稱')
							->setCellValue('H1', '業務/負責')
							->setCellValue('I1', '專案日期')
							->setCellValue('J1', '任務/工作/明細');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						$e_percent=$this->mm_project_search_set->get_project_percentage($value['jec_project_id']);
						$jtp_data=$this->mm_project_search_set->get_jtp_num($value['jec_project_id']);
						
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, number_format($e_percent,2).'%')
           				 ->setCellValue('B'.$eno, $value['value'])
						 ->setCellValue('C'.$eno, $projstatus_pdb[$value['projstatus']])  // Update by Johnson 2012/12/04
						 ->setCellValue('D'.$eno,$value['company_name'])
						 ->setCellValue('E'.$eno, isset($dept_pdb[$value['jec_dept_id']])?$dept_pdb[$value['jec_dept_id']]:'')
						 ->setCellValue('F'.$eno, $value['jec_customer_id']==0?$value['customername']:$value['customer_name'])
                         ->setCellValue('G'.$eno, $value['name'])
                         ->setCellValue('H'.$eno, $value['sales_name'])
                         ->setCellValue('I'.$eno, date('Y-m-d',strtotime($value['startdate'])).'~'.date('Y-m-d',strtotime($value['enddate'])))
                         ->setCellValue('J'.$eno, $jtp_data['j'].'/'.$jtp_data['t'].'/'.$jtp_data['p'])
						 ;	
				endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Invoice');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="project-list-'.date('Y-m-d').'.'.$excel_type.'"');
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