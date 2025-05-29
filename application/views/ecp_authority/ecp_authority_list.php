<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ECPlant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/pagereload.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 權限定義/編輯權限/使用者管理 -->
	<div class="tabpage">
		<ul id="functiontabs">
			<li><a href=# onclick="loadme(0)" class="selected">權限定義</a></li>
			<li><a href=# onclick="loadme(1)">編輯權限</a></li>
			<li><a href=# onclick="loadme(2)">使用者管理</a></li>
		</ul>
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
						location.href = '<?= base_url().'ecp_authority/index/' ?>';
						break;
					case 1:
						break;
					case 2:
						location.href = '<?= base_url().'ecp_authority/user_managerment/' ?>';
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 權限定義 -->
	<div id="authority_list" style="display: inline;">
		<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6">現有系統權限</td>
			</tr>
			<tr>
				<td>權限名稱</td>
				<td>備註說明</td>
				<td align="center">人數統計</td>
				<td align="center">編輯權限</td>
				<td align="center">使用者管理</td>
				<td align="center">刪除</td>
			</tr>
			<tr>
				<td>系統管理者</td>
				<td>全部作業都可操作</td>
				<td>3</td>
				<td align="center">
					<?php if ($authority['isupdate']=='Y'): ?>
						<input type="button" id="btn_edit" 
						value="編輯權限" onclick="role_edit(1)" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
				<td align="center">
					<?php if ($authority['isupdate']=='Y'): ?>
						<input type="button" id="btn_user" 
						value="使用者管理" onclick="role_user(1)" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
				<td align="center">
					<?php if ($authority['isdelete']=='Y'): ?>
						<input type="button" id="btn_delete" 
						value="刪除" onclick="role_delete(1)" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
<!--
			<?php foreach($jec_role as $jecrole): ?>
				<tr>
					<td align="center"><?= $jecrole['value'] ?></td>
					<td><?= $jecrole['name'] ?></td>
					<td align="center" class="keyword-count"><?= $jecrole['usercount'] ?></td>
					<td align="center">
						<input type="button" class="tab-input" id="<?= 'btn_edit'.$jecrole['jec_role_id'] ?>" 
						value="編輯權限" onclick="role_edit(<?= $jecrole['jec_role_id'] ?>)" />
					</td>
					<td align="center">
						<input type="button" class="tab-input" id="<?= 'btn_user'.$jecrole['jec_role_id'] ?>" 
						value="成員列表" onclick="role_user(<?= $jecrole['jec_role_id'] ?>)" />
					</td>
					<td align="center">
						<input type="button" class="tab-input" id="<?= 'btn_new'.$jecrole['jec_role_id'] ?>" 
						value="新增管理者" onclick="role_new(<?= $jecrole['jec_role_id'] ?>)" />
					</td>
					<td align="center">
						<?php if ($jecrole['usercount']=='0'): ?>
							<input type="button" class="tab-input" id="<?= 'btn_delete'.$jecrole['jec_role_id'] ?>" 
							value="刪除" onclick="role_delete(<?= $jecrole['jec_role_id'] ?>)" />
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
-->
		</table>
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="2" align="left">新增系統權限</td>
			</tr>
			<tr>
				<td align="right">權限名稱：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea">
					<input id="description" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_newrole" value="確定新增系統權限" onclick="new_role()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			// 新增權限定義
			function new_role()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("等級名稱不可空白");
					return;
				}
				var authoritystring = "";
				var obj=document.getElementsByName("menuname");
        		var len = obj.length;
        		var menuid= "";
        		var menuname = "";
        		var menucheck = "";
        		var isselected = false;
				for (i = 0; i < len; i++)
				{
					if (obj[i].checked == true)
					{
						menucheck = "Y";
						isselected = true;
					}
					else
					{
						menucheck = "N";
					}
					menuid = $("#menuid" + i).val();
					menuname = obj[i].value;
					authoritystring = authoritystring + menuid + "," + menuname + "," + menucheck + ";";
				}
				if (! isselected)
				{
					humane.error("請至少勾選一項功能");
					return;
				}
				if (! confirm("是否確認要新增權限等級?")) return;
				para_data = {
					value: $("#value").val(),
					name: $("#name").val(),
					authoritystring: authoritystring
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_setting_permissionlist/new_role/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('權限等級新增完成');
							pagereload();
						}
						else
							humane.error('權限等級新增作業失敗！');
					}
				});
			}
			// 刪除權限定義(沒有成員才可以刪除)
			function role_delete(id)
			{
				if (! confirm("是否確認要刪除權限等級?")) return;
				para_data = {
					jec_role_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_setting_permissionlist/role_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('權限等級刪除完成');
							pagereload();
						}
						else
							humane.error('權限等級刪除作業失敗！');
					}
				});
			}
			// 編輯權限定義
			function role_edit(id)
			{
				location.href = "<?=base_url().'ecp_setting_permissionlist/role_edit/' ?>" + '/' + id;
			}
			// 成員列表
			function role_user(id)
			{
				location.href = "<?=base_url().'ecp_setting_newmanager/index/' ?>" + '/' + id;
			}
			// 新增管理者
			function role_new(id)
			{
				location.href = "<?=base_url().'ecp_setting_newmanager/index/' ?>" + '/' + id;
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>