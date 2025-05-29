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
			<iframe width="100%" style="height:500px;border:#999999 1px solid;" src="<?=$list_url?>" scrolling="yes" frameborder="0"></iframe>
			</div>
        </td>
    </tr>
</table>