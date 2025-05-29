	<table class="query-div" cellspacing="1" cellpadding="3" <?=$this->ECPM->m_right_tag['add_dp']?> >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>追加日期：</td><td id="frominputarea"><?=$main_op['addsubdate']['op']?></td>
            <td>追加類型：</td><td id="frominputarea"><?=$main_op['addsubtype']['op']?></td>
            <td>追加料品：</td><td id="frominputarea"><?=$main_op['jec_product_id_title']['op']?><?=$main_op['jec_product_id']['op']?><br /><label id="jec_product_id_title_lb"></label></td>
        </tr>
		<tr>
        	<td>追加數量</td><td id="frominputarea"><?=$main_op['quantity']['op']?></td>
            <td>預估單價</td><td id="frominputarea"><?=$main_op['price']['op']?></td>
        	<td>備註說明：</td><td id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button" /><input type="button" value="追加料品" onclick="pg_submit('add_prod','<?=$form_url?>');" class="mm_submit_button" /></td>
        </tr>
	</table>
	<table id="spec_prod_div" style="display:none;" class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right" width="100">料號：</td><td id="frominputarea"><?=$main_op_spec['value']['op']?></td>
            <td align="right">料品名稱：</td><td id="frominputarea"><?=$main_op_spec['name']['op']?></td>
            <td align="right">單位：</td><td id="frominputarea"><?=$main_op_spec['jec_uom_id']['op']?></td>
        </tr>
		<tr>
        	<td align="right">規格：</td><td colspan="5" id="frominputarea"><?=$main_op_spec['specification']['op']?></td>
        </tr>
		<tr>
        	<td align="right">說明：</td><td colspan="5" id="frominputarea"><?=$main_op_spec['description']['op']?></td>
        </tr>
	</table>
<script>
	cal.manageFields("addsubdate", "addsubdate", "%Y-%m-%d");
</script>  