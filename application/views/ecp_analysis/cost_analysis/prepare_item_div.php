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
<div id="result_area_div"  class="mm_area_div_2" width="1500" style="width:1000px;">
	<table width="1000" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="3">履約備品清單分析表</td><td colspan="10"><?=$main_op['excel_type']['op']?><input type="button" value="匯出Excel" class="mm_submit_button" onclick="parent.PG_BK_Action('export_prep_excel');"  /></td>
    	</tr>
        <tr>
        	<td>項次</td>
            <td>品名</td>
            <td>規格</td>
            <td>預估數量</td>  
            <td>預估單價</td>   
            <td>預估成本</td> 
            <td>實際數量</td> 
            <td>實際單價</td> 
            <td>減折讓</td> 
            <td>實際成本</td> 
            <td>業務成本</td> 
            <td>預估-實際</td>
			<td>實際-業務</td>     
        </tr>
        <?php $predict_final=0; $actual_final=0; $real_final=0; $eno=0; $e_task=0; $real_quantity_final=0; $actual_quantity_final=0; $real_price_final=0; $actual_price_final=0; $totalsubtract_final=0; foreach($main_list as $value): $eno++; $real_total=$value['projprod_total']; $real_final+=$real_total; $predict_final+=$value['total']; ?>
        <tr>
        	<td><?=$eno?></td>
            <td><?=$value['prodname']?></td>
            <td><?=$value['prodspec']?></td>
            <td align="center"><?=(float)$value['quantity']?></td>  
            <td align="right"><?=number_format((float)$value['price'])?></td>   
            <td align="right"><?=number_format((float)$value['total'])?></td> 
            <td align="center"><?=(float)$value['projprod_quantity']?></td>
            <td align="right"><?=number_format((float)$value['projprod_price'])?></td>
            <td align="right"><?=number_format((float)$value['projprod_totalsubtract'])?></td>
            <td align="right"><?=(int)$value['jec_projprod_id']>0?number_format((float)$real_total):'-'?></td> 
            <td align="right">
			<?php
			$actual_quantity_final+=$value['quantity'];//預估數量加總
			$real_quantity_final+=$value['projprod_quantity'];//實際數量加總
			$actual_price_final+=$value['price'];//預估單價加總
			$real_price_final+=$value['projprod_price'];//實際單價加總
			if((int)$value['jec_projprod_id']>0):
				$actual_total=(int)$value['projprod_cost']>0?$value['projprod_cost']*$value['projprod_quantity']:$value['projprod_price']*$value['projprod_quantity'];
				$actual_total=$actual_total*$value['projprod_extramultiple']+$value['projprod_extraaddition'];
				//echo $value['projprod_actualcost']>0?$value['projprod_actualcost']*$value['quantity']:$value['projprod_price']*$value['quantity'];
				$actual_final+=(float)$actual_total;				
				echo number_format($actual_total);
			else:
				$actual_total='-';
				echo $actual_total;
			endif;				
				
			?>
			</td> 
            <td align="right">
            <?php
			if((int)$value['jec_projprod_id']>0):
				echo number_format($value['total']-(float)$real_total);
			endif;
			?>
            </td>
			<td align="right">
            <?php
			if((int)$value['jec_projprod_id']>0):
				echo number_format((float)$real_total-(float)$actual_total);
			endif;
			?>
            </td> 
        </tr> 
        <?php endforeach;?>
        <!--
        <tr>
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
        </tr>-->
        <tr>
        	<td>合計</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <!--<td align="center"><?=number_format($actual_quantity_final)?></td>-->
            <!--<td align="right"><?=number_format($actual_price_final)?></td> -->  
            <td align="right"><?=number_format($predict_final)?></td> 
            <!--<td align="center"><?=number_format($real_quantity_final)?></td>-->
            <!--<td align="right"><?=number_format($real_price_final)?></td>-->
            <td></td>
            <td></td>
            <td></td>          
            <td align="right"><?=number_format($real_final)?></td> 
            <td align="right"><?=number_format($actual_final)?></td> 
            <td align="right"><?=number_format($predict_final-$real_final)?></td>
			<td align="right"><?=number_format($real_final-$actual_final)?></td>  
        </tr>
    </table>

</div>  
</body>  
</html>