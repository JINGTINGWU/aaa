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
	<!-- 設定功能操作頁籤: 部門列表/展開部門/人員列表/群組人員 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">部門列表</a></li>
					<li><a href=# onclick="loadme(1)">展開部門</a></li>
					<li><a href=# onclick="loadme(2)">人員列表</a></li>
					<li><a href=# onclick="loadme(3)" class="selected">群組人員</a></li>
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
						location.href = "<?= base_url().'ecp_data_deptuser/user_list/' ?>";
						break;
					case 3:
						//location.href = "<?= base_url().'ecp_data_deptuser/usergroup_list/' ?>";
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<!-- 群組人員列表(不分頁) -->
		<div id="usergroup_list">
			<?php $this->load->view('ecp_data/ecp_data_usergroup_list', $usergroup_list); ?>
		</div>
		<script type="text/javascript">
			// 新增群組中的人員
			function data_new(id)
			{
				if ($.trim($("#jec_user_id" + id).val()) == "")
				{
					humane.error("人員不可空白");
					return;
				}
				//if (! confirm("是否確認要新增群組中的人員?")) return;
				$("#btn_new" + id).attr("disabled", true);
				para_data = {
					jec_group_id: id,
					jec_user_id: $("#jec_user_id" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/usergroup_new/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('群組中的人員新增完成');
							para_data1 = {
								nowtime: new Date().getTime()
							};
							$("#usergroup_list").load('<?= site_url('ecp_data_deptuser/reload_usergroup_list/') ?>', para_data1);
							$("#btn_new" + id).attr("disabled", false);
						}
						else if (result == "EXIST")
						{
							humane.error('群組中的人員重覆新增！');
							$("#btn_new" + id).attr("disabled", false);
						}
						else
						{
							humane.error('群組中的人員新增作業失敗！');
							$("#btn_new" + id).attr("disabled", false);
						}
					}
				});
			}
			// 刪除群組中的人員
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除群組中的人員?")) return;
				para_data = {
					jec_usergroup_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/usergroup_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('群組中的人員刪除完成');
							para_data1 = {
								nowtime: new Date().getTime()
							};
							$("#usergroup_list").load('<?= site_url('ecp_data_deptuser/reload_usergroup_list/') ?>', para_data1);
						}
						else
							humane.error('群組中的人員刪除作業失敗！');
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