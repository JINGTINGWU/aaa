<?php
	$o_del_da=$this->ECPM->m_right_tag['del_da'];
	log_message('info','isset proj_data:'.isset($proj_data));
		if($proj_data['projstatus']==6):
			$o_del_da='disabled';
		endif;
	
			  if($o_del_da==''):
		  			$del_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $del_da = $o_del_da;
			  endif;
	
?>
<?php $this->load->view('common/page_bar_div_f',array('fpd'=>$fpd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="2">工作項目附件列表</td>
    	</tr>
        <tr>
        	<td  class="mm_table2_title2" <?=$fob=='filename'?'id="'.$fpd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('file_area_div','<?=$fpd['ob_filename_url']?>');">附件名稱</td>
            <td  id="detail-normal">刪除</td>        
        </tr>
        <?php foreach($file_list as $no=>$value):?>
        <tr id="ftr_<?=$no?>">
        	<td><a href="<?=$this->CM->DL_URL($value['jec_projfile_id'])?>" ><?=$value['filename']?></a></td>
            <td><input type="button" value="刪除附件" onclick="AWEA_Ajax('<?=site_url('ecp_common/delete_file/reload_file_list/'.$value['jec_projfile_id'].'/')?>','','del','ftr_<?=$no?>')" <?=$del_da?> ></td> 
        </tr>        
        <?php endforeach;?>
    </table>
