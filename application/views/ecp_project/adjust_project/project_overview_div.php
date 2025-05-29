<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ECPlant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<style type="text/css"> 
body {
	background-color: #FFFFFF;
	margin: 0 10px 0px 10px;
	font-family: "微軟正黑體", Verdana;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
	word-break: break-all;
}
.detail-div {
	width: 100%;
	background: #FFFFFF;
	border: 1px solid #BBDDE5;
	margin: 10px 0 0 0;
	-webkit-text-size-adjust:none;
}
.detail-div table {
	width: 100%;
	border: 1px solid #7B9AB5;
}

.detail-div tr:hover td {
	background: #FFFFDE;
}
.detail-div tr:first-child td {
	background: #8496AD;
	color: #FFFFFF;
	font-weight: bold;
	padding-left: 15px;
	text-decoration: None;
	background-image: url('../images/title_mark.gif');
	background-size: 9px 26px;
	background-repeat: no-repeat;
}
.detail-div tr:nth-child(2) td {
	background: #6B9AB5;
	color: #FFFFFF;
	font-weight: bold;
}
.detail-div td {	
	line-height: 20px;
}
</style>
<body>
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<div id="result_area_div"  class="mm_area_div_2" width="1500" style="width:1500px;">
	<table width="1500" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="15">專案所有工作清單列表</td>
    	</tr>
        <tr bgcolor="#E7EBF7">
        	<td>項次</td>
            <td>狀態/比率</td>
            <td>任務名稱</td>
            <td>工作名稱</td>  
            <td>負責人員</td>   
            <td>工作日期</td>
            <td>督導人</td> 
            <td>完成狀態</td> 
            <td>完成日期</td> 
            <td>料品與工作明細</td>
			<td>數量*單價=金額</td> 
            <td>需求日期</td> 
            <td>採購廠商</td>      
            <td>匯出表單</td>   
            <td>流程完成</td>           
        </tr>
        <?php $eno=0; $e_task=0; foreach($main_list as $st1=>$sv1): $eno++; ?>
        <tr bgcolor="#E7EBF7">
        	<td><?=$eno?></td>
            <td></td>
            <td><a target=_parent href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/job_list_index/list/<?=$sv1['row']['jec_project_id']?>/created/asc/0/-1'><?=$sv1['row']['jobname']?></a></td>
            <td></td>  
            <td></td>   
            <td></td>
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td>
			<td></td> 
            <td></td> 
            <td></td>      
            <td></td>   
            <td></td> 
        </tr>
        	 <?php  foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; ?>
        <tr bgcolor="<?=$sv2['row']['isfinish']=='Y'?'#DAFF7F':'#E7EBF7'?>">
        	<td><?=$eno?></td>
            <td>
			<?php if($sv2['row']['projtasktype']=='6'): echo '已完成';
			elseif($sv2['row']['projtasktype']=='4'): echo '已廢止';
			elseif($sv2['row']['projtasktype']=='5'): echo '已暫停';
			else: echo '未完成'; 
			endif;
			?>
            /進度<label id="e_task_<?=$e_task?>"><?=$e_task_v?>%</label></td>
            <td></td>
            <td><a target=_parent href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/task_list_index/target/<?=$sv2['row']['jec_projjob_id']?>/created/asc/0/-1.html/<?=$sv2['row']['jec_projtask_id']?>'><?=$sv2['row']['taskname']?></a></td>  
            <td><?=$sv2['row']['sales_name']<>''?$sv2['row']['sales_name']:$sv2['row']['group_name']?></td>   
            <td><?=substr($sv2['row']['startdate'],0,10)?>~<?=substr($sv2['row']['enddate'],0,10)?></td>
            <td><?=$sv2['row']['super_name']?></td> 
            <td><?=$sv2['row']['isfinish']=='Y'?'已完成':'未完成'?></td> 
            <td><?=$sv2['row']['isfinish']=='Y'?substr($sv2['row']['finishdate'],0,10):''?></td> 
            <td></td>
			<td></td> 
            <td></td> 
            <td></td>      
            <td></td>   
            <td></td> 
        </tr>
        		 <?php foreach($sv2['data'] as $sv3): $eno++; ?>
                 <?php
				 	if($sv3['isworkflow']=='Y') $e_prod_f++;
				 ?>
        <tr bgcolor="<?=$sv2['row']['isfinish']=='Y'?'#DAFF7F':'#E7EBF7'?>">
        	<td><?=$eno?></td>
            <td></td>
            <td></td>
            <td></td>  
            <td></td>   
            <td></td>
            <td></td> 
            <td></td> 
            <td></td> 
            <td><?=$sv3['prodname']?></td>
			<td><?=(float)$sv3['quantity']?>*<?=(float)$sv3['price']?>=<?=(float)$sv3['total']?></td> 
            <td><?=substr($sv3['startdate'],0,10)?></td> 
            <td><?=$sv3['vendor_name']?></td>      
            <td><?=$sv3['exporttime']=='0000-00-00 00:00:00'?'':date('Y-m-d',strtotime($sv3['exporttime']))?></td>   
            <td><!--<?=$sv3['isworkflow']?>-date--><?php if($sv3['resda020']==''&&$sv3['resda021']==''){ ?>未傳送/未完成<?php }else{ ?><?=$resda020_pdb[(int)$sv3['resda020']]?>/<?=$resda021_pdb[(int)$sv3['resda021']]?><?php }?></td> 
        </tr> 
                 <?php endforeach;?>
                 <?php
				 $e_total_prod=count($sv2['data']);
				 if($e_total_prod>0):
				 	$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
				 else:
				 	$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0';
				 endif;
				 ?>
                 <script>
                 	 document.getElementById('e_task_<?=$e_task?>').innerHTML="<?=$e_task_v?>%";
                 </script>
             <?php endforeach;?>        
        <?php endforeach;?>
    </table>

</div>  
</body>  
</html>