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
		<td colspan="14">現有工作項目基本資料列表</td>
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
			<?php endif; ?> onclick="data_sort('name')">名稱</td>
		<td <?php if ($sort_field=='tasktype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='tasktype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('tasktype')">類別</td>
		<td <?php if ($sort_field=='jec_user_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_user_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_user_id')">承辦</td>
		<td <?php if ($sort_field=='daywork' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='daywork' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('daywork')">天數</td>
		<td <?php if ($sort_field=='daynotice' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='daynotice' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('daynotice')">通知</td>
		
		<td <?php if ($sort_field=='workweight' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='workweight' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('workweight')">權重</td>
		<td <?php if ($sort_field=='processtype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='processtype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('processtype')">處理</td>
		<td <?php if ($sort_field=='confirmtype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='confirmtype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('confirmtype')">確認</td>
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
	<?php foreach($task_list as $key => $tasklist): ?>
		<tr>
			<td>
				<?= $tasklist['deptname'] ?>
			</td>
			<td>
				<input type="text" id="<?= 'name'.$tasklist['jec_task_id'] ?>" 
				value="<?= $tasklist['name'] ?>" size="15" />
			</td>
			<td>
				<select size="1" name="<?= 'tasktype'.$tasklist['jec_task_id'] ?>" id="<?= 'tasktype'.$tasklist['jec_task_id'] ?>">
					<?php foreach($select_tasktype as $selecttasktype): ?>
						<option value="<?= $selecttasktype['datatype'] ?>" 
						<?php if ($selecttasktype['datatype'] == $tasklist['tasktype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selecttasktype['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select size="1" name="<?= 'usergroup'.$tasklist['jec_task_id'] ?>" id="<?= 'usergroup'.$tasklist['jec_task_id'] ?>" style="width: 80px">
					<?php foreach($select_usergroup as $selectusergroup): ?>
						<option value="<?= $selectusergroup['id'] ?>" 
						<?php if ($tasklist['usertype'] == '1'): ?>
							<?php if ($selectusergroup['id'] == $tasklist['usertype'].','.$tasklist['jec_user_id']): ?>
								selected="selected"
							<?php endif; ?>
						<?php else: ?>
							<?php if ($selectusergroup['id'] == $tasklist['usertype'].','.$tasklist['jec_group_id']): ?>
								selected="selected"
							<?php endif; ?>
						<?php endif; ?>
						><?= $selectusergroup['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'daywork'.$tasklist['jec_task_id'] ?>" 
				value="<?= $tasklist['daywork'] ?>" size="1" />
			</td>
			<td>
				<select size="1" name="<?= 'daynotice'.$tasklist['jec_task_id'] ?>" id="<?= 'daynotice'.$tasklist['jec_task_id'] ?>" style="width: 50px">
					<?php foreach($select_daynotice as $selectdaynotice): ?>
						<option value="<?= $selectdaynotice['datatype'] ?>" 
						<?php if ($selectdaynotice['datatype'] == $tasklist['daynotice']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectdaynotice['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			
			<td>
				<select size="1" name="<?= 'workweight'.$tasklist['jec_task_id'] ?>" id="<?= 'workweight'.$tasklist['jec_task_id'] ?>">
					<?php foreach($select_workweight as $selectworkweight): ?>
						<option value="<?= $selectworkweight['datatype'] ?>" 
						<?php if ($selectworkweight['datatype'] == $tasklist['workweight']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectworkweight['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select size="1" name="<?= 'processtype'.$tasklist['jec_task_id'] ?>" id="<?= 'processtype'.$tasklist['jec_task_id'] ?>">
					<?php foreach($select_processtype as $selectprocesstype): ?>
						<option value="<?= $selectprocesstype['datatype'] ?>" 
						<?php if ($selectprocesstype['datatype'] == $tasklist['processtype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectprocesstype['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select size="1" name="<?= 'confirmtype'.$tasklist['jec_task_id'] ?>" id="<?= 'confirmtype'.$tasklist['jec_task_id'] ?>" style="width: 50px">
					<?php foreach($select_confirmtype as $selectconfirmtype): ?>
						<option value="<?= $selectconfirmtype['datatype'] ?>" 
						<?php if ($selectconfirmtype['datatype'] == $tasklist['confirmtype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectconfirmtype['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'description'.$tasklist['jec_task_id'] ?>" 
				value="<?= $tasklist['description'] ?>" size="8" />
			</td>
			<td align="center">
				<?php if (($authority['isupdate']=='Y' AND $tasklist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$tasklist['jec_task_id'] ?>" 
					value="修改" onclick="data_update(<?= $tasklist['jec_task_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if (($authority['isupdate']=='Y' AND $tasklist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_check'.$tasklist['jec_task_id'] ?>" 
					value="檢核表" onclick="data_check(<?= $tasklist['jec_task_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if (($authority['isdelete']=='Y' AND $tasklist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$tasklist['jec_task_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $tasklist['jec_task_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>