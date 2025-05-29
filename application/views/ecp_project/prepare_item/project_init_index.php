<table width="100%">
	<tr>
    	<td valign="top" class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="mission_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/init_project/project_mng_edit_div',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td valign="top">
<div id="result_area_div" class="mm_area_div_2">
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="12" class="mm_table2_title">專案所有工作清單列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2">項次</td>
            <td class="mm_table2_title2">任務名稱</td>
            <td class="mm_table2_title2">工作項目</td>
            <td class="mm_table2_title2">負責人員</td>  
            <td class="mm_table2_title2">工作日期</td>   
            <td class="mm_table2_title2">料品與工作明細</td> 
            <td class="mm_table2_title2">數量*單價=金額</td> 
            <td class="mm_table2_title2">需求日期</td> 
            <td class="mm_table2_title2">採購廠商</td>             
        </tr>
         <?php $eno=0; foreach($main_list as $st1=>$sv1): $eno++; ?>
        <tr>
        	<td><?=$eno?></td>
            <td><a><?=$sv1['row']['jobname']?></a></td>
            <td></td>
            <td></td>  
            <td></td>   
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td> 
        </tr>
        	 <?php foreach($sv1['data'] as $st2=>$sv2): $eno++; ?>
        <tr>
        	<td><?=$eno?></td>
            <td></td>
            <td><?=$sv2['row']['taskname']?></td>
            <td><?=$sv2['row']['sales_name']?></td>  
            <td><?=substr($sv2['row']['startdate'],0,10)?>~<?=substr($sv2['row']['enddate'],0,10)?></td>   
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td> 
        </tr>
        		 <?php foreach($sv2['data'] as $sv3): $eno++; ?>
        <tr>
        	<td><?=$eno?></td>
            <td></td>
            <td></td>
            <td></td>  
            <td></td>   
            <td><?=$sv3['prodname']?></td> 
            <td><?=(float)$sv3['quantity']?>*<?=(float)$sv3['price']?>=<?=number_format($sv3['quantity']*$sv3['price'])?></td> 
            <td><?=substr($sv3['startdate'],0,10)?></td> 
            <td><?=$sv3['vendor_name']?></td> 
        </tr> 
                 <?php endforeach;?>
             <?php endforeach;?>
         <?php endforeach;?>
    </table>

</div>
        </td>
    </tr>
</table>
