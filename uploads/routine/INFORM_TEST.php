<?php

$projtask_list=$this->db->where('projtasktype',2)->where('replystatus',0)->where('isactive','Y')->get('jec_projtask_search_view')->result_array();

//
		$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
		$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
		$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
		$proj_set=$this->CM->Init_TB_Set('mm_project_set');
		$setup_set=$this->CM->Init_TB_Set('mm_setup_set');
		$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
		
foreach($projtask_list as $value):
	$projt_data=$value;
	if(strtotime($value['enddate'])<time())://$value['isdelay']=='Y'||
		//status2-2.逾期工作
		//count delay_days /daydelay
		//$this->CM->JS_TMsg('@@');
		$xx=time()-strtotime($value['enddate']);
		$delay_days=floor($xx/60/60/24);
		//update_delaydays
		$this->db->where('jec_projtask_id',$projt_data['jec_projtask_id'])->update('jec_projtask',array('delaydate'=>$delay_days,'isdelay'=>'Y'));
		//先send給承辦人 - 
		$projt_data=$value;
		
		if((int)$projt_data['jec_user_id']>0):
			$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
		else:
			$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
		endif;
		
		if($delay_days>$projt_data['daydelay']):
			//send super_vision
			array_push($tu_user,array('jec_user_id'=>$projt_data['jec_usersuper_id']));
			//if import->Send project incharge
		endif;

		$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//		
		$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);	
		$df_ip['ac']='delay';
		$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);
		
		$sales_name=$this->QIM->get_final_sales_name($projt_data);
		$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'delay_days'=>$delay_days);
		$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
						
		//$this->CM->JS_TMsg(count($tu_user));
		foreach($tu_user as $tu_value):
			//eamil
							//-Email-
							//proj_notice

							//Send - 
				
			
							
				
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
							$this->$projn_set['mm_set']->notice_action($upd);
							$this->CM->JS_TMsg('@@'.$tu_value['jec_user_id']);
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
			
			//calendar-change_status 
		endforeach;
		//DDDD
			if($delay_days>$value['daydelay']&&$value['processtype']==1):
				$tu_value['jec_user_id']=$value['proj_jec_user_id'];
				//array_push($tu_user,array('jec_user_id'=>$value['proj_jec_user_id']));
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
							$this->$projn_set['mm_set']->notice_action($upd);
						
							//record-
							
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$df_ip['key_id'],
								'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
			endif;
			
	else:
		//status1-待辦通知 
		
		$starttime=strtotime($value['startdate']);
		$compare_date=date('Y-m-d',mktime(date('H',$starttime),date('i',$starttime),date('s',$starttime),date('m',$starttime),date('d',$starttime)-$value['daynotice'],date('Y',$starttime)));
		$informtime=date('Y-m-d',strtotime($value['noticetime']));

		
		if($compare_date==date('Y-m-d')&&$informtime!=date('Y-m-d')&&$value['isnotice']=='N')://且尚未通知??判定方式->暫用當天日期判定
		
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
					'emailcontent'=>$mail_content
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

