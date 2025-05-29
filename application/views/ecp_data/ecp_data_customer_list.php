<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有客戶資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="14">現有客戶資料列表</td>
	</tr>
	<tr>
		<td <?php if ($sort_field=='value' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='value' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('value')">編號</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">名稱</td>
		<td <?php if ($sort_field=='name2' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name2' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name2')">簡稱</td>
		<td <?php if ($sort_field=='taxid' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='taxid' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('taxid')">統編</td>
		<td <?php if ($sort_field=='boss' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='boss' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('boss')">負責人</td>
		<td <?php if ($sort_field=='contact' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='contact' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('contact')">聯絡人</td>
		<td <?php if ($sort_field=='telephone1' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='telephone1' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('telephone1')">電話1</td>
		<td <?php if ($sort_field=='telephone2' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='telephone2' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('telephone2')">電話2</td>
		<td <?php if ($sort_field=='faxphone' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='faxphone' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('faxphone')">傳真</td>
		<td <?php if ($sort_field=='email' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='email' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('email')">電郵</td>
		<td <?php if ($sort_field=='address' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='address' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('address')">地址</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註</td>
		<td align="center">修改</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($customer_list as $key => $customerlist): ?>
		<tr>
			<td>
				<input type="text" id="<?= 'value'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['value'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'name'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['name'] ?>" size="8" />
			</td>
			<td>
				<input type="text" id="<?= 'name2'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['name2'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'taxid'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['taxid'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'boss'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['boss'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'contact'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['contact'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'telephone1'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['telephone1'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'telephone2'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['telephone2'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'faxphone'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['faxphone'] ?>" size="6" />
			</td>
			<td>
				<input type="text" id="<?= 'email'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['email'] ?>" size="8" />
			</td>
			<td>
				<input type="text" id="<?= 'address'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['address'] ?>" size="8" />
			</td>
			<td>
				<input type="text" id="<?= 'description'.$customerlist['jec_customer_id'] ?>" 
				value="<?= $customerlist['description'] ?>" size="8" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$customerlist['jec_customer_id'] ?>" 
					value="修改" onclick="data_update(<?= $customerlist['jec_customer_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$customerlist['jec_customer_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $customerlist['jec_customer_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>