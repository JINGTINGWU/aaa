<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有公告資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有公告資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='startdate' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='startdate' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('startdate')">公告日期</td>
		<td <?php if ($sort_field=='enddate' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='enddate' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('enddate')">結束日期</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">公告內容</td>
		<td <?php if ($sort_field=='jec_user_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_user_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_user_id')">發表人</td>
		<td align="center">修改</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($announce_list as $key => $announcelist): ?>
		<tr>
			<td>
				<?php if (! is_null($announcelist['startdate']) && $announcelist['startdate'] != '0000-00-00 00:00:00'): ?>
					<?= date("Y-m-d", strtotime($announcelist['startdate'])) ?>
				<?php endif; ?>
			</td>
			<td>
				<?php if (! is_null($announcelist['enddate']) && $announcelist['enddate'] != '0000-00-00 00:00:00'): ?>
					<?= date("Y-m-d", strtotime($announcelist['enddate'])) ?>
				<?php endif; ?>
			</td>
			<td>
				<input type="text" id="<?= 'name'.$announcelist['jec_announce_id'] ?>" 
				value="<?= $announcelist['name'] ?>" size="90" />
			</td>
			<td>
				<!--
				<select size="1" name="<?= 'jec_user_id'.$announcelist['jec_announce_id'] ?>" id="<?= 'jec_user_id'.$announcelist['jec_announce_id'] ?>">
					<?php foreach($select_user as $selectuser): ?>
						<option value="<?= $selectuser['jec_user_id'] ?>" 
						<?php if ($selectuser['jec_user_id'] == $announcelist['jec_user_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectuser['name'] ?></option>
					<?php endforeach; ?>
				</select>
				-->
				<?= $announcelist['user_name'] ?>
				<input type="hidden" id="<?= 'jec_user_id'.$announcelist['jec_announce_id'] ?>" value="<?= $announcelist['jec_user_id'] ?>" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$announcelist['jec_announce_id'] ?>" 
					value="修改" onclick="data_update(<?= $announcelist['jec_announce_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$announcelist['jec_announce_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $announcelist['jec_announce_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>