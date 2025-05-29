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
	<!-- 設定功能操作頁籤: 專案範本列表/範本內容編輯 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">專案範本列表</a></li>
					<li><a href=# onclick="loadme(1)" class="unselected">範本內容編輯</a></li>
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
						//location.href = "<?= base_url().'ecp_data_projecttemp/index/' ?>";
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
				<td colspan="4" align="left">新增專案範本</td>
			</tr>
			<tr>
				<td align="right">範本名稱：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">備註說明：</td>
				<td id="frominputarea">
					<input id="description" type="text" value="" size="50" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增專案範本" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有專案範本列表(含頁次) -->
		<div id="projecttemp_list">
			<?php $this->load->view('ecp_data/ecp_data_projecttemp_list', $projecttemp_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("範本名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增專案範本?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/projecttemp_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('專案範本新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#projecttemp_list").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
							$("#description").val("");
						}
						else
							humane.error('專案範本新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("範本名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要更新專案範本?")) return;
				para_data = {
					jec_projecttemp_id: id,
					jec_dept_id: $("#jec_dept_id" + id).val(),
					name: $("#name" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/projecttemp_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('專案範本更新完成');
						else
							humane.error('專案範本更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除專案範本?")) return;
				para_data = {
					jec_projecttemp_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/projecttemp_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('專案範本刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#projecttemp_list").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_list/') ?>', para_data1);
						}
						else
							humane.error('專案範本刪除作業失敗！');
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
				$("#projecttemp_list").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_list/') ?>', para_data);
			}
			// 編輯內容
			function data_edit(id)
			{
				location.href = "<?=base_url().'ecp_data_projecttemp/projecttemp_edit/' ?>" + id + "/" + $("#sort_field").val() + "/" + $("#sort_sequence").val() + "/" + "<?= $pagestart ?>";
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>