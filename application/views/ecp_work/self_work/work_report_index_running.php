<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<script src="<?=base_url()?>js/PL_P.js"></script>
<input type="hidden" id="time_tag" value="<?=$time_tag?>" />
<input type="hidden" id="rp_time" value="<?=$rp_time?>" />
<style>
.mm_pg_width_1{
	width:80px;
}
.mm_pg_width_2{
	width:80px;
}
</style>
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
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">工作狀態</td>
            <td>
            <?php
			switch($projt_data['projtasktype']):
				case 6:
					?>本項工作已回報完成，完成時間：<?=substr($projt_data['finishdate'],0,10)?><?php
					break;
				default:
					?>本項工作已回報<?php
					break;
			endswitch;
			?>
            <input type="button" value="取消回報此項工作" class="mm_submit_button" onclick="PG_BK_Action('rp_cancel',{url:'<?=$rp_url['rp_cancel']?>'});"  id="rp_cancel_btn"  >
            </td>
        </tr>
	</table>
</div>

		</div>
        </td>
    </tr>
</table>
<script>
function PG_BK_Action(type,data)
{	
	switch(type){
		case 'rp_cancel':
			if(confirm("確定取消回報?")){
				document.getElementById('rp_cancel_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
			break;	
		case 'after_cancel':
			JS_Link('<?=$tcate_url['work_list_index']?>');
			break;	
	}
}

</script>


