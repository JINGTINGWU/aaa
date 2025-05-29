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
<body onload="Reset_Routine();">
自動PMS啟動排程功能
	
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
			
			function Reset_Routine()
			{
				para_data={ action_type:'reset_on' };
				$.ajax({
					type: "POST",
					url: "<?=base_url('ecp_routine_start/routine_bk/')?>",
					data: (para_data),
					success: function(result){
						window.open('<?php echo base_url('ecp_routine_start/Routine_Lib/0/');?>','exe_routine','height=10,width=10');
						alert('已啟動');
						//document.location.href="<?=base_url('ecp_data_setting/setting_routine/')?>";
						//refresh-
					}
				});				
			}
		</script>
	
</body>
</html>