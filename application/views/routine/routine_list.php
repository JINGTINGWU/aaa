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
<title>無標題文件</title>
</head>
<script>
function PG_EXE_ACTION(status,key_id){
	 document.getElementById('action_type').value=status;
	 document.getElementById('key_id').value=key_id;
	 document.getElementById('edit_form').target='phf';
	 document.getElementById('edit_form').submit();
	 document.getElementById('action_type').value='new_routine';
}
</script>
<body>
<div>
<div>New</div>
<form method="post" name="edit_form" id="edit_form" action="<?=site_url('ecp_routine/routine_bk/')?>" target="phf" >
<input type="hidden" name="key_id" id="key_id" value="0" />
<input type="hidden" name="action_type" id="action_type" value="new_routine" />
<input type="text" name="zrs_title" />
<input type="button" onclick="document.getElementById('edit_form').submit();" value="Send" />
</form>
<input type="button" value="reset" onclick="PG_EXE_ACTION('reset','');" />
<?php if($status_on=='N'&&$switch_on=='N'):?>
<input type="button" value="SwitchON" onclick="PG_EXE_ACTION('SwitchOn','');" />
<?php endif;?>
<?php if($status_on=='Y'&&$switch_on=='Y'):?>
<input type="button" value="SwitchOff" onclick="PG_EXE_ACTION('SwitchOff','');" />
<?php endif;?>
</div>

<table>
<tr><th>名稱</th><!--<th>狀態</th>--><th>下回執行時間</th><!--<th>運行停止時<br />寄送通知</th>--><th>開關</th><th>修改</th>
<th>手動執行</th></tr>
<?php $alert='N'; foreach($routine_list as $value):?>
<?php
if($alert=='N'&&$value['zrs_status']=='Y'&&strtotime($value['zrs_setchange_time'])<time()-600) $alert='Y';
?>
<tr><td><?=$value['zrs_title']?></td><!--<td><?=$value['zrs_status']?></td>--><td><?=$value['zrs_status']=='Y'?$value['zrs_setchange_time']:'-'?></td>
<!--<td><input type="checkbox" /></td>--><td><?=$value['zrs_exe_switch']?></td>
<td>
<?php if($value['zrs_on_exe']=='N'):?>
<input type="button" value="修改" onclick="location.href='<?=site_url('ecp_routine/routine_edit/'.$value['zrs_id'].'/')?>'" />
<?php endif;?>
<?php if($value['zrs_status']=='N'&&$value['zrs_exe_switch']=='N'){ ?><?php } ?>
<input type="button" value="啟動" onclick="PG_EXE_ACTION('open_switch','<?=$value['zrs_id']?>');" />
<?php if($value['zrs_status']=='Y'&&$value['zrs_exe_switch']=='Y'){ ?><?php } ?>
<input type="button" value="停止" onclick="PG_EXE_ACTION('close_switch','<?=$value['zrs_id']?>');" />
</td><td><input type="button" value="執行" onclick="PG_EXE_ACTION('exe_once','<?=$value['zrs_id']?>');" /></td></tr>
<?php endforeach;?>
</table>
<?php if($alert=='Y') echo 'Please reset the Routine.'; ?>
<iframe name="phf" id="phf" style="display:none;"></iframe>
</body>
</html>
