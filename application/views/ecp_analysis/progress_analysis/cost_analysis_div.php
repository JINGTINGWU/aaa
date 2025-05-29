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
<style>
.mm_mission_tr td{
	background:#D6D8E9;
}
</style>
<div id="result_area_div"  class="mm_area_div_2" width="700" style="width:700px;">
	<table width="700" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="3">專案所有工作成本分析列表</td><td colspan="4"><?=$main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="parent.PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td>項次</td>
            <td>任務名稱</td>
            <td>工作項目</td>  
            <td>預估成本</td> 
            <td>業務成本</td> 
            <td>成本差異</td>
			<td>備註</td>        
        </tr>
        <?php $full_assum_cost=0; $full_sale_cost=0; $now_job=0; $now_task=0; $eno=0; $e_task=0; foreach($main_list as $st1=>$sv1): $eno++;
			$now_job=$eno;
			$e_job_assum=0;
			$e_job_cost=0;
		?>
        <tr class="mm_mission_tr">
        	<td><?=$eno?></td>
            <td><?=$sv1['row']['jobname']?></td>
            <td></td> 
            <td id="job_assum_<?=$now_job?>" align="right"></td>  
            <td id="job_erp_<?=$now_job?>" align="right"></td>   
            <td id="job_deff_<?=$now_job?>" align="right"></td> 

            <td></td> 
      	<?php  foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; $now_task=$eno; ?>
        
        <tr>
        	<td><?=$eno?></td>
            <td></td>
            <td><?=$sv2['row']['taskname']?></td>  
            <td id="task_assum_<?=$now_task?>" align="right"></td> 
            <td id="task_erp_<?=$now_task?>" align="right"></td>      
            <td id="task_deff_<?=$now_task?>" align="right"></td>   
            <td></td> 
        </tr>
        		 <?php $e_count_prod_assum=0; $e_count_prod_cost=0; foreach($sv2['data'] as $sv3): /*$eno++;*/ ?>
                 <?php
				 	$e_count_prod_assum+=round($sv3['estimcostcalc']);//各別四捨五入
					$e_count_prod_cost+=round($sv3['salecostcalc']);//各別四捨五入
				 	if($sv3['isworkflow']=='Y') $e_prod_f++;
				 ?>
                 <?php endforeach;?>
                 
                 <?php
				 $e_total_prod=count($sv2['data']);
				 if($e_total_prod>0):
				 	$e_task_assum=$e_count_prod_assum;
					$e_task_cost=$e_count_prod_cost;
					$e_job_assum+=$e_task_assum;
					$e_job_cost+=$e_task_cost;
				 	//$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
				 else:
				 	$e_task_assum=$sv2['row']['price'];
					$e_task_cost=$sv2['row']['price'];
					$e_job_assum+=$e_task_assum;
					$e_job_cost+=$e_task_cost;					
				 	//$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0'; 
				 endif;
				 $e_task_deff=$e_task_assum-$e_task_cost;
				 ?>
                 <script>
                 	 document.getElementById('task_assum_<?=$now_task?>').innerHTML="<?=number_format($e_task_assum)?>";
					 document.getElementById('task_erp_<?=$now_task?>').innerHTML="<?=number_format($e_task_cost)?>";
					 document.getElementById('task_deff_<?=$now_task?>').innerHTML="<?=number_format($e_task_deff)?>";
                 </script>
             <?php endforeach;?>   
             <?php
			 $full_assum_cost+=$e_job_assum;
			 $full_sale_cost+=$e_job_cost;
			 ?>
                 <script>
                 	 document.getElementById('job_assum_<?=$now_job?>').innerHTML="<?=number_format($e_job_assum)?>";
					 document.getElementById('job_erp_<?=$now_job?>').innerHTML="<?=number_format($e_job_cost)?>";
					 document.getElementById('job_deff_<?=$now_job?>').innerHTML="<?=number_format($e_job_assum-$e_job_cost)?>";
                 </script>                  
        <?php endforeach;?>
        <tr>
        	<td>合計</td>
            <td></td>
            <td>預估成本合計</td>  
            <td align="right"><?=number_format($full_assum_cost)?></td> 
            <td  align="right"></td>      
            <td  align="right"></td>   
            <td></td> 
        </tr>
        <tr>
        	<td></td>
            <td></td>
            <td>業務成本合計</td>  
            <td align="right"></td> 
            <td  align="right"><?=number_format($full_sale_cost)?></td>      
            <td  align="right"></td>   
            <td></td> 
        </tr>
        <?php
		$multi_sale_cost=$full_sale_cost*(float)$proj_data['costrate'];
		?>
        <tr>
        	<td></td>
            <td></td>
            <td>業務成本*係數比率=<?=(float)$proj_data['costrate']?></td>  
            <td align="right"></td> 
            <td  align="right"><?=number_format($multi_sale_cost)?></td>      
            <td  align="right"></td>   
            <td></td> 
        </tr>
        <tr>
        	<td></td>
            <td></td>
            <td>成本差異合計</td>  
            <td align="right"></td> 
            <td  align="right"><?=number_format(($multi_sale_cost-$full_assum_cost))?></td>      
            <td  align="right"></td>   
            <td></td> 
        </tr>
    </table>

</div>  
</body>  
</html>