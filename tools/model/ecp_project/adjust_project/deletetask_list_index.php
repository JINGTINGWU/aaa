<?php
        switch($df_ip['ac']):
            case 'list': 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['list_url']=base_url($final['var_purl'].'deletetask_list_index/list_div/'.$df_ip['key_id'].'/');
				$final['delete_date_url']=base_url($final['var_purl'].$df_ip['tag'].'/rp_impossible/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='deletetask_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);				
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				
				$task_list=$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projtask_search_view')->result_array();
				$final['total_item']=count($task_list);			
				
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'project_adjust_index'=>base_url($final['var_purl'].'project_adjust_index/list/'.$df_ip['key_id'].'/'),
						'adjusttask_list_index'=>base_url($final['var_purl'].'adjusttask_list_index/list/'.$df_ip['key_id'].'/'),
						'deletetask_list_index'=>base_url($final['var_purl'].'deletetask_list_index/list/'.$df_ip['key_id'].'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/')
					);
            break;
			case 'list_div':
				$final['assign_view']='deletetask_list_div';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['resda020_pdb']=$this->$_G['L_CS']->resda020_info;
				$final['resda021_pdb']=$this->$_G['L_CS']->resda021_info;	
										
				$task_list=$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projtask_search_view')->result_array();
				$final['total_item']=count($task_list);			
			break;
			case 'rp_impossible':
				$gv=array('task_string'); $gv=$this->CM->GPV($gv);
				$final['task_array']=explode('-',$gv['task_string']);
				foreach($final['task_array'] as $taskid):
					if($taskid>0):
						$task_data=$this->db->where('jec_projtask_id',$taskid)->get('jec_projtask_search_view')->result_array();
						
							$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
							$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
							$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
							$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($taskid);
							$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
							$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
							$proj_set=$this->CM->Init_TB_Set('mm_project_set');
							$proj_data=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
							$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
							
							$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
							$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);

							$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']));
							//add reply
							$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
							$upd=array(
							'jec_project_id'=>$df_ip['key_id'],
							'jec_projtask_id'=>$taskid,
							'replystatus'=>'4',
							'replytime'=>date("Y-m-d H:i:s"),
							'description'=>'批次刪除',
							'jec_user_id'=>$this->ad_id													
							);				
							$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);							
							//add record							
							$mail_data['sales_name']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_user_id']);
							$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
							$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
							'jec_project_id'=>$df_ip['key_id'],
							'jec_projtask_id'=>$taskid,
							'recordtype'=>'7',
							'recordtime'=>date('Y-m-d H:i:s'),
							'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
							'description'=>$mail_content,
							'description2'=>'批次刪除'
							);
							$this->$projr_set['mm_set']->record_action($upd);							
							//add notice
							$mail_data['sales_name']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_user_id']);
							$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);

							$email=array(
							'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id']),
							'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$projt_data['jec_usersuper_id']),							
							'time'=>date('Y-m-d H:i:s'),
							'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),	//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
							'content'=>$mail_content,
							'emailsend'=>'N'
							);

							$upd=array(
							'jec_project_id'=>$df_ip['key_id'],
							'jec_projtask_id'=>$taskid,
							'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),
							'noticefrom'=>1,
							'jec_user_id'=>$projt_data['jec_usersuper_id'],
							'startdate'=>$projt_data['startdate'],
							'enddate'=>$projt_data['enddate'],
							'emailtime'=>$email['time'],
							'emailsubject'=>$email['subject'],
							'emailcontent'=>$email['content'],
							'emailsend'=>$email['emailsend'],
							'description'=>'批次刪除',
							'noticetime'=>date('Y-m-d H:i:s'),
							'jec_projreply_id'=>$projreply_id
							);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
										
							//adjust_projtask
							$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$taskid,'upd'=>array('replystatus'=>2,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));
							
					endif;
				endforeach;	
				//back_to_list
							$refresh_url=base_url($final['var_purl'].'deletetask_list_index/list/'.$df_ip['key_id'].'/');
							$msg="已批次回報";
						if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) $msg=iconv('utf-8','big5',$msg);
                			?><script>
                	parent.ECP_Msg('<?=$msg?>',999);
					function PG_Refresh(){
							parent.location.href="<?php echo $refresh_url;?>";
						}
						setTimeout("PG_Refresh()", 1500 );
                </script><?php
			break;
        endswitch;
?>