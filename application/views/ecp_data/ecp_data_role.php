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
	<!-- 設定功能操作頁籤: 權限列表/編輯權限/人員設定 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">權限列表</a></li>
					<li><a href=# onclick="loadme(1)" class="unselected">編輯權限</a></li>
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
						//location.href = "<?= base_url().'ecp_data_roleuser/index/' ?>";
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
				<td colspan="4" align="left">新增權限</td>
			</tr>
			<tr>
				<td align="right">權限名稱：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">備註說明：</td>
				<td id="frominputarea">
					<input id="description" type="text" value="" size="50" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增權限" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有權限資料列表(含頁次) -->
		<div id="role_list">
			<?php $this->load->view('ecp_data/ecp_data_role_list', $role_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("權限名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增權限?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_roleuser/role_new/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('權限新增完成');
							para_data1 = {
								nowtime: new Date().getTime()
							};
							$("#role_list").load('<?= site_url('ecp_data_roleuser/reload_role_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
							$("#description").val("");
						}
						else if (result == "EXIST")
						{
							humane.error('權限名稱重覆！');
							$("#btn_new").attr("disabled", false);
						}
						else
						{
							humane.error('權限新增作業失敗！');
							$("#btn_new").attr("disabled", false);
						}
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("權限名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要更新權限?")) return;
				para_data = {
					jec_role_id: id,
					name: $("#name" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_roleuser/role_update/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
							humane.info('權限更新完成');
						else if (result == "EXIST")
							humane.error('權限名稱重覆！');
						else
							humane.error('權限更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除權限?")) return;
				para_data = {
					jec_role_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_roleuser/role_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('權限刪除完成');
							para_data1 = {
								nowtime: new Date().getTime()
							};
							$("#role_list").load('<?= site_url('ecp_data_roleuser/reload_role_list/') ?>', para_data1);
						}
						else if (result == "EXIST")
							humane.error('此權限使用中，不能刪除！');
						else
							humane.error('權限刪除作業失敗！');
					}
				});
			}
			// 編輯權限
			function data_edit(id)
			{
				location.href = "<?=base_url().'ecp_data_roleuser/role_edit/' ?>" + id;
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>