<?php
$final['pg_tag']='p2j_pd';
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['chinfo']='N'; 
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'ASC',
			'ob'=>'seqno',
			'pp'=>$this->m_pp,
			'fnp'=>0,
			'fot'=>'ASC',
			'fob'=>'filename',
			'fpp'=>$this->m_pp
		);//project_1_project ->default 
		
}

//$pd_pp=10;

        switch($df_ip['ac']):
            case 'list': 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'seqno':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].'job_list_index/add_job/'.$df_ip['key_id'].'/');
				
				$final['add_job_url']=site_url($final['var_purl'].'job_list_index/add_job_div/'.$df_ip['key_id'].'/');
				$final['job_list_url']=site_url($final['var_purl'].'job_list_index/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['file_list_url']=site_url($final['var_purl'].'job_list_index/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'/0/N/');
				//$final['proj_edit_url']=site_url($final['var_purl'].'job_list_index/update_project/'.$df_ip['key_id'].'/');
				$final['update_projjob_url']=site_url($final['var_purl'].'job_list_index/update_projjob/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='job_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$mm_tb=$projj_v_set['mm_tb'];
				$ip_data=array('con_'.$mm_tb.'.jec_project_id'=>$df_ip['key_id'],'con_'.$mm_tb.'.isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$mm_tb.'.'.$df_ip['ob']=>$df_ip['ot']);
				if($this->isadmin=='Y'):
					$type='def';
				else:
					$type='join_task';
					$type='def';
					//$ip_data['con_jec_projtask.jec_user_id']=$this->ad_id;
				endif;
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'type'=>$type,'data'=>$ip_data));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_jobname_url'=>'jobname@@@'.$df_ip['ob'],'ob_jobjobtype_url'=>'jobjobtype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projj_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['description_n']=$final['ip_info']['description'];
				$final['ip_info']['jec_job_id_title']['onchange']="PG_BK_Action('change_jobname',{})";
				$final['ip_info']['jec_job_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_job_id'),'page_db','s_array');
				//
                $final['main_data']=array(); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				

				
				//$final['file_list']=array();//分頁用session
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$_SESSION[$final['pg_tag']]['fpp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_task_name_url'=>'task_name@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_job_name_url'=>'job_name@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_uploader_name_url'=>'uploader_name@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				
            	$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				//proj_edit_op
				
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_data=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				//$proj_data=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				/*
				$proj_ip=$this->$proj_set['mm_set']->load_mm_field_check();
				$fix_w=140;
				$proj_ip['description']['style']='width:'.$fix_w.'px;height:30px;';
				$proj_ip['description']['type']='textarea';
				$proj_ip['jec_company_id']['style']='width:'.$fix_w.'px;';
				$proj_ip['projyear']['style']='width:'.$fix_w.'px;';
				$proj_ip['jec_customer_id']['style']='width:'.$fix_w.'px;';
				$proj_ip['startdate']['style']='width:'.$fix_w.'px;';
				$proj_ip['enddate']['style']='width:'.$fix_w.'px;';
				$proj_ip['jec_user_id']['style']='width:'.$fix_w.'px;';
				$proj_ip['jec_usersales_id']['style']='width:'.$fix_w.'px;';
				$proj_ip['name']['style']='width:'.$fix_w.'px;';
				$proj_ip['projyear']['ld']=$this->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>($proj_data['projyear']-4),'en'=>(date('Y')+4)),"page_db","num");
				
				$proj_data['startdate']=date('Y-m-d',strtotime($proj_data['startdate']));
				$proj_data['enddate']=date('Y-m-d',strtotime($proj_data['enddate']));
				$final['proj_op']=$this->form_input->each_op_trans('full',$proj_ip,$proj_data);*/

				$final['tcate_url']=array(
						'project_init_index'=>base_url($final['var_purl'].'project_init_index/list/'.$df_ip['key_id'].'/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'bk_url'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/')
					);
            break;
			
			case 'add_job':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$gv=array("jec_job_id","description",'jobname'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());//
				
				$jec_usersuper_id=$this->GM->GetSpecData('jec_project','jec_user_id','jec_project_id',$df_ip['key_id']);//
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$upd=array_merge($upd,array('seqno'=>$this->$projj_set['mm_set']->get_projjob_series($df_ip['key_id']),'jec_project_id'=>$df_ip['key_id']));
				if($gv['jec_job_id']>0) $upd['jobjobtype']=$this->GM->GetSpecData('jec_job','jobtype','jec_job_id',$upd['jec_job_id']);
				if((int)$upd['jec_job_id']==0) $upd['jec_job_id']=NULL;
				
				$this->GM->common_ac('insert',array('info'=>$projj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$projjob_id=mysql_insert_id();
				$jobt_set=$this->CM->Init_TB_Set('mm_jobtask_set');
				$append_task=$this->GM->common_ac('list',array('info'=>$jobt_set['mm_set'],'type'=>'def','data'=>array('con_jec_job_id'=>$gv['jec_job_id'])));
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$task_set=$this->CM->Init_TB_Set('mm_task_set');
				foreach($append_task as $value):
					$e_task=$this->$task_set['mm_set']->get_task_row($value['jec_task_id']);
					$upd=array(
							'jec_task_id'=>$value['jec_task_id'],
							'jec_projjob_id'=>$projjob_id,
							'jec_project_id'=>$df_ip['key_id'],
							'jec_user_id'=>(int)$e_task['jec_user_id']==0?NULL:$e_task['jec_user_id'],
							'jec_group_id'=>(int)$e_task['jec_group_id']==0?NULL:$e_task['jec_group_id'],
							'jec_usersuper_id'=>$jec_usersuper_id,
							'seqno'=>$this->$projt_set['mm_set']->get_projtask_series($projjob_id),
							'taskname'=>$e_task['name'],
							'taskdaynotice'=>$e_task['daynotice'],
							'taskdaydelay'=>$e_task['daydelay'],
							'taskworkweight'=>$e_task['workweight'],
							'taskprocesstype'=>$e_task['processtype'],
							'taskconfirmtype'=>$e_task['confirmtype']
						);
					//若有值就帶入
						//'jec_user_id'=>$this->ad_id
					$upd=array_merge($upd,$this->CM->Base_New_UPD());
					//seqno....= =
					$this->GM->common_ac('insert',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$upd));
				endforeach;
			
                $ajo=array(
					'bk_action'=>'after_add_job',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'list_div':
				if($df_ip['chinfo']==''):
					//不影響，只讀原本的
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);//重取
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$final['assign_view']='job_list_div';
				$this->load->library('form_input');
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$mm_tb=$projj_v_set['mm_tb'];
				$ip_data=array('con_'.$mm_tb.'.jec_project_id'=>$df_ip['key_id'],'con_'.$mm_tb.'.isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$mm_tb.'.'.$df_ip['ob']=>$df_ip['ot']);
				if($this->isadmin=='Y'):
					$type='def';
				else:
					$type='join_task';
					$type='def';
					//$ip_data['con_jec_projtask.jec_user_id']=$this->ad_id;
				endif;
				$final['ip_info']=$this->$projj_v_set['mm_set']->load_mm_field_check();
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'type'=>$type,'data'=>$ip_data));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_jobname_url'=>'jobname@@@'.$df_ip['ob'],'ob_jobjobtype_url'=>'jobjobtype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
			break;
			
			case 'file_list_div':
				if($df_ip['chinfo']==''):
					//不影響，只讀原本的
					$_SESSION[$final['pg_tag']]['fnp']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['fot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['fob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['fpp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['chinfo']='';
					$df_ip['np']=$_SESSION[$final['pg_tag']]['fnp'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['fob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['fot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['fpp'];
					$final=$this->CM->get_df_url($final,$df_ip);//重取
				endif; //
				$pd_pp=$df_ip['pp'];
				$final['assign_view']='project_file_list_div';
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='file_area_div'; //
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_task_name_url'=>'task_name@@@'.$df_ip['ob'],'ob_job_name_url'=>'job_name@@@'.$df_ip['ob'],'ob_filename_url'=>'filename@@@'.$df_ip['ob'],'ob_uploader_name_url'=>'uploader_name@@@'.$df_ip['ob'])));
				$final['fpd']['ot']=$df_ip['ot'];
				$final['fpd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['fob']=$df_ip['ob'];
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
			break;
			
			case 'add_job_div':
				$final['form_url']=site_url($final['var_purl'].'job_list_index/add_job/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='add_job_div';
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'con_isactive'=>'Y')));
				
				$this->load->library('form_input');
                $final['ip_info']=$this->$projj_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['description_n']=$final['ip_info']['description'];
				$final['ip_info']['jec_job_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_job_id'),'page_db','s_array');
				$final['ip_info']['jec_job_id_title']['onchange']="PG_BK_Action('change_jobname',{})";
				//
                $final['main_data']=array(); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				
				$final['tcate_url']=array(
						'bk_url'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/')
					);
			break;
			
			case 'delete_job':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('delete'),array('exit'=>'Y'));
			    $projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
			    $final['projj_data']=$this->$projj_set['mm_set']->get_projjob_row($df_ip['key_id']);
			   
			    $del_test=$this->$projj_set['mm_set']->exe_right_check('delete_check',$final['projj_data']);
			    if($del_test==true):
			    //reorder
			   	    $this->$projj_set['mm_set']->delete_projjob($final['projj_data']);//delete_projjob($projjob=0)
			   	    $this->$projj_set['mm_set']->seqno_action('reorder',$final['projj_data']);
			   //refresh.
                    $ajo=array(
						'bk_action'=>'after_del_mission',
                    	'pass'=>1
                   		 );
				 else:
                    $ajo=array(
						'msg'=>$_G['err_msg'],
                    	'pass'=>1
                   		 );				
				 endif;
                 $final['response_type']='ajax';
                 $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'update_projjob':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("projjob_id","description","jobname",'jobjobtype'); $gv=$this->CM->GPV($gv);
				$upd=array(
						'description'=>$gv['description'],
						'jobjobtype'=>$gv['jobjobtype']
					);
				if($gv['jobname']!='') $upd['jobname']=$gv['jobname'];
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$this->GM->common_ac('update',array('info'=>$projj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projjob_id']));
                $ajo=array(
					'msg'=>'已修改',
					//'refresh_url'=>site_url($final['var_purl'].'mission_list_index/list/'.$final['projj_data']['jec_project_id'].'/'.$final['var_surl']),
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			case 'move_up':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$projj_data=$this->$projj_set['mm_set']->get_projjob_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_down';
				$this->$projj_set['mm_set']->seqno_action($type,$projj_data);
				
                $ajo=array(
					'bk_action'=>'reload_job_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'move_down':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$projj_data=$this->$projj_set['mm_set']->get_projjob_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_up';
				$this->$projj_set['mm_set']->seqno_action($type,$projj_data);
				
                $ajo=array(
					'bk_action'=>'reload_job_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;

        endswitch;
?>