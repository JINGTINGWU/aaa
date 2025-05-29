<?php
        switch($df_ip['ac']):
            case 'list': 
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].'project_new_index/update/0/');
				//
				$final['assign_view']='project_init_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/')
					);
            break;
			/*
            case 'update'://只放此處有編的
				
				$gv=array("value","jec_company_id","projyear","name","description","jec_customer_id","jec_user_id","jec_usersales_id","startdate","enddate","projtype"); $gv=$this->CM->GPV($gv);
				
				$upd=array_merge($gv,array('isactive'=>'Y','projstatus'=>1));
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('insert',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$final['acbk_url']=site_url($final['var_purl'].'project_list_index/list/');
				$final['response_type']='bk_ac';
            break;*/
			
			case 'init_project'://
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				
				$undone=$done=0;//新增到calendar
				/*
				$task_list=$this->GM->common_ac('list',array('info'=>$projt_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'])));
				foreach($task_list as $value):
					if(((int)$value['jec_user_id']>0||(int)$value['jec_group_id']>0)&&($value['startdate']!='0000-00-00 00:00:00'&&$value['enddate']!='0000-00-00 00:00:00'&&(int)$value['jec_usersuper_id']>0)):
						$done++;
						$this->db->where($projt_set['mm_kid'],$value[$projt_set['mm_kid']])->update($projt_set['mm_tb'],array('projtasktype'=>2));
						//+到行事曆
						/*
						$cal_user=array();
						if((int)$value['jec_user_id']>0):
							array_push($cal_user,array('jec_user_id'=.$value['jec_user_id']));
						else:
							//get group_id
							$cal_user=$this->db->where('jec_group_id',$value['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
						endif;
						foreach($cal_user as $cu_value):
							//+ 
						endforeach;*/
				/*	else:
						$undone++;
					endif;
				endforeach;
				*/
				$this->db->where('jec_project_id',$df_ip['key_id'])->update('jec_project',array('projstatus'=>2));
				$msg="專案已開展。";
				if($undone>0):
					$msg.='<br>有 '.$undone.' 個工作項目因未完整設定工作日期或指派負責人無法開展。';
				endif;
                $ajo=array(
					'msg'=>$msg,
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);
			break;

        endswitch;
?>