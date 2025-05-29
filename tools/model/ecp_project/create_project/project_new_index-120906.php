<?php
$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));

        switch($df_ip['ac']):
            case 'edit': 
				//get_Dept_ur lCONVERT( ad019005 using big5 )
				$mssqlef = $this->load->database('mssqlef', true);
				//$dept_list=$mssqlef->query("SELECT DISTINCT ad019005 FROM ad019 ORDER By CONVERT( ad019005 using big5 ) ASC ")->result_array();
				$dept_list = $mssqlef->distinct('ad019005')->select('ad019005')->order_by('ad019005','ASC')->get('ad019')->result_array();// collate Chinese_Taiwan_Stroke_CI_AS
				
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['get_purchase_url']=$this->$_G['L_CS']->common_url_ld('get_purchase_list_by_dept');
				$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				$final['search_ef_proj_url']=base_url('ecp_common/search_ef_proj/1/ad019004/___/');
				$final['check_projno_url']=base_url('ecp_common/check_projno/');
				$final['check_proj_url']=base_url($final['var_purl'].'project_new_index/check_proj_add/');
				//$final['form_model_url']=site_url($final['var_purl'].'project_new_index/load_model/0/');
				//$final['form_project_url']=site_url($final['var_purl'].'project_new_index/load_project/0/'); //
				
				$final['assign_view']='project_new_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
				$final['ip_info']['efprojdept']['ld']=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'ad019005'),'page_db','mssql_ld');
				//$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('get_purchase_list_by_dept')";
				$final['ip_info']['efprojno']['onchange']="PG_BK_Action('check_projno',this.value)";
				$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('change_projdept',this.value)";
				
				//
				$final['ip_info']['project_model']=array(
						'call_name'=>'範本',
						'type'=>'select',
						'ld'=>'mm_projecttemp_set@def',
						'ld_key'=>'jec_projecttemp_id',
						'ld_value'=>'name',
						'style'=>'width:160px;'
					);//
				$final['ip_info']['project_history']=array(
						'call_name'=>'舊專案',
						'type'=>'select',
						'ld'=>'mm_project_set@def',
						'ld_key'=>'jec_project_id',
						'ld_value'=>'name',
						'style'=>'width:160px;'
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
										'costrate'=>1
									); 
				//$final['ip_info']['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['tcate_url']=array(
						'project_new_index'=>base_url($final['var_purl'].'project_new_index/edit/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/-1/created/asc/0/')
					);
            break;
            case 'update'://只放此處有編的
				
				$gv=array("value","jec_company_id","projyear","name","description","jec_customer_id","jec_customer_id_title","jec_user_id","jec_usersales_id","startdate","enddate","projtype",'customerdoc','value2','name2','address','description2','description3','cus_select_type','efprojdept','efprojno','efprojname','total','costrate'); $gv=$this->CM->GPV($gv);
				$project_model=(int)$_POST['project_model'];
				$project_history=(int)$_POST['project_history'];
				
				$upd=array_merge($gv,array('isactive'=>'Y','projstatus'=>1));
				//dept自抓
				//$upd['efprojname']=$this->CM->GetString($gv['efprojno'],'>>','');
				//$upd['efprojno']=$this->CM->GetString($gv['efprojno'],'','>>');
				
				//$upd['startdate']=strtotime($upd['startdate'].' 00:00:00');
				//$upd['enddate']=strtotime($upd['enddate'].' 00:00:00');
				
				$upd=array_merge($upd,$this->CM->Base_New_UPD());
				$upd['jec_dept_id']=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$upd['jec_usersales_id']);
				//抓成本來源
				$upd['costtype']=$this->GM->GetSpecData('jec_user','costtype','jec_user_id',$upd['jec_user_id']);
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				
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
				
				
				$this->GM->common_ac('insert',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$project_id=mysql_insert_id();
				$costtype=$upd['costtype'];

				if($project_model>0):
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
				
				$final['acbk_url']=site_url($final['var_purl'].'project_list_index/list/');
				$final['response_type']='bk_ac';
            break;
			case 'check_proj_add':
				//cus_name
				//$cus_name=trim($_POST['cus_name']);//trim()
				$gv=array('cus_name','sales_name','user_name'); $gv=$this->CM->GPV($gv);
				$check=$this->db->where('name',$gv['cus_name'])->where('isactive','Y')->get('jec_customer')->result_array();
				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$msg='';
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
                    'pass'=>1
                );
				if($msg!='') $ajo['msg']=$msg;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;

        endswitch;
?>