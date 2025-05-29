<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ecplant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 片語資料 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">片語資料</a></li>
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
						//location.href = "<?= base_url().'ecp_data_phrase/index/' ?>";
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
				<td colspan="4" align="left">新增片語資料</td>
			</tr>
			<tr>
				<td align="right">片語內容：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
				<td align="right">片語類型：</td>
				<td id="frominputarea">
					<input type="radio" name="phrasetype" value="1" <?php if ($isadmin!='Y'): ?> disabled="disabled" <?php endif; ?>/>&nbsp;共用片語&nbsp;&nbsp;
					<input type="radio" name="phrasetype" value="2" checked="checked" />&nbsp;片語專屬&nbsp;<?= $user_name ?>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增片語" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有片語資料列表(含頁次) -->
		<div id="phrase_list">
			<?php $this->load->view('ecp_data/ecp_data_phrase_list', $phrase_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("片語內容不可空白");
					return;
				}
				//if (! confirm("是否確認要新增片語資料?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					phrasetype: $('input[name=phrasetype]:checked').val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_phrase/phrase_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('片語資料新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#phrase_list").load('<?= site_url('ecp_data_phrase/reload_phrase_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
						}
						else
							humane.error('片語資料新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("片語內容不可空白");
					return;
				}
				//if (! confirm("是否確認要更新片語資料?")) return;
				para_data = {
					jec_phrase_id: id,
					name: $("#name" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_phrase/phrase_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('片語資料更新完成');
						else
							humane.error('片語資料更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除片語資料?")) return;
				para_data = {
					jec_phrase_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_phrase/phrase_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('片語資料刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#phrase_list").load('<?= site_url('ecp_data_phrase/reload_phrase_list/') ?>', para_data1);
						}
						else
							humane.error('片語資料刪除作業失敗！');
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
				$("#phrase_list").load('<?= site_url('ecp_data_phrase/reload_phrase_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>