<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
//$this->db->insert(array('table'=>'arrange_test','insert_array'=>array('at_time'=>date('Y-m-d H:i:s'),'at_name'=>'TEST')));
//
$this->db->insert('arrange_test',array('at_time'=>date('Y-m-d H:i:s'),'at_name'=>'TEST'));
?>
<script>
alert('@@@@');
</script>
</body>
</html>
