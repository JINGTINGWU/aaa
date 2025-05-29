<?php
        switch($df_ip['ac']):
            case 'list': 
			
				$final['cal_url']=$this->$_G['L_CS']->common_url_ld('cal');
				//$final['get_dept_url']=$this->$_G['L_CS']->common_url_ld('get_dept_by_saler');
				$final['check_item_url']=base_url($final['var_purl'].$df_ip['tag'].'/check_item_add/0/');
				$final['form_url']=site_url($final['var_purl'].$df_ip['tag'].'/add_item/0/');

				//$final['form_model_url']=site_url($final['var_purl'].'project_new_index/load_model/0/');
				//$final['form_project_url']=site_url($final['var_purl'].'project_new_index/load_project/0/'); //
				
				$final['assign_view']='create_item_index';
				$final['show_tcate']='Y';
				$final['show_plate']='Y';
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				
				$this->load->library('form_input');
                //$final['field_pre']=$this->field_pre;
                $final['ip_info']=$this->$proj_set['mm_set']->load_mm_field_check();
				//$final['ip_info']['jec_project_id_title']['onchange']="PG_BK_Action('clean_project_id')";
				
				//
				$final['ip_info']['item_model']=array(
						'call_name'=>'範本',
						'type'=>'select',
						'ld'=>'mm_producttemp_set@def',
						'ld_key'=>'jec_producttemp_id',
						'ld_value'=>'name',
						'style'=>'width:260px;'
					);//
				$final['ip_info']['project_history']=array(
						'call_name'=>'舊專案',
						'type'=>'select',
						'ld'=>$this->CM->db->where('isproductprep','Y')->where('isactive','Y')->get('jec_project')->result_array(),//'mm_project_set@def'
						'ld_key'=>'jec_project_id',
						'ld_value'=>'name',
						'style'=>'width:260px;'
					);
                $final['main_data']=array(
										'value'=>$this->$proj_set['mm_set']->get_project_series(),
										'costrate'=>1,
										'projyear'=>date('Y')
									); 
				//$final['ip_info']['jec_usersales_id']['onchange']="PG_BK_Action('get_dept_id_by_saler',{ user_id:this.value })";
				$final['main_op']=$this->form_input->each_op_trans('full',$final['ip_info'],$final['main_data']);
				$final['tcate_url']=array(
						'create_item_index'=>base_url($final['var_purl'].'create_item_index/list/'),
						'item_list_index'=>base_url($final['var_purl'].'item_list_index/list/-1/created/asc/0/')
					);
				//不可隨便亂新增= = 
            break;
			
            case 'add_item'://只放此處有編的
				
				$gv=array('jec_project_id'); $gv=$this->CM->GPV($gv);
				$item_model=(int)$_POST['item_model'];
				$project_history=(int)$_POST['project_history'];
				
				//
				$this->CM->db->where('jec_project_id',$gv['jec_project_id'])->update('jec_project',array('isproductprep'=>'Y'));

				$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
				if($item_model>0):
					//load	- 
					//$prodt_set=$this->CM->Init_TB_Set('mm_producttemp_set');
					$prodtl_v_set=$this->CM->Init_TB_Set('mm_producttempline_search_set');
					$prod_list=$this->GM->common_ac('list',array('info'=>$prodtl_v_set['mm_set'],'type'=>'def','data'=>array('con_jec_producttemp_id'=>$item_model,'ob_seqno'=>'ASC')));
					
					foreach($prod_list as $pno=>$pvalue):
						$p_upd=array(
								'jec_project_id'=>$gv['jec_project_id'],
								'jec_product_id'=>$pvalue['jec_product_id'],
								'value'=>$pvalue['value'],
								'prodname'=>$pvalue['name'],
								'prodspec'=>$pvalue['specification'],
								'prod_uom_id'=>$pvalue['jec_uom_id'],
								'quantity'=>0,
								'price'=>$pvalue['price'],
								'total'=>0,
								'jec_user_id'=>$this->ad_id,
								'jec_vendor_id'=>$pvalue['jec_vendor_id'],
								'description'=>$pvalue['description'],
								'seqno'=>($pno+1)
							);
						$p_upd=array_merge($this->CM->Base_New_UPD(),$p_upd);
						//NewNewNew
						$this->GM->common_ac('insert',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>$p_upd));
					endforeach;					
					
				elseif($project_history>0):
					//load-load 有備品清單的。@@--
					$prod_list=$this->GM->common_ac('list',array('info'=>$prodprep_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$project_history,'ob_seqno'=>'ASC')));
					/* 
					$projj_set=$this->CM->Init_TB_Set('mm_projjob_set');
					$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
					$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
					$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
					$projj_list=$this->GM->common_ac('list',array('info'=>$projj_set['mm_set'],'type'=>'def','data'=>array('con_jec_project_id'=>$project_history,'ob_seqno'=>'ASC')));
					foreach($projj_list as $jno=>$jvalue):						
						$task_list=$this->GM->common_ac('list',array('info'=>$projt_set['mm_set'],'type'=>'def','data'=>array('con_jec_projjob_id'=>$jvalue['jec_projjob_id'],'ob_seqno'=>'ASC')));
						foreach($task_list as $tno=>$tvalue):							
							$prod_list=$this->GM->common_ac('list',array('info'=>$projp_set['mm_set'],'type'=>'def','data'=>array('con_jec_projtask_id'=>$tvalue['jec_projtask_id'],'ob_seqno'=>'ASC')));*/
							foreach($prod_list as $pno=>$pvalue):
							
								$p_upd=array(
										'jec_project_id'=>$gv['jec_project_id'],
										'jec_product_id'=>$pvalue['jec_product_id'],
										'value'=>$pvalue['value'],
										'prodname'=>$pvalue['prodname'],
										'prodspec'=>$pvalue['prodspec'],
										'prod_uom_id'=>$pvalue['prod_uom_id'],
										'quantity'=>$pvalue['quantity'],
										'price'=>$pvalue['price'],
										'total'=>$pvalue['total'],
										'jec_user_id'=>$this->ad_id,
										'jec_vendor_id'=>$pvalue['jec_vendor_id'],
										'description'=>$pvalue['description'],
										'seqno'=>($pno+1)
									);	
								$this->GM->common_ac('insert',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>$p_upd));
							endforeach;/*
						endforeach;
					endforeach;*/
				endif;
				
				$final['acbk_url']=site_url($final['var_purl'].'item_detail_index/list/'.$gv['jec_project_id'].'/seqno/asc/0/-1/');
				$final['response_type']='bk_ac';
            break;
			case 'check_item_add':
				//cus_name
				//$cus_name=trim($_POST['cus_name']);//trim()
				$gv=array('proj_name'); $gv=$this->CM->GPV($gv);
				
				$projname=$projid=$msg='';
				$check=$this->db->where('name',$gv['proj_name'])->where('isactive','Y')->get('jec_project')->result_array();
				
				$pass='Y';
				
				if($pass=='Y')://user_sales
					//$check=$this->db->where('name',$gv['user_name'])->where('isactive','Y')->get('jec_user')->result_array();
					if(count($check)>0):
						$pass='Y';
						$projname=$check[0]['name'];
						$projid=$check[0]['jec_project_id'];
					else:
						$pass='N';
						$msg='查無此專案';
					endif;
				endif;
				
                $ajo=array(
					'bk_action'=>'add_item_go',
					'isexist'=>$pass,
					'proj_name'=>$projname,
					'proj_id'=>$projid,
                    'pass'=>1
                );
				if($msg!='') $ajo['msg']=$msg;
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
				break;
        endswitch;
?>