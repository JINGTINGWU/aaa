<?php
        switch($df_ip['ac']):
            case 'list': 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['list_url']=base_url($final['var_purl'].'project_overview_index/list_div/'.$df_ip['key_id'].'/');

				$final['assign_view']='project_overview_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				//$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'project_adjust_index'=>base_url($final['var_purl'].'project_adjust_index/list/'.$df_ip['key_id'].'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/')
					);
            break;
			case 'list_div':
				$final['assign_view']='project_overview_div';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['resda020_pdb']=$this->$_G['L_CS']->resda020_info;
				$final['resda021_pdb']=$this->$_G['L_CS']->resda021_info;				
			break;
			
        endswitch;
?>