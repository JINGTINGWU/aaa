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
					<li><a href=# onclick="loadme(0)" class="selected">客戶資料</a></li>
					<li><a href=# onclick="loadme(1)">廠商資料</a></li>
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
						//location.href = "<?= base_url().'ecp_data_customer_vendor/index/' ?>";
						break;
					case 1:
						location.href = "<?= base_url().'ecp_data_customer_vendor/vendor_list/' ?>";
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
				<td colspan="8" align="left">新增客戶資料</td>
			</tr>
			<tr>
				<td align="right">客戶編號</td>
				<td id="frominputarea">
					<input id="value" type="text" value="" size="15" />
				</td>
				<td align="right">客戶名稱</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">客戶簡稱</td>
				<td id="frominputarea">
					<input id="name2_new" type="text" value="" size="15" />
				</td>
				<td align="right">統一編號</td>
				<td id="frominputarea">
					<input id="taxid" type="text" value="" size="15" />
				</td>
			</tr>
			<tr>
				<td align="right">負責人</td>
				<td id="frominputarea">
					<input id="boss" type="text" value="" size="15" />
				</td>
				<td align="right">聯絡人</td>
				<td id="frominputarea">
					<input id="contact" type="text" value="" size="15" />
				</td>
				<td align="right">聯絡電話1</td>
				<td id="frominputarea">
					<input id="telephone1" type="text" value="" size="15" />
				</td>
				<td align="right">聯絡電話2</td>
				<td id="frominputarea">
					<input id="telephone2" type="text" value="" size="15" />
				</td>
			</tr>
			<tr>
				<td align="right">傳真電話</td>
				<td id="frominputarea">
					<input id="faxphone" type="text" value="" size="15" />
				</td>
				<td align="right">客戶址址</td>
				<td colspan="5" id="frominputarea">
					<input id="address" type="text" value="" size="80" />
				</td>
			</tr>
			<tr>
				<td align="right">電子郵件</td>
				<td colspan="3" id="frominputarea">
					<input id="email" type="text" value="" size="50" />
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
						<input type="button" id="btn_new" value="確定新增客戶" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有客戶資料列表(含頁次) -->
		<div id="customer_list">
			<?php $this->load->view('ecp_data/ecp_data_customer_list', $customer_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#value").val()) == "")
				{
					humane.error("客戶編號不可空白");
					return;
				}
				if ($.trim($("#name").val()) == "")
				{
					humane.error("客戶名稱不可空白");
					return;
				}
				if ($.trim($("#name2_new").val()) == "")
				{
					humane.error("客戶簡稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增客戶資料?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					value: $("#value").val(),
					name: $("#name").val(),
					name2: $("#name2_new").val(),
					taxid: $("#taxid").val(),
					boss: $("#boss").val(),
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
					url: "<?=site_url('ecp_data_customer_vendor/customer_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('客戶資料新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#customer_list").load('<?= site_url('ecp_data_customer_vendor/reload_customer_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#value").val("");
							$("#name").val("");
							$("#name2_new").val("");
						}
						else
							humane.error('客戶資料新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#value" + id).val()) == "")
				{
					humane.error("客戶編號不可空白");
					return;
				}
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("客戶名稱不可空白");
					return;
				}
				if ($.trim($("#name2" + id).val()) == "")
				{
					humane.error("客戶簡稱不可空白");
					return;
				}
				//if (! confirm("是否確認要更新客戶資料?")) return;
				para_data = {
					jec_customer_id: id,
					value: $("#value" + id).val(),
					name: $("#name" + id).val(),
					name2: $("#name2" + id).val(),
					taxid: $("#taxid" + id).val(),
					boss: $("#boss" + id).val(),
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
					url: "<?=site_url('ecp_data_customer_vendor/customer_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('客戶資料更新完成');
						else
							humane.error('客戶資料更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除客戶資料?")) return;
				para_data = {
					jec_customer_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_customer_vendor/customer_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('客戶資料刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#customer_list").load('<?= site_url('ecp_data_customer_vendor/reload_customer_list/') ?>', para_data1);
						}
						else
							humane.error('客戶資料刪除作業失敗！');
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
				$("#customer_list").load('<?= site_url('ecp_data_customer_vendor/reload_customer_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>