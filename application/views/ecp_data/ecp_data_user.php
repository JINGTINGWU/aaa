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
	<!-- 設定功能操作頁籤: 部門列表/展開部門/人員列表/群組人員 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">部門列表</a></li>
					<li><a href=# onclick="loadme(1)">展開部門</a></li>
					<li><a href=# onclick="loadme(2)" class="selected">人員列表</a></li>
					<li><a href=# onclick="loadme(3)">群組人員</a></li>
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
						location.href = "<?= base_url().'ecp_data_deptuser/index/' ?>";
						break;
					case 1:
						location.href = "<?= base_url().'ecp_data_deptuser/dept_expand/' ?>";
						break;
					case 2:
						//location.href = "<?= base_url().'ecp_data_deptuser/user_list/' ?>";
						break;
					case 3:
						location.href = "<?= base_url().'ecp_data_deptuser/usergroup_list/' ?>";
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
				<td colspan="6" align="left">新增人員</td>
			</tr>
			<tr>
				<td align="right">人員帳號：</td>
				<td id="frominputarea">
					<input id="value" type="text" value="" size="20" />
				</td>
				<td align="right">人員姓名：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">登入密碼：</td>
				<td id="frominputarea">
					<input id="password" type="text" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td align="right">所屬部門：</td>
				<td id="frominputarea">
					<select size="1" name="jec_dept_id" id="jec_dept_id">
						<?php foreach($select_dept as $selectdept): ?>
							<option value="<?= $selectdept['jec_dept_id'] ?>"><?= $selectdept['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td align="right">職務名稱：</td>
				<td id="frominputarea">
					<select size="1" name="jec_title_id" id="jec_title_id">
						<?php foreach($select_title as $selecttitle): ?>
							<option value="<?= $selecttitle['jec_title_id'] ?>"><?= $selecttitle['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td align="right">電子郵件：</td>
				<td id="frominputarea" colspan="5">
					<input id="email" type="text" value="" size="50" />
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增人員" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有人員資料列表(含頁次) -->
		<div id="user_list">
			<?php $this->load->view('ecp_data/ecp_data_user_list', $user_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#value").val()) == "")
				{
					humane.error("帳號不可空白");
					return;
				}
				if ($.trim($("#name").val()) == "")
				{
					humane.error("姓名不可空白");
					return;
				}
				if ($.trim($("#password").val()) == "")
				{
					humane.error("密碼不可空白");
					return;
				}
				if ($.trim($("#jec_dept_id").val()) == "")
				{
					humane.error("所屬部門不可空白");
					return;
				}
				if ($.trim($("#email").val()) == "")
				{
					humane.error("電子郵件不可空白");
					return;
				}
				if (! checkVal($("#password").val()))
				{
					humane.error("密碼必須為英文字加數字的組合，至少8碼");
					return;
				}
				//if (! confirm("是否確認要新增人員?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					value: $("#value").val(),
					name: $("#name").val(),
					password: $("#password").val(),
					jec_dept_id: $("#jec_dept_id").val(),
					jec_title_id: $("#jec_title_id").val(),
					email: $("#email").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/user_new/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('人員新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#user_list").load('<?= site_url('ecp_data_deptuser/reload_user_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#value").val("");
							$("#name").val("");
							$("#password").val("");
							$("#email").val("");
						}
						else if (result == "EXIST")
						{
							humane.error('人員帳號重覆！');
							$("#btn_new").attr("disabled", false);
						}
						else
						{
							humane.error('人員新增作業失敗！');
							$("#btn_new").attr("disabled", false);
						}
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#value" + id).val()) == "")
				{
					humane.error("帳號不可空白");
					return;
				}
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("姓名不可空白");
					return;
				}
				if ($.trim($("#password" + id).val()) == "")
				{
					humane.error("密碼不可空白");
					return;
				}
				if ($.trim($("#jec_dept_id" + id).val()) == "")
				{
					humane.error("所屬部門不可空白");
					return;
				}
				if ($.trim($("#email" + id).val()) == "")
				{
					humane.error("電子郵件不可空白");
					return;
				}
				if (! checkVal($("#password" + id).val()))
				{
					humane.error("密碼必須為英文字加數字的組合，至少8碼");
					return;
				}
				//if (! confirm("是否確認要更新人員?")) return;
				para_data = {
					jec_user_id: id,
					value: $("#value" + id).val(),
					name: $("#name" + id).val(),
					password: $("#password" + id).val(),
					jec_dept_id: $("#jec_dept_id" + id).val(),
					jec_title_id: $("#jec_title_id" + id).val(),
					email: $("#email" + id).val(),
					costtype: $("#costtype" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/user_update/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
							humane.info('人員更新完成');
						else if (result == "EXIST")
							humane.error('人員帳號重覆！');
						else
							humane.error('人員更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除人員?")) return;
				para_data = {
					jec_user_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/user_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('人員刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#user_list").load('<?= site_url('ecp_data_deptuser/reload_user_list/') ?>', para_data1);
						}
						else if (result == "EXIST")
							humane.error('此人員為部門主管，不能刪除！');
						else
							humane.error('人員刪除作業失敗！');
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
				$("#user_list").load('<?= site_url('ecp_data_deptuser/reload_user_list/') ?>', para_data);
			}
			// 檢查輸入值是否為文數字(a~Z & 0~9), 目前只能檢查文字OR數字, 還沒有辦法判斷一定要文字加數字
			// 目前規則尚未確認, 暫不檢查
			function checkVal(str)
			{
				return true;
//				var regExp = /[a-zA-Z0-9]{8,}/;
//				if (regExp.test(str))
//					return true;
//				else
//					return false;
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>