<?php
$final['pg_tag']='p4c_pd';//reduce
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'chargedate',
			'pp'=>$this->m_pp
		);//project_1_project ->default 
}
//$pd_pp=5;

        switch($df_ip['ac']):
            case 'list': 
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
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_cost/'.$df_ip['key_id'].'/');
				$final['add_cost_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_cost_div/'.$df_ip['key_id'].'/');
				$final['cost_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['update_cost_url']=site_url($final['var_purl'].$df_ip['tag'].'/update_cost/'.$df_ip['key_id'].'/');
				

				
				$final['assign_view']='project_cost_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$projc_v_set=$this->CM->Init_TB_Set('mm_projcharge_search_set');//34
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projc_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_chargedate_url'=>'chargedate@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_chargefee_url'=>'chargefee@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projc_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_chargeitem_id']['ld']=$this->db->where('isactive','Y')->get('jec_chargeitem')->result_array();
                $final['main_data']=array('chargedate'=>date('Y-m-d')); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'project_invoice_index'=>base_url($final['var_purl'].'project_invoice_index/list/'.$df_ip['key_id'].'/created/asc/0/N/')
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
				$final['assign_view']='cost_list_div';
				$this->load->library('form_input');
				
				$projc_v_set=$this->CM->Init_TB_Set('mm_projcharge_search_set');//34
				$final['ip_info']=$this->$projc_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_chargeitem_id']['ld']=$this->db->where('isactive','Y')->get('jec_chargeitem')->result_array();
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projc_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_chargedate_url'=>'chargedate@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_chargefee_url'=>'chargefee@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';

			break;
			case 'add_cost_div':
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_cost/'.$df_ip['key_id'].'/');
				$final['add_cost_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_cost_div/'.$df_ip['key_id'].'/');
				$final['cost_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				
				$final['assign_view']='add_cost_div';
				$projc_v_set=$this->CM->Init_TB_Set('mm_projcharge_search_set');
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projc_v_set['mm_set']->load_mm_field_check();
                $final['main_data']=array('chargedate'=>date('Y-m-d')); 
				
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);

				
			break;
			case 'add_cost'://
			
				$gv=array("jec_chargeitem_id","description",'chargedate','chargefee'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());//
				$upd=array_merge($upd,array('jec_project_id'=>$df_ip['key_id']));
				$projc_set=$this->CM->Init_TB_Set('mm_projcharge_set');
				$this->GM->common_ac('insert',array('info'=>$projc_set['mm_set'],'upt'=>'def','upd'=>$upd));
			
                $ajo=array(
					'bk_action'=>'after_add_cost',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'update_cost':
				$gv=array("projcharge_id","description",'chargefee','jec_chargeitem_id','chargedate','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$projc_set=$this->CM->Init_TB_Set('mm_projcharge_set');
				//
				$upd=$gv;
				unset($upd['projcharge_id']);
				unset($upd['no']);
				$this->GM->common_ac('update',array('info'=>$projc_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projcharge_id']));

                $ajo=array(
					'msg'=>'已修改',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			case 'delete_cost':
			    $projc_set=$this->CM->Init_TB_Set('mm_projcharge_set');//
			   
			    $this->$projc_set['mm_set']->delete_projcharge($df_ip['key_id']);//delete_projjob($projjob=0)
                $ajo=array(
					'bk_action'=>'after_add_cost',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
        endswitch;
?>