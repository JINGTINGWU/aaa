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
					<li><a href=# onclick="loadme(1)" class="unselected">編輯權限</a></li>
					<li><a href=# onclick="loadme(2)" class="selected">人員設定</a></li>
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
						//location.href = "<?= base_url().'ecp_data_roleuser/user_list/' ?>";
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<!-- 現有人員資料列表(不分頁) -->
		<div id="user_list">
			<?php $this->load->view('ecp_data/ecp_data_role_user_list', $user_list); ?>
		</div>
		<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
		<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
		<script type="text/javascript">
			// 修改
			function data_update(id)
			{
				if ($.trim($("#jec_role_id" + id).val()) == "")
				{
					humane.error("人員權限不可空白");
					return;
				}
				//if (! confirm("是否確認要更新人員權限?")) return;
				var acctstatus = $("input[name=acctstatus" +id + "]:checked").val();
				var isadmin = "N";
				if ($("#isadmin" + id).is(':checked')) isadmin = "Y"; else isadmin = "N";
				para_data = {
					jec_user_id: id,
					jec_role_id: $("#jec_role_id" + id).val(),
					acctstatus: acctstatus,
					isadmin: isadmin
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_roleuser/userrole_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('人員權限更新完成');
						else
							humane.error('人員權限更新作業失敗！');
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
					sort_field: $("#sort_field").val(),
					sort_sequence: $("#sort_sequence").val(),
					nowtime: new Date().getTime()
				};
				$("#user_list").load('<?= site_url('ecp_data_roleuser/reload_user_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>