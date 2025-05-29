<?php
        switch($df_ip['ac']):
            case 'list': 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				//$final['form_url']=site_url($final['var_purl'].'prod_list_index/add_projprod/'.$df_ip['key_id'].'/');
				//
				$final['prod_list_url']=site_url($final['var_purl'].'work_detail_index/list_div/'.$df_ip['key_id'].'/');
				$final['update_projprod_url']=site_url($final['var_purl'].'work_detail_index/update_projprod/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=site_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/');
				$final['purchase_form_url']=base_url($final['var_purl'].$df_ip['tag'].'/purchase_form_div/'.$df_ip['key_id'].'/');
				$final['purchase_prod_url']=base_url($final['var_purl'].$df_ip['tag'].'/purchase_prod_div/'.$df_ip['key_id'].'/created/ASC/0/');
				$final['recount_result_url']=site_url($final['var_purl'].'work_detail_index/get_recount_result/'.$df_ip['key_id'].'/');
				
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
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_product_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_product_id'),'page_db','s_array');				
                $final['main_data']=array('startdate'=>date('Y-m-d')); 
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');

				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);

				
				
				$final['file_list']=array();
				
            	//$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				//proj_edit_op

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
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
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				
			break;

			
			case 'update_projprod':
				$gv=array("projprod_id",'price','quantity','jec_vendor_id','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$upd=$gv;
				unset($upd['projprod_id']);
				unset($upd['no']);
				$upd['total']=$upd['price']*$upd['quantity'];
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
				
			break;
			
			case 'submit_purchase':

				$_G['os']=$this->GM->GetSpecData('jec_setup','value','noticetype','OS');
			
				$final['p_user']=$this->QIM->get_user_row($this->ad_id);
				$gv=array('prod_string',"ad005053",'ad005059','ad005055','ad005005','ad005009','ad005006','ad005010','ad005013','ad005016','ad005038','ad005037','ad005054','ad005056','ad005057','ad005060','ad005018','ad005017','prod_string'); $gv=$this->CM->GPV($gv);


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
				$serial=date('Y-m-d-H-i-s-').rand(100,999);
				$time=date('Y/m/d H:i:s');				
		
				$p_user=$this->QIM->get_user_row($gv['ad005006']);
				$a_user=$gv['ad005010']>0?$this->QIM->get_user_row($gv['ad005010']):array('value'=>'','name'=>'');
				$r_user=$gv['ad005013']>0?$this->QIM->get_user_row($gv['ad005013']):array('value'=>'','name'=>'');
				
				$jec_vendor_id=$gv['ad005005'];
				$vendor_no=$this->GM->GetSpecData('jec_vendor','value','jec_vendor_id',$jec_vendor_id);
				$vendor_name=$this->GM->GetSpecData('jec_vendor','name','jec_vendor_id',$jec_vendor_id);				
				foreach($final['prod_array'] as $vv):
					$this->db->where('jec_projprod_id',$vv)->update('jec_projprod',array('exportcode'=>$serial,'exporttime'=>$time,'isexport'=>'Y','jec_vendor_id'=>$jec_vendor_id));
					//$this->CM->JS_TMsg($vv);
					//已匯=
				endforeach;	

				
				
				//$this->CM->JS_TMsg('xxx'.$gv['prod_string']);
				//exit();		
						
				$mssqlef=$this->load->database('mssqlef',TRUE);
				$ms_p_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$p_user['value']."'")->result_array();
				$ms_p_user=$ms_p_user[0];
				if($a_user['value']==''):
					$ms_a_user=array('deptno'=>'','deptname'=>'');
				else:
					$ms_a_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$a_user['value']."'")->result_array();
					$ms_a_user=$ms_a_user[0];
				endif;
				if($r_user['value']==''):
					$ms_r_user=array('deptno'=>'','deptname'=>'');
				else:
					$ms_r_user=$mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='".$r_user['value']."'")->result_array();
					$ms_r_user=$ms_r_user[0];
				endif;


				//取得採購的-SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='9220';


				$upd=array(
						'ad005001'=>'AD005',
						'ad005002'=>'',//
						'ad005900'=>$this->CM->db_trans($final['p_user']['value']),
						'ad005901'=>date('Y/m/d H:i:s'),
						'ad005902'=>'',
						'ad005903'=>'',
						'ad005904'=>$ms_p_user['deptname'],//dept
						'ad005905'=>'',
						'ad005003'=>'',//flow
						'ad005004'=>$vendor_name,//vendor_name
						'ad005005'=>$vendor_no,//vendor_no
						'ad005006'=>$p_user['value'],//p_acc
						'ad005007'=>$this->CM->db_trans($p_user['name']),//p_name
						'ad005008'=>$ms_p_user['deptname'],//p_dept
						'ad005009'=>$this->CM->db_trans($gv['ad005009']),
						'ad005010'=>$a_user['value'],
						'ad005011'=>$this->CM->db_trans($a_user['name']),
						'ad005012'=>$ms_a_user['deptname'],//apply_dept
						'ad005013'=>$r_user['value'],
						'ad005014'=>$this->CM->db_trans($r_user['name']),
						'ad005015'=>$ms_r_user['deptname'],//rece_dept
						'ad005016'=>$this->CM->db_trans($gv['ad005016']),
						'ad005017'=>$this->CM->db_trans($gv['ad005017']),
						'ad005018'=>$this->CM->db_trans($gv['ad005018']),
						'ad005019'=>'',//審核知會
						'ad005020'=>'',//領用人員
						'ad005021'=>$this->CM->db_trans('現金'),
						'ad005022'=>'',
						'ad005023'=>'',
						'ad005024'=>'',
						'ad005025'=>'',
						'ad005026'=>'',
						'ad005027'=>'',
						'ad005028'=>$this->CM->db_trans('郵寄'),
						'ad005029'=>'',
						'ad005030'=>'',
						'ad005031'=>'',
						'ad005032'=>'',
						'ad005033'=>'',
						'ad005034'=>'',
						'ad005035'=>'',
						'ad005036'=>$this->CM->db_trans('否'),//是否需填寫設備驗收單：是 / 否
						'ad005037'=>$this->CM->db_trans($gv['ad005037']),
						'ad005038'=>$this->CM->db_trans($gv['ad005038']),
						'ad005039'=>'',//代辦扣款
						'ad005040'=>'',
						'ad005098'=>'',
						'ad005041'=>'',
						'ad005042'=>'',
						'ad005099'=>'',
						'ad005043'=>'',//表單來源：無 / 設備汰舊換新申請表 / 模(治)具製作/維修申請單 / 模(治)具申請單
						'ad005044'=>'',
						'ad005045'=>'',
						'ad005046'=>'',
						'ad005047'=>'',
						'ad005048'=>'',
						'ad005049'=>'',
						'ad005050'=>'',
						'ad005051'=>$this->CM->db_trans('否'),//是否需填寫模(治)具檢驗記錄單：是 / 否
						'ad005052'=>'',
						'ad005053'=>$this->CM->db_trans($gv['ad005053']),
						'ad005054'=>$this->CM->db_trans($gv['ad005054']),
						'ad005055'=>$this->CM->db_trans($gv['ad005055']),
						'ad005056'=>$this->CM->db_trans($gv['ad005056']),
						'ad005057'=>$this->CM->db_trans($gv['ad005057']),
						'ad005058'=>0,
						'ad005059'=>$this->CM->db_trans($gv['ad005059']),
						'ad005060'=>$this->CM->db_trans($gv['ad005060']),
						'ad005061'=>'',//專dept
						'ad005062'=>'',//proj_value
						'ad005063'=>'',//proj_name
						'ad005064'=>$p_user['value'],
						'ad005065'=>$this->CM->db_trans($p_user['name']),
						'ad005066'=>$ms_p_user['deptname'],//p_dept
						'ad005067'=>'',
						'ad005068'=>'',
						'ad005069'=>$this->CM->db_trans($p_user['name']),
						'ad005070'=>'',
						'ad005071'=>'',
						'ad005072'=>$this->CM->db_trans('無'),
						'ad005073'=>'',
						'ad005074'=>'',
						'ad005075'=>'',
						'ad005076'=>'',//採購用途：其他 / 外訓 / 設備增購 / 設備維修及保養 / 押標金 / 履約保證金 / 發展專案費 / 
						'ad005077'=>'',
						'ad005078'=>0,
						'ad005079'=>$this->CM->db_trans('否'),//是否需附保固書或合約書：是 / 否
						'ad005080'=>'',//固資編號
						'ad005081'=>'',//資產類別：無/辦公類/試驗類/量測類/運輸類/模具類/治具類/工具類/印章類/軟體類/設施類/
						'ad005082'=>'',//設備編號,
						'ad005910'=>$serial						
					);

					

				//$this->CM->JS_TMsg($time);
				//$mssqlef=$this->load->database('mssqlef',TRUE);
				//$test=$erp->query("SELECT * FROM obpd_category_list WHERE ac_mark='0'")->result_array();
				//$final['test']=$test;
				//$df=$this->load->database('default',TRUE);
					
				$ad005s=array(
						'ad005s001'=>array(),//fix
						'ad005s002'=>array(),
						'ad005s003'=>array(),//serial
						'ad005s900'=>array(),//acc
						'ad005s901'=>array(),//time
						'ad005s902'=>array(),
						'ad005s903'=>array(),
						'ad005s904'=>array(),//部門ID
						'ad005s905'=>array(),
						'ad005s004'=>array(),//serial_num
						'ad005s005'=>array(),//name
						'ad005s006'=>array(),//spec
						'ad005s007'=>array(),//num
						'ad005s008'=>array(),//up
						'ad005s009'=>array(),//up
						'ad005s010'=>array(),//totol
						'ad005s011'=>array(),//??
						'ad005s012'=>array(),//desc
						'ad005s014'=>array(),//*1.05
						'ad005s015'=>array() //dept來源
						
					);
					
				foreach($final['main_list'] as $no=>$eprod):
					
					if(in_array($eprod['jec_projprod_id'],$final['prod_array'])):
						array_push($ad005s['ad005s001'],'AD005');
						array_push($ad005s['ad005s002'],'');
						array_push($ad005s['ad005s003'],$this->CM->FormatData(array('len'=>4,'value'=>($no+1)),'number','fill_num'));//printf("%04d", ($no+1))
						
						array_push($ad005s['ad005s900'],$p_user['value']);
						array_push($ad005s['ad005s901'],$time);
						array_push($ad005s['ad005s902'],'');
						array_push($ad005s['ad005s903'],'');
						array_push($ad005s['ad005s904'],'');//dept
						array_push($ad005s['ad005s905'],'');
						array_push($ad005s['ad005s004'],(string)($no+1));
						array_push($ad005s['ad005s005'],$this->CM->db_trans($eprod['name'])); //品名
						array_push($ad005s['ad005s006'],$this->CM->db_trans($eprod['specification'])); //規格
						array_push($ad005s['ad005s007'],$eprod['quantity']); //數量(float)
						
						array_push($ad005s['ad005s008'],$this->CM->db_trans($final['uom_pdb'][$eprod['jec_uom_id']])); //單位 --- 
						array_push($ad005s['ad005s009'],$eprod['price']); //單價(float)
						
						array_push($ad005s['ad005s010'],$eprod['total']); //小計(float)
						array_push($ad005s['ad005s011'],$this->CM->db_trans($p_user['value'].'-'.$p_user['name'])); //人員鋰部門@@@@
						array_push($ad005s['ad005s012'],$this->CM->db_trans($eprod['description'])); //後住
						array_push($ad005s['ad005s013'],$this->CM->db_trans('0')); //$this->CM->db_trans($eprod['外加'])
						
						array_push($ad005s['ad005s014'],$eprod['total'])*1.05; //合計(float)
						array_push($ad005s['ad005s015'],$this->CM->db_trans($p_user['value'].'-'.$p_user['name'])); //人員部門@@@
					endif;
				endforeach;

				//主旨
					$e_upd=array(
							'strFormID'=>'AD005',
							'ScriptSheetNo'=>$time,
							'Owner'=>$final['p_user']['value'],//acc
							'RecordsetName'=>'resda',
							'FieldName'=>'ScriptSubject',
							'RecordIndex'=>1,
							'FieldValue'=>$this->CM->db_trans(date('Y/m/d').'-'.$proj_data['name'].'-'.$final['projj_data']['name'].'-'.$final['projt_data']['name']) //$現在日期$-$專案名稱$-$任務名稱$-$工作明稱$
						);
					$mssqlef->insert('ressa',$e_upd);
														
				foreach($upd as $st=>$sv):
					$e_upd=array(
							'strFormID'=>'AD005',
							'ScriptSheetNo'=>$time,
							'Owner'=>$final['p_user']['value'],//acc
							'RecordsetName'=>'rstAD005',
							'FieldName'=>$st,
							'RecordIndex'=>1,
							'FieldValue'=>$sv
						);
					//insert
					
					$mssqlef->insert('ressa',$e_upd);					
				endforeach;
				
				foreach($ad005s as $st=>$sv):
					foreach($sv as $eno=>$vv):
						$e_upd=array(
								'strFormID'=>'AD005',
								'ScriptSheetNo'=>$time,
								'Owner'=>$final['p_user']['value'],//acc
								'RecordsetName'=>'rstAD005S',
								'FieldName'=>$st,
								'RecordIndex'=>($eno+1),
								'FieldValue'=>$vv	
							);
						$mssqlef->insert('ressa',$e_upd);	
					endforeach;
				endforeach;
				//Insert add003s
				//Rreload.
				//http://easy.ems.com.tw/ef2kwebtest/CHT/Forms/Form_Load.asp?strFilter=ALL&DoAction=Init
				$_SESSION['w_url']='http://easy.ems.com.tw/ef2kwebtest/CHT/Forms/Form_Load.asp?strFilter=ALL&DoAction=Init';
				$final['acbk_url']=base_url($final['var_purl'].'work_detail_index/list/'.$df_ip['key_id'].'/');
				$final['response_type']='bk_ac';
				
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
            				->setCellValue('A1', '料號')
            				->setCellValue('B1', '品名')
            				->setCellValue('C1', '規格')
            				->setCellValue('D1', '單位')
							->setCellValue('E1', '數量')
							->setCellValue('F1', '預估單價')
							->setCellValue('G1', '預估合計')
							->setCellValue('H1', '需求日期')
							->setCellValue('I1', '採購廠商')
							->setCellValue('J1', '備註')
							->setCellValue('K1', '匯出日期');

				// Miscellaneous glyphs, UTF-8
				
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('B'.$eno, $value['name'])
						 ->setCellValue('C'.$eno, $value['specification'])
						 ->setCellValue('D'.$eno, $final['uom_pdb'][$value['jec_uom_id']])
						 ->setCellValue('E'.$eno, $value['quantity'])
						 ->setCellValue('F'.$eno, $value['price'])
						 ->setCellValue('G'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('H'.$eno, substr($value['startdate'],0,10))
						 ->setCellValue('I'.$eno, $value['vendor_name'])
						 ->setCellValue('J'.$eno, $value['description'])
						 ->setCellValue('K'.$eno, $value['exporttime'])
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

        endswitch;
?>