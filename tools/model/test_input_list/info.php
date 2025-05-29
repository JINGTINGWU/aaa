<?php
        switch($df_ip['ac']):
            case 'list': 
				//echo $df_ip['chinfo'].'<==';
				$this->CM->Unique_Load_Lib('Hscal');
				$chinfo=$this->CM->CHINFO_MNG($df_ip['chinfo']);
				$final['cal_today']=isset($chinfo['cal_today'])?$chinfo['cal_today']:date('Y-m-d');
				if(substr($final['cal_today'],0,7)==date('Y-m')){
					 $final['cal_today']=date('Y-m-d');
				}else{
					$final['cal_today']=substr($final['cal_today'],0,7).'-01';
				}
				//$final['cal_today']='2012-05-30';
				$final['cal_sed']=$this->hscal->cal_get_sed("m",$final['cal_today']);
				$final['week_info']=$this->hscal->cal_get_weeknum($final['cal_sed']);
				$final['today_sd']=$final['cal_sed']['sd']." 00:00:00";
				$final['today_ed']=$final['cal_sed']['ed']." 23:59:59";
				$final['w_sd']=$this->hscal->cal_get_sed("wm",$final['cal_sed']['sd']);
				//$final['w_ed']=$this->hscal->cal_get_sed("wm",$final['cal_sed']['ed']);

				$today_time=strtotime($final['cal_today'].' 00:00:00'); 
				$pre_month=date('Y-m-d',mktime(0,0,0,date('m',$today_time)-1,date('d',$today_time),date('Y',$today_time)));
				$next_month=date('Y-m-d',mktime(0,0,0,date('m',$today_time)+1,date('d',$today_time),date('Y',$today_time)));
				$final['pre_year_month']=substr($pre_month,0,8);
				$final['pre_month_title']=$this->CM->FormatData(date('m',strtotime($pre_month.' 00:00:00'))*1,'number',1);
				$final['next_month_title']=$this->CM->FormatData(date('m',strtotime($next_month.' 00:00:00'))*1,'number',1);
				$final['this_month_title']=$this->CM->FormatData(date('m',strtotime($final['cal_today'].' 00:00:00'))*1,'number',1);
				$final['pre_month']=site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$pre_month)."").'/');
				$final['next_month']=site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$next_month)."").'/');
				$pre_year=date('Y-m-d',mktime(0,0,0,date('m',$today_time),date('d',$today_time),date('Y',$today_time)-1));
				$next_year=date('Y-m-d',mktime(0,0,0,date('m',$today_time),date('d',$today_time),date('Y',$today_time)+1));
				$final['pre_year']='<a href="'.site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$pre_year)."").'/').'">'.substr($pre_year,0,4).'</a>';
				$final['next_year']='<a href="'.site_url($final['var_purl'].$df_ip['tag'].'/list/0/'.$final['var_surl'].''.str_replace('=','',base64_encode("cal_today=".$next_year)."").'/').'">'.substr($next_year,0,4).'</a>';

            break;
            case 'edit':
                $this->CM->close_cache();
                $final['first_tag']=isset($_POST['first_tag'])?$_POST['first_tag']:'';

                $final['up_f']=$up_f;
                $this->load->library('form_input');
                $final['fs_bkurl']=site_url($final['var_purl'].$df_ip['tag']."/list/0/".$final['var_surl']);
                $final['fs_hidden']=$this->form_input->temp_hidden_string($search_array_f,array('post_pre_tag'=>$this->field_pre));
                $final['field_pre']=$this->field_pre;
                $final['input_info']=$this->GM->common_ac('spec_data',array('info'=>$mm_set,'tt'=>'f','target'=>'load_mm_field_check'));
                $final['main_data']=$this->GM->common_ac('list',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id']));  
                $final=$this->CM->trans_input_G($final);
                //get_store_grade
                $sg_set=$this->CM->Init_TB_Set('mm_storegrade_set');
                $final['sg_list']=$this->GM->common_ac('list',array('info'=>$sg_set['mm_set'],'type'=>'def','data'=>array('ob_seqno'=>'ASC')));
                $final['sg_selected']=explode('/',$final['main_data']['jec_storegrade_setup']);// $this->CM->array_input('jec_project_id',$proj_selected); 
                if(!is_array($final['sg_selected'])) $final['sg_selected']=array();
                $final['tb_cols']=4;
                $this->CM->Unique_Load_Lib('form_input'); 
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );
            break;
            case 'update_1'://只放此處有編的
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $up_v=$this->CM->UPD($up_f,$mm_set);
                $up_v['isopen']=$up_v['isopen']==''?'N':$up_v['isopen'];
                $up_v['startdate']=$this->CM->FormatData('startdate','input','setdate').' 00:00:00';
                $up_v['enddate']=$this->CM->FormatData('enddate','input','setdate').' 00:00:00';
                $up_v['updated']=date('Y-m-d H:i:s');
                //test_sg_data....
                $sg_set=$this->CM->Init_TB_Set('mm_storegrade_set');
                $check_list=$this->GM->common_ac('list',array('info'=>$sg_set['mm_set'],'type'=>'def','data'=>array()));
                $selected_array=$this->CM->get_format_list('def',$check_list,'jec_storegrade_id','sg_');
                $up_v['jec_storegrade_setup']=implode('/',$selected_array);
                
                if($df_ip['key_id']==0)
                {
                    $this->GM->common_ac('insert',array('info'=>$mm_set,'upt'=>'def','upd'=>$up_v));
                }
                else
                {   
                    $this->GM->common_ac('update',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>$up_v)); 
                }
                //renew_order 依修改結果
                $source_list=$this->GM->common_ac('list',array('info'=>$mm_set,'type'=>'def','data'=>array('glt'=>2,'con_'.$pj_set['mm_tb'].'.datatype'=>$up_v['datatype'],'con_'.$pj_set['mm_tb'].'.noticetype'=>$up_v['noticetype'],'ob_'.$pj_set['mm_tb'].'.seqno'=>'ASC','ob_'.$pj_set['mm_tb'].'.updated'=>'ASC')));
                $this->CM->ReOrderSeqno($pj_set['mm_set'],$source_list,'seqno'); 
                ?><script>parent.PG_Reload_Project_Info();parent.ECP_Msg('',1);</script><?php            
            break;
            case 'update_2':
                
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $main_data=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
                $pro_pic_path='..'.MM_Pic_DF_URL;//MM_Pic_DF_URL
                $value='ad_image_id';
                
                //foreach($up_f as $value):
                    $post_file=$this->field_pre.$value;
                    if($_FILES[$post_file]['name']!='')
                    {  //刪舊的-這邊上的還是用系統給檔名
                        
                        $img_s_w=180; $img_s_h=50; 
                        $upload_filename=$_FILES[$post_file]['name'];
                        $assign_name=$post_file."_".date('YmdHis').rand(10,99);
                        $upload_exe=$this->CM->Upload_File($_FILES[$post_file],$pro_pic_path,$assign_name,1);
                        //$this->CM->JS_Msg('xxx'.$post_file.$pro_pic_path.$assign_name);
                    
                        if($upload_exe['status']==0)
                        {
                            $msg.="圖片未上傳成功。";  
                            ?><script>parent.ECP_Msg("<?=$msg?>");</script><?php                        
                        }
                        else
                        {
                            $file_pic=$assign_name.".".$upload_exe['sub_name']; 
                            $file_pic_s=$assign_name."_s.".$upload_exe['sub_name'];
                        //壓小圖
                        //save-可先取空值
                            $img_set=$this->CM->Init_TB_Set('mm_ad_image_set');
                            if($main_data[$value]*1==0)://原無圖 
                                $up=array(
                                    'ad_client_id'=>$this->ad_client_id,
                                    'ad_org_id'=>$this->ad_org_id,
                                    'isactive'=>'Y',
                                    'created'=>date('Y-m-d H:i:s'),
                                    'createdby'=>$this->ad_id,
                                    'updated'=>date('Y-m-d H:i:s'),
                                    'updatedby'=>$this->ad_id,
                                    'upload_filename'=>$upload_filename,
                                    'sys_filename'=>$file_pic,
                                    'sys_filename_s'=>$file_pic_s,
                                    'entitytype'=>'D'
                                );
                                $this->GM->common_ac('insert',array('info'=>$img_set['mm_set'],'upt'=>'def','upd'=>$up));
                                $ad_image_id=mysql_insert_id(); 
                            //update prodkind
                                $this->GM->common_ac('update',array('info'=>$pj_set['mm_set'],'upt'=>'def','upd'=>array($value=>$ad_image_id),'kid'=>$df_ip['key_id']));                       
                            else:
                                //刪舊圖
                                $pic_data=$this->GM->common_ac('list',array('info'=>$img_set['mm_set'],'upt'=>'def','kid'=>$main_data[$value]));
                                @unlink($pro_pic_path.$pic_data['sys_filename']);
                                @unlink($pro_pic_path.$pic_data['sys_filename_s']);
                                $up=array(
                                    'updated'=>date('Y-m-d H:i:s'),
                                    'updatedby'=>$this->ad_id,
                                    'upload_filename'=>$upload_filename,
                                    'sys_filename'=>$file_pic,
                                    'sys_filename_s'=>$file_pic_s,
                                );
                                $this->GM->common_ac('update',array('info'=>$img_set['mm_set'],'upt'=>'def','upd'=>$up,'kid'=>$main_data[$value]));    
                            endif; 

                            //$_G['acbk_div']='tcate_'.$df_ip['tag'].'_div';
                            //$_G['acbk_url']=site_url($final['var_purl'].$df_ip['tag'].'/edit_noplate/'.$df_ip['key_id'].'/'); 
                            //$this->CM->JS_Load($_G['acbk_div'],$_G['acbk_url'],"p"); 
                            include_once('tools/common/thumb.class.php');
                            $t = new ThumbHandler();
                            $t->setSrcImg($pro_pic_path.$file_pic);
                        //$t->setSrcImg("images/mask_blank.jpg");
                        //$t->setMaskImg($pro_pic_path.$file_pic);
                        //$t->setMaskPosition(5,array('h'=>$img_s_h,'w'=>$img_s_w));
                            $t->setCutType(1);//这一句就OK了
                            $t->setDstImg($pro_pic_path.$file_pic_s); 
                            $t->createImg($img_s_w,$img_s_h); 
                        }
                    }
                    ?><script>parent.CleanFile('<?php echo $this->field_pre;?>ad_image_id');parent.document.getElementById('prod_project_pic_img').src='<?php echo "http://".$_SERVER['HTTP_HOST'].MM_Pic_DF_URL.$file_pic_s;?>';parent.document.getElementById('prod_project_pic_div').style.display='block';parent.PG_Reload_Project_Info();</script><?php                       
            break;
            case 'del_pic':
                
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $img_set=$this->CM->Init_TB_Set('mm_ad_image_set');
                $field='ad_image_id';
                $main_data=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
                $pic_data=$this->GM->common_ac('list',array('info'=>$img_set['mm_set'],'upt'=>'def','kid'=>$main_data[$field]));
                $pro_pic_path='..'.MM_Pic_DF_URL;
                
                @unlink($pro_pic_path.$pic_data['sys_filename']);
                @unlink($pro_pic_path.$pic_data['sys_filename_s']);
                $this->db->where($img_set['mm_kid'],$main_data[$field])->update($img_set['mm_tb'],array('isactive'=>'N'));
                $this->db->where($pj_set['mm_kid'],$df_ip['key_id'])->update($pj_set['mm_tb'],array($field=>NULL));
                
                //refresh
                $ajo=array(
                    'css_id'=>'prod_project_pic_div',
                    'css_display'=>'none',
                    //'reload'=>'tcate_'.$df_ip['tag'].'_div',
                    'info_refresh'=>'prodproj',
                    //'reload_url'=>site_url($final['var_purl'].$df_ip['tag']."/edit_noplate/".$df_ip['key_id']."/".$final['var_surl']),
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);
                  
            break;
            case 'del':
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $this->GM->common_ac('del',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
                $ajo=array(
                        'resubmit'=>'fs_search_form',
                        'pass'=>1
                     );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo);  
            break;
            case "move_up":
                //key_id->item
                
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $main_data=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
                $fs_datatype=$main_data['datatype'];
                $fs_noticetype=$main_data['noticetype'];
                //find pre.            
                if($main_data['seqno']*1>1):
                    $target_v=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'type'=>'def','data'=>array('con_datatype'=>$fs_datatype,'con_noticetype'=>$fs_noticetype,'con_seqno <'=>$main_data['seqno'],'ob_seqno'=>'DESC','ob_updated'=>'DESC','pd_np'=>0,'pd_pp'=>1,'row_type'=>1)));
                    $target_id=isset($target_v[$pj_set['mm_kid']])?$target_v[$pj_set['mm_kid']]:0;
                    if($target_id>0):
                        $change_order=$target_v['seqno'];
                        $this->GM->common_ac('update',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$target_id,'upd'=>array('seqno'=>$main_data['seqno'])));
                        $this->GM->common_ac('update',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('seqno'=>$change_order)));
                        //reorder
                        $ajo=array(
                            'resubmit'=>'fs_search_form',
                            //'reload'=>'tcate_'.$df_ip['tag'].'_div',
                            //'reload_url'=>site_url($final['var_purl'].$df_ip['tag']."/list/".$datakeyid."/".$final['var_surl']),
                            'pass'=>1
                        );
                        $final['response_type']='ajax';
                        $final['ajax_output']=$this->CM->tag_pack($ajo);                         
                    endif;
                endif;

            break;
            case "move_down":
                $pj_set=$this->CM->Init_TB_Set($mm_set);
                $main_data=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id']));
                $fs_datatype=$main_data['datatype'];
                $fs_noticetype=$main_data['noticetype'];
                //find pre.            
                if($main_data['seqno']*1>0):
                    $target_v=$this->GM->common_ac('list',array('info'=>$pj_set['mm_set'],'type'=>'def','data'=>array('con_datatype'=>$fs_datatype,'con_noticetype'=>$fs_noticetype,'con_seqno >'=>$main_data['seqno'],'ob_seqno'=>'ASC','ob_updated'=>'ASC','pd_np'=>0,'pd_pp'=>1,'row_type'=>1)));
                    $target_id=isset($target_v[$pj_set['mm_kid']])?$target_v[$pj_set['mm_kid']]:0;
                    if($target_id>0):
                        $change_order=$target_v['seqno'];
                        $this->GM->common_ac('update',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$target_id,'upd'=>array('seqno'=>$main_data['seqno'])));
                        $this->GM->common_ac('update',array('info'=>$pj_set['mm_set'],'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>array('seqno'=>$change_order)));
                        //reorder
                        $ajo=array(
                            'resubmit'=>'fs_search_form',
                            //'reload'=>'tcate_'.$df_ip['tag'].'_div',
                            //'reload_url'=>site_url($final['var_purl'].$df_ip['tag']."/list/".$datakeyid."/".$final['var_surl']),
                            'pass'=>1
                        );
                        $final['response_type']='ajax';
                        $final['ajax_output']=$this->CM->tag_pack($ajo);                         
                    endif;
                endif;
            break;
        endswitch;
?>