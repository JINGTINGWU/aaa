<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4" class="mm_table2_title">工作紀錄列表
            <select name="recordtype" id="recordtype" onchange="recordtype_change();">
                    <option value="N" <?=$ac=='list' || $ac=='list_div'?'selected':''?>>不顯示逾期通知</option>
                    <option value="ALL" <?=$ac=='list-all' || $ac=='list_div-all'?'selected':''?>>顯示全部</option>
  		    </select></td>
    	</tr>
    	<tr>
    	  <td colspan="4" style="color:#F00">此工作已逾期<?=$projt_data['delaydate']?>日，調整日期<?=$datechangecount?>次，移轉人員<?=$mantransfercount?>次，申請暫停<?=$pausecount?>次</td>
  	  </tr>
        <tr>
            <td class="mm_table2_title2" id="detail-normal">處理時間</td>
            <td class="mm_table2_title2" id="detail-normal">工作紀錄</td>
            <td class="mm_table2_title2" id="detail-normal">備註說明</td>
            <td class="mm_table2_title2" id="detail-normal">異動人員</td>          
        </tr>
        <?php foreach($main_list as $value):?>
        <tr>
            <td><?=$value['recordtime']?></td>
            <td><?=$value['description']?></td>
            <td><?=$value['description2']?></td>
            <td><?=$value['user_name']?></td>   
        </tr>        
        <?php endforeach;?>
    </table>
<script type="text/javascript">
    function recordtype_change()
    {        
        if($('#recordtype').val()=='N')
        {            
            location.href='<?=base_url('/ecp_project/adjust_project_mng/record_list_index/list/'.$key_id.'/created/DESC/0/-1.html')?>';
        }
        else
        {
            location.href='<?=base_url('/ecp_project/adjust_project_mng/record_list_index/list-all/'.$key_id.'/created/DESC/0/-1.html')?>';
        }
    }
</script>