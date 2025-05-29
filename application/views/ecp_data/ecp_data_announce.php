<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ecplant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>tools/append/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>tools/append/calendar/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>tools/append/calendar/css/steel/steel.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>tools/append/calendar/js/jscal2.js"></script>
<script type="text/javascript" src="<?=base_url()?>tools/append/calendar/js/lang/cn.js"></script>
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 公告列表 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">公告列表</a></li>
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
						//location.href = "<?= base_url().'ecp_data_announce/index/' ?>";
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
				<td colspan="6" align="left">新增公告</td>
			</tr>
			<tr>
				<td align="right">公告日期：</td>
				<td id="frominputarea">
					<input id="startdate" type="text" value="" size="10" />
				</td>
				<td align="right">結束日期：</td>
				<td id="frominputarea">
					<input id="enddate" type="text" value="" size="10" />
				</td>
				<td align="right">發表人：</td>
				<td id="frominputarea">
					<!--
					<select size="1" name="jec_user_id" id="jec_user_id">
						<?php foreach($select_user as $selectuser): ?>
							<option value="<?= $selectuser['jec_user_id'] ?>"><?= $selectuser['name'] ?></option>
						<?php endforeach; ?>
					</select>
					-->
					<?= $user_name ?>
					<input type="hidden" id="jec_user_id" value="<?= $jec_user_id ?>" />
				</td>
			</tr>
			<tr>
				<td align="right">公告內容：</td>
				<td colspan="5" id="frominputarea">
					<input id="name" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增公告" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- 指定日期選擇欄位  -->
		<script type="text/javascript">
			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide(); }
			});
			cal.manageFields("startdate", "startdate", "%Y-%m-%d");
			cal.manageFields("enddate", "enddate", "%Y-%m-%d");
		</script>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有公告資料列表(含頁次) -->
		<div id="announce_list">
			<?php $this->load->view('ecp_data/ecp_data_announce_list', $announce_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#startdate").val())=="" || $.trim($("#enddate").val())=="" || $.trim($("#enddate").val())<$.trim($("#startdate").val()))
				{
					humane.error('公告日期期間不正確');
					return;
				}
				if ($.trim($("#jec_user_id").val()) == "")
				{
					humane.error("發表人不可空白");
					return;
				}
				if ($.trim($("#name").val()) == "")
				{
					humane.error("公告內容不可空白");
					return;
				}
				//if (! confirm("是否確認要新增公告?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					startdate: $("#startdate").val(),
					enddate: $("#enddate").val(),
					jec_user_id: $("#jec_user_id").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_announce/announce_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('公告新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#announce_list").load('<?= site_url('ecp_data_announce/reload_announce_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
							$("#startdate").val("");
							$("#enddate").val("");
							$("#jec_user_id").val("");
						}
						else
						{
							humane.error('公告新增作業失敗！');
							$("#btn_new").attr("disabled", false);
						}
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#jec_user_id" + id).val()) == "")
				{
					humane.error("發表人不可空白");
					return;
				}
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("公告內容不可空白");
					return;
				}
				//if (! confirm("是否確認要更新公告?")) return;
				para_data = {
					jec_announce_id: id,
					name: $("#name" + id).val(),
					jec_user_id: $("#jec_user_id" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_announce/announce_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('公告更新完成');
						else
							humane.error('公告更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除公告?")) return;
				para_data = {
					jec_announce_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_announce/announce_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('公告刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#announce_list").load('<?= site_url('ecp_data_announce/reload_announce_list/') ?>', para_data1);
						}
						else
							humane.error('公告刪除作業失敗！');
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
				$("#announce_list").load('<?= site_url('ecp_data_announce/reload_announce_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>