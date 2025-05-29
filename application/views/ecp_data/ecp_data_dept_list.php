<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有部門資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有部門基本資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">部門名稱</td>
		<td <?php if ($sort_field=='jec_deptuplayer_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_deptuplayer_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_deptuplayer_id')">上層部門</td>
		<td <?php if ($sort_field=='jec_user_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_user_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_user_id')">部門主管</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註說明</td>
		<td align="center">修改</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($dept_list as $key => $deptlist): ?>
		<tr>
			<td>
				<input type="text" id="<?= 'name'.$deptlist['jec_dept_id'] ?>" 
				value="<?= $deptlist['name'] ?>" size="30" />
			</td>
			<td>
				<select size="1" name="<?= 'jec_deptuplayer_id'.$deptlist['jec_dept_id'] ?>" id="<?= 'jec_deptuplayer_id'.$deptlist['jec_dept_id'] ?>">
					<?php foreach($select_deptuplayer as $selectdeptuplayer): ?>
						<option value="<?= $selectdeptuplayer['jec_dept_id'] ?>" 
						<?php if ($selectdeptuplayer['jec_dept_id'] == $deptlist['jec_deptuplayer_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectdeptuplayer['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select size="1" name="<?= 'jec_user_id'.$deptlist['jec_dept_id'] ?>" id="<?= 'jec_user_id'.$deptlist['jec_dept_id'] ?>">
					<?php foreach($select_user as $selectuser): ?>
						<option value="<?= $selectuser['jec_user_id'] ?>" 
						<?php if ($selectuser['jec_user_id'] == $deptlist['jec_user_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectuser['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'description'.$deptlist['jec_dept_id'] ?>" 
				value="<?= $deptlist['description'] ?>" size="60" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$deptlist['jec_dept_id'] ?>" 
					value="修改" onclick="data_update(<?= $deptlist['jec_dept_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$deptlist['jec_dept_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $deptlist['jec_dept_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>