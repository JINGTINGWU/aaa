<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ecplant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/thickbox.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/thickbox_rc.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/common.js"></script>
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 料品列表/ERP料品對應 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">料品列表</a></li>
					<li><a href=# onclick="loadme(1)" class="unselected">ERP料品對應</a></li>
				</ul>
			</div>
			<div class="tab-div-right"><?= $function_name ?></div>
		</div>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr><td class="tab-underline"></td></tr>
		</table>
		<!-- 頁籤切換  -->
		<script type="text/javascript">
			function loadme(idxtag)
			{
				switch (idxtag)
				{
					case 0:
						//location.href = "<?= base_url().'ecp_data_product/index/' ?>";
						break;
					case 1:
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6" align="left">新增料品</td>
			</tr>
			<tr>
				<td align="right">品名：</td>
				<td colspan="2" id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
				<td align="right">規格：</td>
				<td colspan="2" id="frominputarea">
					<input id="specification" type="text" value="" size="50" />
				</td>
			</tr>
			<tr>
<!--				<td align="right">料品編號：</td>-->
<!--				<td id="frominputarea">-->
<!--					<input id="value" type="text" value="" size="20" />-->
<!--				</td>-->
				<td align="right">單位：</td>
				<td colspan="2" id="frominputarea">
					<select size="1" name="jec_uom_id" id="jec_uom_id">
						<?php foreach($select_uom as $selectuom): ?>
							<option value="<?= $selectuom['datatype'] ?>"><?= $selectuom['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td align="right">料品類別：</td>
				<td colspan="2" id="frominputarea">
					<select size="1" name="prodtype" id="prodtype">
						<?php foreach($select_prodtype as $selectprodtype): ?>
							<option value="<?= $selectprodtype['datatype'] ?>"><?= $selectprodtype['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">預估單價：</td>
				<td id="frominputarea">
					<input id="price" type="text" value="" size="10" />
				</td>
				<td align="right">作業天數：</td>
				<td id="frominputarea">
					<input id="daywork" type="text" value="" size="10" />
				</td>
				<td align="right">預設廠商：</td>
				<td id="frominputarea">
					<select size="1" name="jec_vendor_id" id="jec_vendor_id" style="width: 200px">
						<?php foreach($select_vendor as $selectvendor): ?>
							<option value="<?= $selectvendor['datatype'] ?>"><?= $selectvendor['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea" colspan="6">
					<input id="description" type="text" value="" size="100" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增料品" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有料品基本資料列表(含頁次) -->
		<div id="product_list">
			<?php $this->load->view('ecp_data/ecp_data_product_list', $prod_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
//				if ($.trim($("#value").val()) == "")
//				{
//					humane.error("料品編號不可空白");
//					return;
//				}
				if ($.trim($("#name").val()) == "")
				{
					humane.error("品名不可空白");
					return;
				}
				if ($.trim($("#jec_uom_id").val()) == "")
				{
					humane.error("單位不可空白");
					return;
				}
				if (isNaN($.trim($("#daywork").val())))
				{
					humane.error('工作天數須為數字');
					return;
				}
				//if (! confirm("是否確認要新增料品?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					//value: $("#value").val(),
					prodtype: $("#prodtype").val(),
					jec_uom_id: $("#jec_uom_id").val(),
					name: $("#name").val(),
					specification: $("#specification").val(),
					price: $("#price").val(),
					daywork: $("#daywork").val(),
					jec_vendor_id: $("#jec_vendor_id").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_product/prod_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('料品新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#product_list").load('<?= site_url('ecp_data_product/reload_prod_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							//$("#value").val("");
							$("#name").val("");
							$("#specification").val("");
							$("#description").val("");
						}
						else
							humane.error('料品新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
//				if ($.trim($("#value" + id).val()) == "")
//				{
//					humane.error("料品編號不可空白");
//					return;
//				}
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("品名不可空白");
					return;
				}
				if ($.trim($("#jec_uom_id" + id).val()) == "")
				{
					humane.error("單位不可空白");
					return;
				}
				if (isNaN($.trim($("#daywork" + id).val())))
				{
					humane.error('工作天數須為數字');
					return;
				}
				//if (! confirm("是否確認要更新料品?")) return;
				para_data = {
					jec_product_id: id,
					//value: $("#value" + id).val(),
					prodtype: $("#prodtype" + id).val(),
					jec_uom_id: $("#jec_uom_id" + id).val(),
					name: $("#name" + id).val(),
					specification: $("#specification" + id).val(),
					price: $("#price" + id).val(),
					daywork: $("#daywork" + id).val(),
					jec_vendor_id: $("#jec_vendor_id" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_product/prod_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('料品更新完成');
						else
							humane.error('料品更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除料品?")) return;
				para_data = {
					jec_product_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_product/prod_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('料品刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#product_list").load('<?= site_url('ecp_data_product/reload_prod_list/') ?>', para_data1);
						}
						else
							humane.error('料品刪除作業失敗！');
					}
				});
			}
			// 欄位排序
			function data_sort(sort_field)
			{
				if (sort_field == $("#sort_field").val())
				{
					if ($("#sort_sequence").val() == "asc")
						$("#sort_sequence").val("desc");
					else
						$("#sort_sequence").val("asc");
				}
				else
				{
					$("#sort_field").val(sort_field);
					$("#sort_sequence").val("asc");
				}
				para_data = {
					pagestart: "<?= $pagestart ?>",
					sort_field: $("#sort_field").val(),
					sort_sequence: $("#sort_sequence").val(),
					opertype: "SORT"
				};
				$("#product_list").load('<?= site_url('ecp_data_product/reload_prod_list/') ?>', para_data);
			}
			// ERP對應
			// 傳入:ID/排序欄位/排列順序/目前頁次(因為可能第1頁則沒有頁次, 放在最後面)
			function data_erp(id)
			{
				location.href = "<?=base_url().'ecp_data_product/erp_correspond/' ?>" + id + "/" + $("#sort_field").val() + "/" + $("#sort_sequence").val() + "/" + "<?= $pagestart ?>";
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>