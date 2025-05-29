<?php

$projtask_list=$this->db->where('iscalendar','N')->where('projtasktype',2)->where('replystatus',0)->get('jec_projtask_search_view')->result_array();

//-
		$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');
		//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
		//$projj_v_set=$this->CM->Init_TB_Set('mm_projjob_search_set');
		//$proj_set=$this->CM->Init_TB_Set('mm_project_set');
		$cal_set=$this->CM->Init_TB_Set('mm_calendar_set');
if(count($projtask_list)>0)	$fp=fopen('uploads/routine/load_cal_'.date('Y-m-d-H-i-s').'.txt','a+');	
	
foreach($projtask_list as $value):
	//write_TO_CAL
		fwrite($fp,"Start Row jec_projtask_id=".$value['jec_projtask_id']."\r\n");
		$projt_data=$value;
		
		if((int)$projt_data['jec_user_id']>0):
			$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
		else:
			$tu_user=$this->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
		endif;
		fwrite($fp,"___get tu_user array=".count($tu_user)."\r\n");
		//super_user也要加
		
		//$projj_data=$this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']);//		
		//$proj_data=$this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']);
		$exist_user=array();	
		foreach($tu_user as $tu_value):
		
			array_push($exist_user,$tu_value['jec_user_id']);
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticetype'=>1,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate'],
								'daynotice'=>1,
								'name'=>''
								);
							$this->$cal_set['mm_set']->calendar_action($upd);	//不存在才新增哦
			fwrite($fp,"___save tu_user jec_user_id=".$tu_value['jec_user_id']."\r\n");
		endforeach;
		
		//$add_user=array();
		//if(!in_array($projt_data['jec_usersuper_id'],$exist_user)) array_push($add_user,array('jec_user_id'=>$projt_data['jec_usersuper_id']));
		//if(!in_array($projt_data['proj_jec_user_id'],$exist_user)) array_push($add_user,array('jec_user_id'=>$projt_data['proj_jec_user_id']));
		//foreach($add_user as $tu_value):
							//$upd=array(
								//'jec_project_id'=>$projt_data['jec_project_id'],
								//'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								//'noticetype'=>1,
								//'noticefrom'=>1,
								//'jec_user_id'=>$tu_value['jec_user_id'],
								//'startdate'=>$projt_data['startdate'],
								//'enddate'=>$projt_data['enddate'],
								//'daynotice'=>1,
								//'name'=>''
								//);
							//$this->$cal_set['mm_set']->calendar_action($upd);		
		//endforeach;	
		
		$this->db->where('jec_projtask_id',$projt_data['jec_projtask_id'])->update('jec_projtask',array('iscalendar'=>'Y'));
		fwrite($fp,"End Row jec_projtask_id=".$value['jec_projtask_id']."\r\n");
endforeach;
if(count($projtask_list)>0)	fclose($fp);
//$this->CM->JS_TMsg('@@@');
?>

