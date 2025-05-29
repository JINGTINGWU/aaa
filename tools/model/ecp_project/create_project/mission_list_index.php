<?php
$final['pg_tag']='p1j_pd';
if($df_ip['chinfo']==-1||!isset($_SESSION['p1j_pd'])){
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
			/*
				$df_ip['fnp']=$df_ip['np'];
				$df_ip['fob']=$df_ip['np'];
				$df_ip['fot']=$df_ip['ob'];*/
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];	
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'created':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					/*
					$df_ip['fnp']=$_SESSION[$final['pg_tag']]['fnp'];
					$df_ip['fob']=$_SESSION[$final['pg_tag']]['fob'];
					$df_ip['fot']=$_SESSION[$final['pg_tag']]['fot'];	*/			
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$mssqlef = $this->load->database('mssqlef', true);
				//$dept_list=$mssqlef->query("SELECT DISTINCT ad019005 FROM ad019 ORDER By CONVERT( ad019005 using big5 ) ASC ")->result_array();
				$dept_list = $mssqlef->distinct('ad019005')->select('ad019005')->order_by('ad019005','ASC')->get('ad019')->result_array();
				
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['get_purchase_url']=$this->$_G['L_CS']->common_url_ld('get_purchase_list_by_dept');
				$final['form_url']=site_url($final['var_purl'].'mission_list_index/add_mission/'.$df_ip['key_id'].'/');
				$final['add_mission_url']=site_url($final['var_purl'].'mission_list_index/add_mission_div/'.$df_ip['key_id'].'/');
				$final['mission_list_url']=site_url($final['var_purl'].'mission_list_index/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['file_list_url']=site_url($final['var_purl'].'mission_list_index/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'/0/N/');
				$final['proj_edit_url']=site_url($final['var_purl'].'mission_list_index/update_project/'.$df_ip['key_id'].'/');
				$final['update_projjob_url']=site_url($final['var_purl'].'mission_list_index/update_projjob/'.$df_ip['key_id'].'/');
				$final['search_ef_proj_url']=base_url('ecp_common/search_ef_proj/1/ad019004/___/');
				$final['check_projno_url']=base_url('ecp_common/check_projno/');
				$final['check_proj_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_proj_edit/');
				
				$final['assign_view']='mission_list_index';
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
				$this->load->model('Mm_search_obj','SOBJ',True);
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projj_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['description_n']=$final['ip_info']['description'];
				$final['ip_info']['jec_job_id_title']['onchange']="PG_BK_Action('change_jobname',{})";
				$final['ip_info']['jec_job_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_job_id'),'page_db','s_array');
				//
				
                $final['main_data']=array(); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				

				
				//$final['file_list']=array();//分頁用session-好餓
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br>'.$_SESSION[$final['pg_tag']]['fob'].'-------------------------------';
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$_SESSION[$final['pg_tag']]['fpp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_task_name_url'=>'task_name@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_job_name_url'=>'job_name@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_uploader_name_url'=>'uploader_name@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				
            	$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				//proj_edit_op
				
				/*
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				//$proj_data=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				$proj_data=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				$proj_data['cus_select_type']=(int)$proj_data['jec_customer_id']==0?'K':'S';
				$proj_ip=$this->$proj_set['mm_set']->load_mm_field_check();
				$proj_data['costrate']=(float)$proj_data['costrate'];
				$proj_data['total']=(float)$proj_data['total'];
				$proj_ip['efprojdept']['ld']=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'ad019005'),'page_db','mssql_ld');
				//$proj_ip['efprojdept']['onchange']="PG_BK_Action('get_purchase_list_by_dept')";
				//$proj_ip['efprojno']['onchange']="PG_BK_Action('get_purchase_name',this.value)";
				$proj_ip['efprojno']['onchange']="PG_BK_Action('check_projno',this.value)";
				$proj_ip['efprojdept']['onchange']="PG_BK_Action('change_projdept',this.value)";
				if($proj_data['efprojno']!='')://要抓
					//$proj_data['efprojno']=$proj_data['efprojno'].'>>'.$proj_data['efprojname'];
					$os=$this->CM->db->where('noticetype','OS')->where('isactive','Y')->get('jec_setup')->result_array();
					$os=strtolower($os[0]['value']);
					$istrans=$os=='linux'?'Y':'N';
					$ms_dept=$istrans=='Y'?iconv('utf-8','big5',$proj_data['efprojdept']):$proj_data['efprojdept'];
					$purchase_list = $mssqlef->where('ad019005',$ms_dept)->select('ad019004')->select('ad019006')->get('ad019')->result_array();
					$proj_ip['efprojno']['ld']=$this->CM->FormatData(array('db'=>$purchase_list,'field'=>'ad019004,ad019006','istrans'=>$istrans),'page_db','mssql_ld');
				endif;
				
								
				$proj_ip['cus_select_type']=array(
						'call_name'=>'選擇類型',
						'type'=>'select',
						'ld'=>$this->$_G['L_CS']->common_use_ld('select_type'),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'style'=>'width:80px;',
						'full_selected'=>'N'
					);				
				$proj_ip['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$fix_w=140;
				$proj_ip['description']['style']='width:'.$fix_w.'px;height:30px;';
				$proj_ip['description']['type']='textarea';
				$proj_ip['description2']['style']='width:'.$fix_w.'px;height:30px;';
				$proj_ip['description2']['type']='textarea';
				$proj_ip['description3']['style']='width:'.$fix_w.'px;height:30px;';
				$proj_ip['description3']['type']='textarea';
				
				
				//$proj_ip['address']['style']='width:'.$fix_w.'px;';
				//$proj_ip['jec_company_id']['style']='width:'.$fix_w.'px;';
				//$proj_ip['projyear']['style']='width:'.$fix_w.'px;';
				//$proj_ip['jec_customer_id_title']['style']='width:'.$fix_w.'px;';
				//$proj_ip['startdate']['style']='width:'.$fix_w.'px;';
				//$proj_ip['enddate']['style']='width:'.$fix_w.'px;';
				//$proj_ip['jec_user_id']['style']='width:'.$fix_w.'px;';
				//$proj_ip['jec_usersales_id']['style']='width:'.$fix_w.'px;';
				//$proj_ip['name']['style']='width:'.$fix_w.'px;';
								$width_array=array('address','jec_company_id','projyear','jec_customer_id_title','startdate','enddate','jec_user_id','jec_usersales_id','name','value2','name2','projtype','customerdoc','jec_dept_id','efprojno','efprojname','total','costrate');
				foreach($width_array as $wvalue):
					$proj_ip[$wvalue]['style']='width:'.$fix_w.'px;';
				endforeach;
				
				$proj_ip['projyear']['ld']=$this->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>($proj_data['projyear']-4),'en'=>(date('Y')+4)),"page_db","num");
				
				$proj_data['startdate']=date('Y-m-d',strtotime($proj_data['startdate']));
				$proj_data['enddate']=date('Y-m-d',strtotime($proj_data['enddate']));
				$proj_data['jec_customer_id_title']=$proj_data['jec_customer_id']==0?$proj_data['customername']:$this->GM->GetSpecData('jec_customer','name','jec_customer_id',$proj_data['jec_customer_id']);
				$proj_ip['jec_customer_id_title']['title']=$proj_data['jec_customer_id_title'];
				$proj_ip['jec_user_id']['disabled']='Y';//NoNo
				//right
				$final['up_right']=$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'))?'Y':'N';
				$final['up_btn']=$final['up_right']=='Y'?'':'disabled';
				$full_set=$final['up_right']=='Y'?array():array('disabled'=>'Y');
				if($proj_data['projstatus']==6) $full_set['disabled']='Y';
				
				$proj_data['jec_user_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$proj_data['jec_user_id']);
				$proj_data['jec_usersales_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$proj_data['jec_usersales_id']);
				$final['proj_op']=$this->form_input->each_op_trans('full',$proj_ip,$proj_data,'',$full_set);
				$final['proj_data']=$proj_data;
				*/
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				
				
				
				$final['tcate_url']=array(
						'project_new_index'=>base_url($final['var_purl'].'project_new_index/edit/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'bk_url'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/')
					);
            break;
			
			case 'add_mission':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$gv=array("jec_job_id","description",'jobname'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());
				$jec_usersuper_id=$this->GM->GetSpecData('jec_project','jec_user_id','jec_project_id',$df_ip['key_id']);
				
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
				//
                $ajo=array(
                    /*'reload'=>'result_area_div',
                    'reload_url'=>site_url($final['var_purl'].$df_ip['tag']."/list_div/".$df_ip['key_id']."/".$final['var_surl']),*/
					'bk_action'=>'after_add_mission',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break; //
			
			case 'update_project':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("jec_company_id","projyear","jec_customer_id","jec_customer_id_title","name","description","startdate","enddate","jec_usersales_id",'jec_user_id','customerdoc','value2','name2','projtype','address','description2','description3','jec_dept_id','cus_select_type','efprojdept','efprojno','efprojname','total','costrate'); $gv=$this->CM->GPV($gv);//,"jec_user_id"
				
				$upd=array_merge($gv,array('updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ad_id));
				$upd['jec_dept_id']=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$upd['jec_usersales_id']);
				//$upd['efprojname']=$this->CM->GetString($gv['efprojno'],'>>','');
				//$upd['efprojno']=$this->CM->GetString($gv['efprojno'],'','>>');
				/*
				if($upd['cus_select_type']=='K'):
					$upd['jec_customer_id']=NULL;
					$upd['customername']=$upd['jec_customer_id_title'];					
				else:
					$upd['customername']=$this->GM->GetSpecData('jec_customer','name','jec_customer_id',$upd['jec_customer_id']);
				endif;*/
				$cus_check=$this->CM->db->where('name',$upd['jec_customer_id_title'])->where('isactive','Y')->get('jec_customer')->result_array();
				if(count($cus_check)>0):
					$upd['jec_customer_id']=$cus_check[0]['jec_customer_id'];
				else:
					$upd['jec_customer_id']=NULL;					
				endif;
				$upd['customername']=$upd['jec_customer_id_title'];	
				unset($upd['jec_customer_id_title']);
				unset($upd['cus_select_type']);
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('update',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$df_ip['key_id']));
				
				$this->CM->JS_Msg('專案資料已更新',-1);
				
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
				$final['assign_view']='mission_list_div';
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
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projj_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_jobname_url'=>'jobname@@@'.$df_ip['ob'],'ob_jobjobtype_url'=>'jobjobtype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				//$this->load->model('Mm_search_obj','SOBJ',True);
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
			
			case 'add_mission_div':
				$final['form_url']=site_url($final['var_purl'].'mission_list_index/add_mission/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='add_mission_div';
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
					'bk_action'=>'reload_mission_list',
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
					'bk_action'=>'reload_mission_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'check_proj_edit':
				//cus_name
				//$cus_name=trim($_POST['cus_name']);//trim()
				$gv=array('cus_name','sales_name','user_name'); $gv=$this->CM->GPV($gv);
				$check=$this->db->where('name',$gv['cus_name'])->where('isactive','Y')->get('jec_customer')->result_array();
				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$msg='';
				$pass='Y';
				/*
				if(count($check)>0):
					$pass='Y';
					$cusname=$check[0]['name'];
					$cus_id=$check[0]['jec_customer_id'];
					$msg='';
				else:
					$pass='N';
					$msg='查無此客戶';
				endif;*/
				if($pass=='Y')://user_sales
					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$salesname=$check[0]['name'];
						$salesid=$check[0]['jec_user_id'];
						$salesdept=$check[0]['jec_dept_id'];
					else:
						$pass='N';
						$msg='查無此專案業務';
					endif;
				endif;
				if($pass=='Y')://user_sales
					$check=$this->db->where('name',$gv['user_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$username=$check[0]['name'];
						$userid=$check[0]['jec_user_id'];
					else:
						$pass='N';
						$msg='查無此專案負責人';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>'edit_proj_go',
					'isexist'=>$pass,
					'cus_name'=>$cusname,
					'cus_id'=>$cus_id,
					'user_name'=>$username,
					'user_id'=>$userid,
					'sales_name'=>$salesname,
					'sales_id'=>$salesid,
					'sales_dept'=>$salesdept,
                    'pass'=>1
                );
				if($msg!='') $ajo['msg']=$msg;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
        endswitch;
?>