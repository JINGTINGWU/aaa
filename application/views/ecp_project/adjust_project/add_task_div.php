<?php
	$o_add_da=$this->ECPM->m_right_tag['add_da'];
	$projstatus=array(3,4,5,6);
	if(in_array($proj_data['projstatus'],$projstatus)):
		$o_add_da='disabled';
	endif;
			  if($o_add_da==''):
		  			$add_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $add_da = $o_add_da;
			  endif;
?>
	<table class="query-div" cellspacing="1" cellpadding="3"  style="margin-top:-6px;" >
			<tr>
				<td colspan="9" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td rowspan="4" width="70"><input type="button" value="新增工作" onclick="pg_submit('add_task','<?=$form_url?>');" class="mm_submit_button" <?=$add_da?>  style="width:70px;" /><input  class="mm_submit_button"  type="button" value="回上頁" onclick="JS_Link('<?=$tcate_url['bk_url']?>')"  style="width:70px;" /></td> 
        	<td width="104" align="right">*選擇工作項目：</td>
       	  <td  id="frominputarea" colspan="3"><input type="checkbox" id="tasksearch_type" onclick="PG_BK_Action('task_search_type','tasksearch_type')" checked="checked" />只查我的部門<?=$main_op['jec_task_id_title']['op']?><?=$main_op['jec_task_id']['op']?><br /><label id="jec_task_id_title_lb"></label></td>
          <td width="80" align="right">負責人員：</td>
          <td width="31" id="frominputarea"><?=$main_op['jec_user_id']['op']?><?=$main_op['jec_user_id_title']['op']?></td>
          <td width="75" align="right">督導人員：</td>
          <td id="frominputarea" colspan="2"><?=$main_op['jec_usersuper_id']['op']?><?=$main_op['jec_usersuper_id_title']['op']?></td>
        </tr>
		<tr>
       	   <td align="right">處理原則：</td>
       	  <td width="17" id="frominputarea"><?=$main_op['taskprocesstype']['op']?></td>
        	<td align="right">前置通知：</td>
       	  <td width="17" id="frominputarea"><?=$main_op['taskdaynotice']['op']?></td>
            <td align="right">工作日期：</td>
          <td colspan="4" id="frominputarea"><?=$main_op['startdate']['op']?>
            ~
          <?=$main_op['enddate']['op']?></td>
        </tr>
		<tr>
        	<td align="right">確認方式：</td>
        	<td id="frominputarea"><?=$main_op['taskconfirmtype']['op']?></td>
        	<td align="right">預估成本：</td><td id="frominputarea"><?=$main_op['price']['op']?></td>
            <td width="80" align="right">允許延遲：</td>
          <td width="31" id="frominputarea"><?=$main_op['taskdaydelay']['op']?></td>
            <td width="75" align="right">工作權重：</td>
          <td id="frominputarea" colspan="2"><?=$main_op['taskworkweight']['op']?></td>
            
  </tr>
		<tr>
		  <td align="right">備註說明：</td>
		  <td colspan="8" id="frominputarea"><?=$main_op['description']['op']?>
	      <input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button" <?=$add_da?>  style="width:70px;" /></td>
	  </tr>
	</table>
<script>
cal.manageFields("startdate", "startdate", "%Y-%m-%d");
cal.manageFields("enddate", "enddate", "%Y-%m-%d");
</script> 