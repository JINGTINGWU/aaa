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
	<!-- 設定功能操作頁籤: 部門列表/展開部門/人員列表/群組人員 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">部門列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">展開部門</a></li>
					<li><a href=# onclick="loadme(2)">人員列表</a></li>
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
						//location.href = "<?= base_url().'ecp_data_deptuser/dept_expand/' ?>";
						break;
					case 2:
						location.href = "<?= base_url().'ecp_data_deptuser/user_list/' ?>";
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
		<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6">現有部門展開列表</td>
			</tr>
			<tr>
				<td align="center">部門階層1</td>
				<td align="center">部門階層2</td>
				<td align="center">部門階層3</td>
				<td align="center">部門階層4</td>
				<td align="center">部門階層5</td>
				<td align="center">部門主管</td>
			</tr>
			<?php foreach($dept_expand as $key => $deptexpand): ?>
				<tr>
					<td align="center">
						<?php if ($deptexpand['layer']==0): ?>
							<?= $deptexpand['name'] ?>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($deptexpand['layer']==1): ?>
							<?= $deptexpand['name'] ?>
						<?php endif; ?>
					</td><td align="center">
						<?php if ($deptexpand['layer']==2): ?>
							<?= $deptexpand['name'] ?>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($deptexpand['layer']==3): ?>
							<?= $deptexpand['name'] ?>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($deptexpand['layer']==4): ?>
							<?= $deptexpand['name'] ?>
						<?php endif; ?>
					</td>
					<td align="center">
						<?= $deptexpand['username'] ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>