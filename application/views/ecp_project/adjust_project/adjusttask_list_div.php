<style type="text/css"> 
body {
	background-color: #FFFFFF;
	margin: 0 10px 0px 10px;
	font-family: "微軟正黑體", Verdana;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
	word-break: break-all;
}
.detail-div {
	width: 100%;
	background: #FFFFFF;
	border: 1px solid #BBDDE5;
	margin: 10px 0 0 0;
	-webkit-text-size-adjust:none;
}
.detail-div table {
	width: 100%;
	border: 1px solid #7B9AB5;
}

.detail-div tr:hover td {
	background: #FFFFDE;
}
.detail-div tr:first-child td {
	background: #8496AD;
	color: #FFFFFF;
	font-weight: bold;
	padding-left: 15px;
	text-decoration: None;
	background-image: url('../images/title_mark.gif');
	background-size: 9px 26px;
	background-repeat: no-repeat;
}
.detail-div tr:nth-child(2) td {
	background: #6B9AB5;
	color: #FFFFFF;
	font-weight: bold;
}
.detail-div td {	
	line-height: 20px;
}
</style>
<script type="text/javascript"> 
function selectall() { 
   if($('#checkall').attr('checked'))
   {
	   $("input[name='cb']").each(function() {
         $(this).attr("checked", true);
     });
   }
   else
   {
     $("input[name='cb']").each(function() {
         $(this).attr("checked", false);
     });           
   }
   
}
</script> 
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<form id="edit_form" target="phf" action="" method="post" >
<div id="result_area_div"  class="mm_area_div_2" width="100%">
	<table width="100%" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="8">專案所有工作清單列表</td>
    	</tr>
        <tr bgcolor="#E7EBF7">
        	<td>項次<input type='checkbox' id='checkall' name='checkall' alt='全選' onclick="selectall();"/></td>
            <td>任務名稱</td>
            <td>工作名稱</td>  
            <td>負責人員</td>   
            <td>工作日期</td> 
            <td>完成狀態</td> 
            <td>完成日期</td>
            <td>回報狀態</td> 
        </tr>
        <?php $eno=0; $e_task=0; foreach($main_list as $st1=>$sv1): $eno++; ?>
        <tr bgcolor="#E7EBF7">
        	<td></td>
            <td><a target='_parent' href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/job_list_index/list/<?=$sv1['row']['jec_project_id']?>/created/asc/0/-1'><?=$sv1['row']['jobname']?></a></td>
            <td></td>  
            <td></td>   
            <td></td> 
            <td></td> 
            <td></td>
            <td></td> 
        </tr>
        	 <?php  foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; ?>
        <tr bgcolor="<?=$sv2['row']['isfinish']=='Y'?'#DAFF7F':'#E7EBF7'?>">
        	<td><?=$e_task?>
       	    <?php 
                        $noAdjustTaskID=array(155,156,206,207,149,70,76,224,162);//20160728:行銷部曉莊需求:管線與機電發包,施工,ERP訂單建立不得批次展期，需個別向主管說明
			if($sv2['row']['startdate']!='0000-00-00 00:00:00' && $sv2['row']['enddate']!='0000-00-00 00:00:00' && $sv2['row']['isfinish']=='N' && $sv2['row']['replystatus']=='0' && ($sv2['row']['sales_name']!='' or $sv2['row']['group_name']!='') && !in_array($sv2['row']['jec_task_id'],$noAdjustTaskID))
			{
			echo "<input type='checkbox' name='cb' id='select_".$e_task."' value='".$sv2['row']['jec_projtask_id']."'/>";
			
			}
			else 
			{
				echo "";
			}
			?></td>
            <td>&nbsp;</td>
            <td><a target=_parent href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/task_list_index/target/<?=$sv2['row']['jec_projjob_id']?>/created/asc/0/-1.html/<?=$sv2['row']['jec_projtask_id']?>'><?=$sv2['row']['taskname']?></a></td>  
            <td><?=$sv2['row']['sales_name']<>''?$sv2['row']['sales_name']:$sv2['row']['group_name']?></td>   
            <td><?=substr($sv2['row']['startdate'],0,10)?>~<?=substr($sv2['row']['enddate'],0,10)?></td> 
            <td><?=$sv2['row']['isfinish']=='Y'?'已完成':'未完成'?></td> 
            <td><?=$sv2['row']['isfinish']=='Y'?substr($sv2['row']['finishdate'],0,10):''?></td>
            <td><?=$sv2['row']['replystatus']=='0'?'未回報':'已回報'?></td> 
        </tr>
        		 
                 <?php
				 $e_total_prod=count($sv2['data']);
				 if($e_total_prod>0):
				 	$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
				 else:
				 	$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0';
				 endif;
				 ?>                 
             <?php endforeach;?>        
        <?php endforeach;?>
    </table>
以上所選工作全部展期 <input type="hidden" name="task_string" id="task_string" /><input type='text' id='adjustday' name='adjustday' value="0" size="3" />日<input type="button" value="確定" onclick="PG_BK_Action('adjust_date',{});" />
<br/>說明：因應行銷部20160627資訊需求，以下工作無法批次展期，請用回報延期方式向主管說明，1.發包-管線、機電廠商 2.施工-管線、機電廠商、售服 3.客戶訂單建立(ERP)
</div>  
</form>