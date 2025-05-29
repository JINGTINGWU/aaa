<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有人員資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="9">現有人員基本資料列表</td>
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
		<td <?php if ($sort_field=='password' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='password' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('password')">密碼</td>
		<td <?php if ($sort_field=='jec_dept_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_dept_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_dept_id')">部門</td>
		<td <?php if ($sort_field=='jec_title_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_title_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_title_id')">職稱</td>
		<td <?php if ($sort_field=='email' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='email' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('email')">電子郵件</td>
		<td <?php if ($sort_field=='costtype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='costtype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('costtype')">成本來源</td>
		<td align="center">修改</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($user_list as $key => $userlist): ?>
		<tr>
			<td align="center">
				<input type="text" id="<?= 'value'.$userlist['jec_user_id'] ?>" 
				value="<?= $userlist['value'] ?>" size="15" />
			</td>
			<td align="center">
				<input type="text" id="<?= 'name'.$userlist['jec_user_id'] ?>" 
				value="<?= $userlist['name'] ?>" size="15" />
			</td>
			<td align="center">
				<input type="text" id="<?= 'password'.$userlist['jec_user_id'] ?>" 
				value="<?= $userlist['password'] ?>" size="15" />
			</td>
			<td align="center">
				<select size="1" name="<?= 'jec_dept_id'.$userlist['jec_user_id'] ?>" id="<?= 'jec_dept_id'.$userlist['jec_user_id'] ?>">
					<?php foreach($select_dept as $selectdept): ?>
						<option value="<?= $selectdept['jec_dept_id'] ?>" 
						<?php if ($selectdept['jec_dept_id'] == $userlist['jec_dept_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectdept['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td align="center">
				<select size="1" name="<?= 'jec_title_id'.$userlist['jec_user_id'] ?>" id="<?= 'jec_title_id'.$userlist['jec_user_id'] ?>">
					<?php foreach($select_title as $selecttitle): ?>
						<option value="<?= $selecttitle['jec_title_id'] ?>" 
						<?php if ($selecttitle['jec_title_id'] == $userlist['jec_title_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selecttitle['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'email'.$userlist['jec_user_id'] ?>" 
				value="<?= $userlist['email'] ?>" size="25" />
			</td>
			<td align="center">
				<select size="1" name="<?= 'costtype'.$userlist['jec_user_id'] ?>" id="<?= 'costtype'.$userlist['jec_user_id'] ?>">
					<?php foreach($select_costtype as $selectcosttype): ?>
						<option value="<?= $selectcosttype['datatype'] ?>" 
						<?php if ($selectcosttype['datatype'] == $userlist['costtype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectcosttype['name'] ?></option>
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
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$userlist['jec_user_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $userlist['jec_user_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>