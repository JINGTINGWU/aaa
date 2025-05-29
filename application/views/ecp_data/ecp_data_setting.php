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
	<!-- 設定功能操作頁籤: 參數列表/定時執行 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">參數列表</a></li>
					<li><a href=# onclick="loadme(1)">定時執行</a></li>
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
						//location.href = "<?= base_url().'ecp_data_setting/index/' ?>";
						break;
					case 1:
						location.href = "<?= base_url().'ecp_data_setting/setting_routine/' ?>";
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<!-- 現有系統參數列表 -->
		<div id="setting_list">
			<?php $this->load->view('ecp_data/ecp_data_setting_list', $setting_list); ?>
		</div>
		<script type="text/javascript">
			// 修改
			function data_update(id)
			{
				var content = "";
				var icon = "";
				var value = "";
				var noticetype =  $.trim($("#noticetype" + id).val());
				if (noticetype.substring(0,1) <= "9")
				{
					content = $("#content" + id).val();
					icon = $("#icon" + id).val();
				}
				else if (noticetype != "AT" && noticetype != "AS")
				{
					value = $("#value" + id).val();
				}
				para_data = {
					jec_setup_id: id,
					content: content,
					icon: icon,
					value: value
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_setting/setting_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('系統參數更新完成');
						else
							humane.error('系統參數更新作業失敗！');
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