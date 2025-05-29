<!-- 可選擇的ERP材料列表 -->
<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 0px; width: 100%">
	<tr><td>查詢ERP材料列表</td></tr>
	<tr><td>
		<?php if (empty($proderp_select)): ?>
			查無相關詞的關鍵字
		<?php else: ?>
			<?php foreach($proderp_select as $key => $proderpselect): ?>
				<div style="width: 24.9%; float: left; margin-top: 5px;">
					<input type="checkbox" name="kwselect" id="kwselect" value="Y" />&nbsp;
					<?= trim($proderpselect['MB002']) ?>&nbsp;/&nbsp;<?= trim($proderpselect['MB003']) ?>
					<input type="hidden" id="<?= 'kwselectid'.$key ?>" value="<?= $proderpselect['MB001'] ?>">
				</div>
			<?php endforeach; ?>
		<?php endif;?>
	</td></tr>
	<tr><td align="center">
		<input type="button" id="btn_kwselect" value="確定新增勾選的ERP材料" onclick="keyword_select()" />
	</td></tr>
</table>
