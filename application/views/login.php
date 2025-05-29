<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ECPlant" />
<meta name="description" content="EMS Project Management Information System" />
<title>EMS Project Management Information System</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/s3Capcha.js"></script>
</head>
<body>
<div align="center">
	<table border="0" width="500" cellspacing="0" cellpadding="5" style="margin-top: 20px;">
		<tr>
		  <td align="center" colspan="2" style="font-size: 36px; font-weight: bold; color: #303030;">弓銓企業</td>
	  </tr>
		<tr>
			<td align="center" colspan="2" style="font-size: 18px; font-weight: bold; color: #303030;">專案管理系統</td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="font-size: 18px; font-weight: bold; color: #303030;">Project Management Information System (PMIS)</td>
		</tr>
		<tr><td colspan="2"></td></tr>
		<tr>
			<td align="center" colspan="2" style="font-size: 16px; font-weight: bold; color: #303030;">使用者登入</td>
		</tr>
		<tr>
			<td align="right">使用者帳號：</td>
			<td align="left">
				<input type="text" class="tab-input" id="value" value="" size="20" />
			</td>
		</tr>
		<tr>
			<td align="right">使用者密碼：</td>
			<td align="left">
				<input type="password" class="tab-input" id="password" value="" size="20" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="capcha"><?php include("js/s3Capcha.php"); ?></div>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				請點選此圖示登入系統<br/>
				<input type="image" src="<?=base_url()?>images/login_s.gif" onclick="login()" />
			</td>
		</tr>
	</table>
    <input type="hidden" id="redirect_url" value="<?=$redirect_url?>" />
	<script type="text/javascript">
		$(document).ready(function() {
			$('#capcha').s3Capcha();
		});
	</script>
	<script type="text/javascript">
		function login()
		{
			if ($.trim($("#value").val()) == "")
			{
				humane.error("帳號不可空白");
				return;
			}
			var s3capcha = $("input[name=s3capcha]:checked").val();
			para_data = {
				value: $("#value").val(),
				password: $("#password").val(),
				s3capcha: s3capcha,
				redirect_url:$("#redirect_url").val()
			};
			$.ajax({
				type: "POST",
				url: "<?=base_url().'ecp_admin/ecp_login/'?>",
				data: (para_data),
				success: function(result){
					if (result == "OK")
						location.href = "<?=base_url() ?>";
					else if (result == "ERROR1")
						humane.error('提示圖案程式錯誤，請通知系統管理員');
					else if (result == "ERROR2")
						humane.error('提示圖案選擇錯誤，請重新選擇');
					else if (result=="ERROR3")
						humane.error('帳號或密碼錯誤！');
					else
						//alert(result);
						location.href=result;
				}
			});
		}
	</script>
</div>
</body>
</html>