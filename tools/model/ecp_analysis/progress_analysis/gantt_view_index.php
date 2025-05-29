<?php
/*
$final['pg_tag']='a1p_pd';
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
}*/	
		//
        switch($df_ip['ac']):
            case 'list': 
				$this->CM->close_cache();
				$final['assign_view']='gantt_view_index_1';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';		
				
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$final['projtask_list']=$this->GM->common_ac('list',array('info'=>$projt_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'ob_startdate'=>'ASC','ob_projtasktype'=>'ASC')));
				$gantt_data=$this->$projt_v_set['mm_set']->get_gantt_data($final['projtask_list']);
				//$gantt_data=iconv('utf-8','big5',$gantt_data);
				//echo $gantt_data;
				/*
				@unlink('js/test.txt');	//@unlink('js/test.js');
				$x=fopen('js/test.txt','w+');
				fwrite($x,$gantt_data);
				fclose($x);
				$final['js_name']='test_'.time();
				@rename('js/test.txt','js/'.$final['js_name'].'.js');*/
				
				$final['color_info']=$this->$projt_v_set['mm_set']->color_info;
				$final['task_type']=$this->$_G['L_CS']->common_use_ld('tasktype');
				$final['gantt_data']=$gantt_data;
				
				//	
				
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'work_overview_index'=>site_url($final['var_purl'].'work_overview_index/list/'.$df_ip['key_id'].'/'),
						'cost_analysis_index'=>site_url($final['var_purl'].'cost_analysis_index/list/'.$df_ip['key_id'].'/')
					);//
            break;
            case 'update'://只放此處有編的
				
				$gv=array("value","jec_company_id","projyear","name","description","jec_customer_id","jec_user_id","jec_usersales_id","startdate","enddate","projtype"); $gv=$this->CM->GPV($gv);
				
				$upd=array_merge($gv,array('isactive'=>'Y','projstatus'=>1));
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('insert',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd));
				$final['acbk_url']=site_url($final['var_purl'].'project_list_index/');

            break;
			
            case 'delete_proj':
               //
			   $proj_set=$this->CM->Init_TB_Set('mm_project_set');
			   $this->$proj_set['mm_set']->delete_project($df_ip['key_id']);
			   //refresh.
                $ajo=array(
					'refresh_url'=>site_url($final['var_purl'].'project_list_index/list/0/'.$final['var_surl']),
                    'pass'=>1
                );
				if($_G['err_msg']!=''):
					unset($ajo['refresh_url']);
					$ajo['msg']=$_G['err_msg'];
				endif;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;
        endswitch;
?>