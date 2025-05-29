<?php
        switch($df_ip['ac']):
            case 'list': 
				//echo $df_ip['chinfo'].'<==';
				
				//撈cal資料哦-
				$final['assign_view']='index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				
				$this->CM->Unique_Load_Lib('Hscal');
				$df_ip['chinfo']=base64_decode($df_ip['chinfo']);
				
				$chinfo=$this->CM->CHINFO_MNG($df_ip['chinfo']);
				$final['cal_today']=isset($chinfo['cal_today'])?$chinfo['cal_today']:date('Y-m-d');
				if(substr($final['cal_today'],0,7)==date('Y-m')){
					 $final['cal_today']=date('Y-m-d');
				}else{
					$final['cal_today']=substr($final['cal_today'],0,7).'-01';
				}
				
				//抓一與日
				
				//$final['cal_today']='2012-05-30';
				$final['cal_sed']=$this->hscal->cal_get_sed("m",$final['cal_today']);
				$final['week_info']=$this->hscal->cal_get_weeknum($final['cal_sed']);
				$final['today_sd']=$final['cal_sed']['sd']." 00:00:00";
				$final['today_ed']=$final['cal_sed']['ed']." 23:59:59";
				$final['w_sd']=$this->hscal->cal_get_sed("wm",$final['cal_sed']['sd']);
				//$final['w_ed']=$this->hscal->cal_get_sed("wm",$final['cal_sed']['ed']);
				
				$search_sed=$this->hscal->get_mon_wsed($final['cal_sed'],'wm');
				$cal_v_set=$this->CM->Init_TB_Set('mm_calendar_search_set');
				$mm_tb=$cal_v_set['mm_tb'];
				$cal_list=$this->GM->common_ac('list',array('info'=>$cal_v_set['mm_set'],'type'=>'join_projtask','data'=>array('con_'.$mm_tb.'.jec_user_id'=>$this->ad_id,'con_'.$mm_tb.'.startdate <='=>$search_sed['ed'].' 99:99:99','con_'.$mm_tb.'.enddate >='=>$search_sed['sd'].' 00:00:00','orwhere'=>array("noticefrom='2' OR (noticefrom='1' AND jec_projtask.projtasktype IN ('1','2','5','6'))"))));//,'wi'=>array($mm_tb.'.noticefrom'=>array(1,2),'jec_projtask.projtasktype'=>array(1,2,5,6))
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.count($cal_list).'---'.$this->hscal->get_days($search_sed);
				$final['cal_detail']=$this->$cal_v_set['mm_set']->get_cal_detail($cal_list,$search_sed);	
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.count($final['cal_detail']).'---'.count($cal_list);	
				$today_time=strtotime($final['cal_today'].' 00:00:00'); 
				$pre_month=date('Y-m-d',mktime(0,0,0,date('m',$today_time)-1,date('d',$today_time),date('Y',$today_time)));
				$next_month=date('Y-m-d',mktime(0,0,0,date('m',$today_time)+1,date('d',$today_time),date('Y',$today_time)));

				$final['pre_year_month']=substr($pre_month,0,8);
				$final['next_year_month']=substr($next_month,0,8);
				$final['pre_month_title']=$this->CM->FormatData(date('m',strtotime($pre_month.' 00:00:00'))*1,'number',1);
				$final['next_month_title']=$this->CM->FormatData(date('m',strtotime($next_month.' 00:00:00'))*1,'number',1);
				$final['this_month_title']=$this->CM->FormatData(date('m',strtotime($final['cal_today'].' 00:00:00'))*1,'number',1);
				$final['pre_month']=base_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$pre_month)."").'/');
				$final['next_month']=base_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$next_month)."").'/');

				$pre_year=date('Y-m-d',mktime(0,0,0,date('m',$today_time),date('d',$today_time),date('Y',$today_time)-1));
				$next_year=date('Y-m-d',mktime(0,0,0,date('m',$today_time),date('d',$today_time),date('Y',$today_time)+1));
				$final['pre_year']='<a href="'.site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$pre_year)."").'/').'">'.substr($pre_year,0,4).'</a>';
				$final['next_year']='<a href="'.site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$next_year)."").'/').'">'.substr($next_year,0,4).'</a>';
				
				$final['eday_max_row']=4;
				
				$ann_set=$this->CM->Init_TB_Set('mm_announce_set');
				$today=date('Y-m-d').' 00:00:00';
				$final['ann_list']=$this->GM->common_ac('list',array('info'=>$ann_set['mm_set'],'type'=>'view','data'=>array('con_startdate <='=>$today,'con_enddate >='=>$today,'ob_startdate'=>'DESC')));
				
				/*$projn_v_set=$this->CM->Init_TB_Set('mm_projnotice_search_set');
				$final['noticetype_pdb']=$this->$projn_v_set['mm_set']->noticetype_pdb;
				$ip_data=array('con_isactive'=>'Y','pd_pp'=>3,'pd_np'=>0,'gp'=>'Y','ob_created'=>'DESC','con_jec_user_id'=>$this->ad_id,'orwhere'=>array(),'limit'=>3);//
				$final['notice_list']=$this->GM->common_ac('list',array('info'=>$projn_v_set['mm_set'],'type'=>'def','data'=>$ip_data));*/
				

            break;
        endswitch;
?>