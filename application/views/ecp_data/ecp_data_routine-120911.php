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
					<li><a href=# onclick="loadme(0)">參數列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">定時執行</a></li>
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
						location.href = "<?= base_url().'ecp_data_setting/index/' ?>";
						break;
					case 1:
						//location.href = "<?= base_url().'ecp_data_setting/setting_routine/' ?>";
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
			<?php $this->load->view('ecp_data/ecp_data_routine_list', $setting_list); ?>
		</div>
		<script type="text/javascript">
			// 修改
			function data_update(id)
			{
				var zrs_exe_type = $("input[name=zrs_exe_type" +id + "]:checked").val();
				if (zrs_exe_type=="1" && ($.trim($("#zrs_exe_timespan" + id).val()) == "" || isNaN($.trim($("#zrs_exe_timespan" + id).val()))))
				{
					humane.error('間隔時間請設分鐘');
					return;
				}
				var zrs_exe_timespan = $.trim($("#zrs_exe_timespan" + id).val());
				var zrs_exe_dailytime = $.trim($("#zrs_exe_dailytime" + id).val());
				var regExp = /^([01]\d|2[0-3]):([0-5]\d)$/;
				if (zrs_exe_type=="2" && (zrs_exe_dailytime == "" || !regExp.test(zrs_exe_dailytime)))
				{
					humane.error('固定時間請設HH:SS的格式，例如06:30');
					return;
				}
				var zrs_exe_switch = "";
				if ($("#zrs_exe_switch" + id).is(":checked")) zrs_exe_switch = "Y"; else zrs_exe_switch = "N";
				para_data = {
					zrs_id: id,
					zrs_exe_switch: zrs_exe_switch,
					zrs_exe_type: zrs_exe_type,
					zrs_exe_timespan: zrs_exe_timespan,
					zrs_exe_dailytime: zrs_exe_dailytime
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_setting/routine_update/')?>",
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