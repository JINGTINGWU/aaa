	<table class="query-div" cellspacing="1" cellpadding="3" <?=$this->ECPM->m_right_tag['add_dp']?> >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>選擇費用名稱：</td><td id="frominputarea"><?=$main_op['jec_chargeitem_id']['op']?></td>
            <td>費用日期：</td><td id="frominputarea"><?=$main_op['chargedate']['op']?></td>
            <td>金額：</td><td id="frominputarea"><?=$main_op['chargefee']['op']?></td>
        </tr>
		<tr>
        	<td>備註說明：</td><td colspan="4" id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button"></td>
            <td><input type="button" value="新增專案費用" onclick="pg_submit('add_cost','<?=$form_url?>');" class="mm_submit_button" ></td>
        </tr>
	</table>
<script>
	cal.manageFields("chargedate", "chargedate", "%Y-%m-%d");
</script> 
