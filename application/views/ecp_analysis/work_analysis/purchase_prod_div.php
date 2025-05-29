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
<div id="result_area_div"  class="mm_area_div_2" width="870" style="width:870px;">
	<table width="870" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="10"></td>
    	</tr>
        <tr>
        	<td>項次</td>
            <td>品名</td>
            <td>規格</td>
            <td>數量</td>  
            <td>單位</td>   
            <td>單價</td> 
            <td>小計</td> 
            <td>人員</td> 
            <td>備註</td>
			<td>稅後金額</td>          
        </tr>
		<?php $min_time=time()+999999999; $have_time='N'; $amt=0; $eno=0; foreach($main_list as $no=>$value):?>
        <?php if(in_array($value['jec_projprod_id'],$prod_array)): $eno++; $amt+=round($value['total']*1.05,0); ?>
        <?php if((int)$value['jec_vendor_id']>0) $now_vendor_id=$value['jec_vendor_id']; ?>
        <?php
			if($value['startdate']!='0000-00-00 00:00:00'&&strtotime($value['startdate'])<=$min_time):
				$have_time='Y';
				$min_time=&strtotime($value['startdate']);
			endif; 
		?>
        <tr>
            <td><?=$eno?></td>   
            <td><?=$value['name']?></td> 
            <td><?=$value['specification']?></td> 
            <td><?=$value['quantity']?></td> 
            <td><?=$uom_pdb[$value['jec_uom_id']]?></td>
			<td><?=(float)$value['price']?></td> 
            <td><?=(float)$value['total']?></td> 
            <td><?=$p_user['value'].'-'.$p_user['name']?></td>      
            <td><?=$value['description']?></td>   
            <td><?=round($value['total']*1.05)?></td> 
        </tr>
        <?php endif;?>
		<?php endforeach;?>
    </table>

</div>  
<?php
$final_time=$have_time=='Y'?$min_time:time();
$amt_title=$this->CM->FormatData(array('num'=>$amt),'number','ch_num');
?>
<script>
	parent.document.getElementById('ad005038').value="<?=$amt?>";
	parent.document.getElementById('ad005018').value="<?=$amt?>";
	parent.document.getElementById('fix_price').value="<?=$amt?>";
	parent.document.getElementById('ad005009').value="<?=date('Y/m/d',$final_time)?>";
	parent.document.getElementById('ad005017').value="<?=$amt_title?>";

	parent.document.getElementById('prod_string').value="<?=$prod_string?>";
	<?php if(isset($now_vendor_id)):?>
	parent.document.getElementById('ad005005').value="<?=$now_vendor_id?>";
	parent.document.getElementById('ad005005_title').value="<?=$this->GM->GetSpecData('jec_vendor','name','jec_vendor_id',$now_vendor_id)?>";
	<?php endif;?>
</script>
</body>  
</html>
