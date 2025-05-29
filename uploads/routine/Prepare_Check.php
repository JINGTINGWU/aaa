<?php
/*
12.開始前工作檢核通知
13.完成前工作檢核通知
 加setup.
$專案名稱$-$工作名稱$-$承辦人員$-$開始日期$-工作開始前尚未完成$檢核表開始前的工作名稱$ //
*/
$projtask_list=$this->db->where('projtasktype',2)->where('startdate',date('Y-m-d 00:00:00'))->where('jec_task_id >',0)->where_not_in('projstatus',4)->where('isactive','Y')->group_by('jec_project_id,jec_task_id')->get('jec_projtask_search_view')->result_array();//GROUP BY jec_task_id
$check_info=array();
$mail_pdb=$this->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
$projn_noticetype=12;	
$mail_db=array();	
$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
	
foreach($projtask_list as $value):
	//Check_work_finish- //-> 1
	$projt_data=$value;
	$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);
	if(!isset($check_info[$value['jec_task_id']])):
		$check_data=$this->db->where('jec_task_id',$value['jec_task_id'])->where('isactive','Y')->get('jec_taskcheck')->result_array();
		$check_info[$value['jec_task_id']]=$this->CM->FormatData(array('db'=>$check_data,'key'=>'jec_task_check_id'),'page_db','s_array');
	endif;
	$check_array=$check_info[$value['jec_task_id']];
	
	$e_wi=$this->CM->FormatData($check_array,'page_db','wi');
	$check_sql="SELECT jec_projtask_id FROM jec_projtask WHERE jec_project_id='".$value['jec_project_id']."' AND isfinish='N' AND jec_task_id IN (".$e_wi.") AND isactive='Y'";
	$check_num=$this->db->query($check_sql)->num_rows();
	//$this->CM->JS_TMsg($check_num);
	if($check_num>0)://Add Notice 
		$sales_name=$this->QIM->get_final_sales_name($value);
		$mail_data=array('proj_name'=>$value['proj_name'],'task_name'=>$value['taskname'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'check_name'=>'','startdate'=>$value['startdate']);//
		$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
		
		//Please Add Notice.- Send Email-
				if($value['proj_jec_user_id']==$value['jec_usersuper_id']):
					$tu_user=array($value['jec_usersuper_id']);
				else:
					$tu_user=array($value['proj_jec_user_id'],$value['jec_usersuper_id']);
				endif;
				/*
		$tu_user=array($value['proj_jec_user_id'],$value['jec_usersuper_id']);
		$tu_user=array_unique($tu_user);*/
			//
				foreach($tu_user as $value):
					$tu_value['jec_user_id']=$value;
						if(isset($mail_db[$tu_value['jec_user_id']])):
							$mailto=$mail_db[$tu_value['jec_user_id']];
						else:
							$mailto=$this->QIM->get_user_row($tu_value['jec_user_id']);
							$mail_db[$tu_value['jec_user_id']]=$mailto;
						endif;

							
							
							//$e_link=base_url('ecp_admin/index/work_report/'.$this->MEM->ReturnFinalCode($value['jec_projtask_id'],'emsproj',1).'/'.$this->MEM->ReturnFinalCode($tu_value['jec_user_id'],'emsproj',1).'/'); //to承辦的
			
							
					  //$this->CM->JS_TMsg($mailto['name']);
							$email=array(
								'name'=>$mailto['name'],
								'to'=>$mailto['email'],
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($projn_noticetype),//$value['proj_name'].'-'.$projj_data['name'].'-'.$value['taskname'].'-'.
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
							//$email['content'].='<a href="'.$e_link.'">連結</a>';	
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
								'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($projn_noticetype),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
							//$this->CM->JS_TMsg('After_Record_'.$value['jec_projtask_id']);

									
				endforeach;
	endif;
	
	//  
endforeach;


//$this->CM->JS_TMsg(count($projtask_list));
?>
