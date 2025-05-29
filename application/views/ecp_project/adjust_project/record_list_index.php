<table width="100%">
	<tr>
    	<td valign="top" class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="task_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/task/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
        </td>
        <td valign="top">
<div id="result_area_div" class="mm_area_div_2">
    <?php $this->load->view($this->m_controller.'/adjust_project/record_list_div',array('main_list'=>$main_list,'pd'=>$pd,'proj_data'=>$proj_data)); ?>
</div>
<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/adjust_project/task_file_list_div',array('file_list'=>$file_list,'fpd'=>$fpd,'proj_data'=>$proj_data)); ?>
</div>
        </td>
    </tr>
</table>
<script>
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'reload_file_list':
				ECP_Load_Div('file_area_div','<?=$file_list_url?>','');
			break;

	}
}
</script>