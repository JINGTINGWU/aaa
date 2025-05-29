<?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="5" class="mm_table2_title">範本內容明細列表</td>
    	</tr>
        <tr>
        	<td id="detail-normal">編號</td>
            <td id="detail-normal">料品品名/工作明細</td>
            <td id="detail-normal">規格</td>
            <td id="detail-normal">預估單價</td> 
            <td id="detail-normal">供應廠商</td>  
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <tr>
        	<td><?=($no+$np+1)?></td>
            <td><?=$value['name']?></td>
            <td><?=$value['specification']?></td>
            <td><?=(float)$value['price']?></td> 
            <td><?=$value['vendor_name']?></td>  
        </tr>        
        <?php endforeach;?>
    </table>