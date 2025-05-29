<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<body>

<div>
<form method="post" name="edit_form" id="edit_form" action="<?=site_url('ecp_routine/routine_bk/')?>" target="phf" enctype="multipart/form-data" >
<input type="hidden" name="key_id" value="<?=$routine_id?>" />
<input type="hidden" name="action_type" value="edit_routine" />
<table>
<tr><th><?=$main_op['zrs_title']['title']?></th><td><?=$main_op['zrs_title']['op']?></td></tr>
<tr><th><?=$main_op['zrs_exe_file']['title']?></th><td><?=$main_op['zrs_exe_file']['op']?></td></tr>
<tr><th>上傳執行檔案</th><td><input type="file" name="upload_file" /></td></tr>
<tr><th><?=$main_op['zrs_exe_type']['title']?></th><td><?=$main_op['zrs_exe_type']['op']?></td></tr>
<!--<tr><th><?=$main_op['zrs_exe_switch']['title']?></th><td><?=$main_op['zrs_exe_switch']['op']?></td></tr>-->
<tr><th><?=$main_op['zrs_exe_timespan']['title']?></th><td><?=$main_op['zrs_exe_timespan']['op']?></td></tr>
<tr><th><?=$main_op['zrs_exe_dailytime']['title']?></th><td><?=$main_op['zrs_exe_dailytime']['op']?></td></tr>
</table>
<input type="button" onclick="document.getElementById('edit_form').submit();" value="Send" />
<input type="button" onclick="history.back(-1);" value="Cancel" />
</form>
</div>
<iframe name="phf" id="phf" style="display:none;"></iframe>
</body>
</html>
