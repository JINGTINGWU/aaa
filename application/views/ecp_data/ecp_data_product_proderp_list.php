<!-- 已建立的ERP對應列表 -->
<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 0px; width: 100%">
	<tr><td>已設定的ERP材料對應關係(可勾選無關的ERP材料後，再執行移除作業)</td></tr>
	<tr><td bgcolor="#FFFFDE">
		<?php foreach($proderp_list as $key => $proderplist): ?>
			<div style="width: 24.9%; float: left; margin-top: 5px;">
				<input type="checkbox" name="kwlist" id="kwlist" value="Y" />&nbsp;
				<?= trim($proderplist['prodname']) ?>&nbsp;/&nbsp;<?= trim($proderplist['prodspec']) ?>
				<input type="hidden" id="<?= 'kwlistid'.$key ?>" value="<?= $proderplist['jec_producterp_id'] ?>">
			</div>
		<?php endforeach; ?>
	</td></tr>
	<tr><td align="center">
		<input type="button" id="btn_kwdelete" value="確定移除勾選的ERP材料對應" onclick="keyword_delete()" />
	</td></tr>
</table>
