<?php
$add_da=$this->ECPM->m_right_tag['add_da'];
if($proj_data['projstatus']==6):
	$add_da='disabled';
endif;
?>
	<table  class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="5" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">*任務名稱：</td><td id="frominputarea"><input type="checkbox" id="jobsearch_type" onclick="PG_BK_Action('job_search_type','jobsearch_type')" />只查我的部門<?=$main_op['jec_job_id_title']['op']?><?=$main_op['jec_job_id']['op']?><br /><label id="jec_job_id_title_lb"></label></td><td><input type="button" value="新增任務" onclick="pg_submit('add_job','<?=$form_url?>');" class="mm_submit_button"  <?=$add_da?> /></td></tr>
            <tr>
            <td align="right">備註說明：</td><td id="frominputarea"><?=$main_op['description_n']['op']?>
            <input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description_n/')?>')" class="mm_submit_button" <?=$add_da?> /><td><input  class="mm_submit_button"  type="button" value="回上頁" onclick="JS_Link('<?=$tcate_url['bk_url']?>')" /></td>
        </tr>
	</table>
