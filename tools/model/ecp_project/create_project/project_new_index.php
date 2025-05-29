<?php
$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));

        switch($df_ip['ac']):
            case 'edit': 
				//create_proj_folder_full
				/*
				$proj_list=$this->db->where('isactive','Y')->get('jec_project')->result_array();
				$this->load->model('File_model', 'FM');
				$this->FM->def_temp_path="uploads/";//
				foreach($proj_list as $value):
					$this->FM->prepare_temp_folder('project_file/'.$value['value']);//	
				endforeach;*/
				
			
			
				//get_Dept_ur lCONVERT( ad019005 using big5 )
				$mssqlef = $this->load->database('mssqlefnet', true);//
				//$dept_list=$mssqlef->query("SELECT DISTINCT ad019005 FROM ad019 ORDER By CONVERT( ad019005 using big5 ) ASC ")->result_array();
				$dept_list = $mssqlef->distinct('odmems003004C')->select('odmems003004C')->order_by('odmems003004C','ASC')->get('odmems003')->result_array();// collate Chinese_Taiwan_Stroke_CI_AS
				
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['get_purchase_url']=$this->$_G['L_CS']->common_url_ld('get_purchase_list_by_dept');
				$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				$final['search_ef_proj_url']=base_url('ecp_common/search_ef_proj/1/ad019004/___/');
				$final['check_projno_url']=base_url('ecp_common/check_projno/');
				$final['check_proj_url']=base_url($final['var_purl'].'project_new_index/check_proj_add/');
				//$final['form_model_url']=site_url($final['var_purl'].'project_new_index/load_model/0/');
				//$final['form_project_url']=site_url($final['var_purl'].'project_new_index/load_project/0/'); //
				//
				
				$final['assign_view']='project_new_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
				$final['ip_info']['efprojdept']['ld']=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'odmems003004C'),'page_db','mssql_ld');
				//$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('get_purchase_list_by_dept')";
				$final['ip_info']['efprojno']['onchange']="PG_BK_Action('check_projno',this.value)";
				$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('change_projdept',this.value)";
				//取得登入者資訊
				$loginparameters = $this->session->userdata(LOGIN_SESSION);
				//
				$final['ip_info']['project_model']=array(
						'call_name'=>'範本',
						'type'=>'select',
						'ld'=>'mm_projecttemp_set@def',
						'ld_key'=>'jec_projecttemp_id',
						'ld_value'=>'name',
						'style'=>'width:260px;',
						'ld_con'=>array('con_jec_dept_id'=>$loginparameters['jec_dept_id'])

					);//				
				$final['ip_info']['project_history']=array(
						'call_name'=>'舊專案',
						'type'=>'select',
						'ld'=>'mm_project_set@def',
						'ld_key'=>'jec_project_id',
						'ld_value'=>'name',
						'style'=>'width:260px;',
						'ld_con'=>array('con_projtype'=>'2','con_jec_dept_id'=>$loginparameters['jec_dept_id'])
					);
				$final['ip_info']['cus_select_type']=array(
						'call_name'=>'選擇類型',
						'type'=>'select',
						'ld'=>$this->$_G['L_CS']->common_use_ld('select_type'),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'style'=>'width:80px;',
						'full_selected'=>'N'
					);
                $final['main_data']=array(
										'value'=>$this->$proj_set['mm_set']->get_project_series(),
										'costrate'=>1,
										//'projyear'=>date('Y'),
										'createdby_title'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$this->ad_id)
										); 
				//$final['ip_info']['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['tcate_url']=array(
						'project_new_index'=>base_url($final['var_purl'].'project_new_index/edit/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/-1/created/asc/0/')
					);
            break;
            case 'update'://只放此處有編的
				
				$gv=array("value","jec_company_id","projyear","name","description","jec_customer_id","jec_customer_id_title","jec_user_id","jec_usersales_id","createdby","startdate","enddate","projtype",'customerdoc','value2','name2','address','description2','description3','cus_select_type','efprojdept','efprojno','efprojname','total','costrate','totalvoucher','totalaccept','showdate','getdate','limitdate','tendertype'); $gv=$this->CM->GPV($gv);
				$project_model=(int)$_POST['project_model'];
				$project_history=(int)$_POST['project_history'];
				
				$upd=array_merge($gv,array('isactive'=>'Y','projstatus'=>1));				
				
				//dept自抓
				//$upd['efprojname']=$this->CM->GetString($gv['efprojno'],'>>','');
				//$upd['efprojno']=$this->CM->GetString($gv['efprojno'],'','>>');
				
				//$upd['startdate']=strtotime($upd['startdate'].' 00:00:00');
				//$upd['enddate']=strtotime($upd['enddate'].' 00:00:00');
				
				$upd=array_merge($upd,$this->CM->Base_New_UPD());
				$upd['createdby']=$gv['createdby'];
				$upd['jec_dept_id']=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$upd['jec_usersales_id']);
				//抓成本來源
				$upd['costtype']=$this->GM->GetSpecData('jec_user','costtype','jec_user_id',$upd['jec_usersales_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				//value再抓一次好了
				$upd['value']=$this->$proj_set['mm_set']->get_project_series();
				//create_folder
				$this->load->model('File_model', 'FM');
				$this->FM->def_temp_path="uploads/";
				$this->FM->delete_temp_folder('project_file/'.$upd['value']);
				$this->FM->prepare_temp_folder('project_file/'.$upd['value']);//
				
				$cus_check=$this->CM->db->where('name',$upd['jec_customer_id_title'])->where('isactive','Y')->get('jec_customer')->result_array();
				if(count($cus_check)>0):
					$upd['jec_customer_id']=$cus_check[0]['jec_customer_id'];
				else:
					$upd['jec_customer_id']=NULL;					
				endif;
				$upd['customername']=$upd['jec_customer_id_title'];	
				/*
				if($upd['cus_select_type']=='K'):
					$upd['jec_customer_id']=NULL;
					$upd['customername']=$upd['jec_customer_id_title'];					
				else:
					$upd['customername']=$this->GM->GetSpecData('jec_customer','name','jec_customer_id',$upd['jec_customer_id']);
				endif;*/
				unset($upd['jec_customer_id_title']);
				unset($upd['cus_select_type']);				
				if($project_model>0 || $project_history>0)
				{
					$upd['isimporttemp']='Y';
				}
				$this->GM->common_ac('insert',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$project_id=mysql_insert_id();
				$costtype=$upd['costtype'];
				
				if($gv['projtype']=='1'):				
					//load投標前準備範本
					$project_model=24;
					$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
					$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
					$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					
					$projtempj_set=$this->CM->Init_TB_Set('mm_projecttempjob_set');
					$projtempt_set=$this->CM->Init_TB_Set('mm_projecttemptask_set');
					$job_mm_tb=$projtempj_set['mm_tb'];
					$task_mm_tb=$projtempt_set['mm_tb'];
					$job_list=$this->GM->common_ac('list',array('info'=>$projtempj_set['mm_set'],'type'=>'join_job','data'=>array('con_'.$job_mm_tb.'.jec_projecttemp_id'=>$project_model,'ob_'.$job_mm_tb.'.seqno'=>'ASC')));//join.....					
					$standarddate=strtotime($gv['showdate']);
					foreach($job_list as $jno=>$jvalue):
						$jpd=array(
								'jec_project_id'=>$project_id,
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
									'jec_project_id'=>$project_id,
									'jec_projjob_id'=>$n_projjob_id,
									'jec_task_id'=>$tvalue['jec_task_id'],
									'usertype'=>(int)$tmpuser==0?2:1,
									'jec_user_id'=>(int)$tmpuser==0?NULL:$tmpuser,
									'jec_group_id'=>(int)$tmpgroup==0?NULL:$tmpgroup,
									'description'=>'',
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
				elseif($project_model>0):
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
								'jec_project_id'=>$project_id,
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
									'jec_project_id'=>$project_id,
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
					
					
				elseif($project_history>0):
					//load
					$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
					$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
					$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					$projj_list=$this->GM->common_ac('list',array('info'=>$projj_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$project_history,'ob_seqno'=>'ASC')));
					foreach($projj_list as $jno=>$jvalue):
						//insert
						$jpd=array(
								'jec_project_id'=>$project_id,
								'jec_job_id'=>$jvalue['jec_job_id'],
								'seqno'=>($jno+1),
								'description'=>$jvalue['description'],
								'jobname'=>$jvalue['jobname'],
								'jobjobtype'=>$jvalue['jobjobtype']
							);
						$jpd=array_merge($this->CM->Base_New_UPD(),$jpd);
						$this->GM->common_ac('insert',array('info'=>$projj_set['mm_set'],'upt'=>'def','upd'=>$jpd));
						$n_projjob_id=mysql_insert_id();
						
						$task_list=$this->GM->common_ac('list',array('info'=>$projt_set['mm_set'],'type'=>'def','data'=>array('con_jec_projjob_id'=>$jvalue['jec_projjob_id'],'ob_seqno'=>'ASC')));
						foreach($task_list as $tno=>$tvalue):
							$tpd=array(
									'jec_project_id'=>$project_id,
									'jec_projjob_id'=>$n_projjob_id,
									'jec_task_id'=>$tvalue['jec_task_id'],
									'description'=>$tvalue['description'],
									'seqno'=>($tno+1),
									'jec_usersuper_id'=>$upd['jec_user_id'],
									'jec_userold_id'=>(int)$tvalue['jec_user_id']==0?NULL:$tvalue['jec_user_id'],
									'jec_user_id'=>(int)$tvalue['jec_user_id']==0?NULL:$tvalue['jec_user_id'],
									'jec_groupold_id'=>(int)$tvalue['jec_group_id']==0?NULL:$tvalue['jec_group_id'],
									'jec_group_id'=>(int)$tvalue['jec_group_id']==0?NULL:$tvalue['jec_group_id'],
									'price'=>$tvalue['price'],
									'taskname'=>$tvalue['taskname'],
									'taskdaynotice'=>$tvalue['taskdaynotice'],
									'taskdaydelay'=>$tvalue['taskdaydelay'],
									'taskworkweight'=>$tvalue['taskworkweight'],
									'taskprocesstype'=>$tvalue['taskprocesstype'],
									'taskconfirmtype'=>$tvalue['taskconfirmtype']
								);
							$tpd=array_merge($this->CM->Base_New_UPD(),$tpd);
							$this->GM->common_ac('insert',array('info'=>$projt_set['mm_set'],'upt'=>'def','upd'=>$tpd));
							$n_projtask_id=mysql_insert_id();
							//只載資，不載量…So funny. 
							
							$prod_list=$this->GM->common_ac('list',array('info'=>$projp_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$tvalue['jec_projtask_id'],'ob_seqno'=>'ASC')));
							foreach($prod_list as $pno=>$pvalue):
								//自訂的另存

				
								$ppd=array(
										'jec_project_id'=>$project_id,
										'jec_projtask_id'=>$n_projtask_id,
										'jec_product_id'=>$pvalue['jec_product_id'],
										'seqno'=>($pno+1),
										'prodtype'=>$pvalue['prodtype'],
										'quantity'=>$pvalue['quantity'],
										'price'=>$pvalue['price'],
										'total'=>$pvalue['total'],
										'jec_vendor_id'=>$pvalue['jec_vendor_id'],
										'description'=>$pvalue['description'],
										'prodname'=>$pvalue['prodname'],
										'prodspec'=>$pvalue['prodspec'],
										'prod_uom_id'=>$pvalue['prod_uom_id']
									);
									
								//取新成本喔…,舊參數
								$ppd['cost']=$this->$projp_set['mm_set']->get_erp_cost($pvalue['jec_product_id'],$costtype);				
								$ppd['costtime']=date("Y-m-d H:i:s");
				
								$ppd['extramultiple']=$pvalue['extramultiple'];
								$ppd['extraaddition']=$pvalue['extraaddition'];
								$ppd['estimcostcalc']=$ppd['total']*$ppd['extramultiple'];
								$ppd['salecostcalc']=$ppd['cost']==0?$ppd['estimcostcalc']:$ppd['cost']*$ppd['quantity']*$ppd['extramultiple'];
									
									
									
								if((int)$pvalue['jec_productopen_id']>0)://new
									//get_productopen_data
									$oo_pd=$this->$prodo_set['mm_set']->get_productopen_row($pvalue['jec_productopen_id']);
									$opd=array(
											'value'=>$oo_pd['value'],
											'name'=>$oo_pd['name'],
											'specification'=>$oo_pd['specification'],
											'description'=>$oo_pd['description'],
											'jec_uom_id'=>$oo_pd['jec_uom_id'],
											'price'=>$oo_pd['price']
										);
									$opd=array_merge($this->CM->Base_New_UPD(),$opd);
									$this->GM->common_ac('insert',array('info'=>$prodo_set['mm_set'],'upt'=>'def','upd'=>$opd));
									$ppd['jec_productopen_id']=mysql_insert_id();
								endif;
								$ppd=array_merge($this->CM->Base_New_UPD(),$ppd);
								$this->GM->common_ac('insert',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$ppd));
							endforeach;
						endforeach;
					endforeach;
				endif;
				
				$final['acbk_url']=site_url('ecp_project/adjust_project_mng/job_list_index/list/'.$project_id.'/seqno/asc/0/-1/');
				$final['response_type']='bk_ac';
            break;
			case 'check_proj_add':
				//cus_name
				//$cus_name=trim($_POST['cus_name']);//trim()
				$gv=array('cus_name','sales_name','user_name','createdby_name'); $gv=$this->CM->GPV($gv);
				$check=$this->db->where('name',$gv['cus_name'])->where('isactive','Y')->get('jec_customer')->result_array();
				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$createdby=$createdbyname=$msg='';
				$pass='Y';
				/*
				if(count($check)>0):
					$pass='Y';
					$cusname=$check[0]['name'];
					$cus_id=$check[0]['jec_customer_id'];
					$msg='';
				else:
					$pass='N';
					$msg='查無此客戶';
				endif;*/
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
				if($pass=='Y')://user_sales
					$check=$this->db->where('name',$gv['createdby_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$createdbyname=$check[0]['name'];
						$createdby=$check[0]['jec_user_id'];
					else:
						$pass='N';
						$msg='查無此建檔人員';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>'add_proj_go',
					'isexist'=>$pass,
					'cus_name'=>$cusname,
					'cus_id'=>$cus_id,
					'user_name'=>$username,
					'user_id'=>$userid,
					'sales_name'=>$salesname,
					'sales_id'=>$salesid,
					'sales_dept'=>$salesdept,
					'createdby'=>$createdby,
					'createdby_name'=>$createdbyname,
                    'pass'=>1
                );
				if($msg!='') $ajo['msg']=$msg;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;

        endswitch;
?>