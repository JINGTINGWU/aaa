<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<input type="hidden" id="time_tag" value="<?=$time_tag?>" />
<input type="hidden" id="rp_time" value="<?=$rp_time?>" />
<table width="100%">
	<tr>
    	<td valign="top"  class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_mng_div" class="mm_area_div_3">
			<?php $this->load->view('common/project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="task_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/self_work/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
        </td>
        <td valign="top">
        <div  class="mm_area_div_1">
        <?php
		switch($projt_data['projtasktype']):
			case 5:
				?>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">工作回復</td>
            <td>回復時間：<?=$main_op['rp_recover_time']['op']?></td>
            <td id="frominputarea"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_recover/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>回復原因：</td>
            <td colspan="2" id="frominputarea"><?=$main_op['rp_recover']['op']?><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_recover/')?>')"  class="mm_submit_button" ><input type="button" value="申請工作回覆繼續進行"  class="mm_submit_button"  onclick="PG_BK_Action('rp_recover',{url:'<?=$rp_url['rp_recover']?>'});"></td>
        </tr>
	</table>
</div>
				<?php
				break;
		endswitch;
		?>

		</div>
        </td>
    </tr>
</table>
<script>
function PG_BK_Action(type,data)
{
	if(typeof(data)=='object'){
		data.time_tag=document.getElementById('time_tag').value;
		data.rp_time=document.getElementById('rp_time').value;
		data.content=document.getElementById(type).value;
	}
	switch(type){
		case 'rp_recover':
			AWEA_Ajax(data.url,data,'');
			break;
		case 'after_reply':
			JS_Link('<?=$tcate_url['work_list_index']?>');
			break;
	}
}
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
}
</script>