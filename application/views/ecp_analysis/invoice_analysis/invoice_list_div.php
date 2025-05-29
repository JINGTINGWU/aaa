<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4" class="mm_table2_title">專案發票明細列表</td><td colspan="2"><?=$main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='invoiceyear'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoiceyear_url']?>');">發票年度</td>
            <td class="mm_table2_title2" <?=$ob=='invoicedate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoicedate_url']?>');">發票日期</td>
            <td class="mm_table2_title2" <?=$ob=='customername'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_customername_url']?>');">客戶名稱</td>
<td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_name_url']?>');">專案名稱</td>
            <td class="mm_table2_title2" <?=$ob=='invoiceamount'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_invoiceamount_url']?>');">發票金額</td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</td>            
        </tr>
        <?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			 foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate']));
			$value['invoicedate']=substr($value['invoicedate'],0,10);
			$value['invoiceamount']=(float)$value['invoiceamount'];
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
			?>    
        <tr id="tr_<?=$no?>">
        	<td><?=$e_op['invoiceyear']['value']?></td>
            <td><?=$e_op['invoicedate']['value']?></td>
         	<td><?=$value['jec_customer_id']>0?$value['customer_name']:$value['customername']?></td>
            <td><?=$value['name']?></td>           
            <td><?=number_format($e_op['invoiceamount']['value'])?></td>
            <td><?=$e_op['description']['value']?></td>  
        </tr>     
        <?php endforeach;?>
    </table>