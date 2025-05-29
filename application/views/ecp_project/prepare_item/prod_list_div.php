<?php

	$up_da=$this->ECPM->m_right_tag['up_da'];
	$del_da=$this->ECPM->m_right_tag['del_da'];
	if($proj_data['projstatus']==6):

		$up_da='disabled';
		$del_da='disabled';
	endif;
$mm_work_style='style="background:#D7EBF7;"';
?>
<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="14" class="mm_table2_title">履約備品清單<!-- 
            <input type="button" value="全部清單" class="mm_submit_button"  onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_full_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='full'?'disabled':''?>  />
            <input type="button" value="料品清單"  class="mm_submit_button" onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_prod_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='prod'?'disabled':''?> />
            <input type="button" value="工作明細清單"  class="mm_submit_button"  onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_work_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='work'?'disabled':''?>  />
            
&nbsp; <?=$main_op['excel_type']['op']?><input type="button" value="明細資料匯出Excel" class="mm_submit_button"  onclick="pg_submit('export_excel');" />-->
            </td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='seqno'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_seqno_url']?>');">排序</a></td>
            <td class="mm_table2_title2" <?=$ob=='value'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_value_url']?>');">料號</a></td>
            <td class="mm_table2_title2" width="120" <?=$ob=='prodname'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_prodname_url']?>');">品名</a></td>
            <td class="mm_table2_title2" <?=$ob=='prodspec'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_prodspec_url']?>');">規格</a></td>   
            <td class="mm_table2_title2" <?=$ob=='prod_uom_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_prod_uom_id_url']?>');">單位</a></td>   
            <td class="mm_table2_title2" <?=$ob=='quantity'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_quantity_url']?>');">預估數量</a></td> 
            <td class="mm_table2_title2" <?=$ob=='price'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_price_url']?>');">預估單價(未稅)</a></td> 
            <td class="mm_table2_title2" <?=$ob=='total'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_total_url']?>');">預估合計</a></td>  
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_startdate_url']?>');">需求日期</a></td>
			<td class="mm_table2_title2" <?=$ob=='jec_user_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jec_user_id_url']?>');">採購人員</a></td> 
			<td class="mm_table2_title2" <?=$ob=='vendor_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_vendor_name_url']?>');">採購廠商</a></td> 
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</a></td> 
            <td class="mm_table2_title2" id="detail-normal">修改</td> 
            <td class="mm_table2_title2" id="detail-normal">刪除</td>          
        </tr>
        <?php //Working. 
			if($proj_data['exportcode']!=''){ $up_da="disabled"; $del_da="disabled"; }
			$full_set=$up_da==''?array():array('disabled'=>'Y');
			$ip_info['description']['style']="width:70px;";
			$ip_info['prod_uom_id']['style']="width:40px;";
			//$ip_info['prod_uom_id']['full_selected']="N";
			$ip_info['prodspec']['style']="width:80px;";
			//$ip_info['extraaddition']['style']="width:50px;"; 
			$ip_info['jec_vendor_id_title']['style']="width:60px;";
			$ip_info['jec_user_id_title']['style']="width:60px;";
			 foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate'])); -
			$value['startdate']=substr($value['startdate'],0,10);
			$value['price']=(float)$value['price'];
			$value['quantity']=(float)$value['quantity'];
			//$value['extramultiple']=(float)$value['extramultiple'];
			//$value['extraaddition']=(float)$value['extraaddition'];
			$ip_info['quantity']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			$ip_info['price']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			
			$ip_info['oppro_uom']['ld']=$uom_ld;
			$value['jec_vendor_id_title']=$value['vendor_name'];
			$ip_info['jec_vendor_id_title']['onclick']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['onfocus']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['title']=$value['jec_vendor_id_title'];
			
			$value['jec_user_id_title']=$value['purchasing_user'];
			$ip_info['jec_user_id_title']['onclick']="PL_ChangePL('user_".$no."');";
			$ip_info['jec_user_id_title']['onfocus']="PL_ChangePL('user_".$no."');";
			$ip_info['jec_user_id_title']['title']=$value['jec_user_id_title'];
			
			$value['prodname']=htmlentities($value['prodname'],ENT_QUOTES,"utf-8");
			$value['oppro_name']=$value['prodname'];
			$value['oppro_value']=$value['value'];
			$value['oppro_specification']=$value['prodspec'];
			$value['oppro_uom']=$value['prod_uom_id'];
			
			//$ip_info['extramultiple']['onchange']="PG_BK_Action('recount_row_cost','".$no."');";
			//$ip_info['extraaddition']['onchange']="PG_BK_Action('recount_row_cost','".$no."');";
			
			$e_full_set=$full_set;
			if($value['isexport']=='Y') $e_full_set=array('disabled'=>'Y');
			
			$ip_info['cost_total']=array(
					'call_name'=>'cost_total',
					'type'=>'hidden'
				);
			//$value['cost_total']=$value['cost']*$value['quantity'];
			//$ip_info['prodspec']['type']=$value['prodtype']==9?'hidden':'text';
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$e_full_set);
			$isUserKey='Y';
			
			/*
			if($value['jec_product_id']==0||$value['jec_productopen_id']>0):
				$isUserKey='Y';
			else:
				$isUserKey='N';
			endif;*/
			?>
        <tr id="tr_<?=$no?>">
        	<td ><input type="hidden" id="prodtype_<?=$no?>" value="9" />
            <?php if($ob=='seqno'&&$up_da==''):?>
            <img src="<?=base_url()?>images/up.gif"  onclick="AWEA_Ajax('<?=site_url($var_purl.$tag.'/move_up/'.$value['jec_productprep_id'].'/'.$var_surl)?>','')" />&nbsp;<img src="<?=base_url()?>images/down.gif" onclick="AWEA_Ajax('<?=site_url($var_purl.$tag.'/move_down/'.$value['jec_productprep_id'].'/'.$var_surl)?>','')" />
            <?php endif;?>
            </td>
            <td ><?=$value['jec_product_id']>0?$value['oppro_value']:$e_op['oppro_value']['op']?></td>
            <td ><?=$value['jec_product_id']>0?$value['prodname']:$e_op['prodname']['op']?></td>
            <td ><?=$value['jec_product_id']>0?$value['prodspec']:$e_op['prodspec']['op']?></td>  
            <td ><?=$e_op['prod_uom_id']['op']?></td>   
            <td ><?=$e_op['quantity']['op']?></td> 
            <td><?=$e_op['price']['op']?></td> 
            <td  id="total_tag_<?=$no?>"><?=(float)$value['total']?></td> 
            <td ><?=$e_op['startdate']['op']?></td>
			<td  id="jec_user_id_title_lb_<?=$no?>"><?=$e_op['jec_user_id']['op']?><?=$e_op['jec_user_id_title']['op']?></td> 
			<td  id="jec_vendor_id_title_lb_<?=$no?>"><?=$e_op['jec_vendor_id']['op']?><?=$e_op['jec_vendor_id_title']['op']?></td> 
            <td ><?=$e_op['description']['op']?></td> 
            <td ><input type="button" value="修改"  onclick="PG_BK_Action('update_projprod',{'projprod_id':'<?=$value['jec_productprep_id']?>','no':'<?=$no?>','value':'<?=$value['oppro_value']?>','prodname':'<?=$value['prodname']?>','prodspec':'<?=htmlentities($value['prodspec'])?>'})" class="mm_submit_button_1"  <?=$up_da?> ></td> 
            <td ><input type="button" value="刪除" onclick="AWEA_Ajax('<?=site_url($var_purl.'item_detail_index/delete_projprod/'.$value['jec_productprep_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1"  <?=$del_da?>></td>  
            <script>
            cal.manageFields("startdate_<?=$no?>", "startdate_<?=$no?>", "%Y-%m-%d");
            </script>
        </tr>        
        <?php endforeach;?>
    </table>
<script>
	document.getElementById('prodtype_string').value="<?=$_SESSION[$pg_tag]['view_type']?>";
	if(typeof PG_BK_Action == 'function'){
		PG_BK_Action('prod_search_prodtype','<?=$_SESSION[$pg_tag]['view_type']?>');
	}
</script>