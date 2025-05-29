<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有專案範本列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有專案範本列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">範本名稱</td>
        <td <?php if ($sort_field=='jec_dept_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_dept_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_dept_id')">部門</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註說明</td>
		<td align="center" id="detail-normal">修改</td>
		<td align="center" id="detail-normal">編輯內容</td>
		<td align="center" id="detail-normal">刪除</td>
	</tr>
	<?php foreach($projecttemp_list as $key => $projecttemplist): ?>
		<tr>
			<td>
				<input type="text" id="<?= 'name'.$projecttemplist['jec_projecttemp_id'] ?>" 
				value="<?= $projecttemplist['name'] ?>" size="20" />
			</td>
            <td align="center">
				<select size="1" name="<?= 'jec_dept_id'.$projecttemplist['jec_projecttemp_id'] ?>" id="<?= 'jec_dept_id'.$projecttemplist['jec_projecttemp_id'] ?>">
					<?php foreach($select_dept as $selectdept): ?>
						<option value="<?= $selectdept['jec_dept_id'] ?>" 
						<?php if ($selectdept['jec_dept_id'] == $projecttemplist['jec_dept_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectdept['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'description'.$projecttemplist['jec_projecttemp_id'] ?>" 
				value="<?= $projecttemplist['description'] ?>" size="50" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$projecttemplist['jec_projecttemp_id'] ?>" 
					value="修改" onclick="data_update(<?= $projecttemplist['jec_projecttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_edit'.$projecttemplist['jec_projecttemp_id'] ?>" 
					value="編輯內容" onclick="data_edit(<?= $projecttemplist['jec_projecttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$projecttemplist['jec_projecttemp_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $projecttemplist['jec_projecttemp_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>