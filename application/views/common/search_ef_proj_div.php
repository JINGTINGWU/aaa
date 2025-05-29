<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style>
.on_select{
	/*background:#FFFF99;*/
	color:#000000;
	cursor:pointer;
	font-weight:bolder;
	/*padding-left:15px;*/
}
.off_select{
	background:#FFFFFF;
	color:#666666;
}
.test td{
	border-bottom:1px dotted #999999;
	font-size:13px;
	padding-top:4px;
	padding-bottom:4px;
}
.test th{
	font-size:13px;
	background:#CCCCCC;
}
.ob_on{
	text-decoration:none;
	color:#000000;
}
</style>
</head>
<body>
<div id="ch_search_list" style="overflow:scroll;height:580px;">
<?php /*$this->load->view('common/page_bar_div',array('pd'=>$pd));*/ ?>
<!--<?=$s_main_op['search_type']['op']?><?=$s_main_op['s_comparetype']['op']?><?=$s_main_op['s_keyword']['op']?><input type="button" value="開始尋找" />-->
<table class='test' width="100%">
<tr><th><a class="<?=$ob=='odmems003004'?'ob_on':''?>" href="<?=$ob_base_url?>odmems003004/<?php if($ob=='odmems003004'){ echo $ot=='ASC'?'DESC':'ASC'; }else{ echo 'ASC'; } ?>">主專案部門</a></th><th><a class="<?=$ob=='odmems003005'?'ob_on':''?>" href="<?=$ob_base_url?>odmems003005/<?php if($ob=='odmems003005'){ echo $ot=='ASC'?'DESC':'ASC'; }else{ echo 'ASC'; } ?>">專案案號</a></th><th><a class="<?=$ob=='odmems003006'?'ob_on':''?>" href="<?=$ob_base_url?>odmems003006/<?php if($ob=='odmems003006'){ echo $ot=='ASC'?'DESC':'ASC'; }else{ echo 'ASC'; } ?>">專案名稱</a></th><th><a class="<?=$ob=='odmems003011C'?'ob_on':''?>" href="<?=$ob_base_url?>odmems003011C/<?php if($ob=='odmems003011C'){ echo $ot=='ASC'?'DESC':'ASC'; }else{ echo 'ASC'; } ?>">立案人員</a></th></tr>
<?php
foreach($main_list as $no=>$value):
?><tr onclick="PG_Select_Proj('<?=$no?>')"><td class="off_select" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'"  id="projdept_tag_<?=$no?>"><?=$this->CM->db_trans($value['odmems003004C'],'output')?></td><td class="off_select" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'" id="projno_tag_<?=$no?>"><?=$this->CM->db_trans($value['odmems003005'],'output')?></td><td class="off_select" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'" id="projname_tag_<?=$no?>"><?=$this->CM->db_trans($value['odmems003006'],'output')?></td><td class="off_select" onmouseover="this.className='on_select'" onmouseout="this.className='off_select'"><?=$this->CM->db_trans($value['odmems003011C'],'output')?></td></tr>
<?php
endforeach;
?>
</table>

</div>
<script>
	function PG_Select_Proj(no)
	{	var projdept=document.getElementById('projdept_tag_'+no).innerHTML;
		var projno=document.getElementById('projno_tag_'+no).innerHTML;
		var projname=document.getElementById('projname_tag_'+no).innerHTML;
		//alert(projdept);
		opener.document.getElementById('efprojno').value=projno;
		opener.document.getElementById('efprojname').value=projname;
		opener.document.getElementById('efprojdept').value=projdept;
		window.close();
	}
</script>
</body>
</html>
