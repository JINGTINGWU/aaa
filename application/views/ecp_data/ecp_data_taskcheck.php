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
					<li><a href=# onclick="loadme(1)" class="unselected">任務&amp;工作項目</a></li>
					<li><a href=# onclick="loadme(2)">工作項目列表</a></li>
					<li><a href=# onclick="loadme(3)" class="selected">工作檢核表</a></li>
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
	<!-- 工作項目資料 -->
	<div class="order-div" style="width: 18%; margin-right: 5px;">
		<table class="info-div" cellspacing="1" cellpadding="3">
			<tr><td class="info-title">工作項目</td></tr>
			<tr><td>工作名稱：<?= $task_data[0]['name'] ?></td></tr>
			<tr><td>工作類別：<?= $this->ecp_flag->get_tasktype($task_data[0]['tasktype']) ?></td></tr>
			<tr><td>預設承辦：<?= $task_data[0]['usergroup'] ?></td></tr>
			<tr><td>作業天數：<?= $task_data[0]['daywork'] ?></td></tr>
			<tr><td>前置通知：<?= $task_data[0]['daynotice'] ?></td></tr>
			<tr><td>允許延遲：<?= $task_data[0]['daydelay'] ?></td></tr>
			<tr><td>工作權重：<?= $task_data[0]['workweight'] ?></td></tr>
			<tr><td>處理原則：<?= $this->ecp_flag->get_processtype($task_data[0]['processtype']) ?></td></tr>
			<tr><td>確認方式：<?= $this->ecp_flag->get_confirmtype($task_data[0]['confirmtype']) ?></td></tr>
		</table>
	</div>
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 工作項目檢核表列表 -->
	<div class="order-div" style="display: inline; width: 81%;">
		<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="4" align="left">新增檢核工作項目</td>
			</tr>
			<tr>
				<td align="right">工作項目：</td>
				<td id="frominputarea">
					<select size="1" name="jec_task_check_id" id="jec_task_check_id">
						<?php foreach($select_task as $selecttask): ?>
							<?php if ($selecttask['jec_task_id'] != $task_data[0]['jec_task_id']): ?>
								<option value="<?= $selecttask['jec_task_id'] ?>"><?= $selecttask['name'] ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</td>
				<td align="right">檢核方式：</td>
				<td id="frominputarea">
					<select size="1" name="checktype" id="checktype">
						<?php foreach($select_checktype as $selectchecktype): ?>
							<option value="<?= $selectchecktype['datatype'] ?>"><?= $selectchecktype['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea" colspan="5">
					<input id="description" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增檢核點" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="button" id="btn_back" value="返回工作項目列表" onclick="back_to_task_list()" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<table class="detail-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="4">現有工作項目檢核表</td>
			</tr>
			<tr>
				<td align="center">檢核方式</td>
				<td>工作名稱</td>
				<td>備註說明</td>
				<td align="center">刪除</td>
			</tr>
			<?php foreach($taskcheck_list as $key => $taskchecklist): ?>
				<tr>
					<td>
						<?= $this->ecp_flag->get_checktype($taskchecklist['checktype']) ?>
					</td>
					<td>
						<?= $taskchecklist['name'] ?>
					</td>
					<td>
						<?= $taskchecklist['description'] ?>
					</td>
					<td align="center">
						<?php if ($authority['isdelete']=='Y'): ?>
							<input type="button" id="<?= 'btn_delete'.$taskchecklist['jec_taskcheck_id'] ?>" 
							value="刪除" onclick="data_delete(<?= $taskchecklist['jec_taskcheck_id'] ?>)" />
						<?php else: ?>
							---
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#jec_task_check_id").val()) == "")
				{
					humane.error("檢核的工作項目不可空白");
					return;
				}
				if (! confirm("是否確認要新增檢核工作項目?")) return;
				para_data = {
					jec_task_id: "<?= $task_data[0]['jec_task_id'] ?>",
					jec_task_check_id: $("#jec_task_check_id").val(),
					checktype: $("#checktype").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/taskcheck_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('檢核工作項目新增完成');
							pagereload();
						}
						else
							humane.error('檢核工作項目新增作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除檢核工作項目?")) return;
				para_data = {
					jec_taskcheck_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_jobtask/taskcheck_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('檢核工作項目刪除完成');
							pagereload();
						}
						else
							humane.error('檢核工作項目刪除作業失敗！');
					}
				});
			}
			// 回到工作項目列表之前的頁次
			function back_to_task_list()
			{
				location.href = "<?= base_url().'ecp_data_jobtask/task_list/' ?>" + "<?= $sort_field ?>" + "/" + "<?= $sort_sequence ?>" + "/" + "<?= $pagestart ?>";
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>