<?php
        switch($df_ip['ac']):
            case 'list': 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['list_url']=base_url($final['var_purl'].'adjusttask_list_index/list_div/'.$df_ip['key_id'].'/');
				$final['adjust_date_url']=base_url($final['var_purl'].$df_ip['tag'].'/rp_adjust/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='adjusttask_list_index';
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
				$final['assign_view']='adjusttask_list_div';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['resda020_pdb']=$this->$_G['L_CS']->resda020_info;
				$final['resda021_pdb']=$this->$_G['L_CS']->resda021_info;	
										
				$task_list=$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_projtask_search_view')->result_array();
				$final['total_item']=count($task_list);			
			break;
			case 'rp_adjust':
				$gv=array('task_string','adjustday'); $gv=$this->CM->GPV($gv);
				$final['task_array']=explode('-',$gv['task_string']);
				foreach($final['task_array'] as $taskid):
					if($taskid>0):
						$task_data=$this->db->where('jec_projtask_id',$taskid)->get('jec_projtask_search_view')->result_array();
						if($task_data[0]['isnotice']=='Y'):
							$startdate=substr($task_data[0]['startdate'],0,10);
							$enddate=substr($task_data[0]['enddate'],0,10);
							$enddate=date("Y-m-d", strtotime($enddate."+".$gv['adjustday']." day"));
						else:
							$startdate=substr($task_data[0]['startdate'],0,10);
							$startdate=date("Y-m-d", strtotime($startdate."+".$gv['adjustday']." day"));
							$enddate=substr($task_data[0]['enddate'],0,10);
							$enddate=date("Y-m-d", strtotime($enddate."+".$gv['adjustday']." day"));
						endif;
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

							$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']),'new_date_period'=>$startdate.'~'.$enddate);
							//add reply
							$projrp_set=$this->CM->Init_TB_Set('mm_projreply_set');
							$upd=array(
							'jec_project_id'=>$df_ip['key_id'],
							'jec_projtask_id'=>$taskid,
							'replystatus'=>'2',
							'replytime'=>date("Y-m-d H:i:s"),
							'description'=>'批次展期',
							'jec_user_id'=>$this->ad_id,
							'enddate'=>$enddate,
							'startdate'=>$startdate							
							);				
							$projreply_id=$this->$projrp_set['mm_set']->reply_action($upd);							
							//add record							
							$mail_data['sales_name']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_user_id']);
							$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
							$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
							'jec_project_id'=>$df_ip['key_id'],
							'jec_projtask_id'=>$taskid,
							'recordtype'=>'5',
							'recordtime'=>date('Y-m-d H:i:s'),
							'jec_user_id'=>$this->ad_id,//$projt_data['jec_usersuper_id']
							'description'=>$mail_content,
							'description2'=>'批次展期'
							);
							$this->$projr_set['mm_set']->record_action($upd);
							//add notice
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
							'description'=>'批次展期',
							'noticetime'=>date('Y-m-d H:i:s'),
							'jec_projreply_id'=>$projreply_id
							);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//add calendar
							$tu_user=$this->$projt_set['mm_set']->get_jec_user_list($projt_data);
							//$tu_user=$this->$cal_set['mm_set']->get_cal_by_projtask($projt_data['jec_projtask_id']);
							foreach($tu_user as $tu_value):
								$cal_upd=array(
								'jec_user_id'=>$tu_value['jec_user_id'],
								'noticetype'=>$upd['noticetype'],
								'jec_project_id'=>$df_ip['key_id'],
								'jec_projtask_id'=>$taskid,
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'name'=>'',
								'description'=>$mail_content,
								'noticefrom'=>1
								);
								//批次不存calendar				
								//$this->$cal_set['mm_set']->calendar_action($cal_upd);	//不存的話就新增= =					
							endforeach;
							$cal_upd['noticefrom']=3;
							$cal_upd['jec_user_id']=$projt_data['jec_usersuper_id'];//Super
							//批次不存calendar
							//$t_calendar_id=$this->$cal_set['mm_set']->calendar_action($cal_upd,'new');//新增
							//$this->db->where($projn_set['mm_kid'],$t_projnotice_id)->update($projn_set['mm_tb'],array('jec_calendar_id'=>$t_calendar_id));						
							//adjust_projtask
							$this->GM->common_ac('update',array('info'=>$projt_set['mm_set'],'upt'=>'def','kid'=>$taskid,'upd'=>array('replystatus'=>2,'isconfirm'=>'N','noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id)));
							
					endif;
				endforeach;	
				//back_to_list
							$refresh_url=base_url($final['var_purl'].'adjusttask_list_index/list/'.$df_ip['key_id'].'/');
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