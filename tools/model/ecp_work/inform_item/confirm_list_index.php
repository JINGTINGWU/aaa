<?php
$final['pg_tag']='i2r_pd';

if($df_ip['chinfo']==-1||!isset($_SESSION['i2r_pd'])){
 	$df_ip['chinfo']='N'; 
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'recordtime',
			'pp'=>$this->m_pp,
			'fnp'=>0,
			'fot'=>'ASC',
			'fob'=>'filename',
			'fpp'=>$this->m_pp
		);//project_1_project ->default 
		
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
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];	
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];		
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				//若為不可確認-No
				$final['file_list_url']=base_url($final['var_purl'].$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/filename/ASC/0/N/');
				//check_status - 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['check_cp_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_cp_update/');
				$final['check_cp_super_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_cp_super_update/');
				// 
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$this->$projn_set['mm_set']->exe_right_check('check_confirm',array('jec_user_id'=>$final['projn_data']['jec_user_id'],'rd_url'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'],'/')));
				
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$projr_set=$this->CM->Init_TB_Set('mm_projreply_set');
					$final['projr_data']=$this->$projr_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				
				$projr_v_set=$this->CM->Init_TB_Set('mm_projrecord_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projr_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'con_isactive'=>'Y','wni'=>array('recordtype'=>'2'),'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'pd_np'=>$df_ip['np'],'pd_pp'=>$pd_pp)));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div';
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_recordtime_url'=>'recordtime@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_description2_url'=>'description2@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				
				$final['assign_view']='confirm_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projn_set['mm_set']->load_mm_field_check();//projnotice	
				$final['ip_info']['cp_ip_transfer_user']['ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld();
				$final['ip_info']['cp_transfer_user']['ld']=$final['ip_info']['cp_ip_transfer_user']['ld'];
				//取得ORI_grasnfer_user
				$cp_time=date('Y-m-d H:i:s');                                
				//trans_user
				if((int)$final['projr_data']['jec_usernew_id']>0):
					$df_usernew_id='U-'.$final['projr_data']['jec_usernew_id'];
					$df_usernew_id_title=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_usernew_id']);
				else:
					$df_usernew_id='G-'.$final['projr_data']['jec_groupnew_id'];
					$df_usernew_id_title=$this->GM->GetSpecData('jec_group','name','jec_group_id',$final['projr_data']['jec_groupnew_id']);
				endif;
				//trans_superuser
				if((int)$final['projr_data']['jec_usernew_id']>0):
					$df_superusernew_id='U-'.$final['projr_data']['jec_usernew_id'];
					$df_superusernew_id_title=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_usernew_id']);
				else:
					$df_superusernew_id='G-'.$final['projr_data']['jec_groupnew_id'];
					$df_superusernew_id_title=$this->GM->GetSpecData('jec_group','name','jec_group_id',$final['projr_data']['jec_groupnew_id']);
				endif;
				
                $final['main_data']=array('cp_finish_time'=>$cp_time,'cp_adtime_startdate'=>substr($final['projr_data']['startdate'],0,10),'cp_adtime_enddate'=>substr($final['projr_data']['enddate'],0,10),'cp_iptime_startdate'=>substr($final['projt_data']['startdate'],0,10),'cp_pause_startdate'=>substr($final['projr_data']['startdate'],0,10),'cp_pause_enddate'=>substr($final['projr_data']['enddate'],0,10),'cp_recover_time'=>$cp_time,'cp_ip_transfer_user'=>'','cp_transfer_user'=>$df_usernew_id,'cp_transfer_user_title'=>$df_usernew_id_title,'cp_transfer_superuser'=>$df_superusernew_id,'cp_transfer_superuser_title'=>$df_superusernew_id_title); 
				
				//抓原始的暫停原因跟回復原因……
				if($final['projn_data']['noticetype']==9):
					$final['projr_data']['pause_description']=$this->GM->common_ac('list',array('info'=>$projr_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'con_replystatus'=>5,'pd_pp'=>1,'pd_np'=>0,'row_type'=>1,'one_field'=>'description','ob_created'=>'DESC')));
					$final['main_data']['cp_recover_time']=$this->GM->common_ac('list',array('info'=>$projn_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'con_noticetype'=>18,'pd_pp'=>1,'pd_np'=>0,'row_type'=>1,'one_field'=>'noticetime','ob_created'=>'DESC')));
				
				
				endif;
				//$final['main_data']['cp_recover_time']=$cp_time;
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.$final['projn_data']['jec_projreply_id'].$final['main_data']['cp_recover_time'];
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['cp_time']=$cp_time;
				

				
				$final['tcate_url']=array(
						'inform_list_index'=>base_url($final['var_purl'].'inform_list_index/list/0/startdate/asc/0/N/ '),
						'inform_list_index_unconfirm'=>base_url($final['var_purl'].'inform_list_index/list/-1/created/DESC/0/Unconfirm/ '),
						'work_record_index'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'],'/ ')
					);
					
				$final['cp_url']=array(
						'cp_finish'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_finish/'.$df_ip['key_id'].'/'),
						'cp_adjust'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_adjust/'.$df_ip['key_id'].'/'),
						'cp_transfer'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_transfer/'.$df_ip['key_id'].'/'),
						'cp_adjust_transfer'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_adjust_transfer/'.$df_ip['key_id'].'/'),
						'cp_transfer_super'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_transfer_super/'.$df_ip['key_id'].'/'),
						'cp_impossible'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_impossible/'.$df_ip['key_id'].'/'),
						'cp_pause'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_pause/'.$df_ip['key_id'].'/'),
						'cp_recover'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_recover/'.$df_ip['key_id'].'/'),
						'cp_cancel'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_cancel/'.$df_ip['key_id'].'/'),
						'rp_addsign'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_addsign/'.$df_ip['key_id'].'/'),
                                    		'cp_addsign'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_addsign/'.$df_ip['key_id'].'/')
					);
            break;
			
            case 'list_2': 
				//check_status -  從工作去抓的…= = //抓notice...= =.
				
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['check_cp_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_cp_update/');
				//np為user_id
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->GM->common_ac('list',array('info'=>$projn_set['mm_set'],'type'=>'def','data'=>array('con_jec_user_id'=>$df_ip['np'],'con_jec_projtask_id'=>$df_ip['key_id'],'ob_created'=>'DESC','pd_pp'=>1,'pd_np'=>0,'row_type'=>1))); 
				$df_ip['key_id']=$final['projn_data']['jec_projnotice_id'];
				//$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$projr_set=$this->CM->Init_TB_Set('mm_projreply_set');
					$final['projr_data']=$this->$projr_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				$final['assign_view']='confirm_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projn_set['mm_set']->load_mm_field_check();//projnotice	
				$final['ip_info']['cp_ip_transfer_user']['ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld();
				$final['ip_info']['cp_transfer_user']['ld']=$final['ip_info']['cp_ip_transfer_user']['ld'];
				//取得ORI_grasnfer_user
				if((int)$final['projr_data']['jec_usernew_id']>0):
					$df_usernew_id='U-'.$final['projr_data']['jec_usernew_id'];
					$df_usernew_id_title=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_usernew_id']);
				else:
					$df_usernew_id='G-'.$final['projr_data']['jec_groupnew_id'];
					$df_usernew_id_title=$this->GM->GetSpecData('jec_group','name','jec_group_id',$final['projr_data']['jec_groupnew_id']);
				endif;
				$cp_time=date('Y-m-d H:i:s');
                $final['main_data']=array('cp_finish_time'=>$cp_time,'cp_adtime_startdate'=>substr($final['projr_data']['startdate'],0,10),'cp_adtime_enddate'=>substr($final['projr_data']['enddate'],0,10),'cp_iptime_startdate'=>substr($final['projt_data']['startdate'],0,10),'cp_iptime_enddate'=>substr($final['projt_data']['enddate'],0,10),'cp_recover_time'=>$cp_time,'cp_ip_transfer_user'=>0,'cp_transfer_user'=>$df_usernew_id,'cp_transfer_user_title'=>$df_usernew_id_title); 
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.$final['projn_data']['jec_projreply_id'];
				//抓原始的暫停原因跟回復原因……
				if($final['projn_data']['noticetype']==9):
					$final['projr_data']['pause_description']=$this->GM->common_ac('list',array('info'=>$projr_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'con_replystatus'=>5,'pd_pp'=>1,'pd_np'=>0,'row_type'=>1,'one_field'=>'description','ob_created'=>'DESC')));
					$final['main_data']['cp_recover_time']=$this->GM->common_ac('list',array('info'=>$projn_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'con_noticetype'=>18,'pd_pp'=>1,'pd_np'=>0,'row_type'=>1,'one_field'=>'noticetime','ob_created'=>'DESC')));
				endif;
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['cp_time']=$cp_time;
				

				
				$final['tcate_url']=array(
						'inform_list_index'=>base_url($final['var_purl'].'inform_list_index/list/0/startdate/asc/0/N/'),
						'work_record_index'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'],'/')
					);
					
				$final['cp_url']=array(
						'cp_finish'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_finish/'.$df_ip['key_id'].'/'),
						'cp_adjust'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_adjust/'.$df_ip['key_id'].'/'),
						'cp_transfer'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_transfer/'.$df_ip['key_id'].'/'),
						'cp_impossible'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_impossible/'.$df_ip['key_id'].'/'),
						'cp_pause'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_pause/'.$df_ip['key_id'].'/'),
						'cp_recover'=>base_url($final['var_purl'].$df_ip['tag'].'/cp_recover/'.$df_ip['key_id'].'/')
					);
            break;			
			case 'list_div':
				$final['assign_view']='prod_list_div';
				$this->load->library('form_input');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				
			break;

			
			case 'update_projprod':
				$gv=array("projprod_id",'price','quantity','jec_vendor_id','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$upd=$gv;
				unset($upd['projprod_id']);
				unset($upd['no']);
				$upd['total']=$upd['price']*$upd['quantity'];
				$this->GM->common_ac('update',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projprod_id']));
                $ajo=array(
					'msg'=>'已修改',
					'innerId'=>'total_tag_'.$no,
					'innerHTML'=>$upd['total'],
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			case 'cp_finish':
				//finish. Many Great. ->
				$gv=array('reply','cp_time','cp_finish'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				//cal部份額外計…
				switch($gv['reply']):
					case 'Y'://OK

						//check是否為group.
						
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
												
						//update 主管的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
						
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;


						//異動日期
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'Y','projtasktype'=>6,'replystatus'=>1,'finishdate'=>date('Y-m-d H:i:s'),'isfinish'=>'Y','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id,'confirmdate'=>date('Y-m-d H:i:s')));//無影響
						
						
						break;
					case 'N'://Not OK

						
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						//update 承辦的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
						
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						/*
							$cal_upd=array(
								'jec_projtask_id'=>$upd['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);*/
						
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//不變$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;

						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('projtasktype'=>2,'replystatus'=>0,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
				endswitch;
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);					
				endforeach;
				//calendar
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				
			break;
			
			case 'cp_adjust':
				$gv=array('reply','cp_time','cp_adtime_enddate','cp_adtime_startdate','cp_finish'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);

				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				switch($gv['reply']):
					case 'Y'://OK

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);
						

						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'new_date_period'=>$gv['cp_adtime_startdate'].'~'.$gv['cp_adtime_enddate']);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						//update 主管的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
				
				
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'startdate'=>$gv['cp_adtime_startdate'],
								'enddate'=>$gv['cp_adtime_enddate'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							

						endforeach;

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$projt_up=array('startdate'=>$gv['cp_adtime_startdate'],'enddate'=>$gv['cp_adtime_enddate'],'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id);//,'confirmdate'=>date('Y-m-d H:i:s')
						if(strtotime($gv['cp_adtime_enddate'].' 00:00:00')>time()):
							$projt_up['delaydate']=0;
						else:
							//recount
							$xx=time()-strtotime($gv['cp_adtime_enddate'].' 00:00:00');
							$projt_up['delaydate']=floor($xx/60/60/24);	
						endif;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$projt_up);//無影響
						
						$projt_data['startdate']=$gv['cp_adtime_startdate'];
						$projt_data['enddate']=$gv['cp_adtime_enddate'];
						//前筆要改…
						
						break;
					case 'N'://Not OK

						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'new_date_period'=>$gv['cp_adtime_startdate'].'~'.$gv['cp_adtime_enddate']);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						//update 承辦的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
						
						
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//不變$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							

						endforeach;

						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('projtasktype'=>2,'replystatus'=>0,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
				endswitch;
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);//Fromtype-1
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);					
				endforeach;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype,'startdate'=>$projt_data['startdate'],'enddate'=>$projt_data['enddate']));
				//$final['projn_data']
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'cp_transfer':
				//同意移轉.- -
				$gv=array('reply','cp_time','jec_usernew_id','cp_iptime_startdate','cp_iptime_enddate','cp_impossible','cp_finish'); $gv=$this->CM->GPV($gv);
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				switch($gv['reply']):
					case 'N'://adtime - 
						//update 主管的noticetype
						$jec_usernew_id=$projt_data['jec_user_id'];
						$jec_groupnew_id=$projt_data['jec_group_id'];

						
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;

						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$final['projr_data']['jec_usernew_id'],'jec_group_id'=>$final['projr_data']['jec_groupnew_id']));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
				
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響+Time
				
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							//delete_calendar($data=array())
						endforeach;

						//異動日期- 
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
					case 'Y':
						

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							$jec_usernew_id=NULL;
							$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
						else:
							$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							$jec_groupnew_id=NULL;
						endif;
						
						$this->db->where($projrp_set['mm_kid'],$final['projn_data']['jec_projreply_id'])->update($projrp_set['mm_tb'],array('jec_usernew_id'=>$jec_usernew_id,'jec_groupnew_id'=>$jec_groupnew_id));
						
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響-
						
						//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
						
						foreach($tu_user as $tu_value):
							//update reply
							
							
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							//$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->delete_calendar($cal_upd);
							
							//record
							$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							//$this->$projr_set['mm_set']->record_action($upd);
							
							
							//delete cal
						endforeach;
						//----新承辦人
						
						
						

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET jec_userold_id=jec_user_id,jec_groupold_id=jec_group_id WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						//New/
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							//$jec_usernew_id=NULL;
							//$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
							$tu_user=$this->db->where('jec_group_id',$jec_groupnew_id)->where('isactive','Y')->get('jec_usergroup')->result_array();
						else:
							//$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							//$jec_groupnew_id=NULL;
							$tu_user=array(array('jec_user_id'=>$jec_usernew_id));
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						foreach($tu_user as $tu_value):
							//update reply
							
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);

							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;
						//update OLd
						//
						$task_upd=array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id,'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'transferdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'));//,'confirmdate'=>date('Y-m-d H:i:s')
						if(isset($t_projnotice_id)) $task_upd['jec_projnotice_id']=$t_projnotice_id;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$task_upd);//無影響-
						
						break;

				endswitch;
				
				$projt_data['jec_user_id']=$jec_usernew_id;
				$projt_data['jec_group_id']=$jec_groupnew_id;//....
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);-
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);	
							echo $projt_data['startdate'].'='.$projt_data['enddate'];				
				endforeach;
				//沒改到…
				//echo '@@@@@@@'.$final['projn_data']['jec_calendar_id'].'---'.$projn_noticetype;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'cp_adjust_transfer':
				//同意移轉.- -
				$gv=array('reply','cp_time','jec_usernew_id','cp_iptime_startdate','cp_iptime_enddate','cp_impossible','cp_finish','cp_adtime_enddate','cp_adtime_startdate'); $gv=$this->CM->GPV($gv);
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				switch($gv['reply']):
					case 'N'://adtime - 
						//update 主管的noticetype
						$jec_usernew_id=$projt_data['jec_user_id'];
						$jec_groupnew_id=$projt_data['jec_group_id'];

						
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;

						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$final['projr_data']['jec_usernew_id'],'jec_group_id'=>$final['projr_data']['jec_groupnew_id']));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name,'new_date_period'=>$gv['cp_adtime_startdate'].'~'.$gv['cp_adtime_enddate']);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
				
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響+Time
				
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							//delete_calendar($data=array())
						endforeach;

						//異動日期- 
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
					case 'Y':
						

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							$jec_usernew_id=NULL;
							$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
						else:
							$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							$jec_groupnew_id=NULL;
						endif;
						
						$this->db->where($projrp_set['mm_kid'],$final['projn_data']['jec_projreply_id'])->update($projrp_set['mm_tb'],array('jec_usernew_id'=>$jec_usernew_id,'jec_groupnew_id'=>$jec_groupnew_id));
						
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name,'new_date_period'=>$gv['cp_adtime_startdate'].'~'.$gv['cp_adtime_enddate']);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響-
						
						//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
						
						foreach($tu_user as $tu_value):
							//update reply
							
							
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							//$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->delete_calendar($cal_upd);
							
							//record
							$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							//$this->$projr_set['mm_set']->record_action($upd);
							
							
							//delete cal
						endforeach;
						//----新承辦人
						
						
						
						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$projt_up=array('startdate'=>$gv['cp_adtime_startdate'],'enddate'=>$gv['cp_adtime_enddate']);//,'confirmdate'=>date('Y-m-d H:i:s')
						if(strtotime($gv['cp_adtime_enddate'].' 00:00:00')>time()):
							$projt_up['delaydate']=0;
						else:
							//recount
							$xx=time()-strtotime($gv['cp_adtime_enddate'].' 00:00:00');
							$projt_up['delaydate']=floor($xx/60/60/24);	
						endif;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$projt_up);//無影響
						
						$projt_data['startdate']=$gv['cp_adtime_startdate'];
						$projt_data['enddate']=$gv['cp_adtime_enddate'];
						
						//異動負責人
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET jec_userold_id=jec_user_id,jec_groupold_id=jec_group_id WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						//New/
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							//$jec_usernew_id=NULL;
							//$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
							$tu_user=$this->db->where('jec_group_id',$jec_groupnew_id)->where('isactive','Y')->get('jec_usergroup')->result_array();
						else:
							//$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							//$jec_groupnew_id=NULL;
							$tu_user=array(array('jec_user_id'=>$jec_usernew_id));
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						foreach($tu_user as $tu_value):
							//update reply
							
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);

							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;
						//update OLd
						//
						$task_upd=array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id,'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'transferdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'));//,'confirmdate'=>date('Y-m-d H:i:s')
						if(isset($t_projnotice_id)) $task_upd['jec_projnotice_id']=$t_projnotice_id;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$task_upd);//無影響-
						
						break;

				endswitch;
				
				$projt_data['jec_user_id']=$jec_usernew_id;
				$projt_data['jec_group_id']=$jec_groupnew_id;//....
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);-
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);	
							echo $projt_data['startdate'].'='.$projt_data['enddate'];				
				endforeach;
				//沒改到…
				//echo '@@@@@@@'.$final['projn_data']['jec_calendar_id'].'---'.$projn_noticetype;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;

			
			case 'cp_transfer_super':
				//同意移轉.- -
				$gv=array('reply','cp_time','jec_usernew_id','cp_iptime_startdate','cp_iptime_enddate','cp_impossible','cp_finish'); $gv=$this->CM->GPV($gv);
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				//$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				$sales_name=$this->QIM->get_final_super_name($projt_data);
				
				switch($gv['reply']):
					case 'N'://adtime - 
						//update 主管的noticetype
						$jec_usernew_id=$projt_data['jec_user_id'];
						$jec_groupnew_id=$projt_data['jec_group_id'];

						
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;

						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$final['projr_data']['jec_usernew_id'],'jec_group_id'=>$final['projr_data']['jec_groupnew_id']));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
				
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響+Time
				
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							//delete_calendar($data=array())
						endforeach;

						//異動日期- 
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
					case 'Y':
						

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							$jec_usernew_id=NULL;
							$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
						else:
							$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							$jec_groupnew_id=NULL;
						endif;
						
						$this->db->where($projrp_set['mm_kid'],$final['projn_data']['jec_projreply_id'])->update($projrp_set['mm_tb'],array('jec_usernew_id'=>$jec_usernew_id,'jec_groupnew_id'=>$jec_groupnew_id));
						
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響-
						
						//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
						
						foreach($tu_user as $tu_value):
							//update reply
							
							
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							//$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->delete_calendar($cal_upd);
							
							//record
							$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							//$this->$projr_set['mm_set']->record_action($upd);
							
							
							//delete cal
						endforeach;
						//----新承辦人
						
						
						

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET jec_userold_id=jec_user_id,jec_groupold_id=jec_group_id WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						//New/
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							//$jec_usernew_id=NULL;
							//$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
							$tu_user=$this->db->where('jec_group_id',$jec_groupnew_id)->where('isactive','Y')->get('jec_usergroup')->result_array();
						else:
							//$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							//$jec_groupnew_id=NULL;
							$tu_user=array(array('jec_user_id'=>$jec_usernew_id));
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						foreach($tu_user as $tu_value):
							//update reply
							
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);

							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;
						//update OLd
						//
						$task_upd=array('jec_usersuper_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id,'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'transferdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'));//,'confirmdate'=>date('Y-m-d H:i:s')
						if(isset($t_projnotice_id)) $task_upd['jec_projnotice_id']=$t_projnotice_id;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$task_upd);//無影響-
						
						break;

				endswitch;
				
				$projt_data['jec_user_id']=$jec_usernew_id;
				$projt_data['jec_group_id']=$jec_groupnew_id;//....
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);-
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);	
							echo $projt_data['startdate'].'='.$projt_data['enddate'];				
				endforeach;
				//沒改到…
				//echo '@@@@@@@'.$final['projn_data']['jec_calendar_id'].'---'.$projn_noticetype;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;

			case 'cp_impossible':
				//無法完成
				$gv=array('reply','cp_time','jec_usernew_id','cp_iptime_startdate','cp_iptime_enddate','cp_impossible'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projn_data']['jec_user_id']);
				
				//echo $gv['reply'];
				switch($gv['reply']):
					case 'A'://adtime

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						//$projn_noticetype=16;
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'new_date_period'=>$gv['cp_iptime_startdate'].'~'.$gv['cp_iptime_enddate']);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						//update 主管的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype,'startdate'=>$gv['cp_iptime_startdate'],'enddate'=>$gv['cp_iptime_enddate']));//無影響+Time
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'startdate'=>$gv['cp_iptime_startdate'],
								'enddate'=>$gv['cp_iptime_enddate'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content,
								'description2'=>$gv['cp_impossible']
								);
							$this->$projr_set['mm_set']->record_action($upd);

						endforeach;

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						
						$projt_up=array('startdate'=>$gv['cp_iptime_startdate'],'enddate'=>$gv['cp_iptime_enddate'],'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id);//,'confirmdate'=>date('Y-m-d H:i:s')
						if(strtotime($gv['cp_iptime_enddate'].' 00:00:00')>time()):
							$projt_up['delaydate']=0;
						else:
							//recount
							$xx=time()-strtotime($gv['cp_iptime_enddate'].' 00:00:00');
							$projt_up['delaydate']=floor($xx/60/60/24);	
						endif;
						
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$projt_up);//無影響
						//cal要改
						$projt_data['startdate']=$gv['cp_iptime_startdate'];
						$projt_data['enddate']=$gv['cp_iptime_enddate'];
						break;
					case 'T':

						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							$jec_usernew_id=NULL;
							$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
						else:
							$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							$jec_groupnew_id=NULL;
						endif;
						$this->db->where($projrp_set['mm_kid'],$final['projn_data']['jec_projreply_id'])->update($projrp_set['mm_tb'],array('jec_usernew_id'=>$jec_usernew_id,'jec_groupnew_id'=>$jec_groupnew_id));
						
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);

						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'new_sales_name'=>$new_sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
						
						foreach($tu_user as $tu_value):
							//update reply
							
							
							//-Email
							//proj_notice

							//Send
				
							$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
						
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->delete_calendar($cal_upd);
							//刪掉啊@@
						
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content,
								'description2'=>$gv['cp_impossible']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							//刪掉cal
							
						endforeach;
						//----新承辦人
						
						
						

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET jec_userold_id=jec_user_id,jec_groupold_id=jec_group_id WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							//$jec_user_id=NULL;
							//$jec_group_id=substr($gv['jec_usernew_id'],2);
							$tu_user=$this->db->where('jec_group_id',$jec_groupnew_id)->where('isactive','Y')->get('jec_usergroup')->result_array();
						else:
							//$jec_user_id=substr($gv['jec_usernew_id'],2);
							//$jec_group_id=NULL;
							$tu_user=array(array('jec_user_id'=>$jec_usernew_id));
						endif;
						foreach($tu_user as $tu_value):
							//update reply
							
							//-Email
							//proj_notice

							//Send
				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							/*
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);*/
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content,
								'description2'=>$gv['cp_impossible']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							

							
						endforeach;
						
						
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id,'isconfirm'=>'N','projtasktype'=>2,'replystatus'=>0,'transferdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						$projt_data['jec_user_id']=$jec_usernew_id;
						$projt_data['jec_group_id']=$jec_groupnew_id;
						break;
					case 'C':
						//要存原因-
						
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						//update 主管的noticetype
						
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));//無影響
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send--
				
							
							
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content,
								'description2'=>$gv['cp_impossible']
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;

						//異動日期
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'N','projtasktype'=>4,'replystatus'=>0,'canceldate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
				endswitch;
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);					
				endforeach;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype,'startdate'=>$projt_data['startdate'],'enddate'=>$projt_data['enddate']));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'cp_pause':
				//暫停
				$gv=array('reply','cp_time','cp_finish','cp_pause_startdate','cp_pause_enddate'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				switch($gv['reply']):
					case 'Y'://OK
						//update 主管的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply'])));//無影響
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							/*
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);*/
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;

						//異動日期
						$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$projt_up=array('startdate'=>$gv['cp_pause_startdate'],'enddate'=>$gv['cp_pause_enddate'],'isconfirm'=>'N','projtasktype'=>5,'replystatus'=>0,'pendingdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id);//,'confirmdate'=>date('Y-m-d H:i:s')
						if(strtotime($gv['cp_pause_enddate'].' 00:00:00')>time()):
							$projt_up['delaydate']=0;
						else:
							//recount
							$xx=time()-strtotime($gv['cp_pause_enddate'].' 00:00:00');
							$projt_up['delaydate']=floor($xx/60/60/24);	
						endif;
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],$projt_up);//無影響
						
						$projt_data['startdate']=$gv['cp_pause_startdate'];
						$projt_data['enddate']=$gv['cp_pause_enddate'];

						//$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'N','projtasktype'=>5,'replystatus'=>0,'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
					case 'N'://Not OK
						//update 承辦的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply'])));//無影響
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
						
						//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							/*
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);*/
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//不變$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;

						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('projtasktype'=>2,'replystatus'=>0,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')
						break;
				endswitch;
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);					
				endforeach;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'cp_recover'://recover
				//
				$gv=array('reply','cp_time'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projr_data']['jec_user_id']);
				
				switch($gv['reply']):
					case 'Y'://OK
						//update 主管的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply'])));//無影響
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							/*
							$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);*/
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;

						//異動日期
						//$this->db->query("UPDATE ".$projt_set['mm_tb']." SET oldstartdate=startdate,oldenddate=enddate WHERE ".$projt_set['mm_kid']."='".$final['projn_data']['jec_projtask_id']."'");
						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('projtasktype'=>2,'replystatus'=>0,'recoverydate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id));//無影響,'confirmdate'=>date('Y-m-d H:i:s')'isconfirm'=>'Y',
						break;
					case 'N'://Not OK
						//update 承辦的noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply'])));//無影響
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice

							//Send
				
							
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//不變$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;

						$this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('replystatus'=>0,'isconfirm'=>'N'));//無影響'confirmdate'=>date('Y-m-d H:i:s')
						break;
				endswitch;
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
							$cal_upd=array(
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$projn_noticetype,
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'noticefrom'=>1,
								'description'=>$mail_content
							);
							$this->$cal_set['mm_set']->calendar_action($cal_upd);					
				endforeach;
				$this->db->where($cal_set['mm_kid'],$final['projn_data']['jec_calendar_id'])->update($cal_set['mm_tb'],array('noticetype'=>$projn_noticetype));
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			
			case 'cp_cancel':
				
			break;
			
			case 'rp_addsign':
				//向前加簽
				$gv=array('reply','jec_usernew_id','cp_finish'); $gv=$this->CM->GPV($gv);
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['projn_data']['jec_user_id']);
				
				switch($gv['reply']):					
					case 'Y':
						//check是否為group.
						if((int)$projt_data['jec_user_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							$jec_usernew_id=NULL;
							$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
						else:
							$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							$jec_groupnew_id=NULL;
						endif;
						
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);
						$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
						//組合mail內容
                                                $mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}						
						//update原notice的description
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('description'=>'加簽中'));
						//加簽人
						//New/
						if(substr($gv['jec_usernew_id'],0,1)=='G'):
							//$jec_usernew_id=NULL;
							//$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
							$tu_user=$this->db->where('jec_group_id',$jec_groupnew_id)->where('isactive','Y')->get('jec_usergroup')->result_array();
						else:
							//$jec_usernew_id=substr($gv['jec_usernew_id'],2);
							//$jec_groupnew_id=NULL;
							$tu_user=array(array('jec_user_id'=>$jec_usernew_id));
						endif;
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);
						foreach($tu_user as $tu_value):
							//update reply							
							//-Email
							//proj_notice
							//Send				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//新增notice			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
                                                                'jec_projreply_id'=>$final['projn_data']['jec_projreply_id']
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);

							//新增record							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
							

						endforeach;					
						
						break;

				endswitch;
				
				
                $ajo=array(
					'msg'=>'已加簽',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;

                        case 'cp_addsign':
				//加簽關卡
				$gv=array('reply','cp_time','cp_finish'); $gv=$this->CM->GPV($gv);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$final['projn_data']=$this->$projn_set['mm_set']->get_projnotice_row($df_ip['key_id']);//
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$final['projr_data']=array();
				if((int)$final['projn_data']['jec_projreply_id']>0):
					
					$final['projr_data']=$this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
				endif;
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);//
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']);
				
				switch($gv['reply']):
					case 'Y'://OK

						//check是否為group.
						
						if((int)$projt_data['jec_usersuper_id']>0):
							$tu_user=array(array('jec_user_id'=>$projt_data['jec_usersuper_id']));
						else:
							$tu_user=$this->db->where('jec_group_id',$projt_data['jec_usersuper_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
						$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac'].'_'.$gv['reply']);
						$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name);
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
						$desc=$mail_content;
						//加意見
						if($gv['cp_finish']!='')
						{
							$mail_content .= "<br>意見：".$gv['cp_finish'];
						}
												
						//update原noticetype
						$this->db->where($projn_set['mm_kid'],$df_ip['key_id'])->update($projn_set['mm_tb'],array('emailcontent'=>$mail_content,'noticetype'=>$projn_noticetype));
						//update發動加簽的description
						$this->db->where(array('jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],'description'=>'加簽中'))->update($projn_set['mm_tb'],array('description'=>''));
						
						foreach($tu_user as $tu_value):
							//-Email
							//proj_notice
							//Send				
							//$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'].'_'.$gv['reply']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s')/*,
								'jec_projreply_id'=>$projreply_id 好像要紀錄同意的日期… */
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
						
							//record
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$desc,
								'description2'=>$gv['cp_finish']
								);
							$this->$projr_set['mm_set']->record_action($upd);
						endforeach;
						break;
				endswitch;
				
                $ajo=array(
					'msg'=>'已回覆',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				
			break;
			
			case 'check_cp_update'://確認User....= =
				//cus_name - 
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					/*
					case 'update_task_go':
						$gv=array('sales_name','super_name','no');
						break;*/
					default:
						$gv=array('sales_name');
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
							$msg='查無使用者';
						endif;

					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>$bk_action,
					'isexist'=>$pass,
					'cp_url'=>$_POST['cp_url'],
					'reply'=>$_POST['reply'],
                    'pass'=>1
                );
				
				if(isset($gv['sales_name'])): 
					$ajo['sales_name']=$salesname;
					$ajo['sales_id']=$salesid;
				endif;
				if($msg!='') $ajo['msg']=$msg;
				if(isset($gv['no'])) $ajo['no']=$gv['no'];
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break; 
			case 'check_cp_super_update'://確認User....= =
				//cus_name - 
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					/*
					case 'update_task_go':
						$gv=array('sales_name','super_name','no');
						break;*/
					default:
						$gv=array('sales_name');
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
						$pass='N';
						$msg='督導人不得為群組';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>$bk_action,
					'isexist'=>$pass,
					'cp_url'=>$_POST['cp_url'],
					'reply'=>$_POST['reply'],
                    'pass'=>1
                );
				
				if(isset($gv['sales_name'])): 
					$ajo['sales_name']=$salesname;
					$ajo['sales_id']=$salesid;
				endif;
				if($msg!='') $ajo['msg']=$msg;
				if(isset($gv['no'])) $ajo['no']=$gv['no'];
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break; 
        endswitch;
		$query = $this->db->where('jec_projtask_id',$final['projn_data']['jec_projtask_id'])->like('description','日期變更已確認')->get('jec_projrecord');
        $final['datechangecount'] = $query->num_rows();
        $query = $this->db->where('jec_projtask_id',$final['projn_data']['jec_projtask_id'])->like('description','工作移轉已確認')->get('jec_projrecord');
        $final['mantransfercount']=$query->num_rows();
        $query = $this->db->where('jec_projtask_id',$final['projn_data']['jec_projtask_id'])->like('description','工作暫停已確認')->get('jec_projrecord');
        $final['pausecount']=$query->num_rows();
		$query = $this->db->where('jec_projtask_id',$final['projn_data']['jec_projtask_id'])->like('description','展期暨移轉已確認')->get('jec_projrecord');
        $tmpCount=$query->num_rows();
		$final['datechangecount']+=$tmpCount;
		$final['mantransfercount']+=$tmpCount;
?>