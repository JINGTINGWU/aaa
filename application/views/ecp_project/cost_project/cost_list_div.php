<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="6" class="mm_table2_title">專案費用明細列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='chargedate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_chargedate_url']?>');">費用日期</td>
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_name_url']?>');">費用名稱</td>
            <td class="mm_table2_title2" <?=$ob=='chargefee'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_chargefee_url']?>');">金額</td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</td>  
            <td id="detail-normal">修改</td>   
            <td id="detail-normal">刪除</td>            
        </tr>
        <?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate']));
			$value['chargedate']=substr($value['chargedate'],0,10);
			$value['chargefee']=(float)$value['chargefee'];
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
			?>        
        <tr id="tr_<?=$no?>">
        	<td><?=$e_op['chargedate']['op']?></td>
            <td><?=$e_op['jec_chargeitem_id']['op']?></td>
            <td><?=$e_op['chargefee']['op']?></td>
            <td><?=$e_op['description']['op']?></td>  
            <td><input type="button" value="確定修改"  onclick="PG_BK_Action('update_cost',{'projcharge_id':'<?=$value['jec_projcharge_id']?>','no':'<?=$no?>'})" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['up_da']?> ></td>   
            <td><input type="button" value="費用刪除" onclick="AWEA_Ajax('<?=site_url($var_purl.'project_cost_index/delete_cost/'.$value['jec_projcharge_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['del_da']?>></td> 
        </tr>      
            <script>
            cal.manageFields("chargedate_<?=$no?>", "chargedate_<?=$no?>", "%Y-%m-%d");
            </script>
        <?php endforeach;?>
    </table>
