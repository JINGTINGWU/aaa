<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
$no=0;
foreach($test as $value):
	$no++;
	echo '<br><br>';
	//print_r($value);
	foreach($value as $st=>$sv):
		
		//echo '===='.$sv;	//iconv('big5','utf-8',$sv)
		echo '===='.iconv('big5','utf-8',$sv);
	endforeach;
	//echo iconv('big5','utf-8',$value['ScriptSheetNo']);
	/*
	foreach($value as $st=>$sv):
		echo $st.'-'.$sv;
	endforeach;*/
	if($no>300) break;
endforeach;
?>
</body>
</html>
