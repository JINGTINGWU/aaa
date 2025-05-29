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
<!-- 現有工作明細基本資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="12">現有工作明細基本資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='deptname' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='deptname' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('deptname')">建檔部門</td>
<!--		<td <?php if ($sort_field=='value' && $sort_sequence=='asc'): ?>-->
<!--				id="detail-ascending"-->
<!--			<?php elseif ($sort_field=='value' && $sort_sequence=='desc'): ?>-->
<!--				id="detail-descending"-->
<!--			<?php else: ?>-->
<!--				id="detail-nosort"-->
<!--			<?php endif; ?> onclick="data_sort('value')">編號</td>-->
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">名稱</td>
		<td <?php if ($sort_field=='jec_uom_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_uom_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_uom_id')">單位</td>
		<td <?php if ($sort_field=='price' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='price' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('price')">單價</td>
		<td <?php if ($sort_field=='daywork' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='daywork' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('daywork')">天數</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註</td>
		<td align="center" id="detail-normal">修改</td>
		<td align="center" id="detail-normal">刪除</td>
	</tr>
	<?php foreach($work_list as $key => $worklist): ?>
		<tr>
			<td>
				<?= $worklist['deptname'] ?>
			</td>
<!--			<td>-->
<!--				<input type="text" id="<?= 'value'.$worklist['jec_product_id'] ?>" -->
<!--				value="<?= $worklist['value'] ?>" size="10" />-->
<!--			</td>-->
			<td>
				<input type="text" id="<?= 'name'.$worklist['jec_product_id'] ?>" 
				value="<?= $worklist['name'] ?>" size="20" />
			</td>
			<td>
				<select size="1" name="<?= 'jec_uom_id'.$worklist['jec_product_id'] ?>" id="<?= 'jec_uom_id'.$worklist['jec_product_id'] ?>">
					<?php foreach($select_uom as $selectuom): ?>
						<option value="<?= $selectuom['datatype'] ?>" 
						<?php if ($selectuom['datatype'] == $worklist['jec_uom_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectuom['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'price'.$worklist['jec_product_id'] ?>" 
				value="<?= number_format($worklist['price']) ?>" size="5" />
			</td>
			<td>
				<input type="text" id="<?= 'daywork'.$worklist['jec_product_id'] ?>" 
				value="<?= $worklist['daywork'] ?>" size="5" />
			</td>
			<td>
				<input type="text" id="<?= 'description'.$worklist['jec_product_id'] ?>" 
				value="<?= $worklist['description'] ?>" size="30" />
			</td>
			<td align="center">
				<?php if (($authority['isupdate']=='Y' AND $worklist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$worklist['jec_product_id'] ?>" 
					value="修改" onclick="data_update(<?= $worklist['jec_product_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if (($authority['isdelete']=='Y' AND $worklist['jec_dept_id']==$jec_dept_id) OR $isadmin=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$worklist['jec_product_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $worklist['jec_product_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>