<?php
set_time_limit(0);
$projtask_list=$this->db->where('projtasktype',2)->where_not_in('projstatus',4)->where('isactive','Y')->where('user_isactive','Y')->get('jec_projtask_search_view')->result_array();

//$fp=fopen('uploads/routine/delay_'.date('Y-m-d-H-i-s').'.txt','a+');	 // Debug

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
	$sumMailContent=array();
foreach($projtask_list as $value):
	if(!isset($delay_dup_db[$value['jec_projtask_id']])) $delay_dup_db[$value['jec_projtask_id']]=array();
	$projt_data=$value;
	if(strtotime($value['enddate'])<time())://$value['isdelay']=='Y'||
		//status2-2.逾期工作
		//count delay_days /daydelay
		//$this->CM->JS_TMsg('Delay-'.$value['jec_projtask_id']);
		$xx=time()-strtotime($value['enddate']);		
		$delay_days=floor($xx/60/60/24);
		//fwrite($fp, $delay_days."-");  // Debug
		if($delay_days==0) continue;	
		//update_delaydays
		$this->db->where('jec_projtask_id',$projt_data['jec_projtask_id'])->update('jec_projtask',array('delaydate'=>$delay_days,'isdelay'=>'Y'));
		//先send給承辦人 - 
		if($delay_days>$projt_data['daydelay']): //是否超過允許的延遲天數
			$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//		
			$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);	
			$df_ip['ac']='delay';
			$projn_noticetype=$this->$projn_set['mm_set']->get_noticetype($df_ip['ac']);	
			$sales_name=$this->QIM->get_final_sales_name($projt_data);
			$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'delay_days'=>$delay_days);
			$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
                        $mail_contentTable=$this->$projn_set['mm_set']->get_mail_contentTable($mail_pdb,$mail_data['noticetype'],$mail_data);
			$tmpMail_content=$mail_content;
			//count-Normal
			$span_days = $delay_days - intval($projt_data['daydelay']);//系統允許的延遲天數
			//取得系統參數設定
			$sales_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BA');//自己
			//$sales_pd=$sales_per_day==1?1:$span_days%$sales_per_day;  // 有BUG, 第1天就會全部都通知了
			if ($sales_per_day == 1)  // Update by Johnson 2012/12/08
				$sales_pd = 1;
			elseif ($span_days < $sales_per_day)
				$sales_pd = 0;
			else
				$sales_pd = $span_days%$sales_per_day;
			
			$dpm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BB');//部門主管
			//$dpm_pd=$dpm_per_day==1?1:$span_days%$dpm_per_day;  // 有BUG, 第1天就會全部都通知了
			if ($dpm_per_day == 1)  // Update by Johnson 2012/12/08
				$dpm_pd = 1;
			elseif ($span_days < $dpm_per_day)
				$dpm_pd = 0;
			else
				$dpm_pd = $span_days%$dpm_per_day;
			
			$upm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BC');//上級主管
			//$upm_pd=$upm_per_day==1?1:$span_days%$upm_per_day;  // 有BUG, 第1天就會全部都通知了
			if ($upm_per_day == 1)  // Update by Johnson 2012/12/08
				$upm_pd = 1;
			elseif ($span_days < $upm_per_day)
				$upm_pd = 0;
			else
				$upm_pd = $span_days%$upm_per_day;
			
			$tpm_per_day=$this->GM->GetSpecData('jec_setup','value','noticetype','BD');//最高主管
			//$tpm_pd=$tpm_per_day==1?1:$span_days%$tpm_per_day;  // 有BUG, 第1天就會全部都通知了
			if ($tpm_per_day == 1)  // Update by Johnson 2012/12/08
				$tpm_pd = 1;
			elseif ($span_days < $tpm_per_day)
				$tpm_pd = 0;
			else
				$tpm_pd = $span_days%$tpm_per_day;
			
			$dpm_user_id=0;
			$upm_user_id=0;
			$tpm_user_id=0;
			
			//fwrite($fp, "Begin projtask: ".$projt_data['jec_projtask_id']."/".$sales_pd."/".$dpm_pd."/".$upm_pd."/".$tpm_pd."\r\n");  // Debug
					
			if($sales_pd==1||$dpm_pd==1||$upm_pd==1||$tpm_pd==1):
				
				if((int)$projt_data['jec_user_id']>0):
					$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
				else:
					$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
				endif;	
				foreach($tu_user as $tu_value):
					if($sales_pd==1)://send saler
						$mail_content=$tmpMail_content.'(通知負責人員)';
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
			
							$sumMailContent[$mailto['name'].':'.$mailto['email']][0].=$mail_contentTable.'<td><a href="'.$e_link.'">工作連結</a></td></tr>';
							$sumMailContent[$mailto['name'].':'.$mailto['email']][1]=$sumMailContent[$mailto['name'].':'.$mailto['email']][1]+1;
                                                        $sumMailContent[$mailto['name'].':'.$mailto['email']][2]=$mailto['jec_dept_id'];
                                                        
                                                        $email=array(
								'name'=>$mailto['name'],
								'to'=>$mailto['email'],
								'time'=>date('Y-m-d H:i:s'),
								//'subject'=>str_replace('履約管制系統-','履約管制系統-個人-',$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'])),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
								'subject'=>$mail_content,
								'content'=>$mail_content,
								'emailsend'=>'N'
								);
							//要回全部耶…	
							//fwrite($fp, "Begin 自己:".$tu_value['jec_user_id']."\r\n");  // Debug		
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
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->$projr_set['mm_set']->record_action($upd);
							//$this->CM->JS_TMsg('After_Record_'.$value['jec_projtask_id']);
						endif;
					endif;
					
					//$this->CM->JS_TMsg('Begin projtask:'.$projt_data['jec_projtask_id'].'/'.$dpm_pd.'/'.$upm_pd.'/'.$tpm_pd);  // Debug
					
					if($dpm_pd==1)://send  部門主管
						$mail_content=$tmpMail_content.'(通知部門主管)';
						//Dont Dup
						$dpm_user_id=$this->QIM->get_dept_mng_id($mailto['jec_dept_id']);
						//$this->CM->JS_TMsg('Begin dept manager1:'.$dpm_user_id);  // Debug
						//fwrite($fp, "Begin 部門 1:".$dpm_user_id."\r\n");  // Debug
						//$this->CM->JS_TMsg($dpm_user_id);
						if((int)$dpm_user_id>0):
							if(isset($mail_db[$dpm_user_id])):
								$dpm_mailto=$mail_db[$dpm_user_id];
							else:
								$dpm_mailto=$this->QIM->get_user_row($dpm_user_id);
								$mail_db[$dpm_user_id]=$dpm_mailto;
							endif;
							$df_mailto=$dpm_mailto;
							//$this->CM->JS_TMsg('Begin dept manager2:'.$mail_db);  // Debug
							//fwrite($fp, "Begin 部門 2:".$df_mailto['jec_user_id']."\r\n");  // Debug
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								//$this->CM->JS_TMsg('Begin dept manager3:'.$df_mailto['jec_user_id']);  // Debug
								//fwrite($fp, "Begin 部門 3:".$df_mailto['jec_user_id']."\r\n");  // Debug
								//include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
						
					endif;
					
					if($upm_pd==1)://send  上級
						$mail_content=$tmpMail_content.'(通知上級主管)';
						//Dont Dup
						$upm_user_id=$this->QIM->get_dept_up_mng_id($mailto['jec_dept_id']);
						//$this->CM->JS_TMsg('Begin 上級 1:'.$upm_user_id);  // Debug
						//fwrite($fp, "Begin 上級 1:".$upm_user_id."\r\n");  // Debug
						if((int)$upm_user_id>0):
							//if(isset($mail_db[$upm_user_id])):  // 強迫重新取值
							//	$upm_mailto=$mail_db[$upm_user_id];
							//else:
								$upm_mailto=$this->QIM->get_user_row($upm_user_id);
								$mail_db[$upm_user_id]=$upm_mailto;
							//endif;						
							$df_mailto=$upm_mailto;
							//$this->CM->JS_TMsg('Begin 上級 2:'.$df_mailto['jec_user_id']);  // Debug
							//fwrite($fp, "Begin 上級 2:".$df_mailto['jec_user_id']."\r\n");  // Debug
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):  // 不知為何不會通知, 先拿掉看看
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								//$this->CM->JS_TMsg('Begin 上級 3:'.$df_mailto['jec_user_id']);  // Debug
								//fwrite($fp, "Begin 上級 3:".$df_mailto['jec_user_id']."\r\n");  // Debug
								//include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
						
					endif;	
									
					if($tpm_pd==1)://send  最高
						$mail_content=$tmpMail_content.'(通知最高主管)';
						//Dont Dup
						//$this->CM->JS_TMsg('Begin top manager1.0:'.$mailto['jec_dept_id']);  // Debug
						$tpm_user_id=$this->QIM->get_dept_top_mng_id($mailto['jec_dept_id']);
						//$this->CM->JS_TMsg('Begin 最高 1:'.$tpm_user_id);  // Debug
						//fwrite($fp, "Begin 最高 1:".$tpm_user_id."\r\n");  // Debug
						if((int)$tpm_user_id>0):
							//if(isset($mail_db[$tpm_user_id])):  // 強迫重新取值
							//	$tpm_mailto=$mail_db[$tpm_user_id];
							//else:
								$tpm_mailto=$this->QIM->get_user_row($tpm_user_id);
								$mail_db[$tpm_user_id]=$tpm_mailto;
							//endif;	
						
							$df_mailto=$tpm_mailto;
							//$this->CM->JS_TMsg('Begin 最高 2:'.$df_mailto['jec_user_id']);  // Debug
							//fwrite($fp, "Begin 最高 2:".$df_mailto['jec_user_id']."\r\n");  // Debug
							if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):    // 不知為何不會通知, 先拿掉看看
								array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
								//$this->CM->JS_TMsg('Begin 最高 3:'.$df_mailto['jec_user_id']);  // Debug
								//fwrite($fp, "Begin 最高 3:".$df_mailto['jec_user_id']."\r\n");  // Debug
								//include('tools/common/mail/mail_ac_nolink.php');
							endif;
						endif;
					endif;	
									
				endforeach;
				
				//super另寄
				if($sales_pd==1)://Addsuper
					$mail_content=$tmpMail_content.'(通知督導人)';
					if(isset($mail_db[$value['jec_usersuper_id']])):
						$sup_mailto=$mail_db[$value['jec_usersuper_id']];
					else:
						$sup_mailto=$this->QIM->get_user_row($value['jec_usersuper_id']);
						$mail_db[$value['jec_usersuper_id']]=$sup_mailto;
					endif;
					$df_mailto=$sup_mailto;
					if(!in_array($df_mailto['jec_user_id'],$delay_dup_db[$value['jec_projtask_id']])):
						array_push($delay_dup_db[$value['jec_projtask_id']],$df_mailto['jec_user_id']);
						//include('tools/common/mail/mail_ac_super_nolink.php'); 不通知督導人
					endif;
					
					if($value['processtype']==1)://mail project_mng-重要傳給專案管理人
						$mail_content=$tmpMail_content.'(通知專案管理人)';
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
						//$this->CM->JS_TMsg($df_mailto['jec_user_id']);  // Debug
						//include('tools/common/mail/mail_ac_nolink.php'); 不通知督導人
					endif;
				endif;
			endif;
		endif;
	endif;
endforeach;
//以下為發逾期list
foreach ($sumMailContent as $eachMailAddress => $eachMailContent):
    $nameAndAddress = explode(':', $eachMailAddress);
    if ($nameAndAddress[1] == '') {
        continue;
    }
    $email = array(
        'name' => $nameAndAddress[0],
        'to' => $nameAndAddress[1],
        'time' => date('Y-m-d H:i:s'),
        //'subject'=>str_replace('履約管制系統-','履約管制系統-個人-',$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'])),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
        'subject' => $nameAndAddress[0] . ' 截至' . date('Y-m-d') . '已逾期工作一覽表，共' . $eachMailContent[1] . '項',
        'content' => '<table border="1"><tr><td>專案</td><td>工作</td><td>負責人</td><td>逾期天數</td><td></td></tr>'.$eachMailContent[0].'</table>',
        'emailsend' => 'N'
    );
    $email['content'] = '<p>請盡速完成或回報現況</p>' . $email['content'];
    if ($this->CM->SendMailGo($email['to'], $email['name'], $email['subject'], $email['content'], '', 'From-System')):
        $email['emailsend'] = 'Y';
    endif;
    //發給部門主管
    $dpm_user_id = $this->QIM->get_dept_mng_id($eachMailContent[2]);
    //$this->CM->JS_TMsg('Begin dept manager1:'.$dpm_user_id);  // Debug
    //fwrite($fp, "Begin 部門 1:".$dpm_user_id."\r\n");  // Debug
    //$this->CM->JS_TMsg($dpm_user_id);
    if ((int) $dpm_user_id > 0):
        if (isset($mail_db[$dpm_user_id])):
            $dpm_mailto = $mail_db[$dpm_user_id];
        else:
            $dpm_mailto = $this->QIM->get_user_row($dpm_user_id);
            $mail_db[$dpm_user_id] = $dpm_mailto;
        endif;
        $df_mailto = $dpm_mailto;
        
        if ($df_mailto['email'] == $nameAndAddress[1]) { //如為部門主管，則往上一階發送
            $upm_user_id = $this->QIM->get_dept_up_mng_id($eachMailContent[2]);
            //$this->CM->JS_TMsg('Begin 上級 1:'.$upm_user_id);  // Debug
            //fwrite($fp, "Begin 上級 1:".$upm_user_id."\r\n");  // Debug
            if ((int) $upm_user_id > 0):
                //if(isset($mail_db[$upm_user_id])):  // 強迫重新取值
                //	$upm_mailto=$mail_db[$upm_user_id];
                //else:
                $upm_mailto = $this->QIM->get_user_row($upm_user_id);
                $mail_db[$upm_user_id] = $upm_mailto;
                //endif;						
                $df_mailto = $upm_mailto;               
            endif;
        }
        //$this->CM->JS_TMsg('Begin dept manager2:'.$mail_db);  // Debug
        //fwrite($fp, "Begin 部門 2:".$df_mailto['jec_user_id']."\r\n");  // Debug
        //$this->CM->JS_TMsg('Begin dept manager3:'.$df_mailto['jec_user_id']);  // Debug
        //fwrite($fp, "Begin 部門 3:".$df_mailto['jec_user_id']."\r\n");  // Debug
        $email = array(
            'name' => $df_mailto['name'],
            'to' => $df_mailto['email'],
            'time' => date('Y-m-d H:i:s'),
            //'subject'=>str_replace('履約管制系統-','履約管制系統-部屬-',$this->$projn_set['mm_set']->get_email_subject($df_ip['ac'])),//$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
            'subject' => $nameAndAddress[0] . ' 截至' . date('Y-m-d') . '已逾期工作一覽表，共' . $eachMailContent[1] . '項'.'(通知部門主管)',
            'content' => '<table border="1"><tr><td>專案</td><td>工作</td><td>負責人</td><td>逾期天數</td><td></td></tr>'.$eachMailContent[0].'</table>',
            'emailsend' => 'N'
        );

        if ($this->CM->SendMailGo($email['to'], $email['name'], $email['subject'], $email['content'], '', 'From-System')):
            $email['emailsend'] = 'Y';
        endif;
    endif;

endforeach;
//以下為發待辦通知作業
$where="projtasktype not in (1,4) and projstatus not in (4) and isactive='Y' and isnotice='N' and (jec_user_id <> '' or jec_group_id <> '')";
//$projtask_list=$this->db->where_not_in('projtasktype',1)->where_not_in('projstatus',4)->where('jec_user_id != ','null')->where('isactive','Y')->where('isnotice','N')->get('jec_projtask_search_view')->result_array();
$projtask_list=$this->db->where($where)->get('jec_projtask_search_view')->result_array();
foreach($projtask_list as $value):
	if(!isset($delay_dup_db[$value['jec_projtask_id']])) $delay_dup_db[$value['jec_projtask_id']]=array();
	$projt_data=$value;
	//if(strtotime($value['enddate'])>=time()):
		//status1-待辦通知 
		
		$starttime=strtotime($value['startdate']);
		$compare_date=date('Y-m-d',mktime(date('H',$starttime),date('i',$starttime),date('s',$starttime),date('m',$starttime),date('d',$starttime)-$value['daynotice'],date('Y',$starttime)));
		$informtime=date('Y-m-d',strtotime($value['noticetime']));
		log_message('info','before-'.$value['jec_projtask_id'].'-compare_date:'.$compare_date.'now:'.date('Y-m-d').'-isnotice:'.$value['isnotice']);
		//130425有時日期會往前打,故修改為小於等於今天的都會預發或補發待辦-培旭
		if(date('Y-m-d',strtotime($compare_date))<=date('Y-m-d')&&$value['isnotice']=='N'):
			log_message('info','after-'.$value['jec_projtask_id'].'-compare_date:'.$compare_date.'informtime:'.$informtime);
			$df_ip['ac']='1';
			//$this->CM->JS_TMsg('wain_'.$value['jec_projtask_id']);
			//$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);  // 沒用, 找不到
			$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);  // Update by Johnson 2012/12/05
			$projn_noticetype=1;
			$sales_name=$this->QIM->get_final_sales_name($projt_data);
			$mail_data=array('proj_name'=>$proj_data['name'],'task_name'=>$projt_data['name'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'date_period'=>substr($value['startdate'],0,10).'~'.substr($value['enddate'],0,10));
			$mail_content=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
			//130510工作紀錄不存多餘資訊,寫上但還不用
			//$mail_data=array('proj_name'=>'','task_name'=>'','noticetype'=>$projn_noticetype,'sales_name'=>'','date_period'=>substr($value['startdate'],0,10).'~'.substr($value['enddate'],0,10));
			//$mail_content2=$this->$projn_set['mm_set']->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
			//--end
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
					'description'=>$mail_content,
					'startdate'=>$value['startdate'],
					'enddate'=>$value['enddate']
					);	
			//check_cal_exist
				$cal_exist=$this->db->where('jec_project_id',$value['jec_project_id'])->where('jec_projtask_id',$value['jec_projtask_id'])->where('noticefrom',1)->where('jec_user_id',$tu_value['jec_user_id'])->get('jec_calendar')->result_array();
				if(count($cal_exist)>0):					
					$cal_id=$cal_exist[0]['jec_calendar_id'];
					$this->db->where('jec_calendar_id',$cal_id)->update('jec_calendar',$upd);
					log_message('info',$cal_id.'->0-'.$mail_content);
				else:
					$this->db->insert('jec_calendar',$upd);
					$cal_id=mysql_insert_id();
					log_message('info',$cal_id.'-<0-'.$mail_content);
				endif;
				
			//新增通知紀錄-.
				
				$e_link=base_url('ecp_admin/index/work_report/'.$this->MEM->ReturnFinalCode($value['jec_projtask_id'],'emsproj',1).'/'.$this->MEM->ReturnFinalCode($tu_value['jec_user_id'],'emsproj',1).'/');
				
				$sendusername = $this->GM->GetSpecData('jec_user','name','jec_user_id',$tu_value['jec_user_id']);
				$email=array(
					'name'=>$sendusername,
					'to'=>$this->GM->GetSpecData('jec_user','email','jec_user_id',$tu_value['jec_user_id']),
					'time'=>date('Y-m-d H:i:s'),
					//'subject'=>$proj_data['name'].'-'.$projt_data['name'].'-'.$this->$projn_set['mm_set']->get_email_subject($df_ip['ac']),
					'subject'=>$mail_content,
					'content'=>$mail_content.'<br/><a href="'.$e_link.'">工作連結</a>',
					'emailsend'=>'N'
				);
				//if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
					//$email['emailsend']='Y';
				//endif;
				
				$worksubj = '待辦工作ID:'.$value['jec_projtask_id'].'/'.$sendusername.'/'.$proj_data['name'].'-'.$projt_data['name'];  // Debug
				//fwrite($fp, $worksubj."\r\n");  // Debug
			
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
	//endif;
endforeach;
// Update by Johnson 2012/11/06 增加手動新增行事曆的EMAIL通知
//$this->CM->JS_TMsg('Begin Stage 1 jec_calendar');
$this->db->select('a.*, b.name AS username');
$this->db->from('jec_calendar a');
$this->db->join('jec_user b', 'a.jec_user_id=b.jec_user_id', 'left');
$this->db->where('a.noticefrom', '2');
$this->db->where('a.isopen', 'N');
$this->db->where('DATE(DATE_SUB(a.startdate, INTERVAL a.daynotice DAY))=DATE(CURDATE())', NULL, FALSE);
$calendar_list = $this->db->get('')->result_array();
//$this->CM->JS_TMsg('Begin Stage 2 jec_calendar');
foreach($calendar_list as $calendarlist)
{
	//$this->CM->JS_TMsg('name='.$calendarlist['name']);
	// 組合主旨和內容
	$subject = $calendarlist['name'].'-履約管制系統-行事曆待辦工作通知';
	$calendar_noticetype = 1;  // 同待辦工作通知
	$username = $calendarlist['username'];
	$mail_data = array(
		'proj_name' => '',
		'task_name' => $calendarlist['name'],
		'noticetype' => $calendar_noticetype,
		'sales_name' => $username,
		'date_period' => substr($calendarlist['startdate'],0,10).'~'.substr($calendarlist['enddate'],0,10)
	);
	$content = $this->$projn_set['mm_set']->get_mail_content($mail_pdb, $mail_data['noticetype'], $mail_data);
	//$this->CM->JS_TMsg('content='.$content);
	
	// 傳送EMAIL
	$email = array(
		'name' => $this->GM->GetSpecData('jec_user', 'name', 'jec_user_id', $calendarlist['jec_user_id']),
		'to' => $this->GM->GetSpecData('jec_user', 'email', 'jec_user_id', $calendarlist['jec_user_id']),
		'time' => date('Y-m-d H:i:s'),
		'subject' => $subject,
		'content' => $content,
		'emailsend' => 'N'
	);
	//$this->CM->JS_TMsg('Begin send email');
	//if($this->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
	//	$email['emailsend'] = 'Y';
	//endif;
	//$this->CM->JS_TMsg('End send email='.$email['to']);
	
	// 寫入jec_projnotice
	$upd = array(
		'noticefrom' => '2',
		'jec_project_id' => null,
		'jec_projtask_id' => null,
		'jec_calendar_id' => $calendarlist['jec_calendar_id'],
		'noticetype' => 'AA',
		'noticetime' => date('Y-m-d H:i:s'),
		'jec_user_id' => $calendarlist['jec_user_id'],
		'startdate' => $calendarlist['startdate'],
		'enddate' => $calendarlist['enddate'],
		'emailtime' => $email['time'],
		'emailsubject' => $email['subject'],
		'emailcontent' => $email['content'],
		'emailsend' => $email['emailsend']
	);
	//$this->CM->JS_TMsg('Begin write to jec_projnotice='.$upd['jec_calendar_id']);	
	$this->db->insert('jec_projnotice', $upd);
	//$this->CM->JS_TMsg('End write to jec_projnotice');
}

//fclose($fp); // Debug

//$this->CM->JS_TMsg('@@@');
?>

