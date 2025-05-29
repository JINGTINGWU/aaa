<?php
$final['pg_tag']='p6d_pd';//task
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
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'seqno':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				/*elseif($df_ip['chinfo']=='prod'):
					$_SESSION[$final['pg_tag']]['view_type']='prod';
				elseif($df_ip['chinfo']=='work'):
					$_SESSION[$final['pg_tag']]['view_type']='work';
				elseif($df_ip['chinfo']=='full'):
					$_SESSION[$final['pg_tag']]['view_type']='full';*/
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
				$final['export_copme_url']=base_url($final['var_purl'].$df_ip['tag'].'/export_copme/'.$df_ip['key_id'].'/');
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
				$final['ip_info']['value']['onchange']="PG_BK_Action('change_value',{})";
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
				$upd['seqno']=$this->$prodprep_set['mm_set']->get_productprep_series($upd['jec_project_id']);
				$upd['jec_user_id']=$this->$prodprep_set['mm_set']->get_prep_jec_user_id($_POST['jec_user_id_title']);
				$upd['total']=round($upd['price'])*$upd['quantity'];
				
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
				$final['ip_info']['value']['onchange']="PG_BK_Action('change_value',{})";
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
				$upd['jec_user_id']=$this->$prodprep_set['mm_set']->get_prep_jec_user_id($_POST['jec_user_id_title']);
				unset($upd['projprod_id']);
				unset($upd['no']);
				$upd['total']=round($upd['price'])*$upd['quantity'];
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
					'value'=>$prod_data['value'],
					'name'=>$prod_data['name'],
					'prodtype'=>$prod_data['prodtype'],
					//'prod_price'=>(float)$prod_data['price'], // 改為取得ERP成本, application/libraries/mm_product_set.php
					'prod_price'=>(float)$prod_data['cost'],
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
					?>
                    <!--帶入HTML-->
					<script>
                    	parent.PG_BK_Action('reload_prod_list');
                    </script>
					<?php
				else:
					$this->CM->JS_Msg($msg);
				endif;
				exit();
			break;
			case 'export_excel':
				$jec_project_id=$_POST['jec_project_id'];
				$excel_type=$_POST['excel_type'];;
				$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
				
				
				$data=array('jec_project_id'=>$jec_project_id,'save_path'=>'uploads/','excel_type'=>'xls');
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
				log_message('info','data save:'.$data['proj_data']['name']);			    
			    $objPHPExcel->setActiveSheetIndex(0)							
            				->setCellValue('B1', $data['proj_data']['name'])							
							->setCellValue('B2', $data['proj_data']['value2'])
							->setCellValue('B3', str_replace('-','/',substr($data['proj_data']['startdate'],0,10)))
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
				$file_name='履約備品清單-'.$data['proj_data']['name'].'.'.$excel_type;
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
				
				$objWriter->save('php://output');
				exit;				
			break;
			case 'export_copme':
				$jec_project_id=$_POST['jec_project_id'];
				$data=array('jec_project_id'=>$jec_project_id);
				$proj_data=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->get('jec_project')->result_array();
				$data['proj_data']=$proj_data[0];
				$main_list=$this->CM->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->get('jec_productprep_search_view')->result_array();
				//送ERP銷售預測單頭
				
				$company='EMS';
				$target_erpdb='mssqlerp';
				
				$mssqlerp=$this->load->database($target_erpdb,TRUE);//mssqlerp
				$sqlstring="SELECT ME001 FROM CMSME WHERE ME002 like '%".trim($this->GM->GetSpecData('jec_dept','name','jec_dept_id',$data['proj_data']['jec_dept_id']))."%'";
				$check=$mssqlerp->query($sqlstring)->result_array();
				if(count($check)>0):
					$deptname=$check[0];
				endif;
				$sqlstring="select * from ADMMF WHERE MF001 like '%".$this->CM->pdb_trans($p_user['value'])."%'";
				$check=$mssqlerp->query($sqlstring)->result_array();
				if(count($check)>0):
					$usrgrp=$check[0];
				endif;
				$time=date('Ymd');
				$p_user=$this->QIM->get_user_row($this->ad_id);
				$erp_upd=array(
							'COMPANY'=>$company,
							'CREATOR'=>$this->CM->pdb_trans($p_user['value']),
							'USR_GROUP'=>$usrgrp['MF004'],//acc
							'CREATE_DATE'=>$this->CM->pdb_trans($time),
							'FLAG'=>'1',
							'ME001'=>$data['proj_data']['efprojno'],
							'ME002'=>$this->GM->GetSpecData('jec_customer','value','jec_customer_id',$data['proj_data']['jec_customer_id']),
							'ME006'=>$deptname['ME001'],
							'ME007'=>$this->GM->GetSpecData('jec_user','value','jec_user_id',$data['proj_data']['jec_usersales_id']),
							'ME008'=>'N',
							'ME009'=>$data['proj_data']['name'],
							'ME013'=>'01',
							'ME014'=>'1'						
						);
				/*			
				$sqlstring="SELECT * FROM vCOPPLN WHERE [銷售預測代號] like '".trim($data['proj_data']['value'])."%'";
				$check=$mssqlerp->query($sqlstring)->result_array();
				if(count($check)>0):
					$msg="無法重送銷售預測，該履約備品清單已於".$check[0][iconv('utf-8', 'big5//IGNORE', 'LRP展算日期')]."展開備料，請與".$check[0][iconv('utf-8', 'big5//IGNORE','計劃人員')]."聯繫。";					
					$this->CM->JS_TMsg($msg);
					exit(0);
				endif;
				*/
                $sqlstring="SELECT * FROM COPME WHERE ME001 like '".trim($data['proj_data']['efprojno'])."%'";
				$check=$mssqlerp->query($sqlstring)->result_array();
				if(count($check)>0):
					//$mssqlerp->delete('COPME',array('ME001'=>$data['proj_data']['value']));
					//$mssqlerp->delete('COPMF',array('MF001'=>$data['proj_data']['value']));
					$msg="已拋轉銷售預測，預測代號為專案代號:".trim($data['proj_data']['efprojno']);					
					$this->CM->JS_TMsg($msg);
					exit(0);
				endif;
				$mssqlerp->insert('COPME',$erp_upd);
				//建立銷售預測明細
				foreach($main_list as $no=>$value):
						$product_info=$mssqlerp->query("SELECT * FROM INVMB WHERE MB001 like '".$value['value']."%'")->result_array();
						if(count($product_info)>0):
							$product_info=$product_info[0];
						endif;						
						$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
						$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
						if($value['prod_uom_id']>0)	$uom_string=$this->CM->pdb_trans($final['uom_pdb'][$value['prod_uom_id']]);
						$erp_upd=array(
							'COMPANY'=>$company,
							'CREATOR'=>$this->CM->pdb_trans($p_user['value']),
							'USR_GROUP'=>$usrgrp['MF004'],//acc
							'CREATE_DATE'=>$this->CM->pdb_trans($time),
							'FLAG'=>'1',
							'MF001'=>$data['proj_data']['efprojno'],
							'MF002'=>str_pad($no+1,4,'0',STR_PAD_LEFT),
							'MF003'=>$value['value'],
							'MF004'=>$value['prodname'],
							'MF005'=>$value['prodspec'],
							'MF006'=>$this->CM->pdb_trans($time),
							'MF007'=>$product_info['MB017'],
							'MF008'=>$value['quantity'],
							'MF009'=>'0',
							'MF010'=>$uom_string,
							'MF011'=>'NT$',
							'MF012'=>$value['price'],
							'MF013'=>$value['description'],
							'MF014'=>$value['quantity']*$value['price'],
							'MF016'=>$product_info['MB005'],
							'MF017'=>$product_info['MB006'],
							'MF018'=>$product_info['MB007'],
							'MF019'=>$product_info['MB008'],
							'MF020'=>'N'
						);         				 
						$mssqlerp->insert('COPMF',$erp_upd);
				endforeach;
				$msg="送出銷售預測完成";
				$this->CM->JS_Msg($this->CM->msg_trans($msg));
				//exit
			break;
        endswitch;
?>