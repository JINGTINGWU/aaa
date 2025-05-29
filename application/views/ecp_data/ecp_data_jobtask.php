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
<script type="text/javascript" src="<?=base_url()?>js/pagereload.js"></script>
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
					<li><a href=# onclick="loadme(0)">任務列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">任務&amp;工作項目</a></li>
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
						location.href = "<?= base_url().'ecp_data_jobtask/index/' ?>";
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
	<div class="clearfix">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 任務資料 -->
	<div class="order-div" style="width: 18%; margin-right: 5px;">
		<table class="info-div" cellspacing="1" cellpadding="3">
			<tr><td class="info-title">任務</td></tr>
			<tr><td>任務名稱：<?= $job_data[0]['name'] ?></td></tr>
			<tr><td>任務特性：<?= $this->ecp_flag->get_jobtype($job_data[0]['jobtype']) ?></td></tr>
		</table>
	</div>
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 該任務中預設的工作項目列表 -->
	<div class="order-div" style="display: inline; width: 81%;">
		<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left">新增工作項目</td>
			</tr>
			<tr>
				<td align="right">工作項目：</td>
				<td id="frominputarea">
					<select size="1" name="jec_task_id" id="jec_task_id">
						<?php foreach($select_task as $selecttask): ?>
							<option value="<?= $selecttask['jec_task_id'] ?>"><?= $selecttask['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增工作項目" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="button" id="btn_back" value="返回任務列表" onclick="back_to_job_list()" />
				</td>
			</tr>
		</table>
		<!-- 現有工作項目列表  -->
		<div id="jobtask_list">
			<?php $this->load->view('ecp_data/ecp_data_jobtask_list', $jobtask_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#jec_task_id").val()) == "")
				{
					humane.error("工作項目不可空白");
					return;
				}
				//if (! confirm("是否確認要新增工作項目?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					jec_job_id: "<?= $job_data[0]['jec_job_id'] ?>",
					jec_task_id: $("#jec_task_id").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/jobtask_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('工作項目新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								jec_job_id: "<?= $job_data[0]['jec_job_id'] ?>"
							};
							$("#jobtask_list").load('<?= site_url('ecp_data_jobtask/reload_jobtask_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
						}
						else
							humane.error('工作項目新增作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id, seqno)
			{
				if (! confirm("是否確認要刪除工作項目?")) return;
				para_data = {
					jec_job_id: "<?= $job_data[0]['jec_job_id'] ?>",
					jec_jobtask_id: id,
					seqno: seqno
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/jobtask_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('工作項目刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								jec_job_id: "<?= $job_data[0]['jec_job_id'] ?>"
							};
							$("#jobtask_list").load('<?= site_url('ecp_data_jobtask/reload_jobtask_list/') ?>', para_data1);
						}
						else
							humane.error('工作項目刪除作業失敗！');
					}
				});
			}
			// 回到任務列表之前的頁次
			function back_to_job_list()
			{
				location.href = "<?= base_url().'ecp_data_jobtask/index/' ?>" + "<?= $sort_field ?>" + "/" + "<?= $sort_sequence ?>" + "/" + "<?= $pagestart ?>";
			}
			// 向上下移動
			function jobtask_updown(id, updown)
			{
				para_data = {
					id: id,
					updown: updown,
					parentid: "<?= $job_data[0]['jec_job_id'] ?>"
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/jobtask_updown/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('排序移動完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								jec_job_id: "<?= $job_data[0]['jec_job_id'] ?>"
							};
							$("#jobtask_list").load('<?= site_url('ecp_data_jobtask/reload_jobtask_list/') ?>', para_data1);
						}
						else
							humane.error('排序移動作業失敗！');
					}
				});
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>