<?php
$add_da=$this->ECPM->m_right_tag['add_da'];

if($proj_data['projstatus']==6):
	$add_da='disabled';
endif;
?>
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="8" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
             <td align="right">料號：</td>
            <td id="frominputarea"><?=$main_op['value']['op']?></td>  
        	<td align="right" width="100">*品名：</td><td id="frominputarea" colspan="4"><input type="checkbox" id="prodsearch_type" onclick="PG_BK_Action('prod_search_type','prodsearch_type')" />只查我的部門<?=$main_op['jec_product_id_title']['op']?><?=$main_op['jec_product_id']['op']?><br /><label id="jec_product_id_title_lb"></label></td>
            <td align="right">規格：</td>
            <td id="frominputarea" colspan="2"><?=$main_op['prodspec']['op']?></td>
         
        </tr>
        <tr>
            <td align="right">單位：</td>
            <td id="frominputarea"><?=$main_op['prod_uom_id']['op']?></td>  
            <td align="right">*預估數量：</td>
            <td id="frominputarea"><?=$main_op['quantity']['op']?></td>
            <td align="right">預估單價：</td><td id="frominputarea"><?=$main_op['price']['op']?></td>   
            <td align="right">預估合計：</td><td id="frominputarea">-</td>   
            <td align="right">需求日期：</td><td id="frominputarea"><?=$main_op['startdate']['op']?></td>
        </tr>
		<tr>
			<td align="right">採購人員：</td><td id="frominputarea"><?=$main_op['jec_user_id_title']['op']?><?=$main_op['jec_user_id']['op']?><br /><label id="jec_vendor_id_title_lb"></label></td>
        	<td align="right">採購廠商：</td><td id="frominputarea"><?=$main_op['jec_vendor_id_title']['op']?><?=$main_op['jec_vendor_id']['op']?><br /><label id="jec_vendor_id_title_lb"></label></td>
            <td align="right">備註說明：</td><td colspan="5" id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button" <?=$add_da?> /></td>
        </tr>
	</table>
    <!--
	<table id="spec_prod_div" style="display:none;" class="query-div" cellspacing="1" cellpadding="3">
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
	</table>-->
<script>
	cal.manageFields("startdate", "startdate", "%Y-%m-%d");
</script>   