<?php
        switch($df_ip['ac']):
            case 'list': 
				$mssqlef = $this->load->database('mssqlefnet', true);
				$mssqlerp_ems = $this->load->database('mssqlerp', true);
				//$dept_list=$mssqlef->query("SELECT DISTINCT ad019005 FROM ad019 ORDER By CONVERT( ad019005 using big5 ) ASC ")->result_array();
				$dept_list = $mssqlef->distinct('odmems003004C')->select('odmems003004C')->order_by('odmems003004C','ASC')->get('odmems003')->result_array();
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].'project_adjust_index/update/'.$df_ip['key_id'].'/');
				$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['get_purchase_url']=$this->$_G['L_CS']->common_url_ld('get_purchase_list_by_dept');
				$final['get_updatexls_url']=site_url($final['var_purl'].'project_adjust_index/updatexls/'.$df_ip['key_id'].'/');
				$final['edit_projstatus_url']=site_url($final['var_purl'].'project_adjust_index/edit_projstatus/'.$df_ip['key_id'].'/');
				$final['search_ef_proj_url']=base_url('ecp_common/search_ef_proj/1/ad019004/___/');
				$final['check_projno_url']=base_url('ecp_common/check_projno/');
				$final['check_proj_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_proj_edit/');
				$final['check_close_proj_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_proj_close/');
				//
				$final['assign_view']='project_adjust_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['proj_data']['jec_user_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['jec_user_id']);
				$final['proj_data']['jec_usersales_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['jec_usersales_id']);
				$final['proj_data']['createdby_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['createdby']);
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
				$final['proj_data']['costrate']=(float)$final['proj_data']['costrate'];
				$final['proj_data']['total']=(float)$final['proj_data']['total'];
				
				$final['ip_info']['efprojdept']['ld']=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'odmems003004C'),'page_db','mssql_ld');
				//$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('get_purchase_list_by_dept')";
				//$final['ip_info']['efprojno']['onchange']="PG_BK_Action('get_purchase_name',this.value)";
				$final['ip_info']['efprojno']['onchange']="PG_BK_Action('check_projno',this.value)";
				$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('change_projdept',this.value)";
				//
				//取得登入者資訊
				$loginparameters = $this->session->userdata(LOGIN_SESSION);
				$final['ip_info']['project_model']=array(
						'call_name'=>'範本',
						'type'=>'select',
						'ld'=>'mm_projecttemp_set@def',
						'ld_key'=>'jec_projecttemp_id',
						'ld_value'=>'name',
						'style'=>'width:260px;',
						'ld_con'=>array('con_jec_dept_id'=>$loginparameters['jec_dept_id'])
					);//
				if($final['proj_data']['efprojno']!='')://要抓
					//$final['proj_data']['efprojno']=$final['proj_data']['efprojno'].'>>'.$final['proj_data']['efprojname'];
					$os=$this->CM->db->where('noticetype','OS')->where('isactive','Y')->get('jec_setup')->result_array();
					$os=strtolower($os[0]['value']);
					$istrans=$os=='linux'?'Y':'N';
					$ms_dept=$istrans=='Y'?iconv('utf-8','big5',$final['proj_data']['efprojdept']):$final['proj_data']['efprojdept'];
					$purchase_list = $mssqlef->where('odmems003004C',$ms_dept)->select('odmems003004C')->select('odmems003006')->get('odmems003')->result_array();
					$final['ip_info']['efprojno']['ld']=$this->CM->FormatData(array('db'=>$purchase_list,'field'=>'odmems003005,odmems003006','istrans'=>$istrans),'page_db','mssql_ld');
				endif;
				
				$final['ip_info']['value']['disabled']='Y';
				//$final['ip_info']['jec_company_id']['disabled']='Y';
				//$final['ip_info']['projyear']['disabled']='Y';
				//$final['ip_info']['jec_customer_id_title']['disabled']='Y';
				//$final['ip_info']['jec_user_id']['disabled']='Y';
				//$final['ip_info']['jec_user_id_title']['disabled']='Y';
				//$final['ip_info']['projtype']['disabled']='Y';

				

                $final['main_data']=$final['proj_data']; 
				$final['main_data']['startdate']=substr($final['main_data']['startdate'],0,10);
				$final['main_data']['enddate']=substr($final['main_data']['enddate'],0,10);
				$final['main_data']['showdate']=substr($final['main_data']['showdate'],0,10);
				$final['main_data']['getdate']=substr($final['main_data']['getdate'],0,10);
				$final['main_data']['limitdate']=substr($final['main_data']['limitdate'],0,10);
				$final['main_data']['jec_customer_id_title']=$final['main_data']['jec_customer_id']>0?$this->GM->GetSpecData('jec_customer','name','jec_customer_id',$final['main_data']['jec_customer_id']):$final['main_data']['customername'];
				$final['main_data']['jec_customer_id']=$final['main_data']['jec_customer_id']>0?$final['main_data']['jec_customer_id']:1;
				//取得ef專案預估支出金額
				$projcost = $mssqlef->where('odmems003005',$final['proj_data']['efprojno'])->select('odmems003004C')->select('odmems003006')->select('odmems003016')->get('odmems003')->result_array();
				$final['main_data']['projcost']="";
				foreach ($projcost as $row){
				$final['main_data']['projcost']=$row['odmems003016'];
				}
				//取得erp結帳單金額
				if($final['proj_data']['efprojno']<>'')
				{
				//$projvoucher = $mssqlerp_ems->select('sum(TB019+TB020) as total')->from('ACRTB')->join('ACRTA','TA001=TB001 and TA002=TB002')->where(array('TA025'=>'Y','TB022'=>$final['proj_data']['efprojno']))->get();
				$projvoucher=$mssqlerp_ems->query("select distinct cast(isnull((select TA017+TA018 from ACRTA TA2 where TA1.TA001=TA2.TA001 and TA1.TA002=TA2.TA002 and TA015<>'' and TA019<>'Y'),0)+isnull((select TA203+TA204 from ACRTA TA2 where TA1.TA001=TA2.TA001 and TA1.TA002=TA2.TA002 and TA202<>'' and TA205<>'Y'),0)+isnull((select TA209+TA210 from ACRTA TA2 where TA1.TA001=TA2.TA001 and TA1.TA002=TA2.TA002 and TA208<>'' and TA211<>'Y'),0)+isnull((select TA215+TA216 from ACRTA TA2 where TA1.TA001=TA2.TA001 and TA1.TA002=TA2.TA002 and TA214<>'' and TA217<>'Y'),0)+isnull((select TA221+TA222 from ACRTA TA2 where TA1.TA001=TA2.TA001 and TA1.TA002=TA2.TA002 and TA220<>'' and TA223<>'Y'),0)+isnull((select sum(TB019+TB020) from ACRTB TB2 where TB2.TB001=TA1.TA001 and TB2.TB002=TA002 and TB004='2' and TA1.TA015='' and TA1.TA202='' and TA1.TA208='' and TA1.TA214=''),0) as int) as total, TA001+'-'+TA002 from ACRTA TA1 left join ACRTB on TA1.TA001=TB001 and TA1.TA002=TB002 where TA025='Y' and TB022='".$final['proj_data']['efprojno']."'");
				//$final['main_data']['totalvoucher']="";
				$totalvoucher=0;
				foreach ($projvoucher->result_array() as $row){
				$totalvoucher+=$row['total'];
				}
				if($totalvoucher>0)
				$final['main_data']['totalvoucher']=$totalvoucher;
				}
				$final['ip_info']['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$final['ip_info']['projstatus']['ld']=$this->$proj_set['mm_set']->projstatus_ld_adjust($final['main_data']['projstatus'],$final['ip_info']['projstatus']['ld']);
				$final['ip_info']['projyear']['ld']=$this->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>($final['main_data']['projyear']-1),'en'=>($final['main_data']['projyear']+4)),"page_db","num");
				$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
				if(!isset($full_set['disabled'])):
					if(!$this->$proj_set['mm_set']->exe_right_check('check_adjust_right',$final['proj_data'])):
						$full_set['disabled']='Y';
					endif;
				endif;
				if(isset($full_set['disabled'])) $final['up_da']='disabled';
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data'],'',$full_set);
				
				//$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'project_overview_index'=>base_url($final['var_purl'].'project_overview_index/list/'.$df_ip['key_id'].'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/'),
						'adjusttask_list_index'=>base_url($final['var_purl'].'adjusttask_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/'),
						'deletetask_list_index'=>base_url($final['var_purl'].'deletetask_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/')
					);
            break;
            case 'update'://只放此處有編的
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				//$gv=array("jec_company_id","projyear","name","description","jec_customer_id","jec_customer_id_title","jec_user_id","jec_usersales_id",'jec_dept_id',"startdate","enddate","projtype",'customerdoc','address','value2','description2','name2','description3','efprojdept','efprojno','efprojname','total','costrate','totalvoucher','totalaccept'); $gv=$this->CM->GPV($gv);
				$gv=array("jec_company_id","projyear","projtype","name","description","jec_usersales_id","jec_dept_id","jec_user_id","jec_customer_id","jec_customer_id_title","createdby","startdate","enddate","customerdoc","address","value2","description2","name2","description3","efprojdept","efprojno","efprojname","total","costrate","totalvoucher","totalaccept",'showdate','getdate','limitdate','tendertype');
				$gv=$this->CM->GPV($gv);
				
				$upd=array_merge($gv,$this->CM->Base_UP_UPD());
				//$upd['efprojname']=$this->CM->GetString($gv['efprojno'],'>>','');
				//$upd['efprojno']=$this->CM->GetString($gv['efprojno'],'','>>');
				
				// 修改業務部門
				$upd['jec_dept_id']=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$upd['jec_usersales_id']);
				// 檢查客戶資料
				$cus_check=$this->CM->db->where('name',$upd['jec_customer_id_title'])->where('isactive','Y')->get('jec_customer')->result_array();
				if(count($cus_check)>0):
					$upd['jec_customer_id']=$cus_check[0]['jec_customer_id'];
				else:
					$upd['jec_customer_id']=NULL;					
				endif;
				// 客戶名稱欄位需自行加入, 且jec_customer_id_title不在UPDATE欄位清單, 必須要拿掉, 否則UPDATE會出問題
				$upd['customername']=$upd['jec_customer_id_title'];
				unset($upd['jec_customer_id_title']);
				$project_model=(int)$_POST['project_model'];
				if($project_model>0)
				{
					$upd['isimporttemp']='Y';
				}
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('update',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$df_ip['key_id']));
				//$final['acbk_url']=site_url($final['var_purl'].'project_list_index/list/');
				//$final['response_type']='ajax';
				//匯入範本資料				
				if($gv['projtype']=='1' && $project_model>0):					
					$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
					$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
					$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					
					$projtempj_set=$this->CM->Init_TB_Set('mm_projecttempjob_set');
					$projtempt_set=$this->CM->Init_TB_Set('mm_projecttemptask_set');
					$job_mm_tb=$projtempj_set['mm_tb'];
					$task_mm_tb=$projtempt_set['mm_tb'];
					$job_list=$this->GM->common_ac('list',array('info'=>$projtempj_set['mm_set'],'type'=>'join_job','data'=>array('con_'.$job_mm_tb.'.jec_projecttemp_id'=>$project_model,'ob_'.$job_mm_tb.'.seqno'=>'ASC')));//join.....					
					$standarddate=strtotime($_POST['getdate']);
					foreach($job_list as $jno=>$jvalue):
						$jpd=array(
								'jec_project_id'=>$df_ip['key_id'],
								'jec_job_id'=>$jvalue['jec_job_id'],
								'seqno'=>($jno+1),
								'description'=>'',
								'jobname'=>$jvalue['name'],
								'jobjobtype'=>$jvalue['jobtype']
							);
						$jpd=array_merge($this->CM->Base_New_UPD(),$jpd);
						$this->GM->common_ac('insert',array('info'=>$projj_set['mm_set'],'upt'=>'def','upd'=>$jpd));
						$n_projjob_id=mysql_insert_id();
						
						$task_list=$this->GM->common_ac('list',array('info'=>$projtempt_set['mm_set'],'type'=>'join_task','data'=>array('con_'.$task_mm_tb.'.jec_projecttempjob_id'=>$jvalue['jec_projecttempjob_id'],'ob_'.$task_mm_tb.'.seqno'=>'ASC')));
						//$this->CM->JS_TMsg(count($task_list));
						//取出範本負責人與督導人
						foreach($task_list as $tno=>$tvalue):
							$tmpuser=$tmpgroup=0;
							$tmpuser_array=explode(',',$tvalue['user']);
							if($tmpuser_array[0]=='0')
							{
								switch($tmpuser_array[1])
								{
									case '1':
										$tmpuser=$upd['jec_usersales_id'];
									break;
									case '2':
										$tmpuser=$upd['jec_user_id'];
									break;
									case '3':
										$tmpuser=$upd['createdby'];
									break;
									case '4':
										$tmpuser=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$upd['jec_dept_id']);
										if($tmpuser==$upd['jec_usersales_id'])
										{
											$updept=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$upd['jec_dept_id']);
											$tmpuser=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$updept);
										}
									break;
								}								
							}
							else if($tmpuser_array[0]=='1')
							{
								$tmpuser=$tmpuser_array[1];
							}
							else if($tmpuser_array[0]=='2')
							{
								$tmpgroup=$tmpuser_array[1];
							}
							$tmpsuperuser_array=explode(',',$tvalue['superuser']);
							if($tmpsuperuser_array[0]=='0')
							{
								switch($tmpsuperuser_array[1])
								{
									case '1':
										$tmpsuperuser=$upd['jec_usersales_id'];
									break;
									case '2':
										$tmpsuperuser=$upd['jec_user_id'];
									break;
									case '3':
										$tmpsuperuser=$upd['createdby'];
									break;
									case '4':
										$tmpsuperuser=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$upd['jec_dept_id']);
										if($tmpsuperuser==$upd['jec_usersales_id'])
										{
											$updept=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$upd['jec_dept_id']);
											$tmpsuperuser=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$updept);
										}
									break;
								}								
							}
							else if($tmpsuperuser_array[0]=='1')
							{
								$tmpsuperuser=$tmpsuperuser_array[1];
							}		
							$tmpstartdate=strtotime('+'.$tvalue['startdays'].' days',$standarddate);
							$tmpenddate=strtotime('+'.$tvalue['workdays'].' days',$tmpstartdate);	
							$tpd=array(
									'jec_project_id'=>$df_ip['key_id'],
									'jec_projjob_id'=>$n_projjob_id,
									'jec_task_id'=>$tvalue['jec_task_id'],
									'usertype'=>(int)$tmpuser==0?2:1,
									'jec_user_id'=>(int)$tmpuser==0?NULL:$tmpuser,
									'jec_group_id'=>(int)$tmpgroup==0?NULL:$tmpgroup,
									'description'=>$tvalue['description'],
									'seqno'=>($tno+1),
									'jec_usersuper_id'=>$tmpsuperuser,
									'taskname'=>$tvalue['name'],
									'startdate'=>date('Y-m-d',$tmpstartdate),
									'enddate'=>date('Y-m-d',$tmpenddate),
									'taskdaynotice'=>$tvalue['daynotice'],
									'taskdaydelay'=>$tvalue['daydelay'],
									'taskworkweight'=>$tvalue['workweight'],
									'taskprocesstype'=>$tvalue['processtype'],
									'taskconfirmtype'=>$tvalue['confirmtype'],//cost/price....
									'projtasktype'=>'2'

								);
							$tpd=array_merge($this->CM->Base_New_UPD(),$tpd);
							$this->GM->common_ac('insert',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$tpd));
							$n_projtask_id=mysql_insert_id();
							//
						endforeach;
					endforeach;
				elseif($gv['projtype']=='2' && $project_model>0):
					//load	
					$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
					$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
					$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					
					$projtempj_set=$this->CM->Init_TB_Set('mm_projecttempjob_set');
					$projtempt_set=$this->CM->Init_TB_Set('mm_projecttemptask_set');
					$job_mm_tb=$projtempj_set['mm_tb'];
					$task_mm_tb=$projtempt_set['mm_tb'];
					$job_list=$this->GM->common_ac('list',array('info'=>$projtempj_set['mm_set'],'type'=>'join_job','data'=>array('con_'.$job_mm_tb.'.jec_projecttemp_id'=>$project_model,'ob_'.$job_mm_tb.'.seqno'=>'ASC')));//join.....
					foreach($job_list as $jno=>$jvalue):
						$jpd=array(
								'jec_project_id'=>$df_ip['key_id'],
								'jec_job_id'=>$jvalue['jec_job_id'],
								'seqno'=>($jno+1),
								'description'=>'',
								'jobname'=>$jvalue['name'],
								'jobjobtype'=>$jvalue['jobtype']
							);
						$jpd=array_merge($this->CM->Base_New_UPD(),$jpd);
						$this->GM->common_ac('insert',array('info'=>$projj_set['mm_set'],'upt'=>'def','upd'=>$jpd));
						$n_projjob_id=mysql_insert_id();
						
						$task_list=$this->GM->common_ac('list',array('info'=>$projtempt_set['mm_set'],'type'=>'join_task','data'=>array('con_'.$task_mm_tb.'.jec_projecttempjob_id'=>$jvalue['jec_projecttempjob_id'],'ob_'.$task_mm_tb.'.seqno'=>'ASC')));
						//$this->CM->JS_TMsg(count($task_list));
						foreach($task_list as $tno=>$tvalue):
							$tpd=array(
									'jec_project_id'=>$df_ip['key_id'],
									'jec_projjob_id'=>$n_projjob_id,
									'jec_task_id'=>$tvalue['jec_task_id'],
									'jec_user_id'=>(int)$tvalue['jec_user_id']==0?NULL:$tvalue['jec_user_id'],
									'jec_group_id'=>(int)$tvalue['jec_group_id']==0?NULL:$tvalue['jec_group_id'],
									'description'=>'',
									'seqno'=>($tno+1),
									'jec_usersuper_id'=>$upd['jec_user_id'],
									'taskname'=>$tvalue['name'],
									'taskdaynotice'=>$tvalue['daynotice'],
									'taskdaydelay'=>$tvalue['daydelay'],
									'taskworkweight'=>$tvalue['workweight'],
									'taskprocesstype'=>$tvalue['processtype'],
									'taskconfirmtype'=>$tvalue['confirmtype']//cost/price....
								);
							$tpd=array_merge($this->CM->Base_New_UPD(),$tpd);
							$this->GM->common_ac('insert',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$tpd));
							$n_projtask_id=mysql_insert_id();
							//
						endforeach;
					endforeach;
				endif;
				$this->CM->JS_Msg('專案修改成功');
				$final['acbk_url']=site_url($final['var_purl'].'project_adjust_index/list/'.$df_ip['key_id']);
				$final['response_type']='bk_ac';
				
            break;
			
			case 'edit_projstatus':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("projstatus","totalvoucher","customerdoc","value2","name2","showdate","getdate","limitdate","description3","total","tendertype"); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_UP_UPD());
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);				
				$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']);//
				
				$ok='Y';//change
				
				$ok=$this->$proj_set['mm_set']->exe_right_check('change_projstatus',array('jec_project_id'=>$df_ip['key_id'],'projstatus'=>$gv['projstatus']));
				
				if($ok=='Y'):
					$projstatus=array(3=>'未得標',4=>'廢標/專案取消',5=>'標案/專案暫停');//會隱藏工作的專案狀態
					$this->GM->common_ac('update',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$df_ip['key_id']));
					if($gv['projstatus']==2)
					{
						if(in_array($final['proj_data']['projstatus'],array_keys($projstatus)))
						{
							//加record
							$task_list=$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','D')->get('jec_projtask')->result_array();
							foreach($task_list as $row)
							{
							$upd=array(
								'jec_project_id'=>$df_ip['key_id'],
								'jec_projtask_id'=>$row['jec_projtask_id'],								
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$this->ad_id, //登入者
								'description'=>'標案/專案重新開展'
								);
							$this->$projr_set['mm_set']->record_action($upd);
							}
						}
						$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','D')->update('jec_projtask',array('isactive'=>'Y'));						
					}
					
					if(in_array($gv['projstatus'],array_keys($projstatus)))
					{
						//加record
							$task_list=$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','Y')->get('jec_projtask')->result_array();
							foreach($task_list as $row)
							{
							$upd=array(
								'jec_project_id'=>$df_ip['key_id'],
								'jec_projtask_id'=>$row['jec_projtask_id'],								
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$this->ad_id, //登入者
								'description'=>$projstatus[$gv['projstatus']]
								);
							$this->$projr_set['mm_set']->record_action($upd);
							}
						$this->db->where('jec_project_id',$df_ip['key_id'])->where('isactive','Y')->update('jec_projtask',array('isactive'=>'D'));
						
					}
					/*
					$this->load->library('form_input');
                	$final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
					$final['ip_info']['projstatus']['ld']=$this->$proj_set['mm_set']->projstatus_ld_adjust($gv['projstatus'],$final['ip_info']['projstatus']['ld']);
					$final['ip_info']['projstatus']['only_list']='Y';
					$final['main_op']=$this->form_input->each_op_trans(array('projstatus'),$final['ip_info'],$gv);
					$new_list=$final['main_op']['projstatus']['op'];
					*/
					$new_list='';
					$refresh_url=base_url($final['var_purl'].'project_adjust_index/list/'.$df_ip['key_id'].'/');
				else:
					$gv['projstatus']=$final['proj_data']['projstatus'];
				endif;
				//更改list.parent.document.getElementById('projstatus').innerHTML='$new_list';
				

				

				
				//$final['response_type']='ajax';
				if($ok=='Y'):
						$msg="已調整專案狀態";
						if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) $msg=iconv('utf-8','big5',$msg);
					?><script>

                		parent.ECP_Msg('<?=$msg?>',999);
						function PG_Refresh(){
							parent.location.href="<?php echo $refresh_url;?>";
						}
						setTimeout("PG_Refresh()", 1500 );
						//parent.location.href="<?php echo $refresh_url;?>";
               	    </script><?php	
				else:
						if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) $_G['err_msg']=iconv('utf-8','big5',$_G['err_msg']);
					?><script>
                		parent.ECP_Msg('<?=$_G['err_msg']?>',999);
               	    </script><?php
				endif;
			break;
			
			case 'updatexls':
				$gv=array('jec_project_id'); $gv=$this->CM->GPV($gv);
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				
				
				$data=array('jec_project_id'=>$gv['jec_project_id'],'save_path'=>'uploads/','excel_type'=>'xls');
				//$this->CM->JS_TMsg($data['save_path']);
				
				if(!isset($data['proj_data'])):
					$proj_data=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->get('jec_project')->result_array();
					$data['proj_data']=$proj_data[0];
				endif;
				$data['save_path']='uploads/project_file/'.$data['proj_data']['value'].'/';
				$main_list=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->order_by("seqno","asc")->get('jec_productprep_search_view')->result_array();
				//$main_list=array();
				//
				$excel_type=$data['excel_type'];
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel.php"); 
				require_once("append_tools/phpexcel-1.7.8/Classes/PHPExcel/IOFactory.php");
				//$objPHPExcel = new PHPExcel();
				$inputFileName = 'uploads/template/temp.xls';

				/** Load $inputFileName to a PHPExcel Object  **/
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

				/** Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("履約備品清單-".$data['proj_data']['value'])
							 ->setSubject("履約備品清單-".$data['proj_data']['value'])
							 ->setDescription("履約備品清單-".$data['proj_data']['value'].'-'.$data['proj_data']['name'])
							 ->setKeywords("履約備品清單")
							 ->setCategory("履約備品清單");**/


				// Add some data			    
			    $objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B1', $data['proj_data']['name'])							
							->setCellValue('B2', $data['proj_data']['value2'])
							->setCellValue('B3', str_replace('-','/',substr($data['proj_data']['showdate'],0,10)))
							->setCellValue('B4', $data['proj_data']['description3'])
							->setCellValue('B6', $data['proj_data']['total']);														
				
				// Miscellaneous glyphs, UTF-8
				$eno=0;
				$final_total=0;
				foreach($main_list as $no=>$value):
						$eno=$no+5;
						$final_total+=$value['total'];
						 $objPHPExcel->setActiveSheetIndex(1)
            			 //->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('A'.$eno, str_replace('-','/',substr($value['created'],6,5)))
						 ->setCellValue('B'.$eno, $value['value'])
						 ->setCellValue('C'.$eno, $value['prodname'])
						 ->setCellValue('D'.$eno, $value['prodspec'])
						 ->setCellValue('E'.$eno, $value['quantity'])
						 ->setCellValue('F'.$eno, $value['price'])
						 ->setCellValue('G'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('J'.$eno, $value['purchasing_user'])						 
						 ->setCellValue('L'.$eno, $value['description'])
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				endforeach;
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "小計")						 
						 ->setCellValue('G'.$eno, "=sum(G5:G".$tmpeno.")")
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $objPHPExcel->setActiveSheetIndex(1)            			 
           				 ->setCellValue('F'.$eno, "稅額(5%)")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno."*0.05")		 
						 ;
						 $objPHPExcel->getActiveSheet()->insertNewRowBefore($eno+1, 1);
				$eno++;
						 $tmpeno=$eno-1;
						 $tmpeno2=$eno-2;
						 $objPHPExcel->setActiveSheetIndex(1)
            			 ->setCellValue('F'.$eno, "總合計")						 
						 ->setCellValue('G'.$eno, "=G".$tmpeno2."+G".$tmpeno)	 		
						 ;						 
						
				$objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B5', "=履約購案零配件清單!G".$eno);
				// Rename sheet
				//$objPHPExcel->getActiveSheet()->setTitle('履約備品清單');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(1);


// Redirect output to a client’s web browser (Excel5)
				//$file_name='履約備品清單-'.$data['proj_data']['name'].'.'.$excel_type;
				$file_name='履約備品清單-'.$data['proj_data']['value'].'.'.$excel_type;
				$file_name=$this->CM->ReadFileName('download',$file_name);
				//$file_name='pppp-gggggg.'.$excel_type;
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$file_name.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type)://
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				//exit();
				//$objWriter->save($data['save_path'].str_replace(array('\\','/',':','"','?','*','<','>','|'),'',$file_name));
				$objWriter->save($data['save_path'].$file_name);

			break;
			
			case 'check_proj_edit':
//				//cus_name
//				//$cus_name=trim($_POST['cus_name']);//trim()
//				$gv=array('sales_name'); $gv=$this->CM->GPV($gv);
//				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$msg='';
//				$pass='Y';
//				if($pass=='Y')://user_sales
//					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
//					if(count($check)>0):
//						$pass='Y';
//						$salesname=$check[0]['name'];
//						$salesid=$check[0]['jec_user_id'];
//						$salesdept=$check[0]['jec_dept_id'];
//					else:
//						$pass='N';
//						$msg='查無此專案業務';
//					endif;
//				endif;
//				
//                $ajo=array(
//					'bk_action'=>'edit_proj_go',
//					'isexist'=>$pass,
//					'sales_name'=>$salesname,
//					'sales_id'=>$salesid,
//					'sales_dept'=>$salesdept,
//                    'pass'=>1
//                );
//				if($msg!='') $ajo['msg']=$msg;
//                $final['response_type']='ajax';
//                $final['ajax_output']=$this->CM->tag_pack($ajo); 
//				break;

				$gv=array('cus_name','sales_name','user_name'); $gv=$this->CM->GPV($gv);
				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$msg='';
				$pass='Y';
				if($pass=='Y')://user_sales
					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$salesname=$check[0]['name'];
						$salesid=$check[0]['jec_user_id'];
						$salesdept=$check[0]['jec_dept_id'];
					else:
						$pass='N';
						$msg='查無此專案主持人';
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
				// 檢查客戶資料, 此處要先給值, 否則POST沒有傳回值, 將導致值送不到UPDATE程式...無言...
				$check=$this->db->where('name',$gv['cus_name'])->where('isactive','Y')->get('jec_customer')->result_array();
				if(count($check)>0):
					$pass='Y';
					$cusname=$check[0]['name'];
					$cus_id=$check[0]['jec_customer_id'];
					$msg='';
				else:
					$pass='Y';
					$cus_id=NULL;
					$cusname=$gv['cus_name'];
					$msg='';
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
				case 'check_proj_close':
					$gv=array('wf_proj_id'); $gv=$this->CM->GPV($gv);
					$mssqlerp_ems = $this->load->database('mssqlerp', true);
					$query=$mssqlerp_ems->query("select cast(sum(round(TD012*1.05,0)) as int) as order_value from COPTD left join COPTC on TC001=TD001 and TC002=TD002 where TC027='Y' and TD027='".$gv['wf_proj_id']."'")->row(0);
					$order_value=$query->order_value;
					$query=$mssqlerp_ems->query("select cast(sum(TH037+TH038) as int) as sold_value from COPTH left join COPTG on TG001=TH001 and TG002=TH002 where TG023='Y' and TH030='".$gv['wf_proj_id']."'")->row(0);
					$sold_value=$query->sold_value;
					$query=$mssqlerp_ems->query("select cast(sum(TJ033+TJ034) as int) as sold_return from COPTI left join COPTJ on TI001=TJ001 and TI002=TJ002 where TI019='Y' and TJ028='".$gv['wf_proj_id']."'")->row(0);
					$sold_return=$query->sold_return;
					//訂單-(銷貨-銷退)=未銷貨
					$non_sold=$order_value-($sold_value-$sold_return);

					//if($non_sold >100) 	$msg='尚有未銷貨金額'.$non_sold;
					$ajo=array(
						'bk_action'=>'bk_close_proj',
						'pass'=>1,
						'non_sold'=>$non_sold
					);
					if($msg!='') $ajo['msg']=$msg;
					$final['response_type']='ajax';
                	$final['ajax_output']=$this->CM->tag_pack($ajo);
				
				break;
		endswitch;
?>