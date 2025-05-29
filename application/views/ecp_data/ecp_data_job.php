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
	<!-- 設定功能操作頁籤: 任務列表/任務&工作項目/工作項目列表/工作檢核表/工作明細列表 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">任務列表</a></li>
					<li><a href=# onclick="loadme(1)" class="unselected">任務&amp;工作項目</a></li>
					<li><a href=# onclick="loadme(2)">工作項目列表</a></li>
					<li><a href=# onclick="loadme(3)" class="unselected">工作檢核表</a></li>
					<li><a href=# onclick="loadme(4)">工作明細列表</a></li>
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
						//location.href = "<?= base_url().'ecp_data_jobtask/index/' ?>";
						break;
					case 1:
						break;
					case 2:
						location.href = "<?= base_url().'ecp_data_jobtask/task_list/' ?>";
						break;
					case 3:
						break;
					case 4:
						location.href = "<?= base_url().'ecp_data_jobtask/work_list/' ?>";
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
				<td colspan="4" align="left">新增任務</td>
			</tr>
			<tr>
				<td align="right">任務名稱：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
				<td align="right">任務特性：</td>
				<td id="frominputarea">
					<select size="1" name="jobtype" id="jobtype">
						<?php foreach($select_jobtype as $selectjobtype): ?>
							<option value="<?= $selectjobtype['datatype'] ?>"><?= $selectjobtype['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea" colspan="3">
					<input id="description" type="text" value="" size="100" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增任務" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有任務資料列表(含頁次) -->
		<div id="job_list">
			<?php $this->load->view('ecp_data/ecp_data_job_list', $job_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("任務名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增任務?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					description: $("#description").val(),
					jobtype: $("#jobtype").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/job_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('任務新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#job_list").load('<?= site_url('ecp_data_jobtask/reload_job_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
							$("#description").val("");
						}
						else
							humane.error('任務新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("任務不可空白");
					return;
				}
				//if (! confirm("是否確認要更新任務?")) return;
				para_data = {
					jec_job_id: id,
					name: $("#name" + id).val(),
					description: $("#description" + id).val(),
					jobtype: $("#jobtype" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/job_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('任務更新完成');
						else
							humane.error('任務更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除任務?")) return;
				para_data = {
					jec_job_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/job_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('任務刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#job_list").load('<?= site_url('ecp_data_jobtask/reload_job_list/') ?>', para_data1);
						}
						else
							humane.error('任務刪除作業失敗！');
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
				$("#job_list").load('<?= site_url('ecp_data_jobtask/reload_job_list/') ?>', para_data);
			}
			// 任務&工作項目
			// 傳入:ID/排序欄位/排列順序/目前頁次(因為可能第1頁則沒有頁次, 放在最後面)
			function data_jobtask(id)
			{
				location.href = "<?=base_url().'ecp_data_jobtask/jobtask_list/' ?>" + id + "/" + $("#sort_field").val() + "/" + $("#sort_sequence").val() + "/" + "<?= $pagestart ?>";
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>