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
                <?php else: ?>
                <table><tr>
                <td>基準日開始
                  <input type="text" id="<?= 'startdays'.$projecttempedit['id'] ?>" name="<?= 'startdays'.$projecttempedit['id'] ?>" value="<?= $projecttempedit['startdays'] ?>" size="1" />天後開始，</td>
                <td>工作天數<input type="text" id="<?= 'workdays'.$projecttempedit['id'] ?>" name="<?= 'workdays'.$projecttempedit['id'] ?>" value="<?= $projecttempedit['workdays'] ?>" size="1" /></td>
                <td>負責人
                <select size="1" name="<?= 'user'.$projecttempedit['id'] ?>" id="<?= 'user'.$projecttempedit['id'] ?>">
                <option value="0,1" <?=$projecttempedit['user']=='0,1'?'selected':''?>>業務/專案主持人</option>
                <option value="0,2" <?=$projecttempedit['user']=='0,2'?'selected':''?>>專案負責人</option>
                <option value="0,3" <?=$projecttempedit['user']=='0,3'?'selected':''?>>建檔人員</option>
                <option value="0,4" <?=$projecttempedit['user']=='0,4'?'selected':''?>>業務直屬主管</option>
                <option value="-">------</option>
                <?php 
				$user_list=$this->db->where('isactive','Y')->order_by('value','asc')->get('jec_user')->result_array();
				foreach($user_list as $user):
					if($projecttempedit['user']=='1,'.$user['jec_user_id']):
					echo '<option value="1,'.$user['jec_user_id'].'" selected>'.$user['name'].'</option>';
					else:
					echo '<option value="1,'.$user['jec_user_id'].'">'.$user['name'].'</option>';
					endif;
				endforeach;
				$group_list=$this->db->where('isactive','Y')->order_by('jec_group_id','asc')->get('jec_group')->result_array();
				foreach($group_list as $group):
					if($projecttempedit['user']=='2,'.$group['jec_group_id']):
					echo '<option value="2,'.$group['jec_group_id'].'" selected>'.$group['name'].'</option>';
					else:
					echo '<option value="2,'.$group['jec_group_id'].'">'.$group['name'].'</option>';
					endif;
				endforeach;
				?>
                </select>                
                </td>
                <td>督導人<select size="1" name="<?= 'superuser'.$projecttempedit['id'] ?>" id="<?= 'superuser'.$projecttempedit['id'] ?>">
                <option value="0,1" <?=$projecttempedit['superuser']=='0,1'?'selected':''?>>業務/專案主持人</option>
                <option value="0,2" <?=$projecttempedit['superuser']=='0,2'?'selected':''?>>專案負責人</option>
                <option value="0,3" <?=$projecttempedit['superuser']=='0,3'?'selected':''?>>建檔人員</option>  
                <option value="0,4" <?=$projecttempedit['superuser']=='0,4'?'selected':''?>>業務直屬主管</option>              
                <option value="-">------</option>
                <?php 
				$user_list=$this->db->where('isactive','Y')->order_by('value','asc')->get('jec_user')->result_array();
				foreach($user_list as $user):
					if($projecttempedit['superuser']=='1,'.$user['jec_user_id']):
					echo '<option value="1,'.$user['jec_user_id'].'" selected>'.$user['name'].'</option>';
					else:
					echo '<option value="1,'.$user['jec_user_id'].'">'.$user['name'].'</option>';
					endif;
				endforeach;				
				?>
                </select></td>
                </tr></table>                
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<?php if (!empty($projecttempedit['jobname'])): ?>
						<input type="button" id="<?= 'btn_delete'.$projecttempedit['id'].$projecttempedit['jobid'] ?>" 
						value="刪除任務" onclick="data_delete('JOB', <?= $projecttempedit['id'] ?>, <?= $projecttempedit['jobseqno'] ?>, <?= $projecttempedit['jobid'] ?>)" />
					<?php else: ?>
                    	<input type="button" id="<?= 'btn_edit'.$projecttempedit['id'].$projecttempedit['taskid'] ?>" 
						value="修改" onclick="data_edit('TASK', <?= $projecttempedit['id'] ?>, <?= $projecttempedit['taskseqno'] ?>, <?= $projecttempedit['jobid'] ?>)" />
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