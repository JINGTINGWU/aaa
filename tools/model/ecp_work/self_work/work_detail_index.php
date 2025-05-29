<?php
        switch($df_ip['ac']):
            case 'list': 
				//echo $_SESSION['w1w_pd']['s_task_taskprogress'];
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				//$final['form_url']=site_url($final['var_purl'].'prod_list_index/add_projprod/'.$df_ip['key_id'].'/');
				//
        $final['refresh_url']=base_url($final['var_purl'].'work_detail_index/list/'.$df_ip['key_id'].'/');
				$final['prod_list_url']=site_url($final['var_purl'].'work_detail_index/list_div/'.$df_ip['key_id'].'/');
				$final['update_projprod_url']=site_url($final['var_purl'].'work_detail_index/update_projprod/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/');
				$final['purchase_form_url']=base_url($final['var_purl'].$df_ip['tag'].'/purchase_form_div/'.$df_ip['key_id'].'/');
				$final['purchase_prod_url']=base_url($final['var_purl'].$df_ip['tag'].'/purchase_prod_div/'.$df_ip['key_id'].'/created/ASC/0/');
				$final['recount_result_url']=site_url($final['var_purl'].'work_detail_index/get_recount_result/'.$df_ip['key_id'].'/');
				$final['purchase_submit_url']=base_url($final['var_purl'].$df_ip['tag'].'/submit_purchase/'.$df_ip['key_id'].'/');
				$final['refresh_purchase_status_url']=base_url($final['var_purl'].$df_ip['tag'].'/refresh_purchase_status/'.$df_ip['key_id'].'/');
				$final['check_charge_user_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_charge_user/'.$df_ip['key_id'].'/');
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$final['total_item']=count($final['main_list']);
				$final['assign_view']='work_detail_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True); 
				
				$this->load->library('form_input');
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				$final['resda020_pdb']=$this->$_G['L_CS']->resda020_info;
				$final['resda021_pdb']=$this->$_G['L_CS']->resda021_info;
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_product_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_product_id'),'page_db','s_array');				
                $final['main_data']=array('startdate'=>date('Y-m-d'),'s_user_id_title'=>$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['jec_usersales_id']));
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['ip_info']['s_user_id']=$this->SOBJ->get_search_info('s_user_id');
				$final['ip_info']['s_user_id_title']=$this->SOBJ->get_search_info('s_user_id_title');
				$final['ip_info']['s_user_id_title']['onclick']="PL_ChangePL('s_user');";
				$final['ip_info']['s_user_id_title']['onfocus']="PL_ChangePL('s_user');";
				
				$final['ip_info']['target_db']=array(
                        'call_name'=>'DB',
                        'type'=>'select',
                        'ld'=>$this->CM->db->where('iseasyflow','Y')->where('isactive','Y')->get('jec_company')->result_array(),
						'ld_key'=>'jec_company_id',
						'ld_value'=>'name',
						'full_selected'=>'N',
						'style'=>'display:none;'//Ef.net僅剩弓銓站台	
					);

				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);

				
				
				$final['file_list']=array();
				
            	//$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name','add_zero'=>'Y'),'page_db',1);
				//proj_edit_op
				
				//$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				//$final['projj_data']=$this->CM->db->where('jec_project_id',$final['projt_data']['jec_project_id'])->where('jec_job_id',$final['projt_data']['jec_job_id'])->where('isactive','Y')->get($projj_set['mm_tb'])->result_array();
				
				$final['tcate_url']=array(
						'work_list_index'=>base_url($final['var_purl'].'work_list_index/list/0/startdate/asc/0/N/'),
						'work_report_index'=>base_url($final['var_purl'].'work_report_index/list/'.$df_ip['key_id'].'/'),
						'work_record_index'=>base_url($final['var_purl'].'work_record_index/list/'.$df_ip['key_id'].'/created/DESC/0/-1/')
					);
				if(isset($_SESSION['w_url'])&&$_SESSION['w_url']!=''):
					$final['w_url']=$_SESSION['w_url'];
					$_SESSION['w_url']='';					
				endif;
					/*
				$mssqlef=$this->load->database('mssqlef',TRUE);
				$final['test']=$mssqlef->query('select FieldName FROM ressa ORDER BY FieldName ')->result_array();
				$default=$this->load->database('default',TRUE);*/
            break;
			
			case 'list_div':
				$final['assign_view']='prod_list_div';
				$this->load->library('form_input');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name','add_zero'=>'Y'),'page_db',1);
				
			break;

			
			case 'update_projprod':
				$gv=array("projprod_id",'price','quantity','vendor_name','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$upd=$gv;
				unset($upd['projprod_id']);
				unset($upd['no']);
				$upd['total']=$upd['price']*$upd['quantity'];
				$upd['salecostcalc']=$upd['total'];
				$this->GM->common_ac('update',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projprod_id']));
				
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$this->$projt_set['mm_set']->recount_projtask_total($df_ip['key_id'],'U');
                $ajo=array(
					'msg'=>'已修改',
					'innerId'=>'total_tag_'.$no,
					'innerHTML'=>$upd['total'],
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			case 'purchase_form_div':
				$final['assign_view']='purchase_form_div';
				$final['p_user']=$this->QIM->get_user_row($this->ad_id);
				$ad005_set=$this->CM->Init_TB_Set('mm_ad005_set');
				$this->load->library('form_input');
                $final['ip_info']=$this->$ad005_set['mm_set']->load_mm_field_check();
				$final['main_data']=array('ad005009'=>date('Y/m/d'),'ad005006'=>$final['p_user']['jec_user_id'],'ad005006_title'=>$final['p_user']['name'],'ad005053'=>'A','ad005059'=>'一般報支','ad005055'=>'否');
				$final['ip_info']['ad005053']['disabled']='Y';
				$final['ip_info']['ad005059']['disabled']='Y';
				$final['ip_info']['ad005055']['disabled']='Y';
				$final['ip_info']['ad005017']['disabled']='Y';
				
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['form_url']=base_url($final['var_purl'].$df_ip['tag'].'/submit_purchase/'.$df_ip['key_id'].'/');
				//預代廠商+採購人員-廠商
				
				//$mssqlef=$this->load->database('mssqlef',TRUE);
				//$df=$this->load->database('default',TRUE);
				//$final['test']=$mssqlef->query("SELECT * FROM ressa ")->result_array();
				//$final['test']=$mssqlef->limit(10,0)->get('ressa')->result_array();
				//$this->load->database('default',TRUE);
			break;
			
			case 'purchase_prod_div':
				$final['p_user']=$this->QIM->get_user_row($this->ad_id);
				$final['assign_view']='purchase_prod_div';
				$final['prod_array']=explode('-',$df_ip['chinfo']);
				$final['prod_string']=$df_ip['chinfo'];
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				//
				
			break;
			case 'submit_purchase'://
				$_G['os']=$this->GM->GetSpecData('jec_setup','value','noticetype','OS');
			
				$final['p_user']=$this->QIM->get_user_row($this->ad_id);
				$gv=array('prod_string','uselast_string','target_db','s_user_id'); $gv=$this->CM->GPV($gv);
				//$target_db=$this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$gv['target_db']);
				$target_db='mssqlefnet';
				//'prod_string',"ad005053",'ad005059','ad005055','ad005005','ad005009','ad005006','ad005010','ad005013','ad005016','ad005038','ad005037','ad005054','ad005056','ad005057','ad005060','ad005018','ad005017', 

				//count_num&&get_word....申請、領用->督導! 
				$final['prod_array']=explode('-',$gv['prod_string']);
				
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);

				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));	
				$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');	
				$final['projj_data']=$this->$projj_v_set['mm_set']->get_projjob_row($final['projt_data']['jec_projjob_id']);		
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');

				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));

				//$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				//$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				//OK_V
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$proj_data=$this->$proj_set['mm_set']->get_project_row($final['projt_data']['jec_project_id']);

				$proj_dept=$this->GM->GetSpecData('jec_dept','name','jec_dept_id',$proj_data['jec_dept_id']);
				$proj_dept_efvalue=$this->GM->GetSpecData('jec_dept','ef_value','name',$proj_data['efprojdept']);
				$proj_company=$this->GM->GetSpecData('jec_company','name','jec_company_id',$proj_data['jec_company_id']);
				
				$serial=date('Y-m-d-H-i-s-').rand(100,999);
				$time=date('Y/m/d H:i:s');				
		
				//$p_user=$this->QIM->get_user_row($gv['ad005006']);//$this->ad_id
				//$p_user=$this->QIM->get_user_row($this->ad_id);
				$gv['s_user_id']=(int)$gv['s_user_id']==0?$proj_data['jec_usersales_id']:$gv['s_user_id'];//OK.
				$p_user=$this->QIM->get_user_row($gv['s_user_id']);
				//$gv['ad005010']=$gv['ad005013']=$final['projt_data']['jec_usersuper_id']; //先預設與採購一樣吧
				//$a_user=$gv['ad005010']>0?$this->QIM->get_user_row($gv['ad005010']):array('value'=>'','name'=>'');
				$r_user=$gv['ad005013']>0?$this->QIM->get_user_row($gv['ad005013']):array('value'=>'','name'=>'');
				$a_user=$final['p_user'];
				
				$total_amt=0;//稅前- 
				$total_ad_amt=0;//稅後
				$total_ch_amt='';//稅後國字
				$final_vendor_id=0;		
				$need_date='';//需用
				$last_charge='';//備品清單未花費用
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				foreach($final['prod_array'] as $vv):
					if($vv>0):
						$this->db->where('jec_projprod_id',$vv)->update('jec_projprod',array('exportcode'=>$serial,'exporttime'=>$time,'isexport'=>'Y','jec_company_id'=>$gv['target_db']));
						$vvv=$this->$projp_v_set['mm_set']->get_projprod_row($vv);
						
						$total_amt+=(float)$vvv['total'];
						$total_ad_amt+=round((float)$vvv['total']*1.05);
						$final_vendor_id=$vvv['jec_vendor_id']>0?$vvv['jec_vendor_id']:$vvv['jec_vendor_id'];
						$final_vendor_name=$vvv['vendor_name'];
						if($need_date==''&&$vvv['startdate']!='0000-00-00 00:00:00') $need_date=$vvv['startdate'];
						//$this->CM->JS_TMsg($vv.'-'.$vvv['total'].'='.$total_ad_amt);
					//$this->CM->JS_TMsg($vv);
					//已匯=
					//計算實際花費與預估成本差異,並增加新的明細
					$last_charge=$vvv['estimcostcalc']-$vvv['total'];
					if($gv['uselast_string']=='Y' && $last_charge>0)
					{
						$this->db->where('jec_projprod_id',$vv)->update('jec_projprod',array('estimcostcalc'=>$vvv['total']));
						//insert
						$upd=array(
							'jec_project_id'=>$vvv['jec_project_id'],
							'jec_projtask_id'=>$vvv['jec_projtask_id'],
							'jec_product_id'=>$vvv['jec_product_id'],
							'prodtype'=>$vvv['prodtype'],
							'quantity'=>'1',
							'total'=>$last_charge,
							'price'=>$last_charge,
							'extramultiple'=>'1',
							'salecostcalc'=>$last_charge,
							'jec_vendor_id'=>$vvv['jec_vendor_id'],
							'description'=>$vvv['description'],
							'prodname'=>$vvv['prodname'],
							'prodspec'=>$vvv['prodspec'],
							'prod_uom_id'=>$vvv['prod_uom_id'],
							'jec_productprep_id'=>$vvv['jec_productprep_id'],
							'estimcostcalc'=>$last_charge
						);
					$upd['seqno']=$this->$projp_set['mm_set']->get_projprod_series($df_ip['key_id']);
					$upd=array_merge($upd,$this->CM->Base_New_UPD());
					$this->GM->common_ac('insert',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$upd));
						//$this->db->insert('jec_projprod',array('exportcode'=>$serial,'exporttime'=>$time,'isexport'=>'Y','jec_company_id'=>$gv['target_db']));
					}
					//確認是否有產生備品清單xls				
					if($vvv['jec_productprep_id'] != ''):				
						if(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['value'].'.xls'))):
						$preprodxls=$this->config->item('base_url').'uploads/project_file/'.$proj_data['value'].'/'.'履約備品清單-'.$proj_data['value'].'.xls;Y';
						elseif(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['name'].'.xls'))):
						$preprodxls=$this->config->item('base_url').'uploads/project_file/'.$proj_data['value'].'/'.'履約備品清單-'.$proj_data['name'].'.xls;Y';
						endif;	
					else:
						if($proj_data['exportcode'] != ''):				
					if(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['value'].'.xls'))):
					$preprodxls=$this->config->item('base_url').'uploads/project_file/'.$proj_data['value'].'/'.'履約備品清單-'.$proj_data['value'].'.xls;N';
					elseif(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['name'].'.xls'))):
					$preprodxls=$this->config->item('base_url').'uploads/project_file/'.$proj_data['value'].'/'.'履約備品清單-'.$proj_data['name'].'.xls;N';
					endif;				
				endif;		
					endif;
				  endif;
				endforeach;	
				//$this->CM->JS_TMsg($total_ad_amt);
				$total_ch_amt=$this->CM->FormatData(array('num'=>$total_ad_amt,'mode'=>true),'number','ch_num');
				$jec_vendor_id=$final_vendor_id;//$gv['ad005005']; 
				//$this->CM->JS_TMSg($jec_vendor_id);//
				if($jec_vendor_id>0):
					$vendor_no=$this->GM->GetSpecData('jec_vendor','value','jec_vendor_id',$jec_vendor_id);
					$vendor_name=$this->GM->GetSpecData('jec_vendor','name','jec_vendor_id',$jec_vendor_id);
					foreach($final['prod_array'] as $vv):
						if($vv>0):
							$this->db->where('jec_projprod_id',$vv)->update('jec_projprod',array('jec_vendor_id'=>$jec_vendor_id));
						endif;
					endforeach;
				else:
					$vendor_no='';
					$vendor_name=$final_vendor_name;
				endif;
				
				//-
				
				
				
				//$this->CM->JS_TMsg('xxx'.$gv['prod_string']);
				//exit();		
				//$this->CM->JS_TMsg('^^^^^');	
				//$this->CM->JS_TMsg($target_db);	
				$mssqlef=$this->load->database($target_db,TRUE);//mssqlef
				//$mssqlef=$this->load->database('mssqlef',TRUE);
				$ms_p_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$this->CM->db_trans($p_user['value'],'input')."'")->result_array();
				if(count($ms_p_user)>0):
					$ms_p_user=$ms_p_user[0];
				else:
					$ms_p_user=array('deptno'=>'','deptname'=>'');
				endif;
				if($a_user['value']==''):
					$ms_a_user=array('deptno'=>'','deptname'=>'');
				else:
					$ms_a_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$this->CM->db_trans($a_user['value'],'input')."'")->result_array();
					$ms_a_user=$ms_a_user[0];
				endif;
				if($r_user['value']==''):
					$ms_r_user=array('deptno'=>'','deptname'=>'');
				else:
					$ms_r_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$this->CM->db_trans($r_user['value'],'input')."'")->result_array();
					$ms_r_user=$ms_r_user[0];
				endif;
				

				//取得採購的-SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='9220';			
				
				
				$is_projpurchase=$proj_data['efprojno']==''?'否':'是';	
				$a_user['value']!=$p_user['value']?$useman=$p_user['value'].'-'.$p_user['name'].';':$useman='';
				
				$odmems005_upd=array(
						'odmems005011'=>'其他',//vendor_id
						'odmems005011C'=>$this->CM->pdb_trans($vendor_name),//vendor_name						
						'odmems005012'=>$this->CM->pdb_trans($a_user['value']),
						'odmems005012C'=>$this->CM->pdb_trans($a_user['name']),
						'odmems005013'=>$ms_a_user['deptname'],//p_dept
						'odmems005017'=>$need_date==''?'':$this->CM->pdb_trans(date('Ymd',strtotime($need_date))),//$gv['ad005009']-需用日期
						'odmems005014'=>$this->CM->pdb_trans($p_user['value']),
						'odmems005014C'=>$this->CM->pdb_trans($p_user['name']),
						'odmems005041'=>$ms_p_user['deptname'],//apply_dept
						'odmems005015'=>$this->CM->pdb_trans($p_user['value']).'-'.$this->CM->pdb_trans($p_user['name']).';',//領用人
						'odmems005020'=>$this->CM->db_trans($gv['ad005016']), //附註用途
						'odmems005037'=>$this->CM->pdb_trans($total_ch_amt.'元整'),//採購金額國字 $gv['ad005017']
						'odmems005036'=>$this->CM->pdb_trans((string)$total_ad_amt),//採購金額-數字  $gv['ad005018']							
						//'odmems005101'=>$this->CM->pdb_trans('現金'),
						//'odmems005109'=>$this->CM->pdb_trans('郵寄'),
						'odmems005029'=>$this->CM->pdb_trans('0'), //調整金額
						'odmems005027'=>$this->CM->pdb_trans((string)$total_ad_amt),//$gv['ad005038']預定採購金額
						'odmems005031'=>$this->CM->pdb_trans('0'),//代辦扣款						
						'odmems005009'=>$this->CM->pdb_trans('無'),//表單來源：無 / 設備汰舊換新申請表 / 模(治)具製作/維修申請單 / 模(治)具申請單						
						'odmems005036'=>$this->CM->pdb_trans((string)$total_ad_amt),//實際請款金額
						'odmems005004'=>$this->CM->pdb_trans("B流程"),//$gv['ad005053']
						'odmems005030'=>$this->CM->db_trans($gv['ad005054']), //調整金額原因						
						'odmems005032'=>$this->CM->pdb_trans((string)0),//$gv['ad005056']議價金額 - 
						'odmems005033'=>$this->CM->pdb_trans((string)0), //$gv['ad005057']折扣金額	
						'odmems005035'=>$this->CM->pdb_trans($a_user['name']),//p_acc					
						'odmems005005'=>$this->CM->pdb_trans('一般報支'),//$gv['ad005059']
						'odmems005034'=>$this->CM->db_trans($gv['ad005060']), //折扣原因//
						'odmems005112'=>$this->CM->db_trans('月份'),
						'odmems005016'=>$this->CM->pdb_trans('其他'),//採購用途：其他 / 外訓 / 設備增購 / 設備維修及保養 / 押標金 / 履約保證金 / 發展專案費 /						
						'odmems005303'=>$this->CM->pdb_trans('0'),//逾期扣款						
						'odmems005018'=>$this->CM->pdb_trans('無'),//資產類別：無/辦公類/試驗類/量測類/運輸類/模具類/治具類/工具類/印章類/軟體類/設施類/						
						'odmems005901'=>$useman,//單身歸屬人	
						'odmems005902'=>$useman,//單頭領用人		
						'odmems005903'=>$preprodxls,//備品清單檔,						
						'odmems005904'=>$this->CM->pdb_trans($serial)				
				);
				
				/*
				if($vendor_no==''):
					unset($upd['ad005004']);
					unset($upd['ad005005']);
				endif;*/	
				
				//$this->CM->JS_TMsg($time);
				//$mssqlef=$this->load->database('mssqlef',TRUE);
				//$test=$erp->query("SELECT * FROM obpd_category_list WHERE ac_mark='0'")->result_array();
				//$final['test']=$test;
				//$df=$this->load->database('default',TRUE);
				$odmems005s1=array(
						'odmems005s1001'=>array(),//fix
						'odmems005s1002'=>array(),
						'odmems005s1003'=>array(),//serial
						'odmems005s1004'=>array(),//name
						'odmems005s1005'=>array(),//spec
						'odmems005s1006'=>array(),//num
						'odmems005s1007'=>array(),//單位
						'odmems005s1008'=>array(),//price
						'odmems005s1009'=>array(),//費用規屬
						'odmems005s1010'=>array(),//規屬者
						'odmems005s1011'=>array(),//desc
						'odmems005s1012'=>array(),//total
						'odmems005s1013'=>array(),//tax
						'odmems005s1014'=>array(),//after tax
						'odmems005s1015'=>array(),//專案
						'odmems005s1016'=>array(),//專案部門代號
						'odmems005s1016C'=>array(),//專案部門名稱 
						'odmems005s1017'=>array(),//專案號
						'odmems005s1017C'=>array()//專案名									
					);	
				
					
				$no=-1;	//
				//確認費用是否掛專案
				if($proj_data['efprojno'] !='')
				{
				$isporject="是";				
				}
				else
				{
				$isporject="否";
				}
				foreach($final['main_list'] as $eno=>$eprod):
					
					if(in_array($eprod['jec_projprod_id'],$final['prod_array'])): $no++;
						array_push($odmems005s1['odmems005s1001'],$this->CM->pdb_trans('ODMEMS005'));
						array_push($odmems005s1['odmems005s1002'],'AutoNumber');
						array_push($odmems005s1['odmems005s1003'],$this->CM->pdb_trans($this->CM->FormatData(array('len'=>4,'value'=>($no+1)),'number','fill_num')));//printf("%04d", ($no+1))
						array_push($odmems005s1['odmems005s1004'],$this->CM->pdb_trans($eprod['prodname'])); //品名
						// Update by Johnson 2013/02/20
						//array_push($ad005s['ad005s005'],$this->CM->pdb_trans($eprod['name'])); //品名
						//array_push($ad005s['ad005s006'],$this->CM->pdb_trans($eprod['specification'])); //規格
						array_push($odmems005s1['odmems005s1005'],$this->CM->pdb_trans($eprod['prodspec'])); //規格
						array_push($odmems005s1['odmems005s1006'],$this->CM->pdb_trans((string)(float)$eprod['quantity'])); //數量(float)
						array_push($odmems005s1['odmems005s1007'],$this->CM->pdb_trans($final['uom_pdb'][$eprod['prod_uom_id']])); //單位 ---
						
						//array_push($ad005s['ad005s008'],$this->CM->pdb_trans($final['uom_pdb'][$eprod['jec_uom_id']])); //單位 ---
						array_push($odmems005s1['odmems005s1008'],$this->CM->pdb_trans((string)(float)$eprod['price'])); //單價(float)
						array_push($odmems005s1['odmems005s1009'],$this->CM->pdb_trans('人員')); //人員部門-@@@
						
						array_push($odmems005s1['odmems005s1010'],$this->CM->pdb_trans($p_user['value'].'-'.$p_user['name'])); //歸屬名稱
						array_push($odmems005s1['odmems005s1011'],$this->CM->pdb_trans($eprod['description'])); //備註
						
						array_push($odmems005s1['odmems005s1012'],$this->CM->pdb_trans((string)(float)$eprod['total'])); //小計(float)
						array_push($odmems005s1['odmems005s1013'],$this->CM->pdb_trans((string)'N')); //$this->CM->db_trans($eprod['外加'])
						array_push($odmems005s1['odmems005s1014'],$this->CM->pdb_trans((string)round($eprod['total']*1.05))); //合計(float)-要改-round
						array_push($odmems005s1['odmems005s1015'],$isporject); //是否專案採購
						
						array_push($odmems005s1['odmems005s1016'],$proj_dept_efvalue);//專案部門代號
						array_push($odmems005s1['odmems005s1016C'],$proj_data['efprojdept']); //專案部門
						array_push($odmems005s1['odmems005s1017'],$proj_data['efprojno']);//專案部門代號
						array_push($odmems005s1['odmems005s1017C'],$proj_data['efprojname']); //專案部門
						
					endif;//cp950
				endforeach;
				
				//主旨
				
					$e_upd=array(
							'strFormID'=>$this->CM->pdb_trans('ODMEMS005'),
							'ScriptSheetNo'=>$this->CM->pdb_trans($time),
							'Owner'=>$this->CM->pdb_trans($final['p_user']['value']),//acc
							'RecordsetName'=>$this->CM->pdb_trans('resda'),
							'FieldName'=>$this->CM->pdb_trans('ScriptSubj'),
							'RecordIndex'=>$this->CM->pdb_trans(1),
							'FieldValue'=>$this->CM->pdb_trans('1§PMS-'.$proj_company.'-'.$proj_data['name'].'-'.$final['projj_data']['jobname'].'-'.$final['projt_data']['taskname']) //$現在日期$-$專案名稱$-$任務名稱$-$工作明稱$
						);
					//$this->CM->JS_TMsg($e_upd['FieldName']);
					$mssqlef->insert('ressa',$e_upd);
								
				$xmlstr=
				"<diffgr:diffgram xmlns:msdata=\"urn:schemas-microsoft-com:xml-msdata\" xmlns:diffgr=\"urn:schemas-microsoft-com:xml-diffgram-v1\">
  <NewDataSet>
    <RESULT diffgr:id=\"RESULT2\" msdata:rowOrder=\"0\" diffgr:hasChanges=\"inserted\">
      <COMPANY>EFNETDB</COMPANY>
      <CREATE_DATE>".date("Ymd")."</CREATE_DATE>
      <CREATOR>".$this->CM->pdb_trans($final['p_user']['value'])."</CREATOR>
      <FLAG>1</FLAG>
      <USR_GROUP>0000</USR_GROUP>
      <odmems005001>ODMEMS005</odmems005001>
      <odmems005002>AutoNumber</odmems005002>  
	  <odmems005003>弓銓</odmems005003>    
      <odmems005004>".$odmems005_upd['odmems005004']."</odmems005004>      
      <odmems005005>".$odmems005_upd['odmems005005']."</odmems005005>
      <odmems005009>".$odmems005_upd['odmems005009']."</odmems005009>
      <odmems005011>".$odmems005_upd['odmems005011']."</odmems005011>
	  <odmems005011C>".$odmems005_upd['odmems005011C']."</odmems005011C>
	  <odmems005012>".$odmems005_upd['odmems005012']."</odmems005012>
	  <odmems005012C>".$odmems005_upd['odmems005012C']."</odmems005012C>
	  <odmems005013>".$odmems005_upd['odmems005013']."</odmems005013>
	  <odmems005014>".$odmems005_upd['odmems005014']."</odmems005014>
	  <odmems005014C>".$odmems005_upd['odmems005014C']."</odmems005014C>
	  <odmems005015>".$odmems005_upd['odmems005015']."</odmems005015>
	  <odmems005016>其他</odmems005016>
	  <odmems005017>".$odmems005_upd['odmems005017']."</odmems005017>
	  <odmems005018>無</odmems005018>
	  <odmems005020>".$odmems005_upd['odmems005020']."</odmems005020>
	  <odmems005027>".$odmems005_upd['odmems005027']."</odmems005027>
	  <odmems005028>0</odmems005028>
	  <odmems005029>".$odmems005_upd['odmems005029']."</odmems005029>
	  <odmems005030>".$odmems005_upd['odmems005030']."</odmems005030>
	  <odmems005031>".$odmems005_upd['odmems005031']."</odmems005031>
	  <odmems005032>".$odmems005_upd['odmems005032']."</odmems005032>
	  <odmems005033>".$odmems005_upd['odmems005033']."</odmems005033>
	  <odmems005034>".$odmems005_upd['odmems005034']."</odmems005034>
	  <odmems005035>".$odmems005_upd['odmems005035']."</odmems005035>
	  <odmems005036>".$odmems005_upd['odmems005036']."</odmems005036>
	  <odmems005037>".$odmems005_upd['odmems005037']."</odmems005037>
	  <odmems005041>".$odmems005_upd['odmems005041']."</odmems005041> 
	  <odmems005043>否</odmems005043>    
	  <odmems005047>NTD$</odmems005047>	  
	  <odmems005110>N</odmems005110>
	  <odmems005112>".$odmems005_upd['odmems005112']."</odmems005112>
	  <odmems005301>N</odmems005301>
	  <odmems005303>".$odmems005_upd['odmems005303']."</odmems005303>
	  <odmems005901>".$odmems005_upd['odmems005901']."</odmems005901>
	  <odmems005902>".$odmems005_upd['odmems005902']."</odmems005902>
	  <odmems005903>".$odmems005_upd['odmems005903']."</odmems005903>
	  <odmems005904>".$odmems005_upd['odmems005904']."</odmems005904>
    </RESULT>
  </NewDataSet>
</diffgr:diffgram>
				";														
				
					$e_upd=array(
							'strFormID'=>$this->CM->pdb_trans('ODMEMS005'),
							'ScriptSheetNo'=>$this->CM->pdb_trans($time),
							'Owner'=>$this->CM->pdb_trans($final['p_user']['value']),//acc
							'RecordsetName'=>$this->CM->pdb_trans('rstODMEMS005'),
							'FieldName'=>'',
							'RecordIndex'=>$this->CM->pdb_trans(0),
							'FieldValue'=>$xmlstr
						);
					//insert
					
					$mssqlef->insert('ressa',$e_upd);					
				
				$xmlstr=
				"<diffgr:diffgram xmlns:msdata=\"urn:schemas-microsoft-com:xml-msdata\" xmlns:diffgr=\"urn:schemas-microsoft-com:xml-diffgram-v1\">
  <NewDataSet>";
  
				$detail=array();
				for($i=0;$i<count($final['main_list']);$i++)
				{
					array_push($detail,
					"<RESULT diffgr:id=\"RESULT".($i+2)."\" msdata:rowOrder=\"".$i."\" diffgr:hasChanges=\"inserted\">
      <COMPANY>EFNETDB</COMPANY>
      <CREATE_DATE>".date("Ymd")."</CREATE_DATE>
      <CREATOR>".$this->CM->pdb_trans($p_user['value'])."</CREATOR>
      <FLAG>1</FLAG>
      <USR_GROUP>0000</USR_GROUP>");
				}
				foreach($odmems005s1 as $st=>$sv):
					foreach($sv as $eno=>$vv):
					
					$detail[$eno]=$detail[$eno]."<".$st.">".$vv."</".$st.">";
  					
					endforeach;
				endforeach;
				
				for($i=0;$i<count($odmems005s1['odmems005s1001']);$i++)
				{
					$detail[$i]=$detail[$i]."</RESULT>";
					$xmlstr=$xmlstr.$detail[$i];
				}
				
				$xmlstr=$xmlstr."</NewDataSet></diffgr:diffgram>";
				log_message('info','xml:'.$xmlstr);	
				$e_upd=array(
								'strFormID'=>$this->CM->pdb_trans('ODMEMS005'),
								'ScriptSheetNo'=>$this->CM->pdb_trans($time),
								'Owner'=>$this->CM->pdb_trans($final['p_user']['value']),//acc
								'RecordsetName'=>$this->CM->pdb_trans('rstODMEMS005S1'),
								'FieldName'=>'',
								'RecordIndex'=>$this->CM->pdb_trans(0),
								'FieldValue'=>$xmlstr	
							);
				$mssqlef->insert('ressa',$e_upd);	
				//Insert add003s
				//Rreload.
				//http://easy.ems.com.tw/ef2kwebtest/CHT/Forms/Form_Load.asp?strFilter=ALL&DoAction=Init
				$_SESSION['w_url']=$this->GM->GetSpecData('jec_company','description','jec_company_id',$gv['target_db']);
				//$_SESSION['w_url']='http://easy.ems.com.tw/ef2kwebtest/CHT/Forms/Form_Load.asp?strFilter=ALL&DoAction=Init';
				$final['acbk_url']=base_url($final['var_purl'].'work_detail_index/list/'.$df_ip['key_id'].'/after_sumit_purchase');
				$final['response_type']='bk_ac';
				//				
			break;
			
			case 'get_recount_result':
				$num=(float)$_POST['num'];//(float)
				$ch_num=$this->CM->FormatData(array('num'=>$num),'number','ch_num');
                $ajo=array(
					'bk_action'=>'input_recount_result',
					'ch_num'=>$ch_num,
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'export_excel':
				$excel_type=$_POST['excel_type'];
			
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
			
				
				require_once("append_tools/phpexcel/Classes/PHPExcel.php"); 
				$objPHPExcel = new PHPExcel();

				// Set properties
				$objPHPExcel->getProperties()->setCreator("EMS System")
							 ->setLastModifiedBy("EMS System")
							 ->setTitle("Product")
							 ->setSubject("Product")
							 ->setDescription("Product")
							 ->setKeywords("Product")
							 ->setCategory("Product");


				// Add some data
			    $objPHPExcel->setActiveSheetIndex(0)
            				//->setCellValue('A1', '料號')
            				->setCellValue('A1', '品名')
            				->setCellValue('B1', '規格')
            				->setCellValue('C1', '單位')
							->setCellValue('D1', '數量')
							->setCellValue('E1', '預估單價')
							->setCellValue('F1', '預估合計')
							->setCellValue('G1', '需求日期')
							->setCellValue('H1', '採購廠商')
							->setCellValue('I1', '備註')
							->setCellValue('J1', '匯出日期');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 //->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('A'.$eno, $value['name'])
						 ->setCellValue('B'.$eno, $value['specification'])
						 ->setCellValue('C'.$eno, $final['uom_pdb'][$value['jec_uom_id']])
						 ->setCellValue('D'.$eno, $value['quantity'])
						 ->setCellValue('E'.$eno, $value['price'])
						 ->setCellValue('F'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('G'.$eno, substr($value['startdate'],0,10))
						 ->setCellValue('H'.$eno, $value['vendor_name'])
						 ->setCellValue('I'.$eno, $value['description'])
						 ->setCellValue('J'.$eno, $value['exporttime'])
						 ;	
				endforeach;


				// Rename sheet
				$objPHPExcel->getActiveSheet()->setTitle('Product');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="product-'.date('Y-m-d').'.'.$excel_type.'"');
				header('Cache-Control: max-age=0');

				switch($excel_type):
					case 'xls':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					break;
					case 'xlsx':
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					break;
				endswitch;
				
				$objWriter->save('php://output');
				exit;
			break;
			case 'refresh_purchase_status'://更新表單狀況 
				//$ch_num=$this->CM->FormatData(array('num'=>$num),'number','ch_num');
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));	
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isexport'=>'Y','con_isactive'=>'Y')));
				$mysql_db=$this->db;
				//db分頁…超煩的= =
				$main_list=$this->$projp_set['mm_set']->classify_purchase_check_item_by_db($final['main_list']);
				//$msg='x'.count($main_list);
				foreach($main_list as $db_id=>$e_list):
					//check_each_value
					//$msg.='x'.$db_id.'='.count($e_list);
					if((int)$db_id>0)://mssqlef
						//$e_db=$this->load->database($this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$db_id),TRUE);
						$e_db=$this->load->database('mssqlefnet',TRUE);
						foreach($e_list as $e_value):
						//check-check-e_value.e_db
							//$check_1=$e_db->query("SELECT * FROM ressa WHERE FieldValue='".$e_value['exportcode']."' AND strFormID='AD005' AND FieldName='ad005910'")->result_array();
							include('tools/common/purchase_item_check.php');
						endforeach;
					endif;
				endforeach;
				
				
                $ajo=array(
					'bk_action'=>'after_refresh_purchase',
					'msg'=>'更新完畢',//.$msg
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
			case 'check_charge_user':
				
				$bk_action=$_POST['bk_action'];
				switch($bk_action):
					
					case 'export_purchase':
						$gv=array('user_name');
						break;
					default:
						$gv=array('sales_name');
						break;
				endswitch;
				$gv=$this->CM->GPV($gv);
				$supername=$superid=$salesname=$salesid=$salesdept=$msg='';
				$pass='Y';
				if($pass=='Y'&&isset($gv['sales_name']))://user_sales
					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$salesname=$check[0]['name'];
						$salesid='U-'.$check[0]['jec_user_id'];
					else:
						//check_GROUP
						$check2=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_group')->result_array();
						if(count($check2)>0):
							$pass='Y';
							$salesname=$check2[0]['name'];
							$salesid='G-'.$check2[0]['jec_group_id'];
						else:
							$pass='N';
							$msg='查無此人員';
						endif;

					endif;
				endif;
				if($pass=='Y'&&isset($gv['user_name']))://user_sales
					$check=$this->db->where('name',$gv['user_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$username=$check[0]['name'];
						$userid=$check[0]['jec_user_id'];
					else:
							$pass='N';
							$msg='查無此人員';

					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>$bk_action,
					'isexist'=>$pass,
                    'pass'=>1
                );
				
				if(isset($gv['sales_name'])): 
					$ajo['sales_name']=$salesname;
					$ajo['sales_id']=$salesid;
				endif;
				if(isset($gv['user_name'])): 
					$ajo['user_name']=$username;
					$ajo['user_id']=$userid;
				endif;
				if($msg!='') $ajo['msg']=$msg;
				if(isset($gv['no'])) $ajo['no']=$gv['no'];
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
        endswitch;
?>