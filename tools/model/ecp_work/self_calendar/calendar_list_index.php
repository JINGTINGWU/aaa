<?php
$this->CM->close_cache();
$final['pg_tag']='w3c_pd'; //work_3_calendar@w3c
if($df_ip['key_id']<0||!isset($_SESSION[$final['pg_tag']])){
	//@session_unregister($final['pg_tag']);
 	$df_ip['key_id']=0; 
	//$s_startdate=$s_enddate=date('Y-m-d');
	$s_startdate=$s_enddate='';
	/*
	switch($df_ip['chinfo']):
		case 'Assign_Date'://取ob跟ot
			$s_startdate=$s_enddate=$df_ip['ob'];	
			$final['save_session']='Y';	
			break;
	endswitch;*/
	if($df_ip['chinfo']=='Assign_Date'):
			$s_startdate=$s_enddate=$df_ip['ob'];	
			$final['save_session']='Y';		
	endif;
	
	$df_ip['chinfo']='N';
	//echo $s_startdate.'-'.$s_enddate;//
	//@session_register($final['pg_tag']);
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'created',
			'pp'=>$this->m_pp,
			's_proj_value'=>'',
			's_proj_name'=>'',
			's_task_name'=>'',
			's_startdate'=>$s_startdate,
			's_enddate'=>$s_enddate,
			's_keyword'=>'',
			's_cal_noticetype'=>''
		);//project_1_project ->default - 
	$df_ip['np']=0;
	$df_ip['ot']='DESC';
	$df_ip['ob']='startdate';
	$df_ip['pp']=$this->m_pp;
}
//無-1預設
        switch($df_ip['ac']):
            case 'list': 
			/*
				//Test
				$erp=$this->load->database('erp',TRUE);
				$test=$erp->query("SELECT * FROM obpd_category_list WHERE ac_mark='0'")->result_array();
				$final['test']=$test;
				$df=$this->load->database('default',TRUE);
			*/
			
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
				endif;
		
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['add_self_cal_url']=base_url($final['var_purl'].$df_ip['tag'].'/add_self_cal/0/');
				$final['delete_self_cal_url']=base_url($final['var_purl'].$df_ip['tag'].'/delete_self_cal/0/');
				$final['refresh_url']=base_url($final['var_purl'].$df_ip['tag'].'/list/0/');
				
				
				$final['assign_view']='calendar_list_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				//$pd_pp=10;	
				$pd_pp=$df_ip['pp'];
			
				$cal_v_set=$this->CM->Init_TB_Set('mm_calendar_search_set');
				$ip_data=array('con_isactive'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'gp'=>'Y','ob_'.$df_ip['ob']=>$df_ip['ot'],'con_jec_user_id'=>$this->ad_id,'orwhere'=>array());
				if($_SESSION[$final['pg_tag']]['s_cal_noticetype']!='') $ip_data['con_noticetype']=$_SESSION[$final['pg_tag']]['s_cal_noticetype'];
				
				
				if($_SESSION[$final['pg_tag']]['s_startdate']!=''):
					if($_SESSION[$final['pg_tag']]['s_enddate']!=''):
						array_push($ip_data['orwhere'],"( (startdate<='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."') OR (startdate>='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."' AND enddate<='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."') OR (startdate<='".$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00'."' AND enddate>='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."') )");
						//array_push($ip_data['orwhere'],"((enddate <='".$_SESSION[$final['pg_tag']]['s_enddate']." 00:00:00' AND enddate>='".$_SESSION[$final['pg_tag']]['s_startdate']."') OR (startdate >='".$_SESSION[$final['pg_tag']]['s_startdate']." 00:00:00' AND enddate<='".$_SESSION[$final['pg_tag']]['s_enddate']."') OR (startdate>'".$_SESSION[$final['pg_tag']]['s_enddate']."' AND enddate<'".$_SESSION[$final['pg_tag']]['s_enddate']."') )");
						//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>@@'.$_SESSION[$final['pg_tag']]['s_enddate'];
					else:
						//$ip_data['con_startdate >=']=$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00';
						array_push($ip_data['orwhere'],"enddate >='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."' OR startdate >='".$_SESSION[$final['pg_tag']]['s_startdate'].' 00:00:00'."'");
					endif;//
				else:
					if($_SESSION[$final['pg_tag']]['s_enddate']!=''):
						//$ip_data['con_enddate <=']=$_SESSION[$final['pg_tag']]['s_enddate'].' 00:00:00';
						array_push($ip_data['orwhere'],"enddate <='".$_SESSION[$final['pg_tag']]['s_enddate'].' 23:59:59'."' OR startdate <='".$_SESSION[$final['pg_tag']]['s_enddate'].' 23:59:59'."'");
					endif;
				endif;
				//if($_SESSION[$final['pg_tag']]['s_startdate']!='') $ip_data['con_startdate']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				//if($_SESSION[$final['pg_tag']]['s_enddate']!='') $ip_data['con_enddate']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_value']!='') $ip_data['like_proj_value']=$_SESSION[$final['pg_tag']]['s_proj_value'];
				if($_SESSION[$final['pg_tag']]['s_proj_name']!='') $ip_data['like_proj_name']=$_SESSION[$final['pg_tag']]['s_proj_name'];
				//if($_SESSION[$final['pg_tag']]['s_task_name']!='') $ip_data['like_task_name']=$_SESSION[$final['pg_tag']]['s_task_name'];
				if($_SESSION[$final['pg_tag']]['s_keyword']!=''): //
					 array_push($ip_data['orwhere'],"proj_name LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%' OR task_name LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%' OR description LIKE '%".$_SESSION[$final['pg_tag']]['s_keyword']."%'");
				endif;
				
				$this->load->library('form_input');
				$final['ip_info']=$this->$cal_v_set['mm_set']->load_mm_field_check();
				//$final['ip_info']['open_dept']['on']=array();
				$final['cal_main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],array('open_dept'=>array()));
				
				$this->load->library('form_input');
				$this->load->model('Mm_search_obj','SOBJ',True);
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->SOBJ->get_search_info();
				$final['ip_data']=$this->SOBJ->get_search_item('def_cal');
                $final['main_data']=$_SESSION[$final['pg_tag']]; 
				$final['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
				
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$cal_v_set['mm_set'],'type'=>'def','data'=>$ip_data));	
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_proj_name_url'=>'proj_name@@@'.$df_ip['ob'],'ob_isconfirm_url'=>'isconfirm@@@'.$df_ip['ob'],'ob_task_name_url'=>'task_name@@@'.$df_ip['ob'],'ob_noticetype_url'=>'noticetype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_created_url'=>'created@@@'.$df_ip['ob'],'ob_isopen_url'=>'isopen@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['confirm_btn']=$this->$cal_v_set['mm_set']->btn_allow;
				$final['rp_btn']=$this->$cal_v_set['mm_set']->rp_btn;
				$final['noticetype_img']=$this->$cal_v_set['mm_set']->get_noticetype_img();
				
				$final['noticetype_pdb']=$this->$cal_v_set['mm_set']->noticetype_pdb;			
				$final['tcate_url']=array(
						'new_calendar_index'=>site_url($final['var_purl'].'new_calendar_index/list/')
					);

            break;
			case 'add_self_cal':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('insert'),array('exit'=>'Y'));
				$gv=array("startdate","enddate","daynotice","description",'name','isopen'); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_New_UPD());
				$upd['jec_user_id']=$this->ad_id;
				$upd['noticefrom']=2;
				$upd['noticetype']='AA';
				//$this->CM->JS_TMsg($upd['isopen']);
				if($upd['isopen']=='Y'):
					$open_dept_0=isset($_POST['open_dept_0'])?$_POST['open_dept_0']:0;
					if((int)$open_dept_0>0):
						//選全部/除了自已
						$tu_user=$this->db->where_not_in('jec_user_id',$this->ad_id)->where('isactive','Y')->where('acctstatus','Y')->get('jec_user')->result_array();	
						$dept_array=array($open_dept_0);
					else:
						
						$row_user=$this->db->where_not_in('jec_user_id',$this->ad_id)->where('isactive','Y')->where('acctstatus','Y')->get('jec_user')->result_array();
						$tu_user=array();
						$dept_array=explode("-",$_POST['open_dept_string']);
						/*
						$total_ti=(int)$_POST['open_dept_ti'];
						$dept_array=array();
						for($i=1;$i<=$total_ti;$i++):
							if(isset($_POST['open_dept_'.$i])&&(int)$_POST['open_dept_'.$i]>0) array_push($dept_array,$_POST['open_dept_'.$i]);
						endfor;*/
						foreach($row_user as $value):
							if(in_array($value['jec_dept_id'],$dept_array)&&$value['jec_user_id']!=$this->ad_id&&(int)$value['jec_dept_id']>0) array_push($tu_user,$value);
						endforeach;
						
					endif;
					$upd['opendeptstring']=implode('/',$dept_array);
					
				endif;
				//insert
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				$this->GM->common_ac('insert',array('info'=>$cal_set['mm_set'],'upt'=>'def','upd'=>$upd));
				if(isset($tu_user)):
					
					foreach($tu_user as $tuvalue):
						$upd['jec_user_id']=$tuvalue['jec_user_id'];
						$this->GM->common_ac('insert',array('info'=>$cal_set['mm_set'],'upt'=>'def','upd'=>$upd));
					endforeach;
				endif;
				
                $ajo=array(
					'bk_action'=>'refresh_calendar',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 		
			break;
			case 'delete_self_cal':
				//刪date相同->新增者相同的 
				$cal_id=(int)$_POST['cal_id'];
				$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
				//$cal_data=$this->$cal_set['mm_set']->get_calendar_row($cal_id);
				$this->$cal_set['mm_set']->delete_self_calendar($cal_id);
				
                $ajo=array(
					'bk_action'=>'refresh_calendar_fix',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
        endswitch;
?>