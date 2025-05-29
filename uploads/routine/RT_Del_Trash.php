<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
JS_Msg('Delete_Try-Before_ LC');
$CleanTrash=$this->Load_Class('CleanTrash');

$CleanTrash->sys_dir=array('awea','function','bk_view','common_view','module_view','kute_c','google','ecp','facebook','twitter','Adempiere','document','install','kute','pecl','mm','php','Soft','xampp','temp_desk');

$CleanTrash->dir_root=$_SERVER['DOCUMENT_ROOT'].'/obamboo_work/project_32_awea/awea/uploads/just_try_try_see/';
//$CleanTrash->dir_root='../../uploads/just_try_try_see/';

$CleanTrash->keep_dir=array('uploads','bulletin','contract','knowledge','temp_save','class','js','routine','tb','tools',$_SERVER['DOCUMENT_ROOT'].'/obamboo_work/project_32_awea/awea/uploads/just_try_try_see/');
$CleanTrash->keep_file=array("contract_20120328233732_77.pdf");

$CleanTrash->del($_SERVER['DOCUMENT_ROOT'].'/obamboo_work/project_32_awea/awea/uploads/just_try_try_see/');
//$CleanTrash->del('../../uploads/just_try_try_see/');

$this->db->insert(array('table'=>'arrange_test','insert_array'=>array('at_time'=>date('Y-m-d H:i:s'),'at_name'=>'DELETE_FILE')));
JS_Msg('Delete OK!');//Love you so much. Haha. Many thanks.
?>
</body>
</html>
