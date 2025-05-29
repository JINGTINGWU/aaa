<table class="detail-div" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="3">任務中現有預設的工作項目列表</td>
	</tr>
	<tr>
		<td align="center">排序</td>
		<td>工作名稱</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($jobtask_list as $key => $jobtasklist): ?>
		<tr>
			<td align="center">
				<?php if ($key == 0): ?>
					<img src="<?= base_url().'images/btn_sortup_grey.gif' ?>" />
				<?php else: ?>
					<img src="<?= base_url().'images/btn_sortup.gif' ?>" title="向上移" 
					onclick="jobtask_updown('<?= $jobtasklist['jec_jobtask_id'] ?>', 'UP')" />
				<?php endif; ?>&nbsp;
				<?php if ($key == count($jobtask_list)-1): ?>
					<img src="<?= base_url().'images/btn_sortdown_grey.gif' ?>" />
				<?php else: ?>
					<img src="<?= base_url().'images/btn_sortdown.gif' ?>" title="向下移" 
					onclick="jobtask_updown('<?= $jobtasklist['jec_jobtask_id'] ?>', 'DOWN')" />
				<?php endif; ?>
			</td>
			<td>
				<?= $jobtasklist['name'] ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$jobtasklist['jec_jobtask_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $jobtasklist['jec_jobtask_id'] ?>, <?= $jobtasklist['seqno'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>