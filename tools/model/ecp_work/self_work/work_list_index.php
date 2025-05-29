<?php //
$final['pg_tag']='w1w_pd'; //work_1_work@w1w/work_1_reocord@w1r/work_1_recordf@w1rf/work_1_prod@w1p
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	//$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'ASC',
			'ob'=>'enddate',
			'pp'=>$this->m_pp,
			's_proj_value'=>'',
			's_proj_name'=>'',
			's_job_name'=>'',
			's_task_name'=>'',
			's_task_startdate'=>'',
			's_task_enddate'=>'',
			's_task_keyword'=>'',
			's_task_taskprogress'=>'',
			's_task_tasktype'=>'',
			's_task_proj_user_id'=>'',
			's_task_proj_user_id_title'=>''
		);//project_1_project ->default -
	$df_ip['np']=0;
	$df_ip['ot']='ASC';
	$df_ip['ob']='enddate';
	$df_ip['pp']=$this->m_pp;
	
	
	switch($df_ip['chinfo']):
		case 'Delay':
			$_SESSION[$final['pg_tag']]['s_task_taskprogress']='3';	
			$_SESSION[$final['pg_tag']]['s_task_tasktype']='2';		
			break;
		case 'Undone':
			$_SESSION[$final['pg_tag']]['s_task_tasktype']='2';
			break;		
	endswitch;

	$final['save_session']='Y';
	$df_ip['chinfo']='N';
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
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'enddate':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				//$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				
				$final['assign_view']='work_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$pd_pp=$df_ip['pp'];//10;
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';

				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				
				//$group_id=
				$mm_tb=$projt_v_set['mm_tb'].'.';
				$ug_tb='jec_usergroup.';
				$ip_data=array('pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array($mm_tb."jec_user_id='".$this->ad_id."' OR ".$ug_tb."jec_user_id='".$this->ad_id."'"));//     ,'con_'.$mm_tb.'jec_user_id'=>$this->ad_id
				//QQ.真麻煩吶：鳴鳴
				//+where
				//
				
				if($_SESSION[$final['pg_tag']]['s_task_proj_user_id']!=''):
					 $ip_data['con_'.$mm_tb.'proj_jec_user_id']=$_SESSION[$final['pg_tag']]['s_task_proj_user_id'];
					 $_SESSION[$final['pg_tag']]['s_task_proj_user_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_task_proj_user_id']);
				endif;
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
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.$_SESSION[$final['pg_tag']]['s_task_startdate'].'-'.$_SESSION[$final['pg_tag']]['s_task_enddate'];
				//OR= =
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
				endif;
				
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_'.$mm_tb.'proj_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_'.$mm_tb.'proj_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_task_name']!='') $ip_data['like_'.$mm_tb.'name']=$_SESSION[$final['pg_tag']]['s_task_name'];
				//加入任務名稱搜尋
				if($_SESSION[$final['pg_tag']]['s_job_name']!='') $ip_data['like_'.$mm_tb.'job_name']=$_SESSION[$final['pg_tag']]['s_job_name'];
				//關鍵字亦加入任務名稱搜尋
				if($_SESSION[$final['pg_tag']]['s_task_keyword']!=''): //
					 array_push($ip_data['orwhere'],"proj_name LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR taskname LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR super_name LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR job_name LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR description2 LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR value2 LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%' OR customerdoc LIKE '%".$_SESSION[$final['pg_tag']]['s_task_keyword']."%'");
				endif;
				
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_task');

                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				//main_list為第1頁by頁數的資料
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'group','data'=>$ip_data));
				
			    //+group_id......
				$final['btn_allow']=$this->$projt_v_set['mm_set']->btn_allow;
				
				//.'-'.$pd_pp
				//130312-Patrick-加入任務名
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_proj_name_url'=>'proj_name@@@'.$df_ip['ob'],'ob_job_name_url'=>'job_name@@@'.$df_ip['ob'],'ob_isconfirm_url'=>'isconfirm@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_enddate_url'=>'enddate@@@'.$df_ip['ob'],'ob_super_name_url'=>'super_name@@@'.$df_ip['ob'],'ob_delaydate_url'=>'delaydate@@@'.$df_ip['ob'],'ob_replytime_url'=>'replytime@@@'.$df_ip['ob'],'ob_confirmdate_url'=>'confirmdate@@@'.$df_ip['ob'],'ob_isfinish_url'=>'isfinish@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];//
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
								
				$final['tcate_url']=array(
						'project_new_index'=>site_url($final['var_purl'].'project_new_index/edit/')
					);
				//exit();
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
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;
        endswitch;
?>