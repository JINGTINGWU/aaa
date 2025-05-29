<?php
/*
global $_G;
require('function/awea_init.php');

//http://vegetable_web.aqu.0lx.net
$FTP_obj=$mobj->Load_Class('Ftp'); 
$FTP_obj->Connect_FTP(array('ftp_server'=>'ftp.0lx.net','ftp_user'=>'0lx_7361855','ftp_ps'=>'vg12356789'));//
$FTP_obj->FTP_DirList();
$FTP_obj->FTP_UploadFile('travel.html','htdocs/travel-1.html');
$FTP_obj->Close_FTP();//-
*/
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自動啟動排程</title>
</head>
<script>
function Reset_Routine()
			{
				alert('已啟動');
				para_data={ action_type:'reset_on' };
				$.ajax({
					type: "POST",
					url: "<?=base_url('ecp_routine/routine_bk/')?>",
					data: (para_data),
					success: function(result){
						window.open('<?php echo base_url('ecp_routine/Routine_Lib/0/');?>','exe_routine','height=10,width=10');
						alert('已啟動');
						document.location.href="<?=base_url('ecp_data_setting/setting_routine/')?>";
						//refresh-
					}
				});				
			}
</script>
<body onload="Reset_Routine();">
自動啟動頁
</body>
</html>
