<?php
$final['pg_tag']='a4s_pd';//task
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['chinfo']='N'; 
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'ASC',
			'ob'=>'filename',
			'pp'=>$this->m_pp,
			'fnp'=>0,
			'fot'=>'ASC',
			'fob'=>'filename',
			'fpp'=>$this->m_pp
		);//project_1_project ->default 
}

//$pd_pp=10;	//

        switch($df_ip['ac']):
            case 'list': 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'filename':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].'task_list_index/add_task/'.$df_ip['key_id'].'/');
				$final['add_task_url']=site_url($final['var_purl'].'task_list_index/add_task_div/'.$df_ip['key_id'].'/');
                                $final['get_updatexls_url']=site_url($final['var_purl'].$df_ip['tag'].'/updatexls/'.$df_ip['key_id'].'/');
				$final['file_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['send_prepare_url']=site_url($final['var_purl'].$df_ip['tag'].'/send_prepare_easyflow/'.$df_ip['key_id'].'/');
				$final['refresh_prepare_url']=site_url($final['var_purl'].$df_ip['tag'].'/refresh_prepare_status/'.$df_ip['key_id'].'/');
				$final['refresh_page_url']=site_url($final['var_purl'].$df_ip['tag'].'/list/'.$df_ip['key_id'].'/created/asc/0/N/');			//$final['file_list_url']=site_url($final['var_purl'].'task_list_index/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'/0/N/');
				$final['update_projtask_url']=site_url($final['var_purl'].'task_list_index/update_projtask/'.$df_ip['key_id'].'/');
				$final['after_select_task_url']=site_url($final['var_purl'].$df_ip['tag'].'/after_select_task/'.$df_ip['key_id'].'/');
				$final['check_task_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_task_update/');
				/*
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$final['projj_data']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$ip_data=array('con_jec_project_id'=>$final['projj_data']['jec_project_id'],'con_jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				if($this->isadmin=='N'):
					//$ip_data['con_jec_user_id']=$this->ad_id;
				endif;

				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_sales_name_url'=>'sales_name@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_enddate_url'=>'enddate@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_taskname_url'=>'taskname@@@'.$df_ip['ob'],'ob_isfinish_url'=>'isfinish@@@'.$df_ip['ob'],'ob_jec_usersuper_id_url'=>'jec_usersuper_id@@@'.$df_ip['ob'],'ob_taskdaynotice_url'=>'taskdaynotice@@@'.$df_ip['ob'],'ob_taskdaydelay_url'=>'taskdaydelay@@@'.$df_ip['ob'],'ob_taskworkweight_url'=>'taskworkweight@@@'.$df_ip['ob'],'ob_taskprocesstype_url'=>'taskprocesstype@@@'.$df_ip['ob'],'ob_taskconfirmtype_url'=>'taskconfirmtype@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';*/
				$final['assign_view']='item_submit_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';

				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True); 
				
				$this->load->library('form_input');
				$final['ip_info']['target_db']=array(
                        'call_name'=>'DB',
                        'type'=>'select',
                        'ld'=>$this->CM->db->where('iseasyflow','Y')->where('isactive','Y')->get('jec_company')->result_array(),
						'ld_key'=>'jec_company_id',
						'ld_value'=>'name',
						'full_selected'=>'N',
						'style'=>'display:none;'//Ef.net僅剩弓銓站台
					);
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],array());
                //$final['field_pre']=$this->field_pre;
               // $final['ip_info']=$this->$projt_v_set['mm_set']->load_mm_field_check();
				/*
                $final['main_data']=array('taskdaynotice'=>1,'taskdaydelay'=>0,'taskprocesstype'=>2,'taskconfirmtype'=>2); 
				$final['ip_info']['jec_task_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_task_id'),'page_db','s_array');
				$final['ip_info']['jec_user_id']['ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld();
				$final['ip_info']['jec_user_id']['full_selected']='Y';
				$final['ip_info']['description']['style']='width:70%';
				$final['ip_info']['jec_task_id_title']['onchange']="PG_BK_Action('change_taskname',{})";
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				*/
				//
				//filetype->5 /備品清單 
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'con_filetype'=>5,'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['pp'],'pd_np'=>$_SESSION[$final['pg_tag']]['np'],'ob_'.$_SESSION[$final['pg_tag']]['ob']=>$_SESSION[$final['pg_tag']]['ot'])));//
				//$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projj_data']['jec_project_id'],'con_jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['pd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['ob'].'/'.$_SESSION[$final['pg_tag']]['ot'].'-'.$_SESSION[$final['pg_tag']]['pp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['ot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['ot'],'ob_task_name_url'=>'task_name@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_uploader_name_url'=>'uploader_name@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_seqno_url'=>'seqno@@@'.$_SESSION[$final['pg_tag']]['ob'])));
				$final['pd']['ot']=$_SESSION[$final['pg_tag']]['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['ot']).'ending';
				$final['ob']=$_SESSION[$final['pg_tag']]['ob'];
            	//$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				//proj_edit_op Maybe..

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				//$final['btn_del_rp_allow']=$this->$projt_v_set['mm_set']->btn_del_rp_allow;
				//$final['btn_del_ty_allow']=$this->$projt_v_set['mm_set']->btn_del_ty_allow;
				
				if(isset($_SESSION['w_url'])&&$_SESSION['w_url']!=''):
					$final['w_url']=$_SESSION['w_url'];
					$_SESSION['w_url']='';					
				endif;
				
				$final['tcate_url']=array(
						'create_item_index'=>base_url($final['var_purl'].'create_item_index/list/'.$df_ip['key_id'].'/'),
						'item_list_index'=>base_url($final['var_purl'].'item_list_index/list/0/created/asc/0/N/'),
						'item_detail_index'=>base_url($final['var_purl'].'item_detail_index/list/'.$df_ip['key_id'].'/created/asc/0/N/'),
						'bk_url'=>base_url($final['var_purl'].'item_list_index/list/0/created/asc/0/N/')
					);//
            break;
			
			case 'add_task':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$gv=array("jec_task_id","description",'jec_user_id','startdate','enddate','price','taskname','taskprocesstype','taskdaynotice','taskdaydelay','taskworkweight','taskconfirmtype','jec_user_id_title'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$upd['jec_user_id']=$this->$projt_set['mm_set']->get_user_id_by_title($gv['jec_user_id_title']);
				unset($upd['jec_user_id_title']);
				if(substr($upd['jec_user_id'],0,1)=='U'):
					$upd['jec_user_id']=substr($upd['jec_user_id'],2);
					$upd['jec_group_id']=NULL;
				else:
					if($upd['jec_user_id']==''):
						$upd['jec_group_id']=NULL;
					else:
						$upd['jec_group_id']=substr($upd['jec_user_id'],2);
					endif;
					$upd['jec_user_id']=NULL;
				endif;

				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$final['projj_data']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				//seqno...
				
				$upd=array_merge($upd,array('jec_userold_id'=>$upd['jec_user_id'],'jec_groupold_id'=>$upd['jec_group_id'],'jec_project_id'=>$final['projj_data']['jec_project_id'],'jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'seqno'=>$this->$projt_set['mm_set']->get_projtask_series($final['projj_data']['jec_projjob_id'])));
				$upd['jec_usersuper_id']=$this->GM->GetSpecData('jec_project','jec_user_id','jec_project_id',$final['projj_data']['jec_project_id']);
				if($upd['startdate']!=''&&$upd['enddate']!=''&&$gv['jec_user_id']!='') $upd['projtasktype']=2;
				if((int)$upd['jec_task_id']==0) $upd['jec_task_id']=NULL;
				$this->GM->common_ac('insert',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$upd));
				
			
                $ajo=array(
					'bk_action'=>'after_add_task',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
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
				$final['assign_view']='submit_list_div';
				$this->load->library('form_input');
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'con_filetype'=>5,'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['pp'],'pd_np'=>$_SESSION[$final['pg_tag']]['np'],'ob_'.$_SESSION[$final['pg_tag']]['ob']=>$_SESSION[$final['pg_tag']]['ot'])));//
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['pd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['ob'].'/'.$_SESSION[$final['pg_tag']]['ot'].'-'.$_SESSION[$final['pg_tag']]['pp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['ot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['ot'],'ob_task_name_url'=>'task_name@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_uploader_name_url'=>'uploader_name@@@'.$_SESSION[$final['pg_tag']]['ob'],'ob_seqno_url'=>'seqno@@@'.$_SESSION[$final['pg_tag']]['ob'])));
				$final['pd']['ot']=$_SESSION[$final['pg_tag']]['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['ot']).'ending';
				$final['ob']=$_SESSION[$final['pg_tag']]['ob'];
            	//$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				
				/*
				
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				
				$final['projj_data']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['ip_info']=$this->$projt_v_set['mm_set']->load_mm_field_check();
				$ip_data=array('con_jec_project_id'=>$final['projj_data']['jec_project_id'],'con_jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				if($this->isadmin=='N'):
					//$ip_data['con_jec_user_id']=$this->ad_id;
				endif;
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_sales_name_url'=>'sales_name@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_enddate_url'=>'enddate@@@'.$df_ip['ob'],'ob_taskname_url'=>'taskname@@@'.$df_ip['ob'],'ob_isfinish_url'=>'isfinish@@@'.$df_ip['ob'],'ob_jec_usersuper_id_url'=>'jec_usersuper_id@@@'.$df_ip['ob'],'ob_taskdaynotice_url'=>'taskdaynotice@@@'.$df_ip['ob'],'ob_taskdaydelay_url'=>'taskdaydelay@@@'.$df_ip['ob'],'ob_taskworkweight_url'=>'taskworkweight@@@'.$df_ip['ob'],'ob_taskprocesstype_url'=>'taskprocesstype@@@'.$df_ip['ob'],'ob_taskconfirmtype_url'=>'taskconfirmtype@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['user_ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld();
				$final['btn_del_rp_allow']=$this->$projt_v_set['mm_set']->btn_del_rp_allow;
				$final['btn_del_ty_allow']=$this->$projt_v_set['mm_set']->btn_del_ty_allow;*/
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
			break;
			/*
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
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$final['projj_data']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				$final['assign_view']='job_file_list_div';
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projj_data']['jec_project_id'],'con_jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_task_name_url'=>'task_name@@@'.$df_ip['ob'],'ob_filename_url'=>'filename@@@'.$df_ip['ob'],'ob_uploader_name_url'=>'uploader_name@@@'.$df_ip['ob'])));
				$final['fpd']['ot']=$df_ip['ot'];
				$final['fpd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['fob']=$df_ip['ob'];
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$final['projj_data']['jec_project_id']));
			break;
			*/
			case 'add_task_div':
			
				$final['form_url']=site_url($final['var_purl'].'task_list_index/add_task/'.$df_ip['key_id'].'/');
				$final['add_task_url']=site_url($final['var_purl'].'task_list_index/add_task_div/'.$df_ip['key_id'].'/');
				$final['task_list_url']=site_url($final['var_purl'].'task_list_index/list_div/'.$df_ip['key_id'].'/');
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$final['projj_data']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projj_data']['jec_project_id'],'con_jec_projjob_id'=>$final['projj_data']['jec_projjob_id'],'con_isactive'=>'Y')));
				$final['assign_view']='add_task_div';

				
				$this->load->library('form_input');
                $final['ip_info']=$this->$projt_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_user_id']['full_selected']='Y';
				$final['ip_info']['description']['style']='width:70%';
                $final['main_data']=array('taskdaynotice'=>1,'taskdaydelay'=>0,'taskprocesstype'=>2,'taskconfirmtype'=>1); //修改新增後的預設值為強制
				//$final['ip_info']['jec_task_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_task_id'),'page_db','s_array');
				$final['ip_info']['jec_task_id_title']['onchange']="PG_BK_Action('change_taskname',{})";
				$final['ip_info']['jec_user_id']['ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld();
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$final['projj_data']['jec_project_id']));
				$final['tcate_url']=array(
						'bk_url'=>base_url($final['var_purl'].'job_list_index/list/'.$final['projj_data']['jec_project_id'].'/created/asc/0/N/')
					);
			break;
			
			case 'update_projtask'://
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("projtask_id","description",'startdate','enddate','price','jec_user_id','jec_usersuper_id','taskname','taskprocesstype','taskdaynotice','taskdaydelay','taskworkweight','taskconfirmtype'); $gv=$this->CM->GPV($gv);
				$jec_user_id_title=$_POST['jec_user_id_title']; 
				$jec_usersuper_id_title=$_POST['jec_usersuper_id_title']; 
				$no=$_POST['no'];
				$ad_msg=$bk_action=$bk_userid=$bk_username=$bk_superid=$bk_supername=$is_sales=$is_super='';
				
				
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$gv['jec_user_id']=$this->$projt_set['mm_set']->get_user_id_by_title($jec_user_id_title);
				$upd=$gv;
				if($upd['taskname']=='') unset($upd['taskname']);
				$this->CM->db->query("UPDATE ".$projt_set['mm_tb']." SET jec_userold_id=jec_user_id,jec_groupold_id=jec_group_id WHERE ".$projt_set['mm_kid']."='".$gv['projtask_id']."'");
				unset($upd['projtask_id']);
				if(substr($upd['jec_user_id'],0,1)=='U'):
					$upd['jec_user_id']=substr($upd['jec_user_id'],2);
					$upd['jec_group_id']=NULL;
				else:
					if($upd['jec_user_id']==''):
						$upd['jec_group_id']=NULL;
					else:
						$upd['jec_group_id']=substr($upd['jec_user_id'],2);
					endif;
					$upd['jec_user_id']=NULL;
				endif;
				$upd=array_merge($upd,$this->CM->Base_UP_UPD());
				$ori_data=$this->$projt_set['mm_set']->get_projtask_row($gv['projtask_id']);
				$ori_status=$ori_data['projtasktype'];
				if($ori_status==1&&$upd['startdate']!='0000-00-00'&&$upd['enddate']!='0000-00-00') $upd['projtasktype']=2; //開展
				if($gv['jec_user_id']==''):
					if((int)$ori_data['jec_user_id']>0||(int)$ori_data['jec_group_id']>0||$jec_user_id_title!=''):

						//recover_jec_user_id
						unset($upd['jec_user_id']);
						unset($upd['jec_group_id']);
						$ad_msg=' ,查無此負責人';
						$bk_action="recover_task_user";
						if((int)$ori_data['jec_user_id']>0||(int)$ori_data['jec_group_id']>0):
							$bk_userid=(int)$ori_data['jec_user_id']==0?'G-'.$ori_data['jec_group_id']:'U-'.$ori_data['jec_user_id'];
							$bk_username=(int)$ori_data['jec_user_id']==0?$this->GM->GetSpecData('jec_group','name','jec_group_id',$ori_data['jec_group_id']):$this->GM->GetSpecData('jec_user','name','jec_user_id',$ori_data['jec_user_id']);
						else:
							$bk_userid='';
							$bk_username='';
						endif;
						$is_sales='Y';
					endif;			
				endif;
				if($jec_usersuper_id_title!=''):
					$check=$this->db->where('name',$jec_usersuper_id_title)->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$upd['jec_usersuper_id']=$check[0]['jec_user_id'];
					else:
						unset($upd['jec_usersuper_id']);
						$ad_msg.=" ,查無此督導人員";
						$bk_action="recover_task_user";
						$bk_superid=$ori_data['jec_usersuper_id'];
						$bk_supername=$this->GM->GetSpecData('jec_user','name','jec_user_id',$ori_data['jec_usersuper_id']);
						$is_super='Y';
					endif;
					
				endif;
				
				
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projtask_id']));
                $ajo=array(
					'msg'=>'已修改'.$ad_msg,
					'bk_action'=>$bk_action,
					'bk_userid'=>$bk_userid,
					'bk_username'=>$bk_username,
					'bk_superid'=>$bk_superid,
					'bk_supername'=>$bk_supername,
					'is_sales'=>$is_sales,
					'is_super'=>$is_super,
					'no'=>$no,
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			case 'delete_projtask':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('delete'),array('exit'=>'Y'));
			   $projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
			   $final['projt_data']=$this->$projt_set['mm_set']->get_projtask_row($df_ip['key_id']);
			   
                $ajo=array(
					'bk_action'=>'after_del_task',
                    'pass'=>1
                );
				$btn_del_rp_allow=$this->$projt_set['mm_set']->btn_del_rp_allow;
				$btn_del_ty_allow=$this->$projt_set['mm_set']->btn_del_ty_allow;
				
			   if(in_array($final['projt_data']['projtasktype'],$btn_del_ty_allow)||in_array($final['projt_data']['projtasktype'],$btn_del_rp_allow)):
					$del_test=$this->$projt_set['mm_set']->exe_right_check('check_delete',$final['projt_data']);
					if($del_test==true):
			  	   	    $this->$projt_set['mm_set']->delete_projtask($final['projt_data']);//delete_projjob($projjob=0)
			   	        $this->$projt_set['mm_set']->seqno_action('reorder',$final['projt_data']);
					else:
						$ajo['msg']=$_G['err_msg'];
						unset($ajo['bk_action']);
					endif;
			   else:
					$ajo['msg']='工作狀態無法刪除';
					unset($ajo['bk_action']);
			   endif;
			   
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'move_up':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_data=$this->$projt_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_down';
				$this->$projt_set['mm_set']->seqno_action($type,$projt_data);
				
                $ajo=array(
					'bk_action'=>'reload_task_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'move_down':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_data=$this->$projt_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_up';
				$this->$projt_set['mm_set']->seqno_action($type,$projt_data);
				
                $ajo=array(
					'bk_action'=>'reload_task_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;//
			case 'after_select_task':
				$jec_task_id=(int)$_POST['jec_task_id'];
				$task_set=$this->CM->Init_TB_Set('mm_task_set');
				$task_data=$this->$task_set['mm_set']->get_task_row($jec_task_id);
				$jec_user_id=$jec_user_name='';
				if($task_data['jec_user_id']>0):
					$jec_user_id=$task_data['jec_user_id'];
					$jec_user_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$jec_user_id);
					$jec_user_id='U-'.$jec_user_id;
				endif;
				if($task_data['jec_group_id']>0):
					$jec_user_id=$task_data['jec_group_id'];
					$jec_user_name=$this->GM->GetSpecData('jec_group','name','jec_group_id',$jec_user_id);
					$jec_user_id='G-'.$jec_user_id;
				endif;
                $ajo=array(
					'bk_action'=>'load_task_data',
					'jec_user_id'=>$jec_user_id,
					'jec_user_id_title'=>$jec_user_name,
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
			case 'check_task_update':
				//cus_name
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					case 'add_task_go':
						$gv=array('sales_name');
						break;
					case 'update_task_go':
						$gv=array('sales_name','super_name','no');
						break;
				endswitch;
				$gv=$this->CM->GPV($gv);
				$supername=$superid=$salesname=$salesid=$salesdept=$msg='';
				$pass='Y';
				if($pass=='Y'&&isset($gv['sales_name']))://user_sales
					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$salesname=$check[0]['name'];
						$salesid='U-'.$check[0]['jec_user_id'];
					else:
						//check_GROUP
						$check2=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_group')->result_array();
						if(count($check2)>0):
							$pass='Y';
							$salesname=$check2[0]['name'];
							$salesid='G-'.$check2[0]['jec_group_id'];
						else:
							$pass='N';
							$msg='查無此業務';
						endif;

					endif;
				endif;
				if($pass=='Y'&&isset($gv['super_name']))://user_sales
					$check=$this->db->where('name',$gv['super_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$supername=$check[0]['name'];
						$superid=$check[0]['jec_user_id'];
					else:
						$pass='N';
						$msg='查無此督導';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>$bk_action,
					'isexist'=>$pass,
                    'pass'=>1
                );
				
				if(isset($gv['sales_name'])): 
					$ajo['sales_name']=$salesname;
					$ajo['sales_id']=$salesid;
				endif;
				if(isset($gv['super_name'])): 
					$ajo['super_name']=$supername;
					$ajo['super_id']=$superid;
				endif;
				if($msg!='') $ajo['msg']=$msg;
				if(isset($gv['no'])) $ajo['no']=$gv['no'];
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break; 
			case 'refresh_prepare_status':
				$gv=array('jec_project_id'); $gv=$this->CM->GPV($gv);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($gv['jec_project_id']);
				$e_db=$this->load->database("mssqlefnet",TRUE);
				//$e_db=$this->load->database($this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$proj_data['ef_company_id']),TRUE);
				$e_value=$proj_data;
				include('tools/common/prepare_item_check.php');
				
                $ajo=array(
					'bk_action'=>'after_refresh_prepare',
					'msg'=>'更新完畢',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
                        case 'updatexls':
				$gv=array('jec_project_id'); $gv=$this->CM->GPV($gv);
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				
				
				$data=array('jec_project_id'=>$gv['jec_project_id'],'save_path'=>'uploads/','excel_type'=>'xls');
				//$this->CM->JS_TMsg($data['save_path']);
				
				if(!isset($data['proj_data'])):
					$proj_data=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->get('jec_project')->result_array();
					$data['proj_data']=$proj_data[0];
				endif;
				$data['save_path']='uploads/project_file/'.$data['proj_data']['value'].'/';
				$main_list=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->order_by("seqno","asc")->get('jec_productprep_search_view')->result_array();
				//$main_list=array();
				//
				$excel_type=$data['excel_type'];
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel.php"); 
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel/IOFactory.php");
				//$objPHPExcel = new PHPExcel();
				$inputFileName = 'uploads/template/temp.xls';

				/** Load $inputFileName to a PHPExcel Object  **/
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

				/** Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("履約備品清單-".$data['proj_data']['value'])
							 ->setSubject("履約備品清單-".$data['proj_data']['value'])
							 ->setDescription("履約備品清單-".$data['proj_data']['value'].'-'.$data['proj_data']['name'])
							 ->setKeywords("履約備品清單")
							 ->setCategory("履約備品清單");**/


				// Add some data			    
			    $objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B1', $data['proj_data']['name'])							
							->setCellValue('B2', $data['proj_data']['value2'])
							->setCellValue('B3', str_replace('-','/',substr($data['proj_data']['showdate'],0,10)))
							->setCellValue('B4', $data['proj_data']['description3'])
							->setCellValue('B6', $data['proj_data']['total']);														
				
				// Miscellaneous glyphs, UTF-8
				$eno=0;
				$final_total=0;
				foreach($main_list as $no=>$value):
						$eno=$no+5;
						$final_total+=$value['total'];
						 $objPHPExcel->setActiveSheetIndex(1)
            			 //->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('A'.$eno, str_replace('-','/',substr($value['created'],6,5)))
						 ->setCellValue('B'.$eno, $value['value'])
						 ->setCellValue('C'.$eno, $value['prodname'])
						 ->setCellValue('D'.$eno, $value['prodspec'])
						 ->setCellValue('E'.$eno, $value['quantity'])
						 ->setCellValue('F'.$eno, $value['price'])
						 ->setCellValue('G'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('J'.$eno, $value['purchasing_user'])						 
						 ->setCellValue('L'.$eno, $value['description'])
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				endforeach;
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "小計")						 
						 ->setCellValue('G'.$eno, "=sum(G5:G".$tmpeno.")")
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "稅額(5%)")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno."*0.05")		 
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $tmpeno2=$eno-2;
						 $objPHPExcel->setActiveSheetIndex(1)
            			 ->setCellValue('F'.$eno, "總合計")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno2."+G".$tmpeno)	 		
						 ;						 
						
				$objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B5', "=履約購案零配件清單!G".$eno);
				// Rename sheet
				//$objPHPExcel->getActiveSheet()->setTitle('履約備品清單');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(1);


// Redirect output to a client’s web browser (Excel5)
				//$file_name='履約備品清單-'.$data['proj_data']['name'].'.'.$excel_type;
				$file_name='履約備品清單-'.$data['proj_data']['value'].'.'.$excel_type;
				$file_name=$this->CM->ReadFileName('download',$file_name);
				//$file_name='pppp-gggggg.'.$excel_type;
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$file_name.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type)://
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				//exit();
				//$objWriter->save($data['save_path'].str_replace(array('\\','/',':','"','?','*','<','>','|'),'',$file_name));
				$objWriter->save($data['save_path'].$file_name);

			break;
			case 'send_prepare_easyflow'://
				//
				//產生表
				$gv=array('jec_project_id','target_db'); $gv=$this->CM->GPV($gv);
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				
				
				$data=array('jec_project_id'=>$gv['jec_project_id'],'save_path'=>'uploads/','excel_type'=>'xls');
				//$this->CM->JS_TMsg($data['save_path']);
				
				if(!isset($data['proj_data'])):
					$proj_data=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->get('jec_project')->result_array();
					$data['proj_data']=$proj_data[0];
				endif;
				$data['save_path']='uploads/project_file/'.$data['proj_data']['value'].'/';
				$main_list=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->order_by("seqno","asc")->get('jec_productprep_search_view')->result_array();
				//$main_list=array();
				//
				$excel_type=$data['excel_type'];
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel.php"); 
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel/IOFactory.php");
				//$objPHPExcel = new PHPExcel();
				$inputFileName = 'uploads/template/temp.xls';

				/** Load $inputFileName to a PHPExcel Object  **/
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

				/** Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("履約備品清單-".$data['proj_data']['value'])
							 ->setSubject("履約備品清單-".$data['proj_data']['value'])
							 ->setDescription("履約備品清單-".$data['proj_data']['value'].'-'.$data['proj_data']['name'])
							 ->setKeywords("履約備品清單")
							 ->setCategory("履約備品清單");**/


				// Add some data			    
			    $objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B1', $data['proj_data']['name'])							
							->setCellValue('B2', $data['proj_data']['value2'])
							->setCellValue('B3', str_replace('-','/',substr($data['proj_data']['showdate'],0,10)))
							->setCellValue('B4', $data['proj_data']['description3'])
							->setCellValue('B6', $data['proj_data']['total']);														
				
				// Miscellaneous glyphs, UTF-8
				$eno=0;
				$final_total=0;
				foreach($main_list as $no=>$value):
						$eno=$no+5;
						$final_total+=$value['total'];
						 $objPHPExcel->setActiveSheetIndex(1)
            			 //->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('A'.$eno, str_replace('-','/',substr($value['created'],6,5)))
						 ->setCellValue('B'.$eno, $value['value'])
						 ->setCellValue('C'.$eno, $value['prodname'])
						 ->setCellValue('D'.$eno, $value['prodspec'])
						 ->setCellValue('E'.$eno, $value['quantity'])
						 ->setCellValue('F'.$eno, $value['price'])
						 ->setCellValue('G'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('J'.$eno, $value['purchasing_user'])						 
						 ->setCellValue('L'.$eno, $value['description'])
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				endforeach;
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "小計")						 
						 ->setCellValue('G'.$eno, "=sum(G5:G".$tmpeno.")")
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "稅額(5%)")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno."*0.05")		 
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $tmpeno2=$eno-2;
						 $objPHPExcel->setActiveSheetIndex(1)
            			 ->setCellValue('F'.$eno, "總合計")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno2."+G".$tmpeno)	 		
						 ;						 
						
				$objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B5', "=履約購案零配件清單!G".$eno);
				// Rename sheet
				//$objPHPExcel->getActiveSheet()->setTitle('履約備品清單');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(1);


// Redirect output to a client’s web browser (Excel5)
				//$file_name='履約備品清單-'.$data['proj_data']['name'].'.'.$excel_type;
				$file_name='履約備品清單-'.$data['proj_data']['value'].'.'.$excel_type;
				$file_name=$this->CM->ReadFileName('download',$file_name);
				//$file_name='pppp-gggggg.'.$excel_type;
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$file_name.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type)://
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				//exit();
				//$objWriter->save($data['save_path'].str_replace(array('\\','/',':','"','?','*','<','>','|'),'',$file_name));
				$objWriter->save($data['save_path'].$file_name);
				//require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				//$this->$prodprep_v_set['mm_set']->export_excel('prepare_item',array('jec_project_id'=>$gv['jec_project_id'],'save_path'=>'uploads/','excel_type'=>'xls'));
				
				
				//送籢呈....... 
				$target_db=$this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$gv['target_db']);
				$p_user=$this->QIM->get_user_row($this->ad_id);
				$target_db='mssqlefnet';
				
				$mssqlef=$this->load->database($target_db,TRUE);//mssqlef
				
				
				$ms_p_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$this->CM->db_trans($p_user['value'],'input')."'")->result_array();
				if(count($ms_p_user)>0):
					$ms_p_user=$ms_p_user[0];
				else:
					$ms_p_user=array('deptno'=>'','deptname'=>'');
				endif;
				$serial=date('Y-m-d-H-i-s-').rand(100,999);
				$time=date('Y/m/d H:i:s');
				$ODMEMS001_upd=array(
						'odmems001001'=>'',
						'odmems001002'=>'',
						'odmems001003'=>$this->CM->pdb_trans('履約管制系統'),
						'odmems001004'=>$this->CM->pdb_trans($p_user['value']),//p_acc 承辦人->登入者,//...
						'odmems001004c'=>$this->CM->pdb_trans($p_user['name']),//p_name
						'odmems001005'=>$ms_p_user['deptname'],//p_dept 
						'odmems001006'=>date("Ymd"),//申請日期						
						'odmems001024'=>$target_db=$this->GM->GetSpecData('jec_company','name','jec_company_id',$gv['target_db']),
						'odmems001025'=>$this->CM->pdb_trans('無'),
						'odmems001026'=>$this->$prodprep_v_set['mm_set']->get_projfile_string($data['proj_data']),//附件字串,
						'odmems001027'=>$serial,//export-code,																					
					);
					$proj_company=$this->GM->GetSpecData('jec_company','name','jec_company_id',$data['proj_data']['jec_company_id']);
					$e_upd=array(
							'strFormID'=>$this->CM->pdb_trans('ODMEMS001'),
							'ScriptSheetNo'=>$this->CM->pdb_trans($time),
							'Owner'=>$this->CM->pdb_trans($p_user['value']),//acc
							'RecordsetName'=>$this->CM->pdb_trans('resda'),
							'FieldName'=>$this->CM->pdb_trans('ScriptSubj'),
							'RecordIndex'=>$this->CM->pdb_trans(1),
							'FieldValue'=>$this->CM->pdb_trans('1§PMS-'.$proj_company.'-'.$data['proj_data']['value'].$data['proj_data']['name'].'-履約備品清單') //$現在日期$-$專案名稱$-$任務名稱$-$工作明稱$//主旨
						);
						
					$mssqlef->insert('ressa',$e_upd);//
								
				$xmlstr=
				"<diffgr:diffgram xmlns:msdata=\"urn:schemas-microsoft-com:xml-msdata\" xmlns:diffgr=\"urn:schemas-microsoft-com:xml-diffgram-v1\">
  <NewDataSet>
    <RESULT diffgr:id=\"RESULT2\" msdata:rowOrder=\"0\" diffgr:hasChanges=\"inserted\">
      <COMPANY>EFNETDB</COMPANY>
      <CREATE_DATE>".date("Ymd")."</CREATE_DATE>
      <CREATOR>".$this->CM->pdb_trans($p_user['value'])."</CREATOR>
      <FLAG>1</FLAG>
      <USR_GROUP>0000</USR_GROUP>
      <odmems001001>ODMEMS001</odmems001001>
      <odmems001002>AutoNumber</odmems001002>
      <odmems001003>".$ODMEMS001_upd['odmems001003']."</odmems001003>
      <odmems001004>".$ODMEMS001_upd['odmems001004']."</odmems001004>
      <odmems001004C>".$ODMEMS001_upd['odmems001004c']."</odmems001004C>
      <odmems001005>".$ODMEMS001_upd['odmems001005']."</odmems001005>
      <odmems001006>".$ODMEMS001_upd['odmems001006']."</odmems001006>
      <odmems001024>".$ODMEMS001_upd['odmems001024']."</odmems001024>
      <odmems001025>無</odmems001025>
	  <odmems001026>".$ODMEMS001_upd['odmems001026']."</odmems001026>
	  <odmems001027>".$ODMEMS001_upd['odmems001027']."</odmems001027>
    </RESULT>
  </NewDataSet>
</diffgr:diffgram>
				";
				//log_message('info','xml:'.$xmlstr);				
					$e_upd=array(
							'strFormID'=>$this->CM->pdb_trans('ODMEMS001'),
							'ScriptSheetNo'=>$this->CM->pdb_trans($time),
							'Owner'=>$this->CM->pdb_trans($p_user['value']),//acc
							'RecordsetName'=>$this->CM->pdb_trans('rstODMEMS001'),
							'FieldName'=>'',
							'RecordIndex'=>$this->CM->pdb_trans(0),
							'FieldValue'=>$xmlstr,
						);
					//insert 
					
					$mssqlef->insert('ressa',$e_upd);					
				
				//UP為已送出
				$this->db->where('jec_project_id',$gv['jec_project_id'])->update('jec_project',array('exportcode'=>$serial,'ef_company_id'=>$gv['target_db']));
				//exit();... 
				
				$_SESSION['w_url']=$this->GM->GetSpecData('jec_company','description','jec_company_id',$gv['target_db']);
                $ajo=array(
					'bk_action'=>'after_send_easyflow',
					'msg'=>'已送出',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);			
				//FinalWord
				break;
        endswitch;
?>