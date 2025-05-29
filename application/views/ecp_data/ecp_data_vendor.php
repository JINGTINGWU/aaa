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
	<!-- 設定功能操作頁籤: 客戶資料/廠商資料 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">客戶資料</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">廠商資料</a></li>
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
						location.href = "<?= base_url().'ecp_data_customer_vendor/index/' ?>";
						break;
					case 1:
						//location.href = "<?= base_url().'ecp_data_customer_vendor/vendor_list/' ?>";
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
				<td colspan="8" align="left">新增廠商資料</td>
			</tr>
			<tr>
				<td align="right">廠商編號</td>
				<td id="frominputarea">
					<input id="value" type="text" value="" size="20" />
				</td>
				<td align="right">廠商名稱</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">廠商簡稱</td>
				<td id="frominputarea">
					<input id="name2" type="text" value="" size="20" />
				</td>
				<td align="right">統一編號</td>
				<td id="frominputarea">
					<input id="taxid" type="text" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td align="right">廠商分類</td>
				<td id="frominputarea">
					<input id="vendorkind" type="text" value="" size="20" />
				</td>
				<td align="right">聯絡人</td>
				<td id="frominputarea">
					<input id="contact" type="text" value="" size="20" />
				</td>
				<td align="right">聯絡電話1</td>
				<td id="frominputarea">
					<input id="telephone1" type="text" value="" size="20" />
				</td>
				<td align="right">聯絡電話2</td>
				<td id="frominputarea">
					<input id="telephone2" type="text" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td align="right">傳真電話</td>
				<td id="frominputarea">
					<input id="faxphone" type="text" value="" size="20" />
				</td>
				<td align="right">廠商址址</td>
				<td colspan="5" id="frominputarea">
					<input id="address" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td align="right">電子郵件</td>
				<td colspan="3" id="frominputarea">
					<input id="email" type="text" value="" size="60" />
				</td>
				<td align="right">備註說明</td>
				<td colspan="3" id="frominputarea">
					<input id="description" type="text" value="" size="50" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="8" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增廠商" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有廠商資料列表(含頁次) -->
		<div id="vendor_list">
			<?php $this->load->view('ecp_data/ecp_data_vendor_list', $vendor_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#value").val()) == "")
				{
					humane.error("廠商編號不可空白");
					return;
				}
				if ($.trim($("#name").val()) == "")
				{
					humane.error("廠商名稱不可空白");
					return;
				}
				if ($.trim($("#name2").val()) == "")
				{
					humane.error("廠商簡稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增廠商資料?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					value: $("#value").val(),
					name: $("#name").val(),
					name2: $("#name2").val(),
					taxid: $("#taxid").val(),
					vendorkind: $("#vendorkind").val(),
					contact: $("#contact").val(),
					telephone1: $("#telephone1").val(),
					telephone2: $("#telephone2").val(),
					faxphone: $("#faxphone").val(),
					address: $("#address").val(),
					email: $("#email").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_customer_vendor/vendor_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('廠商資料新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#vendor_list").load('<?= site_url('ecp_data_customer_vendor/reload_vendor_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#value").val("");
							$("#name").val("");
							$("#name2").val("");
						}
						else
							humane.error('廠商資料新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#value" + id).val()) == "")
				{
					humane.error("廠商編號不可空白");
					return;
				}
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("廠商名稱不可空白");
					return;
				}
				if ($.trim($("#name2" + id).val()) == "")
				{
					humane.error("廠商簡稱不可空白");
					return;
				}
				//if (! confirm("是否確認要更新廠商資料?")) return;
				para_data = {
					jec_vendor_id: id,
					value: $("#value" + id).val(),
					name: $("#name" + id).val(),
					name2: $("#name2" + id).val(),
					taxid: $("#taxid" + id).val(),
					vendorkind: $("#vendorkind" + id).val(),
					contact: $("#contact" + id).val(),
					telephone1: $("#telephone1" + id).val(),
					telephone2: $("#telephone2" + id).val(),
					faxphone: $("#faxphone" + id).val(),
					address: $("#address" + id).val(),
					email: $("#email" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_customer_vendor/vendor_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('廠商資料更新完成');
						else
							humane.error('廠商資料更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除廠商資料?")) return;
				para_data = {
					jec_vendor_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_customer_vendor/vendor_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('廠商資料刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#vendor_list").load('<?= site_url('ecp_data_customer_vendor/reload_vendor_list/') ?>', para_data1);
						}
						else
							humane.error('廠商資料刪除作業失敗！');
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
				$("#vendor_list").load('<?= site_url('ecp_data_customer_vendor/reload_vendor_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>