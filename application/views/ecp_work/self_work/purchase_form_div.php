<?php
/*
foreach($test as $no=>$value):
	echo $value['FieldValue'];
	if($no==20) break;
endforeach;*/
?>
<style>
.mm_right{
	text-align:right;
}
</style>
<form name="purchase_form" id="purchase_form" method="post" target="phf" action="<?=$form_url?>">
<table width="100%"  class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="7" align="left" style="padding:0px;"></td>
			</tr>
			<tr>
            	<td class="mm_right">*報支流程：</td>
                <td colspan="2" id="frominputarea"><?=$main_op['ad005053']['op']?></td>
                <td class="mm_right">*報支類別：</td>
                <td id="frominputarea"><?=$main_op['ad005059']['op']?></td>
                <td class="mm_right">專案採購：</td>
                <td id="frominputarea"><?=$main_op['ad005055']['op']?></td>
            </tr>
			<tr>
            	<td class="mm_right">*廠商名稱：</td>
                <td colspan="2" id="frominputarea"><?=$main_op['ad005005']['op']?><?=$main_op['ad005005_title']['op']?></td>
                <td class="mm_right">需用日期：</td><td id="frominputarea"><?=$main_op['ad005009']['op']?></td>
                <td class="mm_right">採購用途：</td><td id="frominputarea">成本</td>
            </tr>
			<tr>
            	<td class="mm_right">*採購人員：</td>
                <td colspan="2" id="frominputarea"><?=$main_op['ad005006']['op']?><?=$main_op['ad005006_title']['op']?></td>
                <td class="mm_right">申請人員：</td>
                <td id="frominputarea"><?=$main_op['ad005010']['op']?><?=$main_op['ad005010_title']['op']?></td>
                <td class="mm_right">領用人員：</td>
                <td id="frominputarea"><?=$main_op['ad005013']['op']?><?=$main_op['ad005013_title']['op']?></td>
           </tr>
		   <tr>
                <td class="mm_right">附註用途：</td>
                <td colspan="6" id="frominputarea"><?=$main_op['ad005016']['op']?></td>
           </tr>
		   <tr>
           		<td class="mm_right">金額 ：</td>
                <td colspan="6">
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
    <tr><td class="mm_right">預計採購金額：</td><td id="frominputarea"><?=$main_op['ad005038']['op']?></td><td class="mm_right">+調整金額：</td><td id="frominputarea"><?=$main_op['ad005037']['op']?></td><td class="mm_right">調整原因：</td><td id="frominputarea"><?=$main_op['ad005054']['op']?></td></tr>
    <tr><td class="mm_right">-議價金額：</td><td id="frominputarea"><?=$main_op['ad005056']['op']?></td><td class="mm_right">-折扣金額：</td><td id="frominputarea"><?=$main_op['ad005057']['op']?></td><td class="mm_right">折扣原因：</td><td id="frominputarea"><?=$main_op['ad005060']['op']?></td></tr> 
    <tr><td class="mm_right">=NT$</td><td><?=$main_op['ad005018']['op']?><?=$main_op['fix_price']['op']?></td><td colspan="4" id="frominputarea">元(本次實際請款金額<?=$main_op['ad005017']['op']?>)</td></tr> 
    </table>
    
				 </td>
           </tr>
		   <tr>
           		<td colspan="7"><iframe id="purchase_prod_div" name="purchase_prod_div" width="100%" frameborder="0" style="border:#CCCCCC 1px solid;height:230px;">
</iframe></td>
		  </tr>
</table>
<input type="hidden" id="prod_string" name="prod_string" >
<div align="center">請選擇公司別<?=$main_op['target_db']['op']?><input id="purchase_submit_btn" type="button" value="送出採購報支單" onclick="PG_BK_Action('send_purchase');"> <input type="button" value="取消" onclick="PG_BK_Action('cancel_purchase')"></div>
</form>
<script>
cal.manageFields("ad005009", "ad005009", "%Y/%m/%d");
PG_BK_Action('load_select_prod',{});
//NumCount....= =.
</script>

