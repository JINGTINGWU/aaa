<?php
$this->load->model('Mm_encode_model', 'MEM');
        switch($df_ip['ac']):
            case 'list': 
				//if_chinfo!=''/
				//Save完就回到原頁 
				//exe_right_check($type='def',$data=array())
				//依權限決定要載入的view--
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');//

				$final['projtasktype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('tasktype'),'key'=>'id','vf'=>'name'),'page_db',1);
				$final['check_rp_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_rp_update/');
				$final['check_rp_super_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_rp_update_super/');
				//$final['form_url']=site_url($final['var_purl'].'prod_list_index/add_projprod/'.$df_ip['key_id'].'/');
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$isreport=$this->$projt_v_set['mm_set']->exe_right_check('check_reply',array('jec_projtask_id'=>$df_ip['key_id']));//,'rd_url'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'].'/created/DESC/0/-1/')
				
				//
				
				
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				//依status				
				$final['assign_view']='work_report_index_off';
				if($final['projt_data']['projtasktype']==2&&$final['projt_data']['replystatus']==0) $final['assign_view']='work_report_index_on';
				//$isreport=$this->$projt_v_set['mm_set']->exe_right_check('check_isreports',array('projt_data'=>$final['projt_data']));
				//if($final['projt_data']['replystatus']>0&&$final['projt_data']['replystatus']!=5) $final['assign_view']='work_report_index_running';//
				if($final['projt_data']['replystatus']>0) $final['assign_view']='work_report_index_running';//

				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre; 
				$rp_time=date('Y-m-d H:i:s');
				
				//if($isreport==true)://-----------------------------Start
				
                $final['ip_info']=$this->$projt_v_set['mm_set']->load_mm_field_check();	
				$final['ip_info']['rp_transfer_user']['ld']=$this->$projt_v_set['mm_set']->get_jec_user_ld($final['projt_data']);
				
                $final['main_data']=array('rp_finish_time'=>$rp_time,'rp_adtime_enddate'=>date('Y-m-d'),'rp_impossible_time'=>$rp_time,'rp_pause_time'=>$rp_time,'rp_recover_time'=>$rp_time,'rp_adtime_startdate'=>substr($final['projt_data']['startdate'],0,10),'rp_adtime_enddate'=>substr($final['projt_data']['enddate'],0,10)); 
				//$full_set=$this->ECPM->m_right_tag['add_da']==''?array():array('disabled'=>'Y');
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				//endif;//-------------------------------------------End
				
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				
				$final['time_tag']=time().'-'.rand(10,99);
				$final['rp_time']=$rp_time;
				$final['tcate_url']=array(
						'work_list_index'=>base_url($final['var_purl'].'work_list_index/list/0/startdate/asc/0/N/'),
						'work_detail_index'=>base_url($final['var_purl'].'work_detail_index/list/'.$df_ip['key_id'].'/'),
						'work_record_index'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'].'/created/DESC/0/-1/')
					);
				$final['rp_url']=array(
						'rp_finish'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_finish/'.$df_ip['key_id'].'/'),
						'rp_progress'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_progress/'.$df_ip['key_id'].'/'),
						'rp_adjust'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_adjust/'.$df_ip['key_id'].'/'),
						'rp_transfer'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_transfer/'.$df_ip['key_id'].'/'),
						'rp_adjust_transfer'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_adjust_transfer/'.$df_ip['key_id'].'/'),
						'rp_transfer_superuser'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_transfer_superuser/'.$df_ip['key_id'].'/'),
						'rp_impossible'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_impossible/'.$df_ip['key_id'].'/'),
						'rp_pause'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_pause/'.$df_ip['key_id'].'/'),
						'rp_recover'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_recover/'.$df_ip['key_id'].'/'),
						'rp_cancel'=>base_url($final['var_purl'].$df_ip['tag'].'/rp_cancel/'.$df_ip['key_id'].'/')
					);
				$final['file_list_url']=base_url($final['var_purl'].'file_info_div/rp_finish'.$final['time_tag']);
					//update->
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
			
			case 'rp_finish'://
				$gv=array("time_tag",'rp_time','content','toboss'); $gv=$this->CM->GPV($gv);				
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				include('tools/common/upload_ac/rp_save_file.php');
				
			
				
				
				$confirm_info=array(
						1=>'請確認',
						2=>'已自動確認',
						3=>'不需確認'
					);
				$confirm_name=$confirm_info[$projt_data['taskconfirmtype']];
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id);
				if(!$this->$projt_v_set['mm_set']->exe_right_check('check_finish_precheck',$projt_data)):
					//mail-
					$this->$projt_v_set['mm_set']->Send_Related_Mail('finish_precheck_alert',array('mail_pdb'=>$mail_pdb,'projt_data'=>$projt_data));
					
				endif;	
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'sales_name'=>$sales_name,'confirm_name'=>$confirm_name);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);
				//
				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//check是否為強制
				$task_set=$this->CM->Init_TB_Set('mm_task_set');
				$task_data=$this->$task_set['mm_set']->get_task_row($projt_data['jec_task_id']);
				//add_record
				
				
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);

				//
				$this->$projr_set['mm_set']->record_action($upd);
				
				//check _pre task checl--@@

				
				
				
				if($projt_data['taskconfirmtype']==1):
					$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
					$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
					$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
					$email=array(
							'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
							'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
							'boss'=>$bossmail,
							'time'=>date('Y-m-d H:i:s'),
							'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
							'content'=>$mail_content,
							'emailsend'=>'N'
						);

									
					$upd=array(
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$df_ip['key_id'],
							'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
							'noticefrom'=>1,
							'jec_user_id'=>$projt_data['jec_usersuper_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'emailtime'=>$email['time'],
							'emailsubject'=>$email['subject'],
							'emailcontent'=>$email['content'],
							'emailsend'=>$email['emailsend'],
							'noticetime'=>date('Y-m-d H:i:s'),
							'jec_projreply_id'=>$projreply_id
						);
					$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
					$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
					$email['content'].='<a href="'.$e_link.'">連結</a>';
					if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
						$email['emailsend']='Y';
					endif;	
					if($gv['toboss']=='Y')
					{
						$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
					}
					//up_con/email
					$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
					
					
					$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>1,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>6,
					//抓全部user...
					
					//up 全部的projtask...
					
					$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
					//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
					foreach($tu_user as $tu_value):
						$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'noticefrom'=>1,
							'description'=>$mail_content
							);
						$e_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd);
						//get_calendar_id...ThanUP					
					endforeach;
					//
					//add_= =
					$cal_upd['noticefrom']=3;
					$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
					$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
					//up t_projnotice_id
					$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				else:
					//改狀態
					$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('projtasktype'=>6,'replystatus'=>1,'isconfirm'=>'Y','isfinish'=>'Y','finishdate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'confirmdate'=>date('Y-m-d H:i:s'))));
					
					$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
					//Record.
					
					//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
					foreach($tu_user as $tu_value):
						$cal_upd=array(
							'jec_projtask_id'=>$upd['jec_projtask_id'],
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$this->$cal_set['mm_set']->get_noticetype('cp_finish_Y'),
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
				endif;
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'rp_progress'://
				$gv=array("time_tag",'rp_time','content','toboss'); $gv=$this->CM->GPV($gv);
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				$file_ac='rp_finish';
				include('tools/common/upload_ac/rp_save_file.php');
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id);
				$this->CM->JS_TMsg($this->$projn_set['mm_set']->get_noticetype($df_ip['ac']));
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'sales_name'=>$sales_name,'description'=>$gv['content']);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);
				//
				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//check是否為強制
				//$task_set=$this->CM->Init_TB_Set('mm_task_set');
				//$task_data=$this->$task_set['mm_set']->get_task_row($projt_data['jec_task_id']);
				//add_record
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);
				
				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				//mail給super_user
					$email=array(
							'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
							'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
							'boss'=>$bossmail,
							'time'=>date('Y-m-d H:i:s'),
							'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
							'content'=>$mail_content,
							'emailsend'=>'N'
						);

									
					$upd=array(
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$df_ip['key_id'],
							'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
							'noticefrom'=>1,
							'jec_user_id'=>$projt_data['jec_usersuper_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'emailtime'=>$email['time'],
							'emailsubject'=>$email['subject'],
							'emailcontent'=>$email['content'],
							'emailsend'=>$email['emailsend'],
							'noticetime'=>date('Y-m-d H:i:s'),
							'jec_projreply_id'=>$projreply_id
						);
					$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
					//$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');

					//$email['content'].='<a href="'.$e_link.'">連結</a>';
					//不用回覆吧
					if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
						$email['emailsend']='Y';
					endif;	
					if($gv['toboss']=='Y')
					{
						$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
					}
					//up_con/email
					$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));					
					//$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('projtasktype'=>6,'replystatus'=>1,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));
					
					//-------------------To 督導END
					//抓全部user...
					
					//up 全部的projtask...
					/*
					$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
					//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
					foreach($tu_user as $tu_value):
						$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'noticefrom'=>1,
							'description'=>$mail_content
							);
						$e_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd);
						//get_calendar_id...ThanUP					
					endforeach;
					//
					//add_= =
					$cal_upd['noticefrom']=3;
					$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
					$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
					//up t_projnotice_id
					$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
					*/


                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;			
			case 'rp_adjust':
				
				$gv=array("time_tag",'rp_time','content','rp_adtime_enddate','rp_adtime_startdate','toboss'); $gv=$this->CM->GPV($gv);
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				include('tools/common/upload_ac/rp_save_file.php');
				//add_reply/add_workrecord/update_status/
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'new_date_period'=>$gv['rp_adtime_startdate'].'~'.$gv['rp_adtime_enddate']);
				
				
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'enddate'=>$gv['rp_adtime_enddate'],
						'startdate'=>$gv['rp_adtime_startdate'],
						'jec_projfile_id'=>implode('/',$up_file_array)
					);

				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//add_record
				$mail_data['sales_name']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				
				
				//->calendar
				//update....= =.OnlyUP_Status
				/*
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$upd=array(
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$cal_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1
					);
				$this->$cal_set['mm_set']->calendar_action($upd);*/
				
				
				//-Email
				//proj_notice

				//Send
				
				
				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
					
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'description'=>$mail_content,
							'noticefrom'=>1
						);
					
					$this->$cal_set['mm_set']->calendar_action($cal_upd);	//不存的話就新增= =					
				endforeach;
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
						
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>2,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>2,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'rp_transfer':
				$gv=array("time_tag",'rp_time','content','jec_usernew_id','toboss'); $gv=$this->CM->GPV($gv);
				
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				
				include('tools/common/upload_ac/rp_save_file.php');
				
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				if(substr($gv['jec_usernew_id'],0,1)=='G'):
					$jec_usernew_id=NULL;
					$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
				else:
					$jec_usernew_id=substr($gv['jec_usernew_id'],2);
					$jec_groupnew_id=NULL;
				endif;
				
				$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
				$sales_name=$this->QIM->get_final_sales_name($projt_data);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_usernew_id'=>$jec_usernew_id,
						'jec_groupnew_id'=>$jec_groupnew_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);

				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//add_record
				
				
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'description'=>$mail_content,
							'noticefrom'=>1
						);
					$this->$cal_set['mm_set']->calendar_action($cal_upd);						
				endforeach;
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增-
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>3,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>3,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'rp_adjust_transfer':
				$gv=array("time_tag",'rp_time','rp_adtime_startdate','rp_adtime_enddate','content','jec_usernew_id','toboss'); $gv=$this->CM->GPV($gv);
				
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				
				include('tools/common/upload_ac/rp_save_file.php');
				
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				if(substr($gv['jec_usernew_id'],0,1)=='G'):
					$jec_usernew_id=NULL;
					$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
				else:
					$jec_usernew_id=substr($gv['jec_usernew_id'],2);
					$jec_groupnew_id=NULL;
				endif;
				
				$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
				$sales_name=$this->QIM->get_final_sales_name($projt_data);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name,'new_date_period'=>$gv['rp_adtime_startdate'].'~'.$gv['rp_adtime_enddate']);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
								
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_usernew_id'=>$jec_usernew_id,
						'jec_groupnew_id'=>$jec_groupnew_id,
						'jec_projfile_id'=>implode('/',$up_file_array),
						'enddate'=>$gv['rp_adtime_enddate'],
						'startdate'=>$gv['rp_adtime_startdate']
					);

				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				
				//add_record
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'description'=>$mail_content,
							'noticefrom'=>1
						);
					$this->$cal_set['mm_set']->calendar_action($cal_upd);						
				endforeach;
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增-
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>3,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>3,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'rp_transfer_superuser':
				$gv=array("time_tag",'rp_time','content','jec_usernew_id','toboss'); $gv=$this->CM->GPV($gv);
				
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				
				include('tools/common/upload_ac/rp_save_file.php');
				
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				if(substr($gv['jec_usernew_id'],0,1)=='G'):
					$jec_usernew_id=NULL;
					$jec_groupnew_id=substr($gv['jec_usernew_id'],2);
				else:
					$jec_usernew_id=substr($gv['jec_usernew_id'],2);
					$jec_groupnew_id=NULL;
				endif;
				
				$new_sales_name=$this->QIM->get_final_sales_name(array('jec_user_id'=>$jec_usernew_id,'jec_group_id'=>$jec_groupnew_id));
				$sales_name=$this->QIM->get_final_super_name($projt_data);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'new_sales_name'=>$new_sales_name,'sales_name'=>$sales_name);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
											
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_usernew_id'=>$jec_usernew_id,
						'jec_groupnew_id'=>$jec_groupnew_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);

				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//add_record
				
				
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'description'=>$mail_content,
							'noticefrom'=>1
						);
					$this->$cal_set['mm_set']->calendar_action($cal_upd);						
				endforeach;
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增-
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>3,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>3,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;

			case 'rp_impossible':
				$gv=array("time_tag",'rp_time','content','toboss'); $gv=$this->CM->GPV($gv);
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				include('tools/common/upload_ac/rp_save_file.php');
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				$sales_name=$this->QIM->get_final_sales_name($projt_data);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'sales_name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id));
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);
				
				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
							'jec_project_id'=>$projt_data['jec_project_id'],
							'jec_projtask_id'=>$projt_data['jec_projtask_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'name'=>'',
							'description'=>$mail_content,
							'noticefrom'=>1
						);
					//$this->CM->JS_TMsg($tu_value['jec_user_id'].'-'.$projt_data['jec_projtask_id']);
					$this->$cal_set['mm_set']->calendar_action($cal_upd);						
				endforeach;
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('projtasktype'=>2,'replystatus'=>4,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
		
			case 'rp_pause':
				$gv=array("time_tag",'rp_time','content','rp_pause_startdate','rp_pause_enddate','toboss'); $gv=$this->CM->GPV($gv);
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				include('tools/common/upload_ac/rp_save_file.php');
				
                            //$day=(strtotime($projt_data['enddate'])-strtotime($projt_data['startdate']))/3600/24;
                            //$newdate=strtotime($gv['rp_pause_newdate']);                            
                            //$years = date("Y",$newdate); //用date()函式取得目前年份格式0000
                            //$months = date("m",$newdate); //用date()函式取得目前月份格式00
                            //$days = date("d",$newdate); //用date()函式取得目前日期格式00
                            //$enddate=date("Y-m-d",mktime(0,0,0,$months,$days+$day,$years));
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'sales_name'=>$sales_name,'new_date_period'=>$gv['rp_pause_startdate'].'~'.$gv['rp_pause_enddate']);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
                                          'startdate'=>$gv['rp_pause_startdate'],
                                          'enddate'=>$gv['rp_pause_enddate'],
						'jec_user_id'=>$this->ad_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);

				
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				//add_record
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
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
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>5,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>5,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'rp_recover':
				$gv=array("time_tag",'rp_time','content','toboss'); $gv=$this->CM->GPV($gv);
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				include('tools/common/upload_ac/rp_save_file.php');
				
				$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
				$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
				
				$sales_name=$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id);
				$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'sales_name'=>$sales_name);
				$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				
				$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'replystatus'=>$this->$projrp_set['mm_set']->get_replystatus($df_ip['ac']),
						'replytime'=>$gv['rp_time'],
						'description'=>$gv['content'],
						'jec_user_id'=>$this->ad_id,
						'jec_projfile_id'=>implode('/',$up_file_array)
					);
				$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);
				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
						'recordtime'=>date('Y-m-d H:i:s'),
						'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
						'description'=>$mail_content,
						'description2'=>$gv['content']
					);
				$this->$projr_set['mm_set']->record_action($upd);

				$deptid=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$projt_data['jec_user_id']);
				$boss=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$deptid);
				$bossmail=$this->GM->GetSpecData('jec_user','email','jec_user_id',$boss);
				$email=array(
						'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
						'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),
						'boss'=>$bossmail,
						'time'=>date('Y-m-d H:i:s'),
						'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
						'content'=>$mail_content,
						'emailsend'=>'N'
					);
									
				$upd=array(
						'jec_project_id'=>$projt_data['jec_project_id'],
						'jec_projtask_id'=>$df_ip['key_id'],
						'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
						'noticefrom'=>1,
						'jec_user_id'=>$projt_data['jec_usersuper_id'],
						'startdate'=>$projt_data['startdate'],
						'enddate'=>$projt_data['enddate'],
						'emailtime'=>$email['time'],
						'emailsubject'=>$email['subject'],
						'emailcontent'=>$email['content'],
						'emailsend'=>$email['emailsend'],
						'noticetime'=>date('Y-m-d H:i:s'),
						'jec_projreply_id'=>$projreply_id
					);
				$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
				$e_link=base_url('ecp_admin/index/work_confirm/'.$this->MEM->ReturnFinalCode($t_projnotice_id,'emsproj',1).'/'.$this->MEM->ReturnFinalCode($upd['jec_user_id'],'emsproj',1).'/');
				$email['content'].='<a href="'.$e_link.'">連結</a>';
				if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					$email['emailsend']='Y';
				endif;	
				if($gv['toboss']=='Y')
				{
					$this->CM->SendMailGo($bossmail,'',$email['subject'].'-回報主管',str_replace('，請確認','',$email['content']).'<br>內容:'.$gv['content'],'','From-System');
				}
					//up_con/email
				$this->GM->common_ac('update',array('info'=>$projn_set['mm_set'],'upt'=>'def','kid'=>$t_projnotice_id,'upd'=>array('emailcontent'=>$email['content'],'emailsend'=>$email['emailsend'])));
				
				$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
				//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
				foreach($tu_user as $tu_value):
					$cal_upd=array(
							'jec_user_id'=>$tu_value['jec_user_id'],
							'noticetype'=>$upd['noticetype'],
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
				$cal_upd['noticefrom']=3;
				$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
				$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
				$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));
				
				//adjust_projtask
				$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('replystatus'=>6,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));//'projtasktype'=>2,
				
				//back_to_list
                $ajo=array(
					'msg'=>'已回報',
					'bk_action'=>'after_reply',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'rp_cancel':
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($df_ip['key_id']);
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
				$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');

				$notice_id=$this->GM->GetSpecData('jec_projtask','jec_projnotice_id','jec_projtask_id',$projt_data['jec_projtask_id']);
				$upddata = array('jec_projnotice_id' => null,'replystatus'=>'0');
				$this->db->where('jec_projtask_id', $projt_data['jec_projtask_id']);
				$this->db->update('jec_projtask',$upddata);
				$reply_id=$this->GM->GetSpecData('jec_projnotice','jec_projreply_id','jec_projnotice_id',$notice_id);
				$calendar_id=$this->GM->GetSpecData('jec_projnotice','jec_calendar_id','jec_projnotice_id',$notice_id);
				
				$sql = "SELECT max(jec_projrecord_id) as jec_projrecord_id FROM `jec_projrecord` as a inner join jec_projnotice as b on  a.jec_projtask_id=b.jec_projtask_id where  b.jec_projnotice_id='".$notice_id."' and emailcontent like concat(a.description,'%')"; 
				$query = $this->db->query($sql);
				foreach ($query->result_array() as $row)
				{
				   $record_id=$row["jec_projrecord_id"];
				}
				log_message('info','rp_cancel:'. $record_id);
				$this->db->where('jec_projrecord_id', $record_id);
				$this->db->delete('jec_projrecord');
				$this->db->where('jec_projnotice_id', $notice_id);
				$this->db->delete('jec_projnotice');
				$this->db->where('jec_projreply_id', $reply_id);
				$this->db->delete('jec_projreply');
				$this->db->where('jec_calendar_id', $calendar_id);
				$this->db->delete('jec_calendar');
				
                $ajo=array(
					'msg'=>'已取消回報',
					'bk_action'=>'after_cancel',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 

			break;
			case 'check_rp_update'://確認User....= =
				//cus_name - 
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					/*
					case 'update_task_go':
						$gv=array('sales_name','super_name','no');
						break;*/
					default:
						$gv=array('sales_name','toboss');
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
							$msg='查無移轉對象';
						endif;

					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>$bk_action,
					'isexist'=>$pass,
					'rp_url'=>$_POST['rp_url'],
                    'pass'=>1,
					'toboss'=>$gv['toboss']
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
			case 'check_rp_update_super'://確認User....= =
				//cus_name - 
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					/*
					case 'update_task_go':
						$gv=array('sales_name','super_name','no');
						break;*/
					default:
						$gv=array('sales_name','toboss');
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
					'rp_url'=>$_POST['rp_url'],
                    'pass'=>1,
					'toboss'=>$gv['toboss']
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
?>