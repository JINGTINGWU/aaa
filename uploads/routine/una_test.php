<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
//
//JS_Msg('Backup_-Before_ LC');
$BackupDB=$this->Load_Class('BackupDB');
$BackupDB->savepath=$_SERVER['DOCUMENT_ROOT'].'/obamboo_work/project_32_awea/awea/uploads/back_up';
$BackupDB->backup();

JS_Msg('Backup OK!');//Love you so much. Haha. Many thanks.
?>
</body>
</html>
