	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="7">料品清單與工作明細列表 <?=$main_op['excel_type']['op']?><input type="button" value="明細資料匯出Excel" class="mm_submit_button" onclick="pg_submit('export_excel');" style="width:130px;" ></td>
            <td colspan="8">電子表單狀況：<input type="button" value="即時更新" class="mm_submit_button" onclick="PG_BK_Action('refresh_purchase_status',{})" style="width:80px;" /></td>
    	</tr>
        <tr>
        	<td>選擇</td>
            <td>匯出</td>
            <!--<td>料號</td>-->
            <td>品名</td>  
            <td>規格</td>   
            <td>單位</td>  
            <td>數量</td>  
            <td>實際單價(未稅)</td>
            <td>含稅單價</td>
            <td>實際合計(未稅)</td>
            <td>需求日期</td>
            <td>採購廠商</td>
            <td>匯出日期</td>
            <td>修改</td>
            <td>表單流水號</td>
            <td>表單流程</td>               
        </tr>
        <?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			foreach($main_list as $no=>$value):?>
        	<?php
			$value['startdate']=substr($value['startdate'],0,10);
			$value['price']=(float)$value['price'];
			$value['quantity']=(float)$value['quantity'];
			//$ip_info['quantity']['type']='hidden';
			$value['jec_vendor_id_title']=$value['vendor_name'];
			$ip_info['jec_vendor_id_title']['onclick']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['onfocus']="PL_ChangePL('vendor_".$no."');";
			$ip_info['jec_vendor_id_title']['title']=$value['jec_vendor_id_title'];
			if($value['isexport']=='Y'):
				$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,array('disabled'=>'Y'));
			else:
				$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
			endif;
			
			//
			?>
        <tr id="tr_<?=$no?>">
        	<td><input type="checkbox" id="select_<?=$no?>" value="<?=$value['jec_projprod_id']?>" <?=$value['isexport']=='Y'?'disabled':''?> ></td>
            <td><img src="<?=base_url()?>images/<?=$value['isexport']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <!--<td><?=$value['value']?></td>-->
            <td><?=$value['prodname']?></td>  
            <td><?=$value['prodspec']?></td>   
            <td><span id='uom_id_<?=$no?>'><?=$uom_pdb[(int)$value['prod_uom_id']]?></span></td>  
            <td><?=$e_op['quantity']['op']?></td>  
            <td><?=$e_op['price']['op']?></td>
            <td align="right"><span id='taxprice_id_<?=$no?>'><?=round($value['price']*1.05)?></span></td>
            <td id="total_tag_<?=$no?>" align="right"><?=number_format((float)$value['total'],3,'.',',')?></td> 
            <td><?=$value['startdate']?></td>
            <td><?=$value['jec_vendor_id']>0?"<input type='hidden' id='jec_vendor_id_title_".$no."' value='".$value['jec_vendor_id_title']."'/>".$value['jec_vendor_id_title']:$e_op['jec_vendor_id_title']['op']?></td>
            <td><?=$value['exporttime']?></td>
            <td><input type="button" value="修改"  onclick="PG_BK_Action('update_projprod',{'projprod_id':'<?=$value['jec_projprod_id']?>','no':'<?=$no?>'})" class="mm_submit_button" <?=$this->ECPM->m_right_tag['up_da']?> <?=$value['isexport']=='Y'?'disabled':''?>  style="width:40px;" ></td>
            <td><?=$value['ad005003']?><!--<?=$value['exportcode']?>--></td>
            <td><?php if($value['resda020']==''&&$value['resda021']==''){ ?>未傳送/未完成<?php }else{ ?><?=$resda020_pdb[(int)$value['resda020']]?>/<?=$resda021_pdb[(int)$value['resda021']]?><?php }?></td>
        </tr>        
        <?php endforeach;?>
    </table>
