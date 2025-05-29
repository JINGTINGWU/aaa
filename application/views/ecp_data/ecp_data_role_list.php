<!-- 現有權限列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有權限列表</td>
	</tr>
	<tr>
		<td>權限名稱</td>
		<td>備註說明</td>
		<td align="center">人數</td>
		<td align="center">修改</td>
		<td align="center">編輯權限</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($role_list as $key => $rolelist): ?>
		<tr>
			<td>
				<input type="text" id="<?= 'name'.$rolelist['jec_role_id'] ?>" 
				value="<?= $rolelist['name'] ?>" size="20" />
			</td>
			<td>
				<input type="text" id="<?= 'description'.$rolelist['jec_role_id'] ?>" 
				value="<?= $rolelist['description'] ?>" size="50" />
			</td>
			<td align="center">
				<?= number_format($rolelist['usercount']) ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$rolelist['jec_role_id'] ?>" 
					value="修改" onclick="data_update(<?= $rolelist['jec_role_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_edit'.$rolelist['jec_role_id'] ?>" 
					value="編輯權限" onclick="data_edit(<?= $rolelist['jec_role_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$rolelist['jec_role_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $rolelist['jec_role_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>