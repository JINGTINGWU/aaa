<table width="100%">

	<tr>
    	<td valign="top"  class="mm_left_info_width">
            <div id="project_info_div" class="mm_area_div_3">
                <?php $this->load->view('common/project/project_info_div', array('proj_data' => $proj_data));?>
            </div>
            <div id="project_mng_div" class="mm_area_div_3">
                <?php $this->load->view('common/project/project_mng_div', array('proj_data' => $proj_data));?>
            </div>
            <div id="task_info_div" class="mm_area_div_3">
                <?php $this->load->view('common/task/task_info2_div', array('projt_data' => $projt_data));?>
            </div>

        </td>
        <td valign="top">
            <div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller . '/inform_item/work_record_div', array('main_list' => $main_list, 'pd' => $pd));?>
	<!--
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="3">工作紀錄列表</td>
    	</tr>
        <tr>

            <td>處理時間</td>
            <td>工作紀錄</td>
            <td>異動人員</td>

        </tr>
        < ?php foreach($main_list as $value):?>
        <tr>

            <td>< ?=$value['recordtime']?></td>
            <td>< ?=$value['description']?></td>
            <td>< ?=$value['user_name']?></td>

        </tr>
        < ?php endforeach;?>
    </table>-->
            </div>
            <div id="file_area_div" class="mm_area_div_2">
                <?php $this->load->view($this->m_controller . '/inform_item/task_file_list_div', array('file_list' => $file_list, 'fpd' => $fpd));?>
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