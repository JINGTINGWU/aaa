<?php

switch ($df_ip['ac']):
    case 'list':
        $final['cal_url'] = $this->$_G['L_CS']->common_url_ld('cal');
        $final['list_url'] = base_url($final['var_purl'] . 'deletetask_list_index/list_div/' . $df_ip['key_id'] . '/');
        $final['delete_task_url'] = base_url($final['var_purl'] . $df_ip['tag'] . '/cp_impossible/' . $df_ip['key_id'] . '/');

        $final['assign_view'] = 'deletetask_list_index';
        $final['show_tcate'] = 'Y';
        $final['show_plate'] = 'Y';
        $proj_v_set = $this->CM->Init_TB_Set('mm_project_search_set');
        $final['proj_data'] = $this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
        $final['main_list'] = $this->project_init_full_view_deltask($df_ip['key_id']);

        $task_list = $this->db->where('jec_project_id', $df_ip['key_id'])->where('isactive', 'Y')->order_by('seqno', 'ASC')->get('jec_projtask_search_view')->result_array();
        $final['total_item'] = count($task_list);

        $final['tcate_url'] = array(
            'project_list_index' => base_url($final['var_purl'] . 'project_list_index/list/0/created/asc/0/N/'),
            'project_adjust_index' => base_url($final['var_purl'] . 'project_adjust_index/list/' . $df_ip['key_id'] . '/'),
            'deletetask_list_index' => base_url($final['var_purl'] . 'deletetask_list_index/list/' . $df_ip['key_id'] . '/'),
            'job_list_index' => base_url($final['var_purl'] . 'job_list_index/list/' . $df_ip['key_id'] . '/created/asc/0/-1/')
        );
        break;
    case 'list_div':
        $final['assign_view'] = 'deletetask_list_div';
        $proj_v_set = $this->CM->Init_TB_Set('mm_project_search_set');
        $final['proj_data'] = $this->$proj_v_set['mm_set']->get_project_row($df_ip['key_id']);
        $final['main_list'] = $this->project_init_full_view_deltask($df_ip['key_id']);
        $final['resda020_pdb'] = $this->$_G['L_CS']->resda020_info;
        $final['resda021_pdb'] = $this->$_G['L_CS']->resda021_info;

        $task_list = $this->db->where('jec_project_id', $df_ip['key_id'])->where('isactive', 'Y')->order_by('seqno', 'ASC')->get('jec_projtask_search_view')->result_array();
        $final['total_item'] = count($task_list);
        break;
    case 'cp_impossible':
        $gv = array('checked_task_string', 'unchecked_task_string');
        $gv = $this->CM->GPV($gv);
        $final['checked_notice_array'] = explode('-', $gv['checked_task_string']);
        $final['unchecked_notice_array'] = explode('-', $gv['unchecked_task_string']);

        $projn_set = $this->CM->Init_TB_Set('mm_projnotice_set');
        $projr_set = $this->CM->Init_TB_Set('mm_projrecord_set');
        $projrp_set = $this->CM->Init_TB_Set('mm_projreply_set');
        $cal_set = $this->CM->Init_TB_Set('mm_calendar_set');
        $projt_set = $this->CM->Init_TB_Set('mm_projtask_set');
        $projt_v_set = $this->CM->Init_TB_Set('mm_projtask_search_set');
        $projj_v_set = $this->CM->Init_TB_Set('mm_projjob_search_set');
        $proj_set = $this->CM->Init_TB_Set('mm_project_set');

        //同意確認刪除勾選的工作
        foreach ($final['checked_notice_array'] as $checkednoticeid):
            if ($checkednoticeid > 0):
                $final['projn_data'] = $this->$projn_set['mm_set']->get_projnotice_row($checkednoticeid); //				
                $final['projr_data'] = array();
                if ((int) $final['projn_data']['jec_projreply_id'] > 0):
                    $final['projr_data'] = $this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
                endif;

                $projt_data = $this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']); //

                $projj_data = $this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']); //

                $proj_data = $this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']); //

                $setup_set = $this->CM->Init_TB_Set('mm_setup_set');
                $mail_pdb = $this->CM->FormatData(array('db' => 'mm_setup_set@def', 'key' => 'noticetype', 'vf' => 'content'), 'page_db', 1);

                $sales_name = $this->GM->GetSpecData('jec_user', 'name', 'jec_user_id', $projt_data['jec_user_id']);

                //check是否為group.
                if ((int) $projt_data['jec_user_id'] > 0):
                    $tu_user = array(array('jec_user_id' => $projt_data['jec_user_id']));
                else:
                    $tu_user = $this->db->where('jec_group_id', $projt_data['jec_group_id'])->where('isactive', 'Y')->get('jec_usergroup')->result_array();
                endif;
                $projn_noticetype = $this->$projn_set['mm_set']->get_noticetype($df_ip['ac'] . '_' . 'C');


                $mail_data = array('proj_name' => $proj_data['name'], 'task_name' => $projt_data['name'], 'noticetype' => $projn_noticetype, 'sales_name' => $sales_name);
                $mail_content = $this->$projn_set['mm_set']->get_mail_content($mail_pdb, $mail_data['noticetype'], $mail_data);

                $desc = $mail_content;
                //批次不加意見
                //if ($gv['cp_finish'] != '') {
                //    $mail_content .= "<br>意見：" . $gv['cp_finish'];
                //}

                //update 主管的noticetype
                $this->db->where($projn_set['mm_kid'], $checkednoticeid)->update($projn_set['mm_tb'], array('emailcontent' => $mail_content, 'noticetype' => $projn_noticetype)); //無影響				

                foreach ($tu_user as $tu_value):
                    //-Email
                    //proj_notice
                    //Send
                    $email = array(
                        'name' => $this->GM->GetSpecData('jec_user', 'name', 'jec_user_id', $tu_value['jec_user_id']),
                        'to' => $this->GM->GetSpecData('jec_user', 'email', 'jec_user_id', $tu_value['jec_user_id']),
                        'time' => date('Y-m-d H:i:s'),
                        'subject' => $this->$projn_set['mm_set']->get_email_subject($df_ip['ac']), //$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
                        'content' => $mail_content,
                        'emailsend' => 'N'
                    );
                    //不發mail
					//if ($this->CM->SendMailGo($email['to'], $email['name'], $email['subject'], $email['content'], '', 'From-System')):
                    //    $email['emailsend'] = 'Y';
                    //endif;
                    							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
								'description' => '批次刪除確認'
								);
							$t_projnotice_id=$this->$projn_set['mm_set']->notice_action($upd);
							//record
							//$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$final['projn_data']['jec_projtask_id'],
								'recordtype'=>$projn_noticetype,//$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content,
								'description2'=>'批次刪除確認'
								);
							$this->$projr_set['mm_set']->record_action($upd);

                endforeach;

                $this->db->where($projt_set['mm_kid'],$final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'],array('isconfirm'=>'Y','projtasktype'=>4,'replystatus'=>0,'canceldate'=>date('Y-m-d H:i:s'),'noticetime'=>date('Y-m-d H:i:s'),'jec_projnotice_id'=>$t_projnotice_id,'isactive'=>'N'));
            //$final['projn_data']
            endif;
        endforeach;
        //不同意確認未勾選的工作
        foreach ($final['unchecked_notice_array'] as $uncheckednoticeid):
            if ($uncheckednoticeid > 0):
                $final['projn_data'] = $this->$projn_set['mm_set']->get_projnotice_row($uncheckednoticeid); //				
                $final['projr_data'] = array();
                if ((int) $final['projn_data']['jec_projreply_id'] > 0):
                    $final['projr_data'] = $this->$projrp_set['mm_set']->get_projreply_row($final['projn_data']['jec_projreply_id']);
                endif;

                $projt_data = $this->$projt_v_set['mm_set']->get_projtask_row($final['projn_data']['jec_projtask_id']); //

                $projj_data = $this->$projj_v_set['mm_set']->get_projjob_row($projt_data['jec_projjob_id']); //

                $proj_data = $this->$proj_set['mm_set']->get_project_row($projt_data['jec_project_id']); //

                $setup_set = $this->CM->Init_TB_Set('mm_setup_set');
                $mail_pdb = $this->CM->FormatData(array('db' => 'mm_setup_set@def', 'key' => 'noticetype', 'vf' => 'content'), 'page_db', 1);

                $sales_name = $this->GM->GetSpecData('jec_user', 'name', 'jec_user_id', $projt_data['jec_user_id']);

                if ((int) $projt_data['jec_user_id'] > 0):
                    $tu_user = array(array('jec_user_id' => $projt_data['jec_user_id']));
                else:
                    $tu_user = $this->db->where('jec_group_id', $projt_data['jec_group_id'])->where('isactive', 'Y')->get('jec_usergroup')->result_array();
                endif;
                $projn_noticetype = $this->$projn_set['mm_set']->get_noticetype($df_ip['ac'] . '_' . 'N');
                $mail_data = array('proj_name' => $proj_data['name'], 'task_name' => $projt_data['name'], 'noticetype' => $projn_noticetype, 'sales_name' => $sales_name);
                $mail_content = $this->$projn_set['mm_set']->get_mail_content($mail_pdb, $mail_data['noticetype'], $mail_data);

                $desc = $mail_content;
                //批次不加意見
                //if ($gv['cp_finish'] != '') {
                //    $mail_content .= "<br>意見：" . $gv['cp_finish'];
                //}

                //update 承辦的noticetype
                $this->db->where($projn_set['mm_kid'], $uncheckednoticeid)->update($projn_set['mm_tb'], array('emailcontent' => $mail_content, 'noticetype' => $projn_noticetype)); //無影響


                foreach ($tu_user as $tu_value):
                    //-Email
                    //proj_notice
                    //Send
                    //$projn_set=$this->CM->Init_TB_Set('mm_projnotice_set');

                    $email = array(
                        'name' => $this->GM->GetSpecData('jec_user', 'name', 'jec_user_id', $tu_value['jec_user_id']),
                        'to' => $this->GM->GetSpecData('jec_user', 'email', 'jec_user_id', $tu_value['jec_user_id']),
                        'time' => date('Y-m-d H:i:s'),
                        'subject' => $this->$projn_set['mm_set']->get_email_subject($df_ip['ac'] . '_' . 'N'), //$proj_data['name'].'-'.$projj_data['name'].'-'.$projt_data['name'].'-'.
                        'content' => $mail_content,
                        'emailsend' => 'N'
                    );
                    //不發mail
					//if ($this->CM->SendMailGo($email['to'], $email['name'], $email['subject'], $email['content'], '', 'From-System')):
                    //    $email['emailsend'] = 'Y';
                    //endif;
                    //要回全部耶…			
                    $upd = array(
                        'jec_project_id' => $projt_data['jec_project_id'],
                        'jec_projtask_id' => $final['projn_data']['jec_projtask_id'],
                        'noticetype' => $projn_noticetype,
                        'noticefrom' => 1,
                        'jec_user_id' => $tu_value['jec_user_id'],                        
                        'emailtime' => $email['time'],
                        'emailsubject' => $email['subject'],
                        'emailcontent' => $email['content'],
                        'emailsend' => $email['emailsend'],
                        'noticetime' => date('Y-m-d H:i:s'),
                        'description' => '批次刪除退回'
                    );
                    $t_projnotice_id = $this->$projn_set['mm_set']->notice_action($upd);

                    //record
                    //$projr_set=$this->CM->Init_TB_Set('mm_projrecord_set');
                    $upd = array(
                        'jec_project_id' => $projt_data['jec_project_id'],
                        'jec_projtask_id' => $final['projn_data']['jec_projtask_id'],
                        'recordtype' => $projn_noticetype, //不變$this->$projr_set['mm_set']->get_recordstatus($df_ip['ac'])
                        'recordtime' => date('Y-m-d H:i:s'),
                        'jec_user_id' => $tu_value['jec_user_id'], //回覆給回報的人
                        'description' => $desc,
                        'description2' => '批次刪除退回'
                    );
                    $this->$projr_set['mm_set']->record_action($upd);


                endforeach;

                $this->db->where($projt_set['mm_kid'], $final['projn_data']['jec_projtask_id'])->update($projt_set['mm_tb'], array('projtasktype' => 2, 'replystatus' => 0, 'isconfirm' => 'N', 'noticetime' => date('Y-m-d H:i:s'), 'jec_projnotice_id' => $t_projnotice_id)); //無影響,'confirmdate'=>date('Y-m-d H:i:s')
								
            endif;
        endforeach;


        $refresh_url=base_url($final['var_purl'].'project_list_index/list/');
							$msg="已批次確認刪除";
						if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE")) $msg=iconv('utf-8','big5',$msg);
                			?><script>
                	parent.ECP_Msg('<?=$msg?>',999);
					function PG_Refresh(){
							parent.location.href="<?php echo $refresh_url;?>";
						}
						setTimeout("PG_Refresh()", 1500 );
                </script><?php
        break;
endswitch;
?>