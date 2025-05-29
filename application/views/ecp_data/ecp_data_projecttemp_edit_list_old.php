<!-- 頁次 -->
<!--
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
 -->
<!-- 現有專案範本內容列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="6">現有專案範本內容列表</td>
	</tr>
	<tr>
		<td align="center">排序</td>
		<td>任務名稱</td>
		<td align="center">排序</td>
		<td>工作項目</td>
		<td>新增任務中的工作項目</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($projecttemp_edit as $key => $projecttempedit): ?>
		<tr>
			<td align="center">
				<?php if (!empty($projecttempedit['jobname'])): ?>
					<?php if ($projecttempedit['jobseqno'] == 10): ?>
						<img src="<?= base_url().'images/btn_sortup_grey.gif' ?>" />
					<?php else: ?>
						<img src="<?= base_url().'images/btn_sortup.gif' ?>" title="向上移" 
						onclick="projecttemp_updown('JOB', '<?= $projecttempedit['id'] ?>', '<?= $projecttempedit['parentid'] ?>', 'UP')" />
					<?php endif; ?>&nbsp;
					<?php if ($projecttempedit['jobseqno'] == $maxseq_job): ?>
						<img src="<?= base_url().'images/btn_sortdown_grey.gif' ?>" />
					<?php else: ?>
						<img src="<?= base_url().'images/btn_sortdown.gif' ?>" title="向下移" 
						onclick="projecttemp_updown('JOB', '<?= $projecttempedit['id'] ?>', '<?= $projecttempedit['parentid'] ?>', 'DOWN')" />
					<?php endif; ?>
				<?php endif; ?>
			</td>
			<td>
				<?= $projecttempedit['jobname'] ?>
			</td>
			<td align="center">
				<?php if (!empty($projecttempedit['taskname'])): ?>
					<?php if ($projecttempedit['taskseqno'] == 10): ?>
						<img src="<?= base_url().'images/btn_sortup_grey.gif' ?>" />
					<?php else: ?>
						<img src="<?= base_url().'images/btn_sortup.gif' ?>" title="向上移" 
						onclick="projecttemp_updown('TASK', '<?= $projecttempedit['id'] ?>', '<?= $projecttempedit['parentid'] ?>', 'UP')" />
					<?php endif; ?>&nbsp;
					<?php if (in_array($projecttempedit['parentid'].'/'.$projecttempedit['taskseqno'], $maxseq_task)): ?>
						<img src="<?= base_url().'images/btn_sortdown_grey.gif' ?>" />
					<?php else: ?>
						<img src="<?= base_url().'images/btn_sortdown.gif' ?>" title="向下移" 
						onclick="projecttemp_updown('TASK', '<?= $projecttempedit['id'] ?>', '<?= $projecttempedit['parentid'] ?>', 'DOWN')" />
					<?php endif; ?>
				<?php endif; ?>
			</td>
			<td>
				<?= $projecttempedit['taskname'] ?>
			</td>
			<td>
				<?php if (!empty($projecttempedit['jobname'])): ?>
					<select size="1" name="<?= 'jec_task_id'.$projecttempedit['id'] ?>" id="<?= 'jec_task_id'.$projecttempedit['id'] ?>">
						<?php foreach($select_task as $selecttask): ?>
							<option value="<?= $selecttask['jec_task_id'] ?>"><?= $selecttask['name'] ?></option>
						<?php endforeach; ?>
					</select>
					<input type="button" id="<?= 'btn_tasknew'.$projecttempedit['id'] ?>" value="確定新增工作項目" 
					onclick="data_tasknew(<?= $projecttempedit['id'] ?>)" />
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<?php if (!empty($projecttempedit['jobname'])): ?>
						<input type="button" id="<?= 'btn_delete'.$projecttempedit['id'].$projecttempedit['jobid'] ?>" 
						value="刪除任務" onclick="data_delete('JOB', <?= $projecttempedit['id'] ?>, <?= $projecttempedit['jobseqno'] ?>, <?= $projecttempedit['jobid'] ?>)" />
					<?php else: ?>
						<input type="button" id="<?= 'btn_delete'.$projecttempedit['id'].$projecttempedit['taskid'] ?>" 
						value="刪除工作項目" onclick="data_delete('TASK', <?= $projecttempedit['id'] ?>, <?= $projecttempedit['taskseqno'] ?>, <?= $projecttempedit['jobid'] ?>)" />
					<?php endif; ?>
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>