<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有片語資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="14">現有片語資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='phrasetype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='phrasetype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('phrasetype')">片語類型</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">片語內容</td>
		<td align="center">修改</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($phrase_list as $key => $phraselist): ?>
		<tr>
			<td align="center">
				<?php if ($phraselist['phrasetype']=='1'): ?>
					共用
				<?php else: ?>
					<?= $user_name ?>
				<?php endif; ?>
			</td>
			<td>
				<?php if ($phraselist['phrasetype']=='1' && $isadmin=='Y'): ?>
					<input type="text" id="<?= 'name'.$phraselist['jec_phrase_id'] ?>" 
					value="<?= $phraselist['name'] ?>" size="50" />
				<?php elseif ($phraselist['phrasetype']!='1'): ?>
					<input type="text" id="<?= 'name'.$phraselist['jec_phrase_id'] ?>" 
					value="<?= $phraselist['name'] ?>" size="50" />
				<?php else: ?>
					<?= $phraselist['name'] ?>
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y' && $phraselist['phrasetype']=='1' && $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$phraselist['jec_phrase_id'] ?>" 
					value="修改" onclick="data_update(<?= $phraselist['jec_phrase_id'] ?>)" />
				<?php elseif ($phraselist['phrasetype']!='1'): ?>
					<input type="button" id="<?= 'btn_update'.$phraselist['jec_phrase_id'] ?>" 
					value="修改" onclick="data_update(<?= $phraselist['jec_phrase_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y' && $phraselist['phrasetype']=='1' && $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$phraselist['jec_phrase_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $phraselist['jec_phrase_id'] ?>)" />
				<?php elseif ($phraselist['phrasetype']!='1'): ?>
					<input type="button" id="<?= 'btn_delete'.$phraselist['jec_phrase_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $phraselist['jec_phrase_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>