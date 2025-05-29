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
	<!-- 設定功能操作頁籤: 權限列表/編輯權限/人員設定 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">權限列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">編輯權限</a></li>
					<li><a href=# onclick="loadme(2)">人員設定</a></li>
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
						location.href = "<?= base_url().'ecp_data_roleuser/index/' ?>";
						break;
					case 1:
						break;
					case 2:
						location.href = "<?= base_url().'ecp_data_roleuser/user_list/' ?>";
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
				<td colspan="3" align="left">編輯權限</td>
			</tr>
			<tr>
				<td align="right">權限名稱：</td>
				<td id="frominputarea">
					<?= $role_data[0]['name']?>
				</td>
				<td align="center">
					<?php if ($authority['isupdate']=='Y'): ?>
						<input type="button" id="btn_new" value="確定修改權限" onclick="data_update()" />
						<input type="button" id="btn_back" value="返回權限列表" onclick="back_to_role_list()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6">編輯作業權限</td>
			</tr>
			<tr>
				<td>主選單</td>
				<td>子選單</td>
				<td align="center">使用</td>
				<td align="center">新增</td>
				<td align="center">修改</td>
				<td align="center">刪除</td>
			</tr>
			<?php foreach($role_edit as $key => $roleedit): ?>
				<tr>
					<td>
						<?php if ($roleedit['layer']==0): ?>
							<?= $roleedit['name'] ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if ($roleedit['layer']!=0): ?>
							<?= $roleedit['name'] ?>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($roleedit['layer']!=0): ?>
							<input type="checkbox" name="<?= 'isaccess_check'.$key ?>" id="<?= 'isaccess_check'.$key ?>" value="Y"
							<?php if ($roleedit['isaccess']=='Y'): ?> checked="checked" <?php endif;?> onclick="isaccess_checked(<?= $key ?>)"/>
							<input type="hidden" id="<?= 'isaccess'.$key ?>" value="<?= $roleedit['jec_menu_id'] ?>"/>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($roleedit['layer']!=0): ?>
							<input type="checkbox" name="<?= 'isinsert_check'.$key ?>" id="<?= 'isinsert_check'.$key ?>" value="Y"
							<?php if ($roleedit['isinsert']=='Y'): ?> checked="checked" <?php endif;?>/>
							<input type="hidden" id="<?= 'isinsert'.$key ?>" value="<?= $roleedit['jec_menu_id'] ?>"/>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($roleedit['layer']!=0): ?>
							<input type="checkbox" name="<?= 'isupdate_check'.$key ?>" id="<?= 'isupdate_check'.$key ?>" value="Y"
							<?php if ($roleedit['isupdate']=='Y'): ?> checked="checked" <?php endif;?>/>
							<input type="hidden" id="<?= 'isupdate'.$key ?>" value="<?= $roleedit['jec_menu_id'] ?>"/>
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($roleedit['layer']!=0): ?>
							<input type="checkbox" name="<?= 'isdelete_check'.$key ?>" id=<?= 'isdelete_check'.$key ?> value="Y"
							<?php if ($roleedit['isdelete']=='Y'): ?> checked="checked" <?php endif;?>/>
							<input type="hidden" id="<?= 'isdelete'.$key ?>" value="<?= $roleedit['jec_menu_id'] ?>"/>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<script type="text/javascript">
			// 勾選(使用)時, 增/修/刪要一起同步勾選
			function isaccess_checked(key)
			{
				if ($("#isaccess_check" + key).is(':checked'))
				{
					$("#isinsert_check" + key).attr("checked",'true');
					$("#isupdate_check" + key).attr("checked",'true');
					$("#isdelete_check" + key).attr("checked",'true');
				}
				else
				{
					$("#isinsert_check" + key).removeAttr("checked");
					$("#isupdate_check" + key).removeAttr("checked");
					$("#isdelete_check" + key).removeAttr("checked");
				}
			}
			// 整批讀取設定, 以字串格式組合: jec_menu_id/isaccess/isinsert/isupdate/isdelete;
			// 例如: 1/Y/Y/Y/Y;2/N/N/N/N;3/Y/Y/N/N;
			function data_update()
			{
				if (! confirm("是否確認要修改目前的權限?")) return;
				var checklist = "";
				$("input[id~='isaccess_check']").each(function()
				{
					var id = $(this).attr('id');
					var key = id.substring(14);
					var jec_menu_id = $("#isaccess" + key).val();
					var isaccess = "Y";
					var isinsert = "Y";
					var isupdate = "Y";
					var isdelete = "Y";
					if ($("#isaccess_check" + key).is(':checked')) isaccess = "Y"; else isaccess = "N";
					if ($("#isinsert_check" + key).is(':checked')) isinsert = "Y"; else isinsert = "N";
					if ($("#isupdate_check" + key).is(':checked')) isupdate = "Y"; else isupdate = "N";
					if ($("#isdelete_check" + key).is(':checked')) isdelete = "Y"; else isdelete = "N";
					checklist = checklist + jec_menu_id + "/" + isaccess + "/" + isinsert + "/" + isupdate + "/" + isdelete + ";";
				});
				para_data = {
					jec_role_id: <?= $role_data[0]['jec_role_id']?>,
					checklist: checklist
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_roleuser/update_rolemenu/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('權限設定更新完成');
						}
						else
						{
							humane.error("權限設定更新作業失敗！");
						}
					}
				});
			}
			// 返回權限列表
			function back_to_role_list()
			{
				location.href = "<?= base_url().'ecp_data_roleuser/index/' ?>";
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>