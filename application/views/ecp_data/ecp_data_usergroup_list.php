<!-- 現有群組人員列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="4">現有群組人員列表</td>
	</tr>
	<tr>
		<td>群組名稱</td>
		<td>人員姓名</td>
		<td>新增群組人員</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($usergroup_list as $key => $usergrouplist): ?>
		<tr>
			<td>
				<?php if (empty($usergrouplist['jec_user_id'])): ?>
					<?= $usergrouplist['groupname'] ?>
				<?php endif; ?>
			</td>
			<td>
				<?php if (!empty($usergrouplist['jec_user_id'])): ?>
					<?= $usergrouplist['username'] ?>
				<?php endif; ?>
			</td>
			<td>
				<?php if (empty($usergrouplist['jec_user_id'])): ?>
					<select size="1" name="<?= 'jec_user_id'.$usergrouplist['jec_group_id'] ?>" id="<?= 'jec_user_id'.$usergrouplist['jec_group_id'] ?>">
						<?php foreach($select_user as $selectuser): ?>
							<option value="<?= $selectuser['jec_user_id'] ?>"><?= $selectuser['name'] ?></option>
						<?php endforeach; ?>
					</select>
					<input type="button" id="<?= 'btn_new'.$usergrouplist['jec_group_id'] ?>" value="確定新增群組人員" 
					onclick="data_new(<?= $usergrouplist['jec_group_id'] ?>)" />
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<?php if (!empty($usergrouplist['jec_user_id'])): ?>
						<input type="button" id="<?= 'btn_delete'.$usergrouplist['jec_usergroup_id'] ?>" 
						value="刪除群組人員" onclick="data_delete(<?= $usergrouplist['jec_usergroup_id'] ?>)" />
					<?php endif; ?>
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>