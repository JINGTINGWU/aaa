
<table width="100%">
	<tr>
    	<td valign="top" class="mm_top_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div_t3',array('proj_data'=>$proj_data)); ?>
        </div>
        <!-- <div id="project_mng_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/adjust_project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div> -->
        </td>
    </tr>
    <tr>
    	<td valign="top">
			<div id="result_area_div" class="mm_area_div_3" style="padding:5px;">
			<!-- <iframe width="100%" style="height:500px;border:#999999 1px solid;" src="<?=$list_url?>" scrolling="yes" frameborder="0"></iframe>--> <?php $this->load->view($this->m_controller.'/adjust_project/adjusttask_list_div',array('proj_data'=>$proj_data)); ?>

			</div>
        </td>
    </tr>
</table>
<script type="text/javascript">
function PG_BK_Action(type,data)
{	var info=Array();
	var total_item=parseInt("<?=$total_item?>");	
	switch(type){
	case 'adjust_date':
		if(PG_BK_Action('check_select',{})==true){
			if(confirm("確定批次調整日期?")){
				document.getElementById('task_string').value=PG_BK_Action('get_string',{});				
				document.getElementById('edit_form').action="<?=$adjust_date_url?>";
				document.getElementById('edit_form').submit();
			}
		}			
	break;
	case 'check_select':			
			var num=0,error=true;
			$("input[name='cb']").each(function() {
         		if($(this).attr("checked")==true)
				{
					num++;
				}
     		});
			if(num==0){
				ECP_Msg("請選擇要展期的工作。");
				error=false;				
			}
			var re = /^[0-9]+$/;
			if(!re.test($('#adjustday').val()))
			{
				ECP_Msg("展期天數請輸入數字。");
				error=false;		
			}
			return error;
	break;	
	case 'get_string':
			var task_string='';
			$("input[name='cb']").each(function() {
         		if($(this).attr("checked")==true)
				{
					task_string+='-'+$(this).val();
				}
     		});
			task_string=task_string.substr(1);
			return task_string;
	break;
	case 'after_reply':			
			JS_Link('<?=$tcate_url['adjusttask_list_index']?>');
	break;
	}
}
</script>