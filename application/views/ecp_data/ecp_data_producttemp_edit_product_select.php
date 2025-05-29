<!-- 可選擇的料品列表 -->
<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 0px; width: 100%">
	<tr><td>查詢料品列表</td></tr>
	<tr><td>
		<?php if (empty($prod_select)): ?>
			查無相關詞的關鍵字
		<?php else: ?>
			<?php foreach($prod_select as $key => $prodselect): ?>
				<div style="width: 24.9%; float: left; margin-top: 5px;">
					<input type="checkbox" name="kwselect" id="kwselect" value="Y" />&nbsp;
					<?= $prodselect['name'] ?>
					<?php if (!empty($prodselect['specification'])): ?>
						/<?= $prodselect['specification'] ?>
					<?php endif; ?>
					<input type="hidden" id="<?= 'kwselectid'.$key ?>" value="<?= $prodselect['jec_product_id'] ?>">
					<input type="hidden" id="<?= 'kwselecttp'.$key ?>" value="<?= $prodselect['prodtype'] ?>">
				</div>
			<?php endforeach; ?>
		<?php endif;?>
	</td></tr>
	<tr><td align="center">
		<input type="button" id="btn_kwselect" value="確定新增勾選的料品或工作明細" onclick="keyword_select()" />
	</td></tr>
</table>
