<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<body>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="10" class="mm_table2_title"></td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2"  id="detail-normal">選擇</td>
        	<td class="mm_table2_title2" id="detail-normal">品名</td>
            <td class="mm_table2_title2"  id="detail-normal">規格</td>
            <td class="mm_table2_title2" id="detail-normal">單位</td>      
            <td class="mm_table2_title2" id="detail-normal">預估數量</td>
            <td class="mm_table2_title2" id="detail-normal">預估單價</td>
            <td class="mm_table2_title2" id="detail-normal">預估合計</td>
            <td class="mm_table2_title2" id="detail-normal">需求日期</td>
            <td class="mm_table2_title2" id="detail-normal">採購廠商</td>
            <td class="mm_table2_title2" id="detail-normal">備註說明</td>               
        </tr>
        <?php foreach($main_list as $no=>$value):?>
         <tr>
        	<td ><?php if($value['isexport']!='Y'):?><input type="checkbox" id="select_<?=$no?>" value="<?=$value['jec_productprep_id']?>" /><?php endif;?></td>
        	<td ><?=$value['prodname']?></td>
            <td ><?=$value['prodspec']?></td>
            <td >
			<?php $uom_set=$this->CM->Init_TB_Set('mm_uom_set');
			$final['uom_pdb']=$this->CM->FormatData(array('db'=>$this->GM->common_ac('list',array('info'=>$uom_set['mm_set'],'type'=>'def','data'=>array('isactive'=>'Y'))),'key'=>'jec_uom_id','vf'=>'name'),'page_db',1);
			if($value['prod_uom_id']>0)
			echo($this->CM->pdb_trans($final['uom_pdb'][$value['prod_uom_id']]));?>
            </td>      
            <td ><?=$value['quantity']?></td>
            <td ><?=$value['price']?></td>
            <td ><?=number_format($value['total'])?></td>
            <td ><?=substr($value['startdate'],0,10)?></td>
            <td ><?=$value['vendor_name']?></td>
            <td ><?=$value['description']?></td>               
        </tr>       	
        <?php endforeach;?>
    </table>
    <div align="center">
    	<input type="button" value="選擇的料品已確定" onclick="import_selected_item();" />
        <input type="button" value="取消" onclick="parent.thick_box('close')" />
    </div>
</body>
<script><!-- Call Back 弓詮 -->
	function import_selected_item()
	{	
		if(confirm("確定匯入選擇的料品?")){
			var select_num=parseInt('<?=$no?>');
			var select_string="";
			for(i=0;i<=select_num;i++){
				if($("#select_"+i).length>0){
					if(document.getElementById('select_'+i).checked==true){
						select_string=select_string+','+document.getElementById('select_'+i).value;
					}
				}
			}
			select_string=select_string.substr(1);
			parent.PG_BK_Action('import_selected_item',{select_string:select_string,project_id:'<?=$value['jec_project_id']?>'});
		}
	}
</script>
</html>
