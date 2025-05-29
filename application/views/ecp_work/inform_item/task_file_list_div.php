<?php $this->load->view('common/page_bar_div_f',array('fpd'=>$fpd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="2">工作項目附件列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$fob=='filename'?'id="'.$fpd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>  onclick="ECP_Load_Div('file_area_div','<?=$fpd['ob_filename_url']?>');">附件名稱</td>
            <td  id="detail-normal">上傳日期</td>
        </tr>
        <?php foreach($file_list as $no=>$value):?>
        <tr id="ftr_<?=$no?>">
        	<td><a href="<?=$this->CM->DL_URL($value['jec_projfile_id'])?>" ><?=$value['filename']?></a></td>
            <td><?=$value['created']?></td>            
        </tr>        
        <?php endforeach;?>
    </table>
