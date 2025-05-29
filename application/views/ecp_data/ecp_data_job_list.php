<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<?php $loginparameters = $this->session->userdata(LOGIN_SESSION);
$jec_dept_id = $loginparameters['jec_dept_id'];
$isadmin = $loginparameters['isadmin'];
?>
<!-- 現有客戶資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="7">現有任務基本資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='deptname' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='deptname' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('deptname')">建檔部門</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">任務名稱</td>
		<td <?php if ($sort_field=='jobtype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jobtype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jobtype')">任務特性</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註說明</td>
		<td align="center" id="detail-normal">修改</td>
		<td align="center" id="detail-normal">任務&amp;工作項目</td>
		<td align="center" id="detail-normal">刪除</td>
	</tr>
	<?php foreach($job_list as $key => $joblist): ?>
		<tr>
			<td>
				<?= $joblist['deptname'] ?>
			</td>
			<td>
				<input type="text" id="<?= 'name'.$joblist['jec_job_id'] ?>" 
				value="<?= $joblist['name'] ?>" size="20" />
			</td>
			<td>
				<select size="1" name="<?= 'jobtype'.$joblist['jec_job_id'] ?>" id="<?= 'jobtype'.$joblist['jec_job_id'] ?>">
					<?php foreach($select_jobtype as $selectjobtype): ?>
						<option value="<?= $selectjobtype['datatype'] ?>" 
						<?php if ($selectjobtype['datatype'] == $joblist['jobtype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectjobtype['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'description'.$joblist['jec_job_id'] ?>" 
				value="<?= $joblist['description'] ?>" size="40" />
			</td>
			<td align="center">
				<?php if (($authority['isupdate']=='Y' AND $joblist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$joblist['jec_job_id'] ?>" 
					value="修改" onclick="data_update(<?= $joblist['jec_job_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if (($authority['isupdate']=='Y' AND $joblist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_jobtask'.$joblist['jec_job_id'] ?>" 
					value="任務&amp;工作項目" onclick="data_jobtask(<?= $joblist['jec_job_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if (($authority['isdelete']=='Y' AND $joblist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$joblist['jec_job_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $joblist['jec_job_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>