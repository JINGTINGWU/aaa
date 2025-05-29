<?php
	$o_up_da=$this->ECPM->m_right_tag['up_da'];
	$o_del_da=$this->ECPM->m_right_tag['del_da'];
	if($proj_data['projstatus']==6):
		$o_up_da='disabled';
		$o_del_da='disabled';
	endif;
			  if($o_up_da==''):
		  			$up_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $up_da = $o_up_da;
			  endif;
			  if($o_del_da==''):
		  			$del_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $del_da = $o_del_da;
			  endif;
$mm_work_style='style="background:#D7EBF7;"';
?>
<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="16" class="mm_table2_title">料品清單與工作明細列表 
            <input type="button" value="全部清單" class="mm_submit_button"  onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_full_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='full'?'disabled':''?>  />
            <input type="button" value="料品清單"  class="mm_submit_button" onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_prod_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='prod'?'disabled':''?> />
            <input type="button" value="工作明細清單"  class="mm_submit_button"  onclick="ECP_Load_Div('result_area_div','<?=$pd['vt_work_url']?>');" <?=$_SESSION[$pg_tag]['view_type']=='work'?'disabled':''?>  />
            &nbsp; <?=$main_op['excel_type']['op']?><input type="button" value="明細資料匯出Excel" class="mm_submit_button"  onclick="pg_submit('export_excel');" />

            </td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='seqno'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_seqno_url']?>');">排序</a></td>
            <!--<td class="mm_table2_title2" <?=$ob=='value'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_value_url']?>');">料號</a></td>-->
            <td class="mm_table2_title2" width="120" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_name_url']?>');">品名</a></td>
            <td class="mm_table2_title2" <?=$ob=='specification'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_specification_url']?>');">規格</a></td>     
            <td class="mm_table2_title2" <?=$ob=='jec_uom_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jec_uom_id_url']?>');">單位</a></td>   
            <td class="mm_table2_title2" <?=$ob=='quantity'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_quantity_url']?>');">實際數量</a></td> 
            <td class="mm_table2_title2" <?=$ob=='price'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_price_url']?>');">實際單價</a></td> 
            <td class="mm_table2_title2" <?=$ob=='totalsubtract'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_totalsubtract_url']?>');">減折讓</a></td>   
            <td class="mm_table2_title2" <?=$ob=='total'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_total_url']?>');">合計</a></td> 
            <td class="mm_table2_title2" <?=$ob=='extramultiple'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_extramultiple_url']?>');">倍數</a></td>
            <td class="mm_table2_title2" <?=$ob=='extraaddition'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_extraaddition_url']?>');">加成</a></td>
            <td class="mm_table2_title2" <?=$ob=='salecostcalc'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_salecostcalc_url']?>');">業務成本</a></td>
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_startdate_url']?>');">需求日期</a></td>
			<td class="mm_table2_title2" <?=$ob=='vendor_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_vendor_name_url']?>');">採購廠商</a></td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</a></td> 
            <td class="mm_table2_title2" id="detail-normal">修改</td> 
            <td class="mm_table2_title2" id="detail-normal">刪除</td>   
      
        </tr>
        <?php 
			$full_set=$up_da==''?array():array('disabled'=>'Y');
			$ip_info['description']['style']="width:70px;";
			$ip_info['prod_uom_id']['style']="width:40px;";
			//$ip_info['prod_uom_id']['full_selected']="N";
			$ip_info['prodspec']['style']="width:80px;";
			$ip_info['extraaddition']['style']="width:50px;";
			$ip_info['jec_vendor_id_title']['style']="width:60px;";
			foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate']));
			$value['startdate']=substr($value['startdate'],0,10);
			$value['price']=(float)$value['price'];
			$value['quantity']=(float)$value['quantity'];
			$value['extramultiple']=(float)$value['extramultiple'];
			$value['extraaddition']=(float)$value['extraaddition'];
			$ip_info['quantity']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			$ip_info['price']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			
			$ip_info['oppro_uom']['ld']=$uom_ld;
			$value['jec_vendor_id_title']=$value['vendor_name'];
			$ip_info['jec_vendor_id_title']['onclick']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['onfocus']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['title']=$value['jec_vendor_id_title'];
			
			$value['oppro_name']=$value['name'];
			$value['oppro_value']=$value['value'];
			$value['oppro_specification']=$value['specification'];
			$value['oppro_uom']=$value['jec_uom_id'];
			
			$ip_info['extramultiple']['onchange']="PG_BK_Action('recount_row_cost','".$no."');";
			$ip_info['extraaddition']['onchange']="PG_BK_Action('recount_row_cost','".$no."');";
			$ip_info['quantity']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			$ip_info['price']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
			$ip_info['totalsubtract']['onchange']="PG_BK_Action('change_prod_pq','".$no."');";
						
			$e_full_set=$full_set;
			if($value['isexport']=='Y') $e_full_set=array('disabled'=>'Y');
			
			$ip_info['cost_total']=array(
					'call_name'=>'cost_total',
					'type'=>'hidden'
				);
			$value['cost_total']=$value['cost']*$value['quantity'];
			$ip_info['prodspec']['type']=$value['prodtype']==9?'hidden':'text';
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$e_full_set);
			if(($value['jec_product_id']==0||$value['jec_productopen_id']>0) && $value['jec_productprep_id']==''):
				$isUserKey='Y';
			else:
				$isUserKey='N';
			endif;
			?>
        <tr id="tr_<?=$no?>">
        	<td <?=$value['prodtype']==9?$mm_work_style:''?>><input type="hidden" id="prodtype_<?=$no?>" value="<?=$value['prodtype']?>" />
            <?php if($ob=='seqno'&&$up_da==''):?>
            <img src="<?=base_url()?>images/up.gif"  onclick="AWEA_Ajax('<?=site_url($var_purl.'prod_list_index/move_up/'.$value['jec_projprod_id'].'/'.$var_surl)?>','')" />&nbsp;<img src="<?=base_url()?>images/down.gif" onclick="AWEA_Ajax('<?=site_url($var_purl.'prod_list_index/move_down/'.$value['jec_projprod_id'].'/'.$var_surl)?>','')" />
            <?php endif;?>
            </td>
            <!--<td <?=$value['prodtype']==9?$mm_work_style:''?>><?=(int)$value['jec_productopen_id']>0?$e_op['oppro_value']['op']:$value['value']?></td>-->
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$isUserKey=='Y'?$e_op['prodname']['op']:"<input type='hidden' id='prodname_".$no."' name='prodname_".$no."' value='".$value['prodname']."'/>".$value['prodname']?></td>
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$isUserKey=='Y'?$e_op['prodspec']['op']:$value['prodspec']?></td>  
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$isUserKey=='Y'?$e_op['prod_uom_id']['op']:"<input type='hidden' id='prod_uom_id_".$no."' name='prod_uom_id_".$no."' value='".$value['prod_uom_id']."'/>".$uom_pdb[(int)$value['prod_uom_id']]?></td>  
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['quantity']['op']?></td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['price']['op']?></td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['totalsubtract']['op']?><?=$e_op['cost']['op']?></td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?> id="total_tag_<?=$no?>"><?=(float)$value['total']?></td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['extramultiple']['op']?></td>
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['extraaddition']['op']?><?=$e_op['cost_total']['op']?></td>
            <!--<td <?=$value['prodtype']==9?$mm_work_style:''?> id="estimcostcalc_tag_<?=$no?>"><?=(float)$value['estimcostcalc']?></td>-->
            <td <?=$value['prodtype']==9?$mm_work_style:''?> id="salecostcalc_tag_<?=$no?>"><?=$value['prodtype']==9?'-':(float)$value['salecostcalc']?></td>
            <td <?=$value['prodtype']==9?$mm_work_style:''?>><?=$e_op['startdate']['op']?></td>
			<td <?=$value['prodtype']==9?$mm_work_style:''?> id="jec_vendor_id_title_lb_<?=$no?>"><?=$value['jec_vendor_id']>0?"<input type='hidden' id='jec_vendor_id_title_".$no."' value='".$value['jec_vendor_id_title']."'/>".$value['jec_vendor_id_title']:$e_op['jec_vendor_id_title']['op']?></td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>>
			<?=$e_op['description']['op']?>
            </td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>>
            <?php if($value['isexport']=='N'):?>
            <input type="button" value="修改"  onclick="PG_BK_Action('update_projprod',{'projprod_id':'<?=$value['jec_projprod_id']?>','no':'<?=$no?>'})" class="mm_submit_button_1" <?=$up_da?> >
            <?php endif;?>
            </td> 
            <td <?=$value['prodtype']==9?$mm_work_style:''?>>
            <?php if($value['isexport']=='N'):?>
            <input type="button" value="刪除" onclick="AWEA_Ajax('<?=site_url($var_purl.'prod_list_index/delete_projprod/'.$value['jec_projprod_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1" <?=$del_da?>>
            <?php endif;?>
            </td>  
             
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