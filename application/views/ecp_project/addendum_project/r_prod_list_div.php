<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="13" class="mm_table2_title">專案追減明細列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='addsubdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_addsubdate_url']?>');">追減日期</td>
            <td class="mm_table2_title2" <?=$ob=='addsubtype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_addsubtype_url']?>');">追減類型</td>
            <td class="mm_table2_title2" <?=$ob=='value'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_value_url']?>');">料號</td>
            <td <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_name_url']?>');">品名</td>  
            
            <td <?=$ob=='quantity'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_quantity_url']?>');">數量</td>  
            <td <?=$ob=='price'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_price_url']?>');">單價</td>
            <td <?=$ob=='total'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_total_url']?>');">合計</td>
            <td class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');">備註說明</td>
            <td id="detail-normal">修改</td>
            <td id="detail-normal">附件</td>
            <td id="detail-normal">刪除</td>               
        </tr>
        <?php 
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=date('Y-m-d',strtotime($value['startdate']));
			$value['addsubdate']=substr($value['addsubdate'],0,10);
			$value['price']=(float)$value['price'];
			$value['quantity']=(float)$value['quantity'];
			$ip_info['oppro_uom']['ld']=$uom_ld;
			
			$value['oppro_name']=$value['name'];
			$value['oppro_value']=$value['value'];
			$value['oppro_specification']=$value['specification'];
			$value['oppro_uom']=$value['jec_uom_id'];
			
			$e_op=$this->form_input->each_op_trans('full',$ip_info,$value,'_'.$no,$full_set);
			?>
        <tr id="tr_<?=$no?>">
        	<td><?=$e_op['addsubdate']['op']?></td>
            <td><?=$addsubtype_pdb[$value['addsubtype']]?></td>
            <td><?=(int)$value['jec_productopen_id']>0?$e_op['oppro_value']['op']:$value['value']?></td>
            <td><?=(int)$value['jec_productopen_id']>0?$e_op['oppro_name']['op']:$value['name']?></td>              
            <td><?=$e_op['quantity']['op']?></td>  
            <td><?=$e_op['price']['op']?></td>
            <td id="total_tag_<?=$no?>"><?=number_format((float)$value['total'])?></td>
            <td><?=$e_op['description']['op']?></td>
            <td><input type="button" value="修改" onclick="PG_BK_Action('update_projprod',{'projaddsub_id':'<?=$value['jec_projaddsub_id']?>','no':'<?=$no?>'})" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['up_da']?> ></td>
            <td><input type="button" value="上傳" onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div/reduce_prod_list/'.$value['jec_project_id'].'/reload_file_list/')?>')"  class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['up_da']?> ></td>
            <td><input type="button" value="刪除" onclick="AWEA_Ajax('<?=site_url($var_purl.'add_detail_index/delete_projprod/'.$value['jec_projaddsub_id'].'/'.$var_surl)?>','','del','tr_<?=$no?>')" class="mm_submit_button_1" <?=$this->ECPM->m_right_tag['del_da']?>></td>  
        </tr>     
            <script>
            cal.manageFields("addsubdate_<?=$no?>", "addsubdate_<?=$no?>", "%Y-%m-%d");
            </script>
        <?php endforeach;?>
    </table>