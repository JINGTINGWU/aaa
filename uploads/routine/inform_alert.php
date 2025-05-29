<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
//min
$test=fopen('uploads/routine/test.txt','a+');
$xx=time()-strtotime('2012-07-08 00:00:04');
$aa=floor($xx/60/60/24);
fwrite($test,iconv('utf-8','big5',$aa."\r\n"));
fclose($test); //
?>
<script>
alert('@@@@');
</script>
</body>
</html>
