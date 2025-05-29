<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ECPlant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<body>
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<div id="result_area_div"  class="mm_area_div_2" width="1500" style="width:1500px;">
	<table width="1500" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4">專案所有工作清單列表</td><td colspan="10"><?=$main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="parent.PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td>項次</td>
            <td>狀態/比率</td>
            <td>任務名稱</td>
            <td>工作項目</td>  
            <td>負責人員</td>   
            <td>工作日期</td> 
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
        <tr>
        	<td><?=$eno?></td>
            <td></td>
            <td><?=$sv1['row']['jobname']?></td>
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
        <tr>
        	<td><?=$eno?></td>
            <td><?=$sv2['row']['isfinish']=='Y'?'已完成':'未完成'?>/進度<label id="e_task_<?=$e_task?>"><?=$e_task_v?>%</label></td>
            <td></td>
            <td><?=$sv2['row']['taskname']?></td>  
            <td><?=$sv2['row']['sales_name']?></td>   
            <td><?=substr($sv2['row']['startdate'],0,10)?>~<?=substr($sv2['row']['enddate'],0,10)?></td> 
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
        <tr>
        	<td><?=$eno?></td>
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
            <td><?=$sv3['isexport']=='Y'?substr($sv3['exporttime'],0,10):'-'?></td>   
            <td><!--<?=$sv3['isworkflow']=='Y'?substr($sv3['workflowtime'],0,10):'-'?>--><?php if($sv3['resda020']==''&&$sv3['resda021']==''){ ?>未傳送/未完成<?php }else{ ?><?=$resda020_pdb[(int)$sv3['resda020']]?>/<?=$resda021_pdb[(int)$sv3['resda021']]?><?php }?></td> 
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