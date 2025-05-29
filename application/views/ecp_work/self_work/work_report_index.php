<table width="100%">
	<tr>
    	<td valign="top"  class="mm_left_info_width">
        <div id="project_info_div">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_mng_div">
			<?php $this->load->view('common/project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="task_info_div">
        	<?php $this->load->view($this->m_controller.'/self_work/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
        </td>
        <td valign="top">
        <div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>工作完成</td>
            <td>工作狀態：</td>
            <td>工作進度：</td>
            <td>完成時間： <input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>工作紀錄：</td>
            <td colspan="3"><input type="text"><input type="button" value="片語輸入"><input type="button" value="回報此項工作已完成"></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>調整日期</td>
            <td>申請調整新的完成日期：</td>
            <td><input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>申請說明：</td>
            <td colspan="2"><input type="text"><input type="button" value="片語輸入"><input type="button" value="申請調整完成日期"></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>工作移轉</td>
            <td>申請將工作移轉至他人：</td>
            <td><input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>申請說明：</td>
            <td colspan="2"><input type="text"><input type="button" value="片語輸入"><input type="button" value="申請工作移轉他人"></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>無法完成</td>
            <td>回報時間：</td>
            <td><input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>問題說明：</td>
            <td colspan="2"><input type="text"><input type="button" value="片語輸入"><input type="button" value="回報此項工作無法完成"></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>工作暫停</td>
            <td>申請時間：</td>
            <td><input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>暫停原因：</td>
            <td colspan="2"><input type="text"><input type="button" value="片語輸入"><input type="button" value="申請工作暫停"></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table>
		<tr>
        	<td>工作回復</td>
            <td>回復時間：</td>
            <td><input type="button" value="上傳附件"></td>
        </tr>
		<tr>
        	<td>回復原因：</td>
            <td colspan="2"><input type="text"><input type="button" value="片語輸入"><input type="button" value="申請工作回覆繼續進行"></td>
        </tr>
	</table>
</div>
		</div>
        </td>
    </tr>
</table>