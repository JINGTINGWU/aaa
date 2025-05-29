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
<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/common.js"></script>
<script type="text/javascript">
			// 新增任務
			function data_new()
			{
				if ($.trim($("#jec_job_id").val()) == "")
				{
					humane.error("任務不可空白");
					return;
				}
				//if (! confirm("是否確認要新增任務?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
					jec_job_id: $("#jec_job_id").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/job_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('任務新增完成');
							para_data1 = {
								jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "NEW1"
							};
							$("#projecttemp_edit").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_edit/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
						}
						else
							humane.error('任務新增作業失敗！');
					}
				});
			}
			// 刪除任務或工作項目
			function data_delete(type, id, seqno, jobid)
			{
				if (! confirm("是否確認要刪除專案範本內容?")) return;
				para_data = {
					jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
					type: type,
					id: id,
					seqno: seqno,
					jobid: jobid
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/jobtask_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('專案範本內容刪除完成');
							para_data1 = {
								jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "DEL"
							};
							$("#projecttemp_edit").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_edit/') ?>', para_data1);
						}
						else
							humane.error('專案範本內容刪除作業失敗！');
					}
				});
			}
			// 修改工作項目
			function data_edit(type, id, seqno, jobid)
			{
				info=Array();
				info[0]={id:'startdays'+id,msg:'開始天數不可空白',type:'ne'};
				info[1]={id:'workdays'+id,msg:'工作天數不可空白',type:'ne'};
					msg=fi_submit_check(info);
			if(msg==''){
					para_data = {
					jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
					type: type,
					id: id,
					seqno: seqno,
					jobid: jobid,
					startdays: $("#startdays"+id).val(),
					workdays: $("#workdays"+id).val(),
					user: $("#user"+id).val(),
					superuser: $("#superuser"+id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/jobtask_edit/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('專案範本內容修改完成');
							para_data1 = {
								jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "EDIT"
							};
							$("#projecttemp_edit").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_edit/') ?>', para_data1);
						}
						else
							humane.error('專案範本內容修改作業失敗！');
					}
				});
			  }
			}
			// 返回專案範本列表
			function back_to_projecttemp_list()
			{
				location.href = "<?= base_url().'ecp_data_projecttemp/index/' ?>" + "<?= $sort_field ?>" + "/" + "<?= $sort_sequence ?>" + "/" + "<?= $pagestart ?>";
			}

			// 向上下移動
			function projecttemp_updown(type, id, parentid, updown)
			{
				para_data = {
					type: type,
					id: id,
					parentid: parentid,
					updown: updown
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/projecttemp_updown/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('排序移動完成');
							para_data1 = {
								jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "SORT"
							};
							$("#projecttemp_edit").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_edit/') ?>', para_data1);
						}
						else
							humane.error('排序移動作業失敗！');
					}
				});
			}

			// 新增任務中的工作項目
			function data_tasknew(id)
			{
				if ($.trim($("#jec_task_id" + id).val()) == "")
				{
					humane.error("工作項目不可空白");
					return;
				}
				//if (! confirm("是否確認要新增任務中的工作項目?")) return;
				$("#btn_tasknew" + id).attr("disabled", true);
				para_data = {
					jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
					jec_projecttempjob_id: id,
					jec_task_id: $("#jec_task_id" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_projecttemp/task_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('工作項目新增完成');
							para_data1 = {
								jec_projecttemp_id: "<?= $projecttemp_data[0]['jec_projecttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "NEW2"
							};
							$("#projecttemp_edit").load('<?= site_url('ecp_data_projecttemp/reload_projecttemp_edit/') ?>', para_data1);
							$("#btn_tasknew" + id).attr("disabled", false);
						}
						else
							humane.error('工作項目新增作業失敗！');
					}
				});
			}			
		</script>
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
					<li><a href=# onclick="loadme(0)">專案範本列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">範本內容編輯</a></li>
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
						location.href = "<?= base_url().'ecp_data_projecttemp/index/' ?>";
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
				<td colspan="4" align="left">專案範本內容編輯</td>
			</tr>
			<tr>
				<td align="right">範本名稱：</td>
				<td id="frominputarea"><?= $projecttemp_data[0]['name'] ?></td>
				<td align="right">新增任務：</td>
				<td id="frominputarea">
					<select size="1" name="jec_job_id" id="jec_job_id">
						<?php foreach($select_job as $selectjob): ?>
							<option value="<?= $selectjob['jec_job_id'] ?>"><?= $selectjob['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增任務" onclick="data_new()" />
						<input type="button" id="btn_back" value="返回專案範本列表" onclick="back_to_projecttemp_list()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 專案範本內容(不分頁) -->
		<div id="projecttemp_edit">
			<?php
			//水務,市售,專案組的標案編輯
			if($projecttemp_data[0]['jec_dept_id'] == "25" || $projecttemp_data[0]['jec_dept_id'] == "26" || $projecttemp_data[0]['jec_dept_id'] == "16" || $projecttemp_data[0]['jec_dept_id'] == "14")
			{
				$this->load->view('ecp_data/ecp_data_projecttemp_edit_list', $projecttemp_edit);
            }
			else
			{
				$this->load->view('ecp_data/ecp_data_projecttemp_edit_list_old', $projecttemp_edit);
			}
			?>
		</div>
		
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>