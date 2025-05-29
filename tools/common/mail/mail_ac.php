<?php
							$email=array(
								'name'=>$df_mailto['name'],
								'to'=>$df_mailto['email'],
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'content'=>$mail_content,
								'emailsend'=>'N'
								);

							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$df_mailto['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate']
								);
								
							if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							//$email['content'].='<br><a href="'.$e_link.'">連結</a>';
							$n_upd=array(
									'emailsend'=>$email['emailsend'],
									'emailcontent'=>$email['content']
								);
							//$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//$this->db->where('jec_projnotice_id',$t_projnotice_id)->update('jec_projnotice',$n_upd);
							
							
							//$this->CM->JS_TMsg('Before_Record_'.$value['jec_projtask_id'].'_'.$df_ip['ac']);
							//record
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'recordtype'=>$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac']),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$df_mailto['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
							
?>