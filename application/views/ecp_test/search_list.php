<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<style>
/*
.test td:hover{
	background:#000000;
	color:#FFFFFF;
	cursor:pointer;
}*/
.on_select{
	background:#000000;
	color:#FFFFFF;
	cursor:pointer;
}
.off_select{
	background:#FFFFFF;
	color:#000000;
}
</style>
</head>

<script>
function PG_SelectList(no){
	parent.document.getElementById('search_here').value=document.getElementById('search_value_'+no).innerHTML;
	parent.document.getElementById('search_div').style.display='none';
	parent.document.getElementById('search_list').innerHTML='';
	parent.document.getElementById('on_select').value=-1;
	parent.document.getElementById('select_status').value='N';	
}
function PG_JumpFocus(no){
	var src=document.getElementById('search_value_'+no);
	//$('#search_list').contents().find('#search_tag_'+on_no).blur();
	//alert(src.offsetLeft);
	window.scrollTo(src.offsetLeft,src.offsetTop);
}
</script>
<body>

<div id="ch_search_list">
<table class='test' width="100%">
<?php
foreach($list as $no=>$value):
?><tr><td onclick="PG_SelectList('<?=$no?>')" id="search_value_<?=$no?>" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'"><?=$value['tt_title']?></td><!--<td width="1"><input type="button" id="search_tag_<?=$no?>" style="border:0px;background:#FFFFFF;height:0px;width:0px;" /></td>--></tr><?php
endforeach;
?>
</table>

</div>
</body>
</html>
