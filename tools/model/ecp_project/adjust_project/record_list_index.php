<?php
$final['pg_tag']='p3r_pd';//record
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['chinfo']='N'; 
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'recordtime',
			'pp'=>$this->m_pp,
			'fnp'=>0,
			'fot'=>'ASC',
			'fob'=>'filename',
			'fpp'=>$this->m_pp
		);//project_1_project ->default 
		
}
//$pd_pp=5;
        $query = $this->db->where('jec_projtask_id',$df_ip['key_id'])->like('description','日期變更已確認')->get('jec_projrecord');
        $final['datechangecount'] = $query->num_rows();
        $query = $this->db->where('jec_projtask_id',$df_ip['key_id'])->like('description','工作移轉已確認')->get('jec_projrecord');
        $final['mantransfercount']=$query->num_rows();
        $query = $this->db->where('jec_projtask_id',$df_ip['key_id'])->like('description','工作暫停已確認')->get('jec_projrecord');
        $final['pausecount']=$query->num_rows();
		$query = $this->db->where('jec_projtask_id',$df_ip['key_id'])->like('description','展期暨移轉已確認')->get('jec_projrecord');
        $tmpCount=$query->num_rows();
		$final['datechangecount']+=$tmpCount;
		$final['mantransfercount']+=$tmpCount;

        switch($df_ip['ac']): //
            case 'list': //抓projrecord- 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];	
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];		
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				//$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['file_list_url']=site_url($final['var_purl'].'record_list_index/file_list_div/'.$df_ip['key_id'].'/');
				//$final['form_url']=site_url($final['var_purl'].'prod_list_index/add_projprod/'.$df_ip['key_id'].'/');
				//$final['add_prod_url']=site_url($final['var_purl'].'prod_list_index/add_prod_div/'.$df_ip['key_id'].'/');
				//$final['prod_list_url']=site_url($final['var_purl'].'prod_list_index/list_div/'.$df_ip['key_id'].'/');
				//$final['update_projprod_url']=site_url($final['var_purl'].'prod_list_index/update_projprod/'.$df_ip['key_id'].'/');
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projr_v_set=$this->CM->Init_TB_Set('mm_projrecord_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projr_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$df_ip['key_id'],'wni'=>array('recordtype'=>'2'),'con_isactive'=>'Y','gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'pd_np'=>$df_ip['np'],'pd_pp'=>$pd_pp)));

                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div';
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_recordtime_url'=>'recordtime@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_description2_url'=>'description2@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';

				$final['assign_view']='record_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				
				//$proj_set['mm_tb']='jec_project_serach_view';
				//$this->load->model('Mm_search_obj','SOBJ',True); 
				
				$this->load->library('form_input');

				
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$_SESSION[$final['pg_tag']]['fpp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$final['projj_data']=$this->CM->db->where('jec_projjob_id',$final['projt_data']['jec_projjob_id'])->where('isactive','Y')->get($projj_set['mm_tb'])->result_array();
				
				$final['tcate_url']=array(
						'project_overview_index'=>base_url($final['var_purl'].'project_overview_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'project_adjust_index'=>base_url($final['var_purl'].'project_adjust_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/'.$final['projt_data']['jec_project_id'],'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'task_list_index'=>base_url($final['var_purl'].'task_list_index/list/'.$final['projj_data'][0]['jec_projjob_id'].'/'),
						'prod_list_index'=>base_url($final['var_purl'].'prod_list_index/list/'.$df_ip['key_id'].'/seqno/ASC/0/N/')
					);
            break;
			case 'list-all': //抓projrecord- 
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];	
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];	
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];		
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				//$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['file_list_url']=site_url($final['var_purl'].'record_list_index/file_list_div/'.$df_ip['key_id'].'/');
				//$final['form_url']=site_url($final['var_purl'].'prod_list_index/add_projprod/'.$df_ip['key_id'].'/');
				//$final['add_prod_url']=site_url($final['var_purl'].'prod_list_index/add_prod_div/'.$df_ip['key_id'].'/');
				//$final['prod_list_url']=site_url($final['var_purl'].'prod_list_index/list_div/'.$df_ip['key_id'].'/');
				//$final['update_projprod_url']=site_url($final['var_purl'].'prod_list_index/update_projprod/'.$df_ip['key_id'].'/');
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projr_v_set=$this->CM->Init_TB_Set('mm_projrecord_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projr_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$df_ip['key_id'],'con_isactive'=>'Y','gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'pd_np'=>$df_ip['np'],'pd_pp'=>$pd_pp)));

                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div';
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div-all/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_recordtime_url'=>'recordtime@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_description2_url'=>'description2@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';

				$final['assign_view']='record_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y'; 
				
				//$proj_set['mm_tb']='jec_project_serach_view';
				//$this->load->model('Mm_search_obj','SOBJ',True); 
				
				$this->load->library('form_input');

				
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$_SESSION[$final['pg_tag']]['fpp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				

				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->GM->common_ac('list',array('info'=>$proj_v_set['mm_set'],'upt'=>'def','kid'=>$final['projt_data']['jec_project_id']));
				$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
				$final['projj_data']=$this->CM->db->where('jec_projjob_id',$final['projt_data']['jec_projjob_id'])->where('isactive','Y')->get($projj_set['mm_tb'])->result_array();
				
				$final['tcate_url']=array(
						'project_overview_index'=>base_url($final['var_purl'].'project_overview_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'project_adjust_index'=>base_url($final['var_purl'].'project_adjust_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/'.$final['projt_data']['jec_project_id'],'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$final['projt_data']['jec_project_id'].'/'),
						'task_list_index'=>base_url($final['var_purl'].'task_list_index/list/'.$final['projj_data'][0]['jec_projjob_id'].'/'),
						'prod_list_index'=>base_url($final['var_purl'].'prod_list_index/list/'.$df_ip['key_id'].'/seqno/ASC/0/N/')
					);
            break;
			case 'list_div':
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projr_v_set=$this->CM->Init_TB_Set('mm_projrecord_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projr_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$df_ip['key_id'],'wni'=>array('recordtype'=>'2'),'con_isactive'=>'Y','gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'pd_np'=>$df_ip['np'],'pd_pp'=>$pd_pp)));
				
				$_G['pg_div_function']='ECP_Load_Div'; //
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['assign_view']='record_list_div';

				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_recordtime_url'=>'recordtime@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_description2_url'=>'description2@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
			break;
			case 'list_div-all':
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['pp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['pp'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;
				$pd_pp=$df_ip['pp'];
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projt_data']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
				
				$projr_v_set=$this->CM->Init_TB_Set('mm_projrecord_search_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projr_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$df_ip['key_id'],'con_isactive'=>'Y','gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'pd_np'=>$df_ip['np'],'pd_pp'=>$pd_pp)));
				
				$_G['pg_div_function']='ECP_Load_Div'; //
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['assign_view']='record_list_div';

				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div-all/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_recordtime_url'=>'recordtime@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_user_id_url'=>'jec_user_id@@@'.$df_ip['ob'],'ob_description2_url'=>'description2@@@'.$df_ip['ob'])));
				
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
			break;
			case 'file_list_div':
				if($df_ip['chinfo']==''):
					//不影響，只讀原本的
					$_SESSION[$final['pg_tag']]['fnp']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['fot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['fob']=$df_ip['ob'];
					$_SESSION[$final['pg_tag']]['fpp']=$df_ip['pp'];
				elseif($df_ip['chinfo']=='N'):
					$df_ip['chinfo']='';
					$df_ip['np']=$_SESSION[$final['pg_tag']]['fnp'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['fob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['fot'];
					$df_ip['pp']=$_SESSION[$final['pg_tag']]['fpp'];
					$final=$this->CM->get_df_url($final,$df_ip);//重取
				endif; //
				$pd_pp=$df_ip['pp'];
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$final['projt_data']['jec_project_id'],'con_jec_projtask_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				$final['assign_view']='task_file_list_div';
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];			
			break;
        endswitch;
?>