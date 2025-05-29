<!-- 現有料品範本內容列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="8">現有料品範本內容列表</td>
	</tr>
	<tr>
		<td align="center">排序</td>
		<td>料號</td>
		<td>品名/工作明細</td>
		<td>規格</td>
		<td align="center">單位</td>
		<td align="right">預估單價</td>
		<td align="center">預設廠商</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($producttemp_edit as $key => $producttempedit): ?>
		<tr>
			<td align="center">
				<?php if ($key == 0): ?>
					<img src="<?= base_url().'images/btn_sortup_grey.gif' ?>" />
				<?php else: ?>
					<img src="<?= base_url().'images/btn_sortup.gif' ?>" title="向上移" 
					onclick="producttemp_updown('<?= $producttempedit['jec_producttempline_id'] ?>', 'UP')" />
				<?php endif; ?>&nbsp;
				<?php if ($key == count($producttemp_edit)-1): ?>
					<img src="<?= base_url().'images/btn_sortdown_grey.gif' ?>" />
				<?php else: ?>
					<img src="<?= base_url().'images/btn_sortdown.gif' ?>" title="向下移" 
					onclick="producttemp_updown('<?= $producttempedit['jec_producttempline_id'] ?>', 'DOWN')" />
				<?php endif; ?>
			</td>
			<td>
				<?= $producttempedit['value'] ?>
			</td>
			<td>
				<?= $producttempedit['name'] ?>
			</td>
			<td>
				<?= $producttempedit['specification'] ?>
			</td>
			<td align="center">
				<?= $producttempedit['unit'] ?>
			</td>
			<td align="right">
				<?= number_format($producttempedit['price']) ?>
			</td>
			<td align="center">
				<?= $producttempedit['vendor'] ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$producttempedit['jec_producttempline_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $producttempedit['jec_producttempline_id'] ?>, <?= $producttempedit['seqno'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>