<?php
$final['pg_tag']='p5a_pd';//add
if($df_ip['chinfo']==-1||!isset($_SESSION[$final['pg_tag']])){
	$df_ip['chinfo']='N';
	$_SESSION[$final['pg_tag']]=array(
			'np'=>0,
			'ot'=>'DESC',
			'ob'=>'addsubdate',
			'pp'=>$this->m_pp,
			'fnp'=>0,
			'fot'=>'DESC',
			'fob'=>'filename',
			'fpp'=>$this->m_pp
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
				
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_projprod/'.$df_ip['key_id'].'/');
				$final['add_prod_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_prod_div/'.$df_ip['key_id'].'/');
				$final['file_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/');
				$final['prod_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['update_projprod_url']=site_url($final['var_purl'].$df_ip['tag'].'/update_projprod/'.$df_ip['key_id'].'/');
				$final['check_prodtype_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_prodtype/'.$df_ip['key_id'].'/');
				

				
				$final['assign_view']='add_detail_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$projas_v_set=$this->CM->Init_TB_Set('mm_projaddsub_search_set');//12
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projas_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'wi'=>array('addsubtype'=>array(1,2)),'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_addsubdate_url'=>'addsubdate@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_addsubtype_url'=>'addsubtype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_product_id_url'=>'jec_product_id@@@'.$df_ip['ob'],'ob_specification_url'=>'specification@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_jec_uom_id_url'=>'jec_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$this->load->model('Mm_search_obj','SOBJ',True);
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projas_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_product_id']['onchange']="PG_BK_Action('check_prodtype',{'jec_product_id':this.value})";	
				unset($final['ip_info']['addsubtype']['ld'][2]);
				unset($final['ip_info']['addsubtype']['ld'][3]);
                $final['main_data']=array('addsubdate'=>date('Y-m-d')); 
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
				$ip_info_spec=$this->$prodo_set['mm_set']->load_mm_field_check();
				$final['main_op_spec']=$this->form_input->each_op_trans('full',$ip_info_spec,array(),'_spec');	
				

				
				//$final['file_list']=array();//分頁用session
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'con_filetype'=>3,'gp'=>'Y','pd_pp'=>$_SESSION[$final['pg_tag']]['fpp'],'pd_np'=>$_SESSION[$final['pg_tag']]['fnp'],'ob_'.$_SESSION[$final['pg_tag']]['fob']=>$_SESSION[$final['pg_tag']]['fot'])));
				//echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>'.count($final['file_list']);
				$_G['pg_div_id']='file_area_div'; 
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$_SESSION[$final['pg_tag']]['fot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$_SESSION[$final['pg_tag']]['fot'].'-'.$_SESSION[$final['pg_tag']]['fpp'].'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ot_asc_url'=>'ASC@@@'.$_SESSION[$final['pg_tag']]['fot'],'ob_created_url'=>'created@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_job_name_url'=>'job_name@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_filename_url'=>'filename@@@'.$_SESSION[$final['pg_tag']]['fob'],'ob_uploader_name_url'=>'uploader_name@@@'.$_SESSION[$final['pg_tag']]['fob'])));
				
				
				$final['fpd']['ot']=$_SESSION[$final['pg_tag']]['fot'];
				$final['fpd']['ob_css']='detail-'.strtolower($_SESSION[$final['pg_tag']]['fot']).'ending';
				$final['fob']=$_SESSION[$final['pg_tag']]['fob'];
				
            	$final['jobtype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('jobtype'),'key'=>'id','vf'=>'name'),'page_db',1); 
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_ld']=$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y')));
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$final['uom_ld'],'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				$final['addsubtype_pdb']=$this->CM->FormatData(array('db'=>$final['ip_info']['addsubtype']['ld'],'key'=>'id','vf'=>'name'),'page_db',1);
				
				$proj_v_set=$this->CM->Init_TB_Set('mm_project_search_set');
				$final['proj_data']=$this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
				
				$final['tcate_url']=array(
						'project_list_index'=>base_url($final['var_purl'].'project_list_index/list/0/created/asc/0/N/'),
						'reduce_detail_index'=>base_url($final['var_purl'].'reduce_detail_index/list/'.$df_ip['key_id'].'/created/asc/0/N/')
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
				$final['assign_view']='a_prod_list_div';
				$this->load->library('form_input');
				
				$projas_v_set=$this->CM->Init_TB_Set('mm_projaddsub_search_set');
				$final['ip_info']=$this->$projas_v_set['mm_set']->load_mm_field_check();
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projas_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'wi'=>array('addsubtype'=>array(1,2)),'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
                $_G['pg_div_id']='result_area_div'; //
				$final['pd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_addsubdate_url'=>'addsubdate@@@'.$df_ip['ob'],'ob_name_url'=>'name@@@'.$df_ip['ob'],'ob_addsubtype_url'=>'addsubtype@@@'.$df_ip['ob'],'ob_description_url'=>'description@@@'.$df_ip['ob'],'ob_jec_product_id_url'=>'jec_product_id@@@'.$df_ip['ob'],'ob_specification_url'=>'specification@@@'.$df_ip['ob'],'ob_value_url'=>'value@@@'.$df_ip['ob'],'ob_jec_uom_id_url'=>'jec_uom_id@@@'.$df_ip['ob'],'ob_quantity_url'=>'quantity@@@'.$df_ip['ob'],'ob_price_url'=>'price@@@'.$df_ip['ob'],'ob_total_url'=>'total@@@'.$df_ip['ob'])));
				$final['pd']['ot']=$df_ip['ot'];
				$final['pd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$uom_set=$this->CM->Init_TB_Set('mm_uom_set');
				$final['uom_ld']=$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y')));
				$final['uom_pdb']=$this->CM->FormatData(array('db'=>$final['uom_ld'],'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
				$final['addsubtype_pdb']=$this->CM->FormatData(array('db'=>$final['ip_info']['addsubtype']['ld'],'key'=>'id','vf'=>'name'),'page_db',1);
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
				$final['assign_view']='a_file_list_div';
				$projf_v_set=$this->CM->Init_TB_Set('mm_projfile_search_set');
				$final['file_list']=$this->GM->common_ac('list',array('info'=>$projf_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$df_ip['key_id'],'con_filetype'=>3,'gp'=>'Y','pd_pp'=>$pd_pp,'pd_np'=>$df_ip['np'],'ob_'.$df_ip['ob']=>$df_ip['ot'])));
                $_G['pg_div_function']='ECP_Load_Div';
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='';
				$_G['pg_div_id']='file_area_div'; 
				//排序的東東
				$final['fpd']=$this->GM->page_data(array('now_ot'=>$df_ip['ot'],'uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/file_list_div/'.$df_ip['key_id'].'/'.$_SESSION[$final['pg_tag']]['fob'].'/'.$df_ip['ot'].'-'.$pd_pp.'/','mm_spec_url'=>array('ot_desc_url'=>'DESC@@@'.$df_ip['ot'],'ot_asc_url'=>'ASC@@@'.$df_ip['ot'],'ob_created_url'=>'created@@@'.$df_ip['ob'],'ob_filename_url'=>'filename@@@'.$df_ip['ob'],'ob_uploader_name_url'=>'uploader_name@@@'.$df_ip['ob'])));
				$final['fpd']['ot']=$df_ip['ot'];
				$final['fpd']['ob_css']='detail-'.strtolower($df_ip['ot']).'ending';
				$final['fob']=$df_ip['ob'];
				
			break;
			
			case 'add_prod_div':
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_projprod/'.$df_ip['key_id'].'/');
				$final['add_prod_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_prod_div/'.$df_ip['key_id'].'/');
				$final['prod_list_url']=site_url($final['var_purl'].$df_ip['tag'].'/list_div/'.$df_ip['key_id'].'/created/asc/0/N/');
				$final['check_prodtype_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_prodtype/'.$df_ip['key_id'].'/');
				
				$final['assign_view']='add_prod_div';
				$projas_v_set=$this->CM->Init_TB_Set('mm_projaddsub_search_set');
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$projas_v_set['mm_set']->load_mm_field_check();
				$final['ip_info']['jec_product_id']['onchange']="PG_BK_Action('check_prodtype',{'jec_product_id':this.value})";	
				unset($final['ip_info']['addsubtype']['ld'][2]);
				unset($final['ip_info']['addsubtype']['ld'][3]);
                $final['main_data']=array('addsubdate'=>date('Y-m-d')); 
				
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
				$ip_info_spec=$this->$prodo_set['mm_set']->load_mm_field_check();
				$final['main_op_spec']=$this->form_input->each_op_trans('full',$ip_info_spec,array(),'_spec');	
				
			break;
			case 'add_projprod'://
				$gv=array("jec_product_id","product_name","description",'addsubdate','quantity','price','addsubtype'); $gv=$this->CM->GPV($gv);				
				$upd=array_merge($gv,$this->CM->Base_New_UPD());//
				$upd['total']=$upd['price']*$upd['quantity'];
				$projas_set=$this->CM->Init_TB_Set('mm_projaddsub_set');
				$prod_set=$this->CM->Init_TB_Set('mm_product_set');
				$final['prod_data']=$this->GM->common_ac('list',array('info'=>$prod_set['mm_set'],'upt'=>'def','kid'=>$upd['jec_product_id']));
				$upd['prodtype']=$final['prod_data']['prodtype'];
				if($final['prod_data']['prodtype']==8)://新增自訂的
					$sgv=array("value","description",'jec_uom_id','name','specification'); $sgv=$this->CM->NFGV($sgv,array('post_sur_tag'=>'_spec'));
					$supd=array_merge($sgv,$this->CM->Base_New_UPD());
					$supd['price']=$upd['price'];
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					$this->GM->common_ac('insert',array('info'=>$prodo_set['mm_set'],'upt'=>'def','upd'=>$supd));
					$upd['jec_productopen_id']=mysql_insert_id();
				elseif($final['prod_data']['prodtype']==null):
					$upd['prodtype']=1;
				endif;
				$upd=array_merge($upd,array('jec_project_id'=>$df_ip['key_id']));
				log_message('info','upd');	
				foreach ($upd as $key =>$tmpupd)
				{					
					log_message('info',$key.'='.$tmpupd);	
				}	
				log_message('info','prod_set');	
				foreach ($prod_set as $key =>$tmpupd)
				{					
					log_message('info',$key.'='.$tmpupd);	
				}	
				log_message('info','projas_set');	
				foreach ($projas_set as $key =>$tmpupd)
				{					
					log_message('info',$key.'='.$tmpupd);	
				}
				$this->GM->common_ac('insert',array('info'=>$projas_set['mm_set'],'upt'=>'def','upd'=>$upd));
				
                $ajo=array(
					'bk_action'=>'after_add_prod',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);
			break;
			case 'check_prodtype'://確認產品類型
				$jec_product_id=(int)$_POST['jec_product_id'];
				$prod_set=$this->CM->Init_TB_Set('mm_product_set');
				$prod_data=$this->$prod_set['mm_set']->get_product_row($jec_product_id);
				
                $ajo=array(
					'bk_action'=>'edit_spec_prod',
					'prodtype'=>$prod_data['prodtype'],
					'prod_price'=>(float)$prod_data['price'],
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
			
			case 'update_projprod':
				$gv=array("projaddsub_id","description",'price','addsubdate','quantity','no'); $gv=$this->CM->GPV($gv);
				$no=$gv['no'];
				$projas_set=$this->CM->Init_TB_Set('mm_projaddsub_set');
				//
				$upd=$gv;
				unset($upd['projaddsub_id']);
				unset($upd['no']);
				$upd['total']=$upd['price']*$upd['quantity'];
				$this->GM->common_ac('update',array('info'=>$projas_set['mm_set'],'upt'=>'def','upd'=>$upd,'kid'=>$gv['projaddsub_id']));
				
				$projas_data=$this->$projas_set['mm_set']->get_projaddsub_row($gv['projaddsub_id']);
				if((int)$projas_data['jec_productopen_id']>0):
					$gv2=array('oppro_value','oppro_name','oppro_uom','oppro_specification'); $gv2=$this->CM->GPV($gv2);
					$upd2=array(
							'value'=>$gv2['oppro_value'],
							'name'=>$gv2['oppro_name'],
							'specification'=>$gv2['oppro_specification'],
							'jec_uom_id'=>$gv2['oppro_uom']
						);
					$this->db->where('jec_productopen_id',$projas_data['jec_productopen_id'])->update('jec_productopen',$upd2);
				endif;


                $ajo=array(
					'msg'=>'已修改',
					'innerId'=>'total_tag_'.$no,
					'innerHTML'=>$upd['total'],
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 	
			break;
			case 'delete_projprod':
			    $projas_set=$this->CM->Init_TB_Set('mm_projaddsub_set');//
			    $final['projas_data']=$this->$projas_set['mm_set']->get_projaddsub_row($df_ip['key_id']);
			   
			    $this->$projas_set['mm_set']->delete_projaddsub($final['projas_data']);//delete_projjob($projjob=0)
                $ajo=array(
					'bk_action'=>'after_add_prod',
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
			break;
        endswitch;
?>