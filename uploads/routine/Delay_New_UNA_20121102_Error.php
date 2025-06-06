<?php

$projtask_list=$this->db->where('projtasktype',2)->where('replystatus',0)->where_not_in('projstatus',4)->where('isactive','Y')->get('jec_projtask_search_view')->result_array();

//
	$this->load->model('Mm_encode_model', 'MEM');
	$this->load->model('Quick_info_model','QIM',TRUE);
		$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
		$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
		$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
		$proj_set=$this->CM->Init_TB_Set('mm_project_set');
		$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
		$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
	$mail_db=array();	
	$delay_dup_db=array();//st(task_id=>sv-user_id);
	
foreach($projtask_list as $value):
	if(!isset($delay_dup_db[$value['jec_projtask_id']])) $delay_dup_db[$value['jec_projtask_id']]=array();
	$projt_data=$value;
	if(strtotime($value['enddate'])<time())://$value['isdelay']=='Y'||
		//status2-2.逾期工作
		//count delay_days /daydelay
		$this->CM->JS_TMsg('Delay-'.$value['jec_projtask_id']);
		$xx=time()-strtotime($value['enddate']);
		$delay_days=floor($xx/60/60/24);	
		if($delay_days==0) continue;	
		//update_delaydays
		$this->db->where('jec_projtask_id',$projt_data['jec_projtask_id'])->update('jec_projtask',array('delaydate'=>$delay_days,'isdelay'=>'Y'));
		//先send給承辦人 - 
		$projt_data=$value;
		
		if($delay_days>$projt_data['daydelay']): //超過允許的
			$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//		
			$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);	
			$df_ip['ac']='delay';
			$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);	
			$sales_name=$this->QIM->get_final_sales_name($projt_data);
			$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'delay_days'=>$delay_days);
			$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
			//count-Normal
			$span_days=$delay_days-$projt_data['daydelay'];
			
			$sales_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BA');//
			$sales_pd=$sales_per_day==1?1:$span_days%$sales_per_day;
			$dpm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BB');//部門主管
			$dpm_pd=$dpm_per_day==1?1:$span_days%$dpm_per_day;
			$upm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BC');//上級主管
			$upm_pd=$upm_per_day==1?1:$span_days%$upm_per_day;
			$tpm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BD');//最高主管
			$tpm_pd=$tpm_per_day==1?1:$span_days%$tpm_per_day;
			
			$dpm_user_id=0;
			$upm_user_id=0;
			$tpm_user_id=0;
			
			if($sales_pd==1||$dpm_pd==1||$upm_pd==1||$tpm_pd==1):
				if((int)$projt_data['jec_user_id']>0):
					$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
				else:
					$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
				endif;	
				foreach($tu_user as $tu_value):
					if($sales_pd==1)://send saler
							//Send - 
						if(isset($mail_db[$tu_value['jec_user_id']])):
							$mailto=$mail_db[$tu_value['jec_user_id']];
						else:
							$mailto=$this->QIM->get_user_row($tu_value['jec_user_id']);
							$mail_db[$tu_value['jec_user_id']]=$mailto;
						endif;
						if(!in_array($mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
							array_push($delay_dup_db[$value['jec_projtask_id']],$mailto['jec_user_id']);
							
							
							$e_link=base_url('ecp_admin/index/work_report/'.$this->MEM->ReturnFinalCode($value['jec_projtask_id'],'emsproj',1).'/'.$this->MEM->ReturnFinalCode($tu_value['jec_user_id'],'emsproj',1).'/'); //to承辦的
			
							
				
							$email=array(
								'name'=>$mailto['name'],
								'to'=>$mailto['email'],
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),
								'content'=>$mail_content,
								'emailsend'=>'N'
								);

							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate']
								);
							$email['content'].='<a href="'.$e_link.'">連結</a>';	
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							
							$n_upd=array(
									'emailsend'=>$email['emailsend'],
									'emailcontent'=>$email['content']
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							$this->db->where('jec_projnotice_id',$t_projnotice_id)->update('jec_projnotice',$n_upd);
							
							
							//$this->CM->JS_TMsg('Before_Record_'.$value['jec_projtask_id'].'_'.$df_ip['ac']);
							//record
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
							//$this->CM->JS_TMsg('After_Record_'.$value['jec_projtask_id']);
						endif;
					endif;
					
					if($dpm_pd==1)://send  部門
						//Dont Dup
						$dpm_user_id=$this->QIM->get_dept_mng_id($mailto['jec_dept_id']);
						//$this->CM->JS_TMsg($dpm_user_id);
						if((int)$dpm_user_id>0):
							if(isset($mail_db[$dpm_user_id])):
								$dpm_mailto=$mail_db[$dpm_user_id];
							else:
								$dpm_mailto=$this->QIM->get_user_row($dpm_user_id);
								$mail_db[$dpm_user_id]=$dpm_mailto;
							endif;
							$df_mailto=$dpm_mailto;
						
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
						
					endif;
					
					if($upm_pd==1)://send  上級
						//Dont Dup
						$upm_user_id=$this->QIM->get_dept_up_mng_id($mailto['jec_dept_id']);
						if((int)$upm_user_id>0):
							if(isset($mail_db[$upm_user_id])):
								$upm_mailto=$mail_db[$upm_user_id];
							else:
								$upm_mailto=$this->QIM->get_user_row($upm_user_id);
								$mail_db[$upm_user_id]=$upm_mailto;
							endif;						
							$df_mailto=$upm_mailto;
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
						
					endif;	
									
					if($tpm_pd==1)://send  最高
						//Dont Dup
						$tpm_user_id=$this->QIM->get_dept_top_mng_id($mailto['jec_dept_id']);
						if((int)$tpm_user_id>0):
							if(isset($mail_db[$tpm_user_id])):
								$tpm_mailto=$mail_db[$tpm_user_id];
							else:
								$tpm_mailto=$this->QIM->get_user_row($tpm_user_id);
								$mail_db[$tpm_user_id]=$tpm_mailto;
							endif;	
						
							$df_mailto=$tpm_mailto;
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
					endif;	
									
				endforeach;
				
				//super另寄
				if($sales_pd==1)://Addsuper
					
					if(isset($mail_db[$value['jec_usersuper_id']])):
						$sup_mailto=$mail_db[$value['jec_usersuper_id']];
					else:
						$sup_mailto=$this->QIM->get_user_row($value['jec_usersuper_id']);
						$mail_db[$value['jec_usersuper_id']]=$sup_mailto;
					endif;
					$df_mailto=$sup_mailto;
					if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
						array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
						include('tools/common/mail/mail_ac_nolink.php');
					endif;
					
					if($value['processtype']==1)://mail project_mng-重要傳給專案管理人
						
						$projn_noticetype=3;
						$mail_data['noticetype']=$projn_noticetype;
						$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);//change
						//$value['proj_jec_user_id']
						if(isset($mail_db[$value['proj_jec_user_id']])):
							$proj_mailto=$mail_db[$value['proj_jec_user_id']];
						else:
							$proj_mailto=$this->QIM->get_user_row($value['proj_jec_user_id']);
							$mail_db[$value['proj_jec_user_id']]=$proj_mailto;
						endif;
						
						$df_mailto=$proj_mailto;
						//$this->CM->JS_TMsg($df_mailto['jec_user_id']);
						include('tools/common/mail/mail_ac_nolink.php');
					endif;
				endif;
			endif;
			
			
			
			
			

			
		//DDDD
		/*
			if($value['processtype']==1)://$delay_days>$value['daydelay']&&noticetype->3
				//為警示
				$tu_value['jec_user_id']=$value['proj_jec_user_id'];
				//array_push($tu_user,array('jec_user_id'=>$value['proj_jec_user_id']));
					$this->CM->JS_TMsg('Before_SendEmail_'.$value['jec_projtask_id']);
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticetype'=>3,//Spec-3 系統警示通知
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate']
								);
							//$this->CM->JS_TMsg('Before_SaveEmailNotice_'.$value['jec_projtask_id']);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							$email['content'].='<br><a href="'.$e_link.'">連結</a>';
							$n_upd=array(
									'emailsend'=>$email['emailsend'],
									'emailcontent'=>$email['content']
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							$this->db->where('jec_projnotice_id',$t_projnotice_id)->update('jec_projnotice',$n_upd);
							
							//$this->CM->JS_TMsg('Before_SaveEmailRecord_'.$value['jec_projtask_id']);
							//record-
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
			endif;
			$this->CM->JS_TMsg('Delay_End_'.$value['jec_projtask_id']);*/
			
			
		endif;
	else:
		//status1-待辦通知 
		
		$starttime=strtotime($value['startdate']);
		$compare_date=date('Y-m-d',mktime(date('H',$starttime),date('i',$starttime),date('s',$starttime),date('m',$starttime),date('d',$starttime)-$value['taskdaynotice'],date('Y',$starttime)));//taskdaynotice
		$informtime=date('Y-m-d',strtotime($value['noticetime']));
		

		if($compare_date==date('Y-m-d')&&$informtime!=date('Y-m-d')&&$value['isnotice']=='N')://且尚未通知??判定方式->暫用當天日期判定
			$df_ip['ac']='1';
			$this->CM->JS_TMsg('wain_'.$value['jec_projtask_id']);
			$projn_noticetype=1;
			$sales_name=$this->QIM->get_final_sales_name($projt_data);
			$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'date_period'=>substr($value['startdate'],0,10).'~'.substr($value['enddate'],0,10));
			$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
			
			
			if((int)$projt_data['jec_user_id']>0):
				$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
			else:
				$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
			endif;
			
			//Send-Email=>可直接登入
			//先存日曆-->通知->工作紀錄 
			
			//1.待辦工作通知
			
			foreach($tu_user as $tu_value):
				$upd=array(
					'noticefrom'=>1,
					'jec_project_id'=>$value['jec_project_id'],
					'jec_projtask_id'=>$value['jec_projtask_id'],
					'noticetype'=>1,
					'jec_user_id'=>$tu_value['jec_user_id'],
					'description'=>$mail_content
					);	
			//check_cal_exist
				$cal_exist=$this->db->where('jec_project_id',$value['jec_project_id'])->where('jec_projtask_id',$value['jec_projtask_id'])->where('noticefrom',1)->where('jec_user_id',$tu_value['jec_user_id'])->get('jec_calendar')->result_array();
				if(count($cal_exist)>0):
					$cal_id=$cal_exist['jec_calendar_id'];
					$this->db->where('jec_calendar_id',$cal_id)->update('jec_calendar',$upd);
				else:
					$this->db->insert('jec_calendar',$upd);
					$cal_id=mysql_insert_id();
				endif;		
			//新增通知紀錄-.
				
				$e_link=base_url('ecp_admin/index/work_report/'.$this->MEM->ReturnFinalCode($value['jec_projtask_id'],'emsproj',1).'/'.$this->MEM->ReturnFinalCode($tu_value['jec_user_id'],'emsproj',1).'/');
				
							$email=array(
								'name'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']),
								'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),
								'content'=>$mail_content.'<a href="'.$e_link.'">連結</a>',
								'emailsend'=>'N'
								);
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
			//email
			
			
				$upd=array(
					'noticefrom'=>1,
					'jec_project_id'=>$value['jec_project_id'],
					'jec_projtask_id'=>$value['jec_projtask_id'],
					'jec_calendar_id'=>$cal_id,
					'noticetype'=>1,
					'noticetime'=>date('Y-m-d H:i:s'),
					'jec_user_id'=>$tu_value['jec_user_id'],
					'startdate'=>$projt_data['startdate'],
					'enddate'=>$projt_data['enddate'],
					'emailtime'=>$email['time'],
					'emailsubject'=>$email['subject'],
					'emailcontent'=>$email['content'],
					'emailsend'=>$email['emailsend'],
					);//+email內容
				$this->db->insert('jec_projnotice',$upd);
			//新增工作紀錄--
				$upd=array(
					'jec_project_id'=>$value['jec_project_id'],
					'jec_projtask_id'=>$value['jec_projtask_id'],
					'recordtype'=>1,
					'recordtime'=>date('Y-m-d H:i:s'),
					'jec_user_id'=>$tu_value['jec_user_id'],
					'description'=>$mail_content
					);
				$this->db->insert('jec_projrecord',$upd);
			endforeach;

			//
			//update
			$this->db->where('jec_projtask_id',$value['jec_projtask_id'])->update('jec_projtask',array('isnotice'=>'Y'));
		endif; 
	endif;
endforeach;
$this->CM->JS_TMsg('@@@');
?>

