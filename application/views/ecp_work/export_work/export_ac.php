<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<style>
.excel_1{
	border:1px solid #CCCCCC;	
	color:#666666;
}
.excel_1 th{
	font-size:14px;
	border:1px solid #CCCCCC;
	text-align:center;
	background:#EEEEEE;
}
.excel_1 td{
	border:1px solid #CCCCCC;	
	font-size:14px;
	padding:5px;
}
.change_td{
	font-weight:bolder;
	color:#FF0000;
	font-size:18px;
}
</style>
<body>
<table class="excel_1" cellspacing="0" width="900" border="1" bordercolor="#CCCCCC">
        <tr>
        	<th bgcolor="#EEEEEE">編號</th>
            <th bgcolor="#EEEEEE">ID</th>
            <th bgcolor="#EEEEEE">料品品名/工作明細</th>
            <th bgcolor="#EEEEEE">規格</th>
            <th bgcolor="#EEEEEE">預估單價</th> 
            <th bgcolor="#EEEEEE">數量</th>
            <th bgcolor="#EEEEEE">供應廠商</th>  
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <tr>
        	<th bgcolor="#EEEEEE"><?=($no+1)?></th>
            <td><?=$value['jec_product_id']?></td>
            <td><?=$value['name']?></td>
            <td><?=$value['specification']?></td>
            <td class="change_td" style="color:#FF0000;font-weight:bolder;"><?=(float)$value['price']?></td> 
            <td class="change_td" style="color:#FF0000;font-weight:bolder;">0</td>
            <td><?=$value['vendor_name']?></td>  
        </tr>  
        <?php endforeach;?>
</table>
</body>
</html>
