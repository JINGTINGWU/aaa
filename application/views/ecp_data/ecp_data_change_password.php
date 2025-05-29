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
<script type="text/javascript" src="<?=base_url()?>js/s3Capcha.js"></script>
</head>
<body>
<div id="navigation"><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 變更密碼 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# class="selected">變更密碼</a></li>
				</ul>
			</div>
			<div class="tab-div-right"><?= $function_name ?></div>
		</div>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr><td class="tab-underline"></td></tr>
		</table>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="2" align="left">變更密碼</td>
			</tr>
			<tr>
				<td align="right">帳號/姓名：</td>
				<td id="frominputarea">
					<?= $user_data[0]['value'] ?>&nbsp;/&nbsp;<?= $user_data[0]['name'] ?>
				</td>
			</tr>
			<tr>
				<td align="right">舊密碼：</td>
				<td id="frominputarea">
					<input id="password1" type="password" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td align="right">新密碼：</td>
				<td id="frominputarea">
					<input id="password2" type="password" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td align="right">新密碼(再一次)：</td>
				<td id="frominputarea">
					<input id="password3" type="password" value="" size="20" />
				</td>
			</tr>
			<tr>
				<td id="frominputarea" colspan="2">
					<div id="capcha"><?php include("js/s3Capcha.php"); ?></div>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isupdate']=='Y'): ?>
						<input type="button" id="btn_update" value="確定變更密碼" onclick="data_update()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<script type="text/javascript">
			$(document).ready(function() {
				$('#capcha').s3Capcha();
			});
		</script>
		<script type="text/javascript">
			// 修改
			function data_update()
			{
				if ($.trim($("#password1").val())=="" || $.trim($("#password2").val())=="" || $.trim($("#password3").val())=="")
				{
					humane.error("密碼不可空白");
					return;
				}
				var old_password = "<?= $user_data[0]['password'] ?>";
				if ($.trim($("#password1").val()) != old_password )
				{
					humane.error("舊密碼錯誤");
					return;
				}
				if ($.trim($("#password2").val()) != $.trim($("#password3").val()))
				{
					humane.error("新密碼不符，請重新輸入新密碼");
					return;
				}
				var s3capcha = $("input[name=s3capcha]:checked").val();
				para_data = {
					jec_user_id: <?= $user_data[0]['jec_user_id'] ?>,
					password: $("#password2").val(),
					s3capcha: s3capcha
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_change_password/password_update/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
							humane.info('變更密碼完成，請以新密碼重新登入系統');
						else if (result == "ERROR1")
							humane.error('提示圖案程式錯誤，請重新登入系統');
						else if (result == "ERROR2")
							humane.error('提示圖案選擇錯誤，請重新選擇');
						else
							humane.error('變更密碼作業失敗！');
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