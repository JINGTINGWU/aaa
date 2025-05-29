<?php
	$o_add_da=$this->ECPM->m_right_tag['add_da'];
	$projstatus=array(3,4,5,6);
	if(in_array($proj_data['projstatus'],$projstatus)):
		$o_add_da='disabled';
	endif;
	if($projt_data['isfinish'] == 'Y'):
		$o_add_da='disabled';
	endif;
			  if($o_add_da==''):
		  			$add_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $add_da = $o_add_da;
			  endif;
?>
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="8" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right" width="100">*品名/工作明細：</td><td id="frominputarea" colspan="3"><input type="checkbox" id="prodsearch_type" onclick="PG_BK_Action('prod_search_type','prodsearch_type')" checked="checked" />只查我的部門<?=$main_op['jec_product_id_title']['op']?><?=$main_op['jec_product_id']['op']?><br /><label id="jec_product_id_title_lb"></label></td>
            <td align="right">規格：</td>
            <td id="frominputarea"><?=$main_op['prodspec']['op']?></td>
             <td align="right">單位：</td>
            <td id="frominputarea"><?=$main_op['prod_uom_id']['op']?></td>           
        </tr>
        <tr>
            <td align="right">*數量：</td>
            <td id="frominputarea"><?=$main_op['quantity']['op']?></td>
            <td align="right">實際單價：</td><td id="frominputarea"><?=$main_op['price']['op']?></td>   
            <td align="right">倍數：</td><td id="frominputarea"><?=$main_op['extramultiple']['op']?></td>      
            <td align="right">加成：</td><td id="frominputarea"><?=$main_op['extraaddition']['op']?></td>    
        </tr>
		<tr>
        	<td align="right">採購廠商：</td><td id="frominputarea"><?=$main_op['jec_vendor_id_title']['op']?><?=$main_op['jec_vendor_id']['op']?><br /><label id="jec_vendor_id_title_lb"></label></td>
        	<td align="right">需求日期：</td><td id="frominputarea"><?=$main_op['startdate']['op']?></td>
            <td align="right">備註說明：</td><td colspan="5" id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button" <?=$add_da?> /></td>
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
	cal.manageFields("startdate", "startdate", "%Y-%m-%d");
</script>   