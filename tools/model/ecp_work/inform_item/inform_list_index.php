<?php
$final['pg_tag']='w2i_pd'; //work_2_inform@w2i/work_2_reocord@w2r/work_2_recordf@w2rf/
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 	
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'noticetime',
			'pp'=>$this->m_pp,
			's_proj_value'=>'',
			's_proj_name'=>'',
			's_job_name'=>'',
			's_task_name'=>'',
			's_startdate'=>'',
			's_enddate'=>'',
			's_keyword'=>'',
			's_noticetype'=>'',
			's_string'=>''
		);//project_1_project ->default -
	$df_ip['np']=0;
	$df_ip['ot']='DESC';
	//$df_ip['pp']=$this->m_pp;
	$df_ip['ob']='startdate';
	switch($df_ip['chinfo']):
		case 'Unconfirm':
			//$_SESSION[$final['pg_tag']]['s_noticetype']=2;
			$_SESSION[$final['pg_tag']]['s_string']='4,5,6,7,8,9,10,31,32';
			//4,5,6,8,9
			break;
		case 'Alert':
			$_SESSION[$final['pg_tag']]['s_noticetype']=3;
			break;
	endswitch;
	$final['save_session']='Y';
	//$df_ip['chinfo']='N';
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
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'noticetime':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.$_SESSION[$final['pg_tag']]['s_string'];
				if((int)$_SESSION[$final['pg_tag']]['s_noticetype']>0) $_SESSION[$final['pg_tag']]['s_string']='';
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['assign_view']='inform_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				//$pd_pp=10;	
				$pd_pp=$df_ip['pp'];
				$projn_v_set=$this->CM->Init_TB_Set('mm_projnotice_search_set');
				$ip_data=array('pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'con_jec_user_id'=>$this->ad_id,'where'=>"((description <> '批次展期' and description <> '批次刪除') or description is null)",'orwhere'=>array());//
				//OR-group_id
				if($_SESSION[$final['pg_tag']]['s_noticetype']!='') $ip_data['con_noticetype']=$_SESSION[$final['pg_tag']]['s_noticetype'];
				if($_SESSION[$final['pg_tag']]['s_string']!='') $ip_data['wi']=array('noticetype'=>explode(',',$_SESSION[$final['pg_tag']]['s_string']));
				
				
				if($_SESSION[$final['pg_tag']]['s_startdate']!=''):
					if($_SESSION[$final['pg_tag']]['s_enddate']!=''):
						//array_push($ip_data['orwhere'],"enddate <='".$_SESSION[$final['pg_tag']]['s_enddate']."' AND startdate >='".$_SESSION[$final['pg_tag']]['s_startdate']."'");
						//array_push($ip_data['orwhere'],"( (startdate<='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."') OR (startdate>='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."' AND enddate<='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."') OR (startdate<='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."') )");
						array_push($ip_data['orwhere'],"noticetime <='".$_SESSION[$final['pg_tag']]['s_enddate'].' 23:59:59'."' AND noticetime >='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."'");
					else:
						//$ip_data['con_startdate >=']=$_SESSION[$final['pg_tag']]['s_startdate'];
						$ip_data['con_noticetime >=']=$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00';
					endif;//
				else:
					if($_SESSION[$final['pg_tag']]['s_enddate']!=''):
						//$ip_data['con_enddate <=']=$_SESSION[$final['pg_tag']]['s_enddate'];
						$ip_data['con_noticetime <=']=$_SESSION[$final['pg_tag']]['s_enddate'].' 23:59:59';
						
					endif;
				endif;
				//if($_SESSION[$final['pg_tag']]['s_startdate']!='') $ip_data['con_startdate']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				//if($_SESSION[$final['pg_tag']]['s_enddate']!='') $ip_data['con_enddate']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_proj_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_proj_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_task_name']!='') $ip_data['like_task_name']=$_SESSION[$final['pg_tag']]['s_task_name'];
				//加入任務名稱搜尋
				if($_SESSION[$final['pg_tag']]['s_job_name']!='') $ip_data['like_job_name']=$_SESSION[$final['pg_tag']]['s_job_name'];
				//關鍵字亦加入任務名稱搜尋
				if($_SESSION[$final['pg_tag']]['s_keyword']!=''): //
					 array_push($ip_data['orwhere'],"proj_name LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%' OR task_name LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%' OR description LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%' OR job_name LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%'");
				endif;
				
				
				$final['noticetype_pdb']=$this->$projn_v_set['mm_set']->noticetype_pdb;
				
				$this->load->library('form_input');
				$this->load->model('Mm_search_obj','SOBJ',True);
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_inform');

                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
								
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projn_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
				
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','chinfo'=>$df_ip['chinfo'],'mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_proj_name_url'=>'proj_name@@@'.$df_ip['ob'],'ob_job_name_url'=>'job_name@@@'.$df_ip['ob'],'ob_isconfirm_url'=>'isconfirm@@@'.$df_ip['ob'],'ob_task_name_url'=>'task_name@@@'.$df_ip['ob'],'ob_noticetype_url'=>'noticetype@@@'.$df_ip['ob'],'ob_projtask_desc_url'=>'projtask_desc@@@'.$df_ip['ob'],'ob_emailcontent_url'=>'emailcontent@@@'.$df_ip['ob'],'ob_noticetime_url'=>'noticetime@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'].'/Unconfirm/';				
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$final['btn_allow']=$this->$projn_v_set['mm_set']->btn_allow;
				$final['noticetype_img']=$this->$projn_v_set['mm_set']->get_noticetype_img();
				
				$final['tcate_url']=array(
						'project_new_index'=>site_url($final['var_purl'].'project_new_index/edit/')
					);
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