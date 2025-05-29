<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="17" class="mm_table2_title">工作項目列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" width="50px" <?=$ob=='seqno'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_seqno_url']?>');">排序</a></td>
        	<td class="mm_table2_title2" width="60px" <?=$ob=='isfinish'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_isfinish_url']?>');">完成/<br />確認</a></td>
            <td class="mm_table2_title2" <?=$ob=='taskname'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_taskname_url']?>');">工作名稱</a></td>
            <td class="mm_table2_title2" width="60px" <?=$ob=='sales_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_sales_name_url']?>');">負責人員</a></td>
            <td class="mm_table2_title2" width="80px" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_startdate_url']?>');">開始日期</a></td>  
            <td class="mm_table2_title2" width="80px" <?=$ob=='enddate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_enddate_url']?>');">結束日期</a></td>   
            <td class="mm_table2_title2" width="60px" <?=$ob=='jec_usersuper_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jec_usersuper_id_url']?>');">督導人員</a></td> 
            <td class="mm_table2_title2" width="50px" <?=$ob=='taskdaynotice'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_taskdaynotice_url']?>');">通知</a></td> 
            <td class="mm_table2_title2" width="50px" <?=$ob=='taskworkweight'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_taskworkweight_url']?>');">權重</a></td>
            <td class="mm_table2_title2" width="60px" <?=$ob=='taskprocesstype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_taskprocesstype_url']?>');">處理</a></td>
            <td class="mm_table2_title2" width="60px" <?=$ob=='taskconfirmtype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_taskconfirmtype_url']?>');">確認</a></td>   
            <td class="mm_table2_title2" width="60px" <?=$ob=='price'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_price_url']?>');">實際成本</a></td> 
            <td class="mm_table2_title2" width="100px" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</a></td> 
            <td class="mm_table2_title2" width="40px" id="detail-normal">修改</td>
			<td class="mm_table2_title2" width="40px" id="detail-normal">明細</td> 
            <td class="mm_table2_title2" width="40px" id="detail-normal">附件</td> 
            <td class="mm_table2_title2" width="40px" id="detail-normal">刪除</td>              
        </tr>
        <?php 
			$ip_info['jec_usersuper_id_title']['style']="width:45px;";
			$ip_info['jec_user_id_title']['style']="width:45px;";
			$ip_info['taskconfirmtype']['style']="width:50px;";
			$ip_info['taskworkweight']['style']="width:35px;";
			$ip_info['taskdaynotice']['style']="width:40px;";
			$ip_info['taskdaydelay']['style']="width:40px;";
			$ip_info['taskname']['style']="width:90%;";
			$ip_info['price']['style']="width:50px;";
			$ip_info['description']['style']="width:90%;";
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			$o_up_da=$this->ECPM->m_right_tag['up_da'];
			$o_del_da=$this->ECPM->m_right_tag['del_da'];
			$edit_1_info=$this->mm_projtask_search_set->edit_1_info;
			$edit_2_info=$this->mm_projtask_search_set->edit_2_info;
			if($proj_data['projstatus']==6):
   				$o_up_da='disabled';
   				$o_del_da='disabled';
				$full_set['disabled']='Y';
			endif;
			  if($o_up_da==''):
		  			$up_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $up_da = $o_up_da;
			  endif;
			  if($o_del_da==''):
		  			$del_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $del_da = $o_del_da;
			  endif;			  			
			foreach($main_list as $no=>$value):?>
        	<?php
			$value['startdate']=substr($value['startdate'],0,10);
			$value['enddate']=substr($value['enddate'],0,10);
			$ip_info['jec_user_id']['ld']=$user_ld;
			/*
			if($value['jec_user_id']>0||$value['jec_group_id']>0):
				$ip_info['jec_user_id']['full_selected']='N';
			else:
				$ip_info['jec_user_id']['full_selected']='Y';
			endif;*/
			$value['jec_user_id_title']=$value['sales_name'];
			if($value['jec_user_id_title']==''&&(int)$value['jec_group_id']>0) $value['jec_user_id_title']=$this->GM->GetSpecData("jec_group",'name','jec_group_id',$value['jec_group_id']);
			$ip_info['jec_user_id_title']['title']=$value['jec_user_id_title'];
			$ip_info['jec_usersuper_id_title']['title']=$value['jec_usersuper_id_title']=$value['super_name'];
			$ip_info['jec_user_id_title']['onclick']=$ip_info['jec_user_id_title']['onfocus']="PL_ChangePL('user_".$no."');";
			$ip_info['jec_usersuper_id_title']['onclick']=$ip_info['jec_usersuper_id_title']['onfocus']="PL_ChangePL('usersuper_".$no."');";
			
			$e_jec_user_id=(int)$value['jec_user_id']==0?'G-'.$value['jec_group_id']:'U-'.$value['jec_user_id'];
			$value['jec_user_id']=$e_jec_user_id;
			
			
			$ip_info['price']['disabled']=$value['isprojprod'];
			$value['price']=(float)$value['price'];
			$e_ip_info=$ip_info;
			$e_full_set=$full_set;
			if(!isset($e_full_set['disabled']))://非disabled				
				$edit_1_right=$this->mm_projtask_search_set->exe_right_check('check_edit_1',$value);
				$edit_2_right=$this->mm_projtask_search_set->exe_right_check('check_edit_2',$value);
				if($edit_1_right==false):
					foreach($edit_1_info as $ed1v):
						$e_ip_info[$ed1v]['disabled']='Y';//Yes
					endforeach;
				endif;
				if($edit_2_right==false):
					foreach($edit_2_info as $ed1v):
						$e_ip_info[$ed1v]['disabled']='Y';//Yes
					endforeach;
				endif;
				if($edit_2_right==false):
					//$e_full_set['disabled']='Y';
				endif;
			endif;
			//
			$e_op=$this->form_input->each_op_trans('full',$e_ip_info,$value,'_'.$no,$e_full_set);
			?>
        <tr id="tr_<?=$no?>">
        	<td align="center">
            <?php if($ob=='seqno'&&$up_da==''):?>
            <img src="<?=base_url()?>images/up.gif"  onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/move_up/'.$value['jec_projtask_id'].'/'.$var_surl)?>','')" />&nbsp;<img src="<?=base_url()?>images/down.gif" onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/move_down/'.$value['jec_projtask_id'].'/'.$var_surl)?>','')" />
            <?php endif;?>
            </td>
            <td align="center"><img src="<?=base_url()?>images/<?=$value['isfinish']=='Y'?'ok':'no'?>.gif" height="14" />/<img src="<?=base_url()?>images/<?=$value['isconfirm']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td><?=$value['jec_task_id']>0?$value['taskname']:$e_op['taskname']['op']?></td>
            <td>
            	<?=$e_op['jec_user_id']['op']?><?=$e_op['jec_user_id_title']['op']?>
			</td>
            <td><?=$e_op['startdate']['op']?></td>  
            <td><?=$e_op['enddate']['op']?></td>   
            <td><?=$e_op['jec_usersuper_id']['op']?><?=$e_op['jec_usersuper_id_title']['op']?></td> 
            <td><?=$e_op['taskdaynotice']['op']?></td>
            <td><?=$e_op['taskworkweight']['op']?></td>
            <td><?=$e_op['taskprocesstype']['op']?></td>
            <td><?=$e_op['taskconfirmtype']['op']?></td>
            <td><?=$e_op['price']['op']?></td> 
            <td><?=$e_op['description']['op']?></td> 
            <td><input type="button" value="修改"  onclick="PG_BK_Action('update_projtask',{'projtask_id':'<?=$value['jec_projtask_id']?>','no':'<?=$no?>'})"  class="mm_submit_button_1" <?=$up_da?> style="width:40px;" ></td>
			<td><input type="button" value="明細" onclick="JS_Link('<?=site_url($var_purl.'job_detail_index/list/'.$value['jec_projtask_id'].'/created/asc/0/-1/')?>');"  class="mm_submit_button_1"  style="width:40px;"></td> 
            <td><input type="button" value="上傳" onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div/task_list/'.$value['jec_projtask_id'].'/')?>')"  class="mm_submit_button_1" <?=$up_da?>  style="width:40px;" ></td> 
            <td>
            	<?php if(in_array($value['projtasktype'],$btn_del_ty_allow)||in_array($value['projtasktype'],$btn_del_rp_allow)):?>
            	<input type="button" value="刪除"  onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/delete_projtask/'.$value['jec_projtask_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1" <?=$del_da?>  style="width:40px;" >
                <?php endif;?>
            </td> 
            <script>
            cal.manageFields("startdate_<?=$no?>", "startdate_<?=$no?>", "%Y-%m-%d");
			cal.manageFields("enddate_<?=$no?>", "enddate_<?=$no?>", "%Y-%m-%d");
            </script>
        </tr>        
        <?php endforeach;?>
    </table>