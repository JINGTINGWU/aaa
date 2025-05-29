<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style>
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

<script src="<?=base_url()?>js/PL_C.js"></script>
<script>
var InputList={};
parent.PL_Load_CData();
</script>
<body>
<div id="ch_search_list">
<table class='test' width="100%">
<?php
foreach($main_list as $no=>$value):
?><tr><td onclick="PL_SelectList('<?=$no?>')" id="search_value_<?=$no?>" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'" abbr="<?=$value['jec_product_id']?>" ><?=$value['name']?></td></tr><?php
endforeach;
?>
</table>

</div>
<script>
/*
if(typeof(parent.PL_SaveTarget_Info == 'function')){
	parent.PL_SaveTarget_Info();
}
*/
</script>
</body>
</html>
