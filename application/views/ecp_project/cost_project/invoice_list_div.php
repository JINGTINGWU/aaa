<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="6" class="mm_table2_title">專案發票明細列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='invoiceyear'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoiceyear_url']?>');">發票年度</td>
            <td class="mm_table2_title2" <?=$ob=='invoicedate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoicedate_url']?>');">發票日期</td>
            <td class="mm_table2_title2" <?=$ob=='invoiceamount'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoiceamount_url']?>');">金額</td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</td>  
            <td id="detail-normal">修改</td>   
            <td id="detail-normal">刪除</td>            
        </tr>
        <?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			 foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate']));
			
			$ip_info['invoiceyear']['ld']=$this->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>($value['invoiceyear']-4),'en'=>($value['invoiceyear']+4)),"page_db","num");
			$value['invoicedate']=substr($value['invoicedate'],0,10);
			$value['invoiceamount']=(float)$value['invoiceamount'];
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
			?>    
        <tr id="tr_<?=$no?>">
        	<td><?=$e_op['invoiceyear']['op']?></td>
            <td><?=$e_op['invoicedate']['op']?></td>
            <td><?=$e_op['invoiceamount']['op']?></td>
            <td><?=$e_op['description']['op']?></td>  
            <td><input type="button" value="確定修改"  onclick="PG_BK_Action('update_invoice',{'projinvoice_id':'<?=$value['jec_projinvoice_id']?>','no':'<?=$no?>'})" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['up_da']?> ></td>   
            <td><input type="button" value="發票刪除" onclick="AWEA_Ajax('<?=site_url($var_purl.'project_invoice_index/delete_invoice/'.$value['jec_projinvoice_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['del_da']?>></td> 
        </tr>     
            <script>
            cal.manageFields("invoicedate_<?=$no?>", "invoicedate_<?=$no?>", "%Y-%m-%d");
            </script>  
        <?php endforeach;?>
    </table>