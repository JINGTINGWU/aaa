<?php $this->load->view('common/page_bar_div_f',array('fpd'=>$fpd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4" class="mm_table2_title">追加附件列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$fob=='created'?'id="'.$fpd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('file_area_div','<?=$fpd['ob_created_url']?>');">追加日期</td>
            <td class="mm_table2_title2" <?=$fob=='filename'?'id="'.$fpd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('file_area_div','<?=$fpd['ob_filename_url']?>');">附件名稱</td>
            <td class="mm_table2_title2" <?=$fob=='uploader_name'?'id="'.$fpd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('file_area_div','<?=$fpd['ob_uploader_name_url']?>');">上傳者</td>
            <td id="detail-normal">刪除</td>                
        </tr>
        <?php foreach($file_list as $no=>$value):?>
        <tr id="ftr_<?=$no?>">
        	<td>追加日期-關聯到…</td>
            <td><a href="<?=$this->CM->DL_URL($value['jec_projfile_id'])?>" ><?=$value['filename']?></a></td>
            <td><?=$value['uploader_name']?></td>
            <td><input type="button" value="刪除附件" onclick="AWEA_Ajax('<?=site_url('ecp_common/delete_file/reload_file_list/'.$value['jec_projfile_id'].'/')?>','','del','ftr_<?=$no?>')"  class="mm_submit_button" <?=$this->ECPM->m_right_tag['up_da']?> ></td>    
        </tr>        
        <?php endforeach;?>
    </table>