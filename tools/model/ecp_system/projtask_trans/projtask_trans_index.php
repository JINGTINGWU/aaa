<?php
/*
$final['pg_tag']='p1p_pd';
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
 	$df_ip['key_id']=0; 
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'value',
			's_proj_value'=>'',
			//'s_proj_jec_customer_id_title'=>'',
			's_proj_jec_company_id'=>'',
			's_proj_name'=>'',
			's_proj_projstatus'=>'',
			's_proj_date'=>'',
			's_proj_keyword'=>'',
			's_proj_customer_title'=>'',
			's_proj_jec_salesuser_id'=>'',
			's_proj_salesuser_title'=>''
		);//project_1_project ->default -
	$df_ip['np']=0;
	$df_ip['ot']='DESC';
	$df_ip['ob']='created';
}	*/
		//
        switch($df_ip['ac']):
            case 'list': 
				/*
				if($df_ip['chinfo']==''):
					$_SESSION[$final['pg_tag']]['np']=$df_ip['np'];
					$_SESSION[$final['pg_tag']]['ot']=$df_ip['ot'];
					$_SESSION[$final['pg_tag']]['ob']=$df_ip['ob'];
				elseif($df_ip['chinfo']=='N'):
					
					$df_ip['np']=$_SESSION[$final['pg_tag']]['np'];
					$df_ip['ob']=$_SESSION[$final['pg_tag']]['ob']=='loadingAnimation.gif'?'value':$_SESSION[$final['pg_tag']]['ob'];
					$df_ip['ot']=$_SESSION[$final['pg_tag']]['ot'];
					$final=$this->CM->get_df_url($final,$df_ip);
					$df_ip['chinfo']='';
				endif;*/

				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/trans_go/0/');
				
				$final['assign_view']='projtask_trans_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$from_user=$this->db->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();//->where('acctstatus','N') CONVERT( `name` using big5 )
				$to_user=$this->db->where('acctstatus','Y')->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
				
				$this->load->library('form_input');
				$ip_info=array(
						'from_user'=>array(
								'call_name'=>'',
								'type'=>'select',
								'ld'=>$from_user,
								'ld_key'=>'jec_user_id',
								'ld_value'=>'name',
								'ld_choose_msg'=>'-請選擇待移轉人員-'
							),
						'to_user'=>array(
								'call_name'=>'',
								'type'=>'select',
								'ld'=>$to_user,
								'ld_key'=>'jec_user_id',
								'ld_value'=>'name',
								'ld_choose_msg'=>'-請選擇轉入人員-'
							)
					);
				$final['main_op']=$this->form_input->each_op_trans('full',$ip_info,array());
				/*
				$pd_pp=10;
				$proj_set=$this->CM->Init_TB_Set('mm_project_search_set');
				//$proj_set['mm_tb']='jec_project_serach_view';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_proj');


				
				$ip_data=array('con_isactive'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'orwhere'=>array());				
				if($_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']!=''):
					 array_push($ip_data['orwhere'],"jec_user_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."' OR jec_usersales_id='".$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']."'");

					 $_SESSION[$final['pg_tag']]['s_proj_salesuser_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$_SESSION[$final['pg_tag']]['s_proj_jec_salesuser_id']);
				endif;

				if($_SESSION[$final['pg_tag']]['s_proj_jec_company_id']!='') $ip_data['con_jec_company_id']=$_SESSION[$final['pg_tag']]['s_proj_jec_company_id'];
				if($_SESSION[$final['pg_tag']]['s_proj_customer_title']!=''):

					array_push($ip_data['orwhere'],"customer_name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%' OR customername LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_customer_title']."%'");
				endif;
				if($_SESSION[$final['pg_tag']]['s_proj_projstatus']!='') $ip_data['con_projstatus']=$_SESSION[$final['pg_tag']]['s_proj_projstatus'];
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				if($_SESSION[$final['pg_tag']]['s_proj_date']!=''){ $ip_data['con_startdate <=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 99:99:99'; $ip_data['con_enddate >=']=$_SESSION[$final['pg_tag']]['s_proj_date'].' 00:00:00'; }
				
				if($_SESSION[$final['pg_tag']]['s_proj_keyword']!=''): //
					 array_push($ip_data['orwhere'],"value LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%' OR name LIKE '%".$_SESSION[$final['pg_tag']]['s_proj_keyword']."%'");
				endif;
				
				
                $final['main_data']=$_SESSION[$final['pg_tag']];
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				//save session
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>'def','data'=>$ip_data));
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_jec_company_id_url'=>'jec_company_id@@@'.$df_ip['ob'],'ob_jec_usersales_id_url'=>'jec_usersales_id@@@'.$df_ip['ob'],'ob_projstatus_url'=>'projstatus@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_customer_name_url'=>'customer_name@@@'.$df_ip['ob'],'ob_startdate_url'=>'startdate@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['projtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('projtype'),'key'=>'id','vf'=>'name'),'page_db',1);
				*/
				$final['tcate_url']=array(
						'project_new_index'=>site_url($final['var_purl'].'project_new_index/edit/')
					);//
            break;
            case 'trans_go'://只放此處有編的
				
				$gv=array("from_user","to_user"); $gv=$this->CM->GPV($gv);
				$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
				
				$this->$projt_set['mm_set']->trans_task($gv['from_user'],$gv['to_user']);
				
                $ajo=array(
					'msg'=>'已移轉',
					'bk_action'=>'after_trans',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);
            break;
        endswitch;
?>