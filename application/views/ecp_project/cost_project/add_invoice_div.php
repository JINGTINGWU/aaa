	<table class="query-div" cellspacing="1" cellpadding="3" <?=$this->ECPM->m_right_tag['add_dp']?> >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>選擇發票年度：</td><td  id="frominputarea"><?=$main_op['invoiceyear']['op']?></td>
            <td>發票日期：</td><td><?=$main_op['invoicedate']['op']?></td>
            <td>金額：</td><td><?=$main_op['invoiceamount']['op']?></td>
        </tr>
		<tr>
        	<td>備註說明：</td><td colspan="4"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button"></td>
            <td><input type="button" value="新增專案發票" onclick="pg_submit('add_invoice','<?=$form_url?>');" class="mm_submit_button" ></td>
        </tr>
	</table>
<script>
	cal.manageFields("invoicedate", "invoicedate", "%Y-%m-%d");
</script> 