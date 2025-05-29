<?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			$up_da=$this->ECPM->m_right_tag['up_da'];
			$del_da=$this->ECPM->m_right_tag['del_da'];
			if($proj_data['projstatus']==6):
   				$up_da='disabled';
   				$del_da='disabled';
				$full_set['disabled']='Y';
			endif;
?>
<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="8" class="mm_table2_title">任務列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='seqno'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_seqno_url']?>');">排序</a></td>
            <td class="mm_table2_title2" <?=$ob=='jobname'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jobname_url']?>');">任務名稱</a></td>
            <td class="mm_table2_title2" <?=$ob=='jobjobtype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jobjobtype_url']?>');">任務特性</a></td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</a></td> 
            <td class="mm_table2_title2" id="detail-normal">修改</td> 
            <td class="mm_table2_title2" id="detail-normal">編輯工作</td>   
            <td class="mm_table2_title2" id="detail-normal">上傳附件</td> 
            <td class="mm_table2_title2" id="detail-normal">刪除</td>            
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <?php
				$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
		?>
        <tr id="tr_<?=$no?>">
        	<td>
            <?php if($ob=='seqno'&&$up_da==''):?>
            <img src="<?=base_url()?>images/up.gif"  onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/move_up/'.$value['jec_projjob_id'].'/'.$var_surl)?>','')" />&nbsp;<img src="<?=base_url()?>images/down.gif" onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/move_down/'.$value['jec_projjob_id'].'/'.$var_surl)?>','')" />
            <?php endif;?>            
            </td>
            <td><?=$value['jec_job_id']>0?$value['jobname']:$e_op['jobname']['op']?></td>
            <td><?=$e_op['jobjobtype']['op']?></td>
            <td><?=$e_op['description']['op']?></td>  
            <td><input type="button" value="修改" onclick="PG_BK_Action('update_projjob',{'projjob_id':'<?=$value['jec_projjob_id']?>','no':'<?=$no?>'})" class="mm_submit_button_1" <?=$up_da?> /></td> 
            <td><input type="button" value="工作項目" onclick="JS_Link('<?=site_url($var_purl.'task_list_index/list/'.$value['jec_projjob_id'].'/created/asc/0/-1/')?>');" class="mm_submit_button_1" ></td>   
            <td><input type="button" value="上傳附件" onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div/job_list/'.$value['jec_projjob_id'].'/')?>')" class="mm_submit_button_1"  <?=$up_da?> ></td> 
            <td><input type="button" value="刪除任務" onclick="AWEA_Ajax('<?=site_url($var_purl.'job_list_index/delete_job/'.$value['jec_projjob_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1"  <?=$del_da?> ></td>  
        </tr>        
        <?php endforeach;?>
    </table>