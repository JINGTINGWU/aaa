<?php
        switch($df_ip['ac']):
            case 'list': 
				$mssqlef = $this->load->database('mssqlef', true);
				//$dept_list=$mssqlef->query("SELECT DISTINCT ad019005 FROM ad019 ORDER By CONVERT( ad019005 using big5 ) ASC ")->result_array();
				$dept_list = $mssqlef->distinct('ad019005')->select('ad019005')->order_by('ad019005','ASC')->get('ad019')->result_array();
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				$final['form_url']=site_url($final['var_purl'].'project_adjust_index/update/'.$df_ip['key_id'].'/');
				$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['get_purchase_url']=$this->$_G['L_CS']->common_url_ld('get_purchase_list_by_dept');
				$final['edit_projstatus_url']=site_url($final['var_purl'].'project_adjust_index/edit_projstatus/'.$df_ip['key_id'].'/');
				$final['search_ef_proj_url']=base_url('ecp_common/search_ef_proj/1/ad019004/___/');
				$final['check_projno_url']=base_url('ecp_common/check_projno/');
				$final['check_proj_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_proj_edit/');
				//
				$final['assign_view']='project_adjust_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				$final['proj_data']['jec_user_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['jec_user_id']);
				$final['proj_data']['jec_usersales_id_title']=$this->GM->GetSpecData('jec_user','name','jec_user_id',$final['proj_data']['jec_usersales_id']);
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
				$final['proj_data']['costrate']=(float)$final['proj_data']['costrate'];
				$final['proj_data']['total']=(float)$final['proj_data']['total'];
				
				$final['ip_info']['efprojdept']['ld']=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'ad019005'),'page_db','mssql_ld');
				//$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('get_purchase_list_by_dept')";
				//$final['ip_info']['efprojno']['onchange']="PG_BK_Action('get_purchase_name',this.value)";
				$final['ip_info']['efprojno']['onchange']="PG_BK_Action('check_projno',this.value)";
				$final['ip_info']['efprojdept']['onchange']="PG_BK_Action('change_projdept',this.value)";
				
				if($final['proj_data']['efprojno']!='')://要抓
					//$final['proj_data']['efprojno']=$final['proj_data']['efprojno'].'>>'.$final['proj_data']['efprojname'];
					$os=$this->CM->db->where('noticetype','OS')->where('isactive','Y')->get('jec_setup')->result_array();
					$os=strtolower($os[0]['value']);
					$istrans=$os=='linux'?'Y':'N';
					$ms_dept=$istrans=='Y'?iconv('utf-8','big5',$final['proj_data']['efprojdept']):$final['proj_data']['efprojdept'];
					$purchase_list = $mssqlef->where('ad019005',$ms_dept)->select('ad019004')->select('ad019006')->get('ad019')->result_array();
					$final['ip_info']['efprojno']['ld']=$this->CM->FormatData(array('db'=>$purchase_list,'field'=>'ad019004,ad019006','istrans'=>$istrans),'page_db','mssql_ld');
				endif;
				
				$final['ip_info']['value']['disabled']='Y';
				$final['ip_info']['jec_company_id']['disabled']='Y';
				$final['ip_info']['projyear']['disabled']='Y';
				$final['ip_info']['jec_customer_id_title']['disabled']='Y';
				$final['ip_info']['jec_user_id']['disabled']='Y';
				$final['ip_info']['jec_user_id_title']['disabled']='Y';
				$final['ip_info']['projtype']['disabled']='Y';
				

                $final['main_data']=$final['proj_data']; 
				$final['main_data']['startdate']=substr($final['main_data']['startdate'],0,10);
				$final['main_data']['enddate']=substr($final['main_data']['enddate'],0,10);
				$final['main_data']['jec_customer_id_title']=$final['main_data']['jec_customer_id']>0?$this->GM->GetSpecData('jec_customer','name','jec_customer_id',$final['main_data']['jec_customer_id']):$final['main_data']['customername'];
				$final['main_data']['jec_customer_id']=$final['main_data']['jec_customer_id']>0?$final['main_data']['jec_customer_id']:1;
				$final['ip_info']['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$final['ip_info']['projstatus']['ld']=$this->$proj_set['mm_set']->projstatus_ld_adjust($final['main_data']['projstatus'],$final['ip_info']['projstatus']['ld']);
				$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
				if(!isset($full_set['disabled'])):
					if(!$this->$proj_set['mm_set']->exe_right_check('check_adjust_right',$final['proj_data'])):
						$full_set['disabled']='Y';
					endif;
				endif;
				if(isset($full_set['disabled'])) $final['up_da']='disabled';
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data'],'',$full_set);
				
				//$final['main_list']=$this->project_init_full_view($df_ip['key_id']);
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'project_overview_index'=>base_url($final['var_purl'].'project_overview_index/list/'.$df_ip['key_id'].'/'),
						'job_list_index'=>base_url($final['var_purl'].'job_list_index/list/'.$df_ip['key_id'].'/created/asc/0/-1/')
					);
            break;
            case 'update'://只放此處有編的
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("name","description","jec_usersales_id",'jec_dept_id',"startdate","enddate",'customerdoc','address','value2','description2','name2','description3','efprojdept','efprojno','total','costrate'); $gv=$this->CM->GPV($gv);
				
				$upd=array_merge($gv,$this->CM->Base_UP_UPD());
				$upd['efprojname']=$this->CM->GetString($gv['efprojno'],'>>','');
				$upd['efprojno']=$this->CM->GetString($gv['efprojno'],'','>>');
				
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$this->GM->common_ac('update',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$df_ip['key_id']));
				//$final['acbk_url']=site_url($final['var_purl'].'project_list_index/list/');
				$final['response_type']='ajax';
				?><script>
                	parent.ECP_Msg('已修改專案資料',999);
                </script><?php
            break;
			
			case 'edit_projstatus':
				$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'),array('exit'=>'Y'));
				$gv=array("projstatus"); $gv=$this->CM->GPV($gv);
				$upd=array_merge($gv,$this->CM->Base_UP_UPD());
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				$final['proj_data']=$this->$proj_set['mm_set']->get_project_row($df_ip['key_id']);
				
				$ok='Y';//change
				
				$ok=$this->$proj_set['mm_set']->exe_right_check('change_projstatus',array('jec_project_id'=>$df_ip['key_id'],'projstatus'=>$gv['projstatus']));
				
				if($ok=='Y'):
					
					$this->GM->common_ac('update',array('info'=>$proj_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$df_ip['key_id']));
					/*
					$this->load->library('form_input');
                	$final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
					$final['ip_info']['projstatus']['ld']=$this->$proj_set['mm_set']->projstatus_ld_adjust($gv['projstatus'],$final['ip_info']['projstatus']['ld']);
					$final['ip_info']['projstatus']['only_list']='Y';
					$final['main_op']=$this->form_input->each_op_trans(array('projstatus'),$final['ip_info'],$gv);
					$new_list=$final['main_op']['projstatus']['op'];
					*/
					$new_list='';
					$refresh_url=base_url($final['var_purl'].'project_adjust_index/list/'.$df_ip['key_id'].'/');
				else:
					$gv['projstatus']=$final['proj_data']['projstatus'];
				endif;
				//更改list.parent.document.getElementById('projstatus').innerHTML='$new_list';
				

				

				
				$final['response_type']='ajax';
				if($ok=='Y'):
					?><script>
						//
                		parent.ECP_Msg('已調整專案狀態',999);
						parent.location.href="<?php echo $refresh_url;?>";
               	    </script><?php	
				else:
					?><script>
                		parent.ECP_Msg('<?=$_G['err_msg']?>',999);
               	    </script><?php
				endif;
			break;
			case 'check_proj_edit':
				//cus_name
				//$cus_name=trim($_POST['cus_name']);//trim()
				$gv=array('sales_name'); $gv=$this->CM->GPV($gv);
				$cusname=$username=$cus_id=$userid=$salesname=$salesid=$salesdept=$msg='';
				$pass='Y';
				if($pass=='Y')://user_sales
					$check=$this->db->where('name',$gv['sales_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$salesname=$check[0]['name'];
						$salesid=$check[0]['jec_user_id'];
						$salesdept=$check[0]['jec_dept_id'];
					else:
						$pass='N';
						$msg='查無此專案業務';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>'edit_proj_go',
					'isexist'=>$pass,
					'sales_name'=>$salesname,
					'sales_id'=>$salesid,
					'sales_dept'=>$salesdept,
                    'pass'=>1
                );
				if($msg!='') $ajo['msg']=$msg;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;        
		endswitch;
?>