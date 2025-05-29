<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<body>
<div id="result_area_div" class="mm_area_div_2">
<table class="detail-div" cellspacing="1" cellpadding="3">
<tr><td colspan="4" style="padding:0px;"></td></tr>
<!--
<tr><td rowspan="2">片語</td><td rowspan="2">類別</td><td colspan="2">功能</td></tr>
<tr><td>加入</td><td>取代</td></tr>-->
<tr><td>片語</td>
<td>類別</td><td colspan="2">功能</td>
</tr>
<?php foreach($main_list as $no=>$value):?>
<tr><td id="phrase_<?=$no?>"><?=$value['name']?></td><td width="46"><?=$phrasetype_pdb[$value['phrasetype']]?></td><td width="42"><input type="button" value="加入" onclick="PG_Phrase_Action('add','<?=$no?>','<?=$target_id?>');" /></td><td width="46"><input type="button" value="取代" onclick="PG_Phrase_Action('replace','<?=$no?>','<?=$target_id?>');" /></td></tr>
<?php endforeach;?>
</table>
</div>
</body>
<script>
function PG_Phrase_Action(type,id,target)
{
	var phrase=document.getElementById('phrase_'+id).innerHTML;
	switch(type){
		case 'add':
			parent.document.getElementById(target).value=parent.document.getElementById(target).value+''+phrase;
			break;
		case 'replace':
			parent.document.getElementById(target).value=phrase;
			break;
	}
}
function PG_Upload_Save()
{
}
</script>
</html>
