<?php
	//不要煩我啦><
	$task_data=$this->CM->db->where('jec_task_id',$projt_data['jec_task_id'])->get('jec_task')->result_array();
	//$task_data=$task_data[0];
?>
        	<table  class="info-div" cellspacing="1" cellpadding="3" style="height:35px;">
            	<tr>
            		<td class="info-title"  width="130">工作項目<input type="button" value="工作紀錄"  class="mm_submit_button" onclick="JS_Link('<?=$record_list_index_url?>')" style="width:70px;height:26px;margin-top:-4px;margin-bottom:-4px;"></td><td><?=$projt_data['taskname']?>，<?=substr($projt_data['startdate'],0,10)?>~<?=substr($projt_data['enddate'],0,10)?>，<?=$projt_data['sales_name']?></td></tr>
                   
            </table>
