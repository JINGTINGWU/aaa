<!-- 現有人員權限資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有人員權限資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='value' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='value' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('value')">帳號</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">姓名</td>
		<td <?php if ($sort_field=='acctstatus' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='acctstatus' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('acctstatus')">帳號正常/停權</td>
		<td <?php if ($sort_field=='isadmin' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='isadmin' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('isadmin')">是否為系統管理員</td>
		<td <?php if ($sort_field=='jec_role_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_role_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_role_id')">人員權限</td>
		<td align="center">修改</td>
	</tr>
	<?php foreach($user_list as $key => $userlist): ?>
		<tr>
			<td align="center">
				<?= $userlist['value'] ?>
			</td>
			<td align="center">
				<?= $userlist['name'] ?>
			</td>
			<td align="center">
				<input type="radio" name="<?= 'acctstatus'.$userlist['jec_user_id'] ?>" value="Y" 
					<?php if ($userlist['acctstatus']=='Y'): ?> checked="checked" <?php endif;?> />&nbsp;正常&nbsp;&nbsp;
				<input type="radio" name="<?= 'acctstatus'.$userlist['jec_user_id'] ?>" value="N" 
					<?php if ($userlist['acctstatus']=='N'): ?> checked="checked" <?php endif;?> />&nbsp;停權
			</td>
			<td align="center">
				<input type="checkbox" name="<?= 'isadmin'.$userlist['jec_user_id'] ?>" id="<?= 'isadmin'.$userlist['jec_user_id'] ?>" value="Y"
				<?php if ($userlist['isadmin']=='Y'): ?> checked="checked" <?php endif;?> />
			</td>
			<td align="center">
				<select size="1" name="<?= 'jec_role_id'.$userlist['jec_user_id'] ?>" id="<?= 'jec_role_id'.$userlist['jec_user_id'] ?>">
					<?php foreach($select_role as $selectrole): ?>
						<option value="<?= $selectrole['jec_role_id'] ?>" 
						<?php if ($selectrole['jec_role_id'] == $userlist['jec_role_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectrole['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$userlist['jec_user_id'] ?>" 
					value="修改" onclick="data_update(<?= $userlist['jec_user_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>