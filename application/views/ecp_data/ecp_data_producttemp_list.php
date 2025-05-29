<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有料品範本列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="5">現有料品範本列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">範本名稱</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註說明</td>
		<td align="center">修改</td>
		<td align="center">編輯內容</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($producttemp_list as $key => $producttemplist): ?>
		<tr>
			<td>
				<input type="text" id="<?= 'name'.$producttemplist['jec_producttemp_id'] ?>" 
				value="<?= $producttemplist['name'] ?>" size="20" />
			</td>
			<td>
				<input type="text" id="<?= 'description'.$producttemplist['jec_producttemp_id'] ?>" 
				value="<?= $producttemplist['description'] ?>" size="50" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$producttemplist['jec_producttemp_id'] ?>" 
					value="修改" onclick="data_update(<?= $producttemplist['jec_producttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_edit'.$producttemplist['jec_producttemp_id'] ?>" 
					value="編輯內容" onclick="data_edit(<?= $producttemplist['jec_producttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$producttemplist['jec_producttemp_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $producttemplist['jec_producttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>