<!-- 頁次 -->
<?php if ($pagelink != ""): ?>
	<div class="list-div" style="text-align: center">
		<?= $pagelink ?>
	</div>
<?php endif; ?>
<!-- 現有料品基本資料列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="12">現有料品基本資料列表</td>
	</tr>
	<tr>
<!--		<td <?php if ($sort_field=='value' && $sort_sequence=='asc'): ?>-->
<!--				id="detail-ascending"-->
<!--			<?php elseif ($sort_field=='value' && $sort_sequence=='desc'): ?>-->
<!--				id="detail-descending"-->
<!--			<?php else: ?>-->
<!--				id="detail-nosort"-->
<!--			<?php endif; ?> onclick="data_sort('value')">料號</td>-->
		<td <?php if ($sort_field=='prodtype' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='prodtype' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('prodtype')">類別</td>
		<td <?php if ($sort_field=='name' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='name' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('name')">品名</td>
		<td <?php if ($sort_field=='specification' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='specification' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('specification')">規格</td>
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
		<td <?php if ($sort_field=='jec_vendor_id' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='jec_vendor_id' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('jec_vendor_id')">廠商</td>
		<td <?php if ($sort_field=='description' && $sort_sequence=='asc'): ?>
				id="detail-ascending"
			<?php elseif ($sort_field=='description' && $sort_sequence=='desc'): ?>
				id="detail-descending"
			<?php else: ?>
				id="detail-nosort"
			<?php endif; ?> onclick="data_sort('description')">備註</td>
		<td align="center">修改</td>
		<td align="center">ERP對應</td>
		<td align="center">刪除</td>
	</tr>
	<?php foreach($prod_list as $key => $prodlist): ?>
		<tr>
<!--			<td>-->
<!--				<input type="text" id="<?= 'value'.$prodlist['jec_product_id'] ?>" -->
<!--				value="<?= $prodlist['value'] ?>" size="10" />-->
<!--			</td>-->
			<td>
				<select size="1" name="<?= 'prodtype'.$prodlist['jec_product_id'] ?>" id="<?= 'prodtype'.$prodlist['jec_product_id'] ?>">
					<?php foreach($select_prodtype as $selectprodtype): ?>
						<option value="<?= $selectprodtype['datatype'] ?>" 
						<?php if ($selectprodtype['datatype'] == $prodlist['prodtype']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectprodtype['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'name'.$prodlist['jec_product_id'] ?>" 
				value="<?= $prodlist['name'] ?>" size="15" />
			</td>
			<td>
				<input type="text" id="<?= 'specification'.$prodlist['jec_product_id'] ?>" 
				value="<?= $prodlist['specification'] ?>" size="15" />
			</td>
			<td>
				<select size="1" name="<?= 'jec_uom_id'.$prodlist['jec_product_id'] ?>" id="<?= 'jec_uom_id'.$prodlist['jec_product_id'] ?>">
					<?php foreach($select_uom as $selectuom): ?>
						<option value="<?= $selectuom['datatype'] ?>" 
						<?php if ($selectuom['datatype'] == $prodlist['jec_uom_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectuom['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'price'.$prodlist['jec_product_id'] ?>" 
				value="<?= number_format($prodlist['price']) ?>" size="3" />
			</td>
			<td>
				<input type="text" id="<?= 'daywork'.$prodlist['jec_product_id'] ?>" 
				value="<?= $prodlist['daywork'] ?>" size="3" />
			</td>
			<td>
				<select size="1" name="<?= 'vendor'.$prodlist['jec_product_id'] ?>" id="<?= 'vendor'.$prodlist['jec_product_id'] ?>" style="width: 150px">
					<?php foreach($select_vendor as $selectvendor): ?>
						<option value="<?= $selectvendor['datatype'] ?>" 
						<?php if ($selectvendor['datatype'] == $prodlist['jec_vendor_id']): ?>
							selected="selected"
						<?php endif; ?>
						><?= $selectvendor['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input type="text" id="<?= 'description'.$prodlist['jec_product_id'] ?>" 
				value="<?= $prodlist['description'] ?>" size="10" />
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$prodlist['jec_product_id'] ?>" 
					value="修改" onclick="data_update(<?= $prodlist['jec_product_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_erp'.$prodlist['jec_product_id'] ?>" 
					value="ERP對應" onclick="data_erp(<?= $prodlist['jec_product_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isdelete']=='Y'): ?>
					<input type="button" id="<?= 'btn_delete'.$prodlist['jec_product_id'] ?>" 
					value="刪除" onclick="data_delete(<?= $prodlist['jec_product_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>