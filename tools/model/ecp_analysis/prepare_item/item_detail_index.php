<?php
$final['pg_tag']='a4d_pd';//task
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['chinfo']='N'; 
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'ASC',
			'ob'=>'seqno',
			'pp'=>$this->m_pp,
			'view_type'=>'full'
		);//project_1_project ->default 
		
}
//$pd_pp=10;

        switch($df_ip['ac']):
            case 'list': 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'created':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				elseif($df_ip['chinfo']=='prod'):
					$_SESSION[$final['pg_tag']]['view_type']='prod';
				elseif($df_ip['chinfo']=='work'):
					$_SESSION[$final['pg_tag']]['view_type']='work';
				elseif($df_ip['chinfo']=='full'):
					$_SESSION[$final['pg_tag']]['view_type']='full';
				endif;
				$pd_pp=$df_ip['pp'];
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_projprod/'.$df_ip['key_id'].'/');
				$final['import_url']=site_url($final['var_purl'].$df_ip['tag'].'/import_ac/'.$df_ip['key_id'].'/');
				$final['add_prod_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_prod_div/'.$df_ip['key_id'].'/');
				$final['prod_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['update_projprod_url']=site_url($final['var_purl'].$df_ip['tag'].'/update_projprod/'.$df_ip['key_id'].'/');
				$final['check_prodtype_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_prodtype/'.$df_ip['key_id'].'/');
				$final['import_producttemp_url']=site_url($final['var_purl'].$df_ip['tag'].'/import_producttemp/'.$df_ip['key_id'].'/');
				$final['export_excel_url']=base_url($final['var_purl'].$df_ip['tag'].'/export_excel/'.$df_ip['key_id'].'/');
				/*
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$ip_data=array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				switch($_SESSION[$final['pg_tag']]['view_type']):
					case 'prod':
						$ip_data['con_prodtype !=']=9;
						break;
					case 'work':
						$ip_data['con_prodtype']=9;
						break;
					case 'full':
						break;
				endswitch;  */   //
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				//$ip_data=array('con_jec_project_id'=>$df_ip['key_id']);
				$ip_data=array('con_jec_project_id'=>$df_ip['key_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodprep_v_set['mm_set'],'type'=>'def','data'=>$ip_data));

                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //=
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_prodspec_url'=>'prodspec@@@'.$df_ip['ob'],'ob_prod_uom_id_url'=>'prod_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_prodname_url'=>'prodname@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_vendor_name_url'=>'vendor_name@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_estimcostcalc_url'=>'estimcostcalc@@@'.$df_ip['ob'],'ob_extraaddition_url'=>'extraaddition@@@'.$df_ip['ob'],'ob_salecostcalc_url'=>'salecostcalc@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$final['pd']['view_type']=$_SESSION[$final['pg_tag']]['view_type'];
				$final['pd']['vt_prod_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/prod/');
				$final['pd']['vt_work_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/work/');
				$final['pd']['vt_full_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/full/');
				
				$final['assign_view']='item_detail_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True); 
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
               // $final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']=$this->$prodprep_v_set['mm_set']->load_mm_field_check();
				//$final['ip_info']['jec_product_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_product_id'),'page_db','s_array');				
                $final['main_data']=array('extramultiple'=>1,'quantity'=>1); //'startdate'=>date('Y-m-d'),
				$final['ip_info']['jec_product_id']['onchange']="PG_BK_Action('check_prodtype',{'jec_product_id':this.value})";	
				$final['ip_info']['jec_product_id_title']['onchange']="PG_BK_Action('change_prodname',{})";
				$final['ip_info']['description']['style']="width:250px;";
				$final['ip_info']['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);

				$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
				$ip_info_spec=$this->$prodo_set['mm_set']->load_mm_field_check();
				$final['main_op_spec']=$this->form_input->each_op_trans('full',$ip_info_spec,array(),'_spec');				
				
				$final['file_list']=array();
				
            	//$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_ld']=$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y')));
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$final['uom_ld'],'key'=>'jec_uom_id','vf'=>'name','add_zero'=>'Y'),'page_db',1);
				//proj_edit_op

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				//$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				//$final['projj_data']=$this->CM->db->where('jec_project_id',$final['projt_data']['jec_project_id'])->where('jec_job_id',$final['projt_data']['jec_job_id'])->where('isactive','Y')->get($projj_set['mm_tb'])->result_array();
				
				$final['tcate_url']=array(
						'create_item_index'=>base_url($final['var_purl'].'create_item_index/list/'),
						'item_list_index'=>base_url($final['var_purl'].'item_list_index/list/0/created/asc/0/N/'),
						'item_submit_index'=>base_url($final['var_purl'].'item_submit_index/list/'.$df_ip['key_id'].'/created/asc/0/N/'),
						'bk_url'=>base_url($final['var_purl'].'item_list_index/list/0/created/asc/0/N/')
					);
            break;
			
			case 'add_projprod':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				
				$gv=array("jec_product_id","description",'jec_vendor_id','startdate','quantity','price','prod_uom_id','prodspec','prodname','jec_user_id','value'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());//
				$upd['jec_project_id']=$df_ip['key_id'];
				$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
				$this->GM->common_ac('insert',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>$upd));

				//
				/* 
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				$prod_set=$this->CM->Init_TB_Set('mm_product_set');
				$final['prod_data']=$this->GM->common_ac('list',array('info'=>$prod_set['mm_set'],'upt'=>'def','kid'=>$upd['jec_product_id']));	
				if((int)$upd['jec_product_id']==0) $final['prod_data']['prodtype']=$gv['prodtype'];//好煩-			
				if($final['prod_data']['prodtype']==8)://新增自訂的
					$sgv=array("value","description",'jec_uom_id','name','specification'); $sgv=$this->CM->NFGV($sgv,array('post_sur_tag'=>'_spec'));
					$supd=array_merge($sgv,$this->CM->Base_New_UPD());
					$supd['price']=$upd['price'];
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					$this->GM->common_ac('insert',array('info'=>$prodo_set['mm_set'],'upt'=>'def','upd'=>$supd));
					$upd['jec_productopen_id']=mysql_insert_id();
				endif;
				$upd=array_merge($upd,array('jec_project_id'=>$final['projt_data']['jec_project_id'],'jec_projtask_id'=>$final['projt_data']['jec_projtask_id']));
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$upd['seqno']=$this->$projp_set['mm_set']->get_projprod_series($final['projt_data']['jec_projtask_id']);
				
				$upd=array_merge($upd,array('prodtype'=>$final['prod_data']['prodtype'],'total'=>$upd['price']*$upd['quantity']));
				
				$costtype=$this->GM->GetSpecData('jec_project','costtype','jec_project_id',$final['projt_data']['jec_project_id']);
				$upd['cost']=$this->$projp_set['mm_set']->get_erp_cost($upd['jec_product_id'],$costtype);				
				$upd['costtime']=date("Y-m-d H:i:s");
				
				$upd['extramultiple']=$upd['extramultiple']*1;
				$upd['extraaddition']=$upd['extraaddition']*1;
				$upd['estimcostcalc']=$upd['total']*$upd['extramultiple']+$upd['extraaddition'];
				$upd['salecostcalc']=$upd['cost']==0?$upd['estimcostcalc']:$upd['cost']*$upd['quantity']*$upd['extramultiple']+$upd['extraaddition'];
				
				if((int)$upd['jec_product_id']==0) $upd['jec_product_id']=NULL;
				$this->GM->common_ac('insert',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$upd));
				
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				$this->$projt_set['mm_set']->recount_projtask_total($df_ip['key_id'],'A');
				*/
                $ajo=array(
					'bk_action'=>'after_add_prod',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'list_div':
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'seqno':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';/*
				elseif($df_ip['chinfo']=='prod'):
					$_SESSION[$final['pg_tag']]['view_type']='prod';
				elseif($df_ip['chinfo']=='work'):
					$_SESSION[$final['pg_tag']]['view_type']='work';
				elseif($df_ip['chinfo']=='full'):
					$_SESSION[$final['pg_tag']]['view_type']='full';*/
				endif;
				$pd_pp=$df_ip['pp'];
				$final['assign_view']='prod_list_div';
				$this->load->library('form_input');
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				$final['ip_info']=$this->$prodprep_v_set['mm_set']->load_mm_field_check();
				//$ip_data=array('con_jec_project_id'=>$df_ip['key_id']);
				$ip_data=array('con_jec_project_id'=>$df_ip['key_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodprep_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
				/*
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['ip_info']=$this->$projp_v_set['mm_set']->load_mm_field_check();
				$ip_data=array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y','gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot']);
				switch($_SESSION[$final['pg_tag']]['view_type']):
					case 'prod':
						$ip_data['con_prodtype !=']=9;
						break;
					case 'work':
						$ip_data['con_prodtype']=9;
						break;
					case 'full':
						break;
				endswitch;
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>$ip_data));*/
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //=
				//$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_specification_url'=>'specification@@@'.$df_ip['ob'],'ob_jec_uom_id_url'=>'jec_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_vendor_name_url'=>'vendor_name@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_extramultiple_url'=>'extramultiple@@@'.$df_ip['ob'],'ob_estimcostcalc_url'=>'estimcostcalc@@@'.$df_ip['ob'],'ob_extraaddition_url'=>'extraaddition@@@'.$df_ip['ob'],'ob_salecostcalc_url'=>'salecostcalc@@@'.$df_ip['ob'])));
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_seqno_url'=>'seqno@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_prodspec_url'=>'prodspec@@@'.$df_ip['ob'],'ob_prod_uom_id_url'=>'prod_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_prodname_url'=>'prodname@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'],'ob_vendor_name_url'=>'vendor_name@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_estimcostcalc_url'=>'estimcostcalc@@@'.$df_ip['ob'],'ob_extraaddition_url'=>'extraaddition@@@'.$df_ip['ob'],'ob_salecostcalc_url'=>'salecostcalc@@@'.$df_ip['ob'])));//
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				
				$final['pd']['view_type']=$_SESSION[$final['pg_tag']]['view_type'];
				$final['pd']['vt_prod_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/prod/');
				$final['pd']['vt_work_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/work/');
				$final['pd']['vt_full_url']=base_url($this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/0/full/');
				
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_ld']=$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y')));
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$final['uom_ld'],'key'=>'jec_uom_id','vf'=>'name','add_zero'=>'Y'),'page_db',1);
				$this->load->model('Mm_search_obj','SOBJ',True); 
				$ip_info=array();
				$ip_info['excel_type']=$this->SOBJ->get_search_info('excel_type');
				$final['main_op']=$this->form_input->each_op_trans('full',$ip_info,array());
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
			break;
			
			case 'add_prod_div':
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_projprod/'.$df_ip['key_id'].'/');
				$final['add_prod_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_prod_div/'.$df_ip['key_id'].'/');
				$final['prod_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/');
				//$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				//$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				//$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				//$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$final['assign_view']='add_prod_div';
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$prodprep_v_set['mm_set']->load_mm_field_check();
				//$final['ip_info']['jec_product_id']['ip_dl_exclude']=$this->CM->FormatData(array('db'=>$final['main_list'],'key'=>'jec_product_id'),'page_db','s_array');				
                $final['main_data']=array('extramultiple'=>1,'quantity'=>1); //'startdate'=>date('Y-m-d'),
				$final['ip_info']['jec_product_id_title']['onchange']="PG_BK_Action('change_prodname',{})";
				$final['ip_info']['jec_product_id']['onchange']="PG_BK_Action('check_prodtype',{'jec_product_id':this.value})";	
				$final['ip_info']['description']['style']="width:250px;";
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
				$ip_info_spec=$this->$prodo_set['mm_set']->load_mm_field_check();
				$final['main_op_spec']=$this->form_input->each_op_trans('full',$ip_info_spec,array(),'_spec');
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$final['tcate_url']=array(
						'bk_url'=>base_url($final['var_purl'].'item_list_index/list/0/created/asc/0/N/')
					);
			break;
			
			case 'update_projprod':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("projprod_id","description",'price','startdate','quantity','jec_vendor_id','no','value','prod_uom_id','prodspec','prodname','jec_user_id'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				//$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
				$upd=$gv;
				unset($upd['projprod_id']);
				unset($upd['no']);
				$upd['total']=$upd['price']*$upd['quantity'];
				$this->GM->common_ac('update',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projprod_id']));
                $ajo=array(
					'msg'=>'已修改',
					'innerId'=>'total_tag_'.$no,
					'innerHTML'=>$upd['total'],
                    'pass'=>1
                );//
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			
			case 'delete_projprod':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('delete'),array('exit'=>'Y'));
				$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
			   // $projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
			   // $final['projp_data']=$this->$projp_set['mm_set']->get_projprod_row($df_ip['key_id']);
			   
			    //$del_test=$this->$projp_set['mm_set']->exe_right_check('delete_check',$final['projp_data']);
				$del_test=true;
			    if($del_test==true):
			   
			   		$this->$prodprep_set['mm_set']->delete_productprep($df_ip['key_id']);//delete_projjob($projjob=0)				
                	$ajo=array(
						'bk_action'=>'after_add_prod',
                    	'pass'=>1
                	);
				else:
                	$ajo=array(
						'msg'=>$_G['err_msg'],
                    	'pass'=>1
                	);					
				endif;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'move_up':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$prodp_set=$this->CM->Init_TB_Set('mm_productprep_set');
				$prodp_data=$this->$prodp_set['mm_set']->get_productprep_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_down';
				$this->$prodp_set['mm_set']->seqno_action($type,$prodp_data);
				
                $ajo=array(
					'bk_action'=>'reload_prod_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'move_down':
				//依目前排的方式決定上移或下移
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$prodp_set=$this->CM->Init_TB_Set('mm_productprep_set');
				$prodp_data=$this->$prodp_set['mm_set']->get_productprep_row($df_ip['key_id']);
				$type=strtolower($df_ip['ot'])=='asc'?$df_ip['ac']:'move_up';
				$this->$prodp_set['mm_set']->seqno_action($type,$prodp_data);
				
                $ajo=array(
					'bk_action'=>'reload_prod_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'check_prodtype'://確認產品類型
				$jec_product_id=(int)$_POST['jec_product_id'];
				$prod_set=$this->CM->Init_TB_Set('mm_product_set');
				$prod_data=$this->$prod_set['mm_set']->get_product_row($jec_product_id);
				
                $ajo=array(
					'bk_action'=>'edit_spec_prod',
					'prodtype'=>$prod_data['prodtype'],
					'prod_price'=>(float)$prod_data['price'],
					'prod_spec'=>$prod_data['specification'],
					'prod_uom_id'=>$prod_data['jec_uom_id'],
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			case 'import_producttemp'://匯入料品
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$producttemp_id=(int)$_POST['producttemp_id'];
				$prodtl_v_set=$this->CM->Init_TB_Set('mm_producttempline_search_set');
				$prod_list=$this->GM->common_ac('list',array('info'=>$prodtl_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_producttemp_id'=>$producttemp_id,'ob_seqno'=>'ASC')));
				
				/*
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');*/
				
				//$final['prod_data']=$this->GM->common_ac('list',array('info'=>$prod_set['mm_set'],'upt'=>'def','kid'=>$upd['jec_product_id']));	
				$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
				$pno=$this->$prodprep_set['mm_set']->get_max_seqno($df_ip['key_id']);//
				foreach($prod_list as $pvalue):
					$pno++;
						$p_upd=array(
								'jec_project_id'=>$df_ip['key_id'],
								'jec_product_id'=>$pvalue['jec_product_id'],
								'value'=>$pvalue['value'],
								'prodname'=>$pvalue['name'],
								'prodspec'=>$pvalue['specification'],
								'prod_uom_id'=>$pvalue['jec_uom_id'],
								'quantity'=>0,
								'price'=>$pvalue['price'],
								'total'=>0,
								'jec_user_id'=>$this->ad_id,
								'jec_vendor_id'=>$pvalue['jec_vendor_id'],
								'description'=>$pvalue['description'],
								'seqno'=>$pno
							);
						$p_upd=array_merge($this->CM->Base_New_UPD(),$p_upd);
						//NewNewNew
						$this->GM->common_ac('insert',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>$p_upd));
				endforeach;
				//
                $ajo=array(
					'bk_action'=>'reload_prod_list',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);
			break;
			case 'import_ac'://上傳檔案
				//--save_temp than read
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$this->load->model('Import_model','IM',True);
				//upload
				$output_name='pip_'.time().'_'.rand(10,99);//
				$f_path=MM_Tmep_File_Dir;
				$msg=$this->CM->SingleUpload('import_excel',$f_path,$output_name);
				//$this->CM->JS_TMsg('xxx');
				if($msg==''):
					//$_G['up_filename']
					$proj_set=$this->CM->Init_TB_Set('mm_project_set');
					//$file_name=$f_path.$_G['up_filename'];
					$proj_data=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
					$this->IM->ExecImport($_G['up_filename'],'productprep',array('proj_data'=>$proj_data));
					?><script>
                    	parent.PG_BK_Action('reload_prod_list');
                    </script><?php
				else:
					$this->CM->JS_Msg($msg);
				endif;
				exit();
			break;
			case 'export_excel':
				$excel_type=$_POST['excel_type'];
			//$this->CM->JS_TMsg('@@@');
			//exit();
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projp_v_set=$this->CM->Init_TB_Set('mm_projprod_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$final['projt_data']['jec_projtask_id'],'con_isactive'=>'Y')));
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name','add_zero'=>'Y'),'page_db',1);
			
				
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
				/*
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('B'.$eno, $value['name'])
						 ->setCellValue('C'.$eno, $value['specification'])
						 ->setCellValue('D'.$eno, $final['uom_pdb'][(int)$value['jec_uom_id']])
						 ->setCellValue('E'.$eno, $value['quantity'])
						 ->setCellValue('F'.$eno, $value['price'])
						 ->setCellValue('G'.$eno, $value['quantity']*$value['price'])
						 ->setCellValue('H'.$eno, substr($value['startdate'],0,10))
						 ->setCellValue('I'.$eno, $value['vendor_name'])
						 ->setCellValue('J'.$eno, $value['description'])
						 ->setCellValue('K'.$eno, $value['exporttime'])
						 ;	
				endforeach;*/
				foreach($final['main_list'] as $no=>$value):
						$eno=$no+2;
						 $objPHPExcel->setActiveSheetIndex(0)
            			 ->setCellValue('A'.$eno, $value['value'])
           				 ->setCellValue('B'.$eno, $value['prodname'])
						 ->setCellValue('C'.$eno, $value['prodspec'])
						 ->setCellValue('D'.$eno, $final['uom_pdb'][(int)$value['prod_uom_id']])
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