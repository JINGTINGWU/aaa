<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
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
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
</script>	
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<form id="edit_form" target="phf" action="" method="post" >
<div id="result_area_div"  class="mm_area_div_2" width="100%">
	<table width="100%" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="9">專案工作展期待確認列表</td>
    	</tr>
        <tr bgcolor="#E7EBF7">
        	<td>項次<input type='checkbox' id='checkall' name='checkall' alt='全選' onclick="selectall();"/></td>
            <td>任務名稱</td>
            <td>工作名稱</td>  
            <td>負責人員</td>
            <td>督導人</td>   
            <td>原工作日期</td>
          <td>新工作日期</td> 
          <td>回報人</td> 
            <td>待辦通知</td>
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
            <td></td>
        </tr>
        	 <?php  foreach($sv1['data'] as $st2=>$sv2): $e_task++; $e_task_v=0; $e_prod_f=0; $eno++; $notice_id=$sv2['row']['jec_projnotice_id']; ?>
        <tr bgcolor="<?=$sv2['row']['isfinish']=='Y'?'#DAFF7F':'#E7EBF7'?>">
        	<td><?=$e_task?>
       	    <?php 			
			echo "<input type='checkbox' name='cb' id='select_".$e_task."' value='".$notice_id."'/>";
			?></td>
            <td>&nbsp;</td>
            <td><a target='_parent' href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/task_list_index/target/<?=$sv2['row']['jec_projjob_id']?>/created/asc/0/-1.html/<?=$sv2['row']['jec_projtask_id']?>'><?=$sv2['row']['taskname']?></a></td>  
            <td><?=$sv2['row']['sales_name']<>''?$sv2['row']['sales_name']:$sv2['row']['group_name']?></td>
            <td><?=$sv2['row']['super_name']?></td>   
            <td><?=substr($sv2['row']['startdate'],0,10)?>~<?=substr($sv2['row']['enddate'],0,10)?></td>
            <td><input type="text" name="newstartdate_<?=$notice_id?>" id="newstartdate_<?=$notice_id?>" value="<?=substr($sv2['row']['newstartdate'],0,10)?>" size="10" readonly="readonly" <?=$sv2['row']['isnotice']=='Y'?'style="background-color:#C0C0C0"':'';?> /> ~ <input type="text" name="newenddate_<?=$notice_id?>" id="newenddate_<?=$notice_id?>" value="<?=substr($sv2['row']['newenddate'],0,10)?>" size="10" readonly="readonly"/>
            </td> 
            <td><?=$sv2['row']['apply_name']?></td> 
            <td><?=$sv2['row']['isnotice']=='Y'?'已通知':'未通知'?></td>
        </tr>
        		 
                 <?php
				 $e_total_prod=count($sv2['data']);
				 if($e_total_prod>0):
				 	$e_task_v=ceil($e_prod_f/$e_total_prod*10000)/100;
				 else:
				 	$e_task_v=$sv2['row']['isfinish']=='Y'?'100':'0';
				 endif;
				 ?>  
            <script>
            <?php if($sv2['row']['isnotice']=='N'):?>                   
            cal.manageFields("newstartdate_<?=$notice_id?>", "newstartdate_<?=$notice_id?>", "%Y-%m-%d");			
            <?php endif?>
			cal.manageFields("newenddate_<?=$notice_id?>", "newenddate_<?=$notice_id?>", "%Y-%m-%d");
            </script>
             <?php endforeach;?>        
        <?php endforeach;?>
    </table>
    <script>
    	cal.manageFields("cp_adtime_enddate", "cp_adtime_enddate", "%Y-%m-%d");
    </script>
回報人提出以上工作展期申請，專案部門主管同意以上所選工作展期，並退回未選擇之工作展期要求
<input type="hidden" name="checked_task_string" id="checked_task_string" /><input type="hidden" name="unchecked_task_string" id="unchecked_task_string" />
<input type="button" value="確認" onclick="PG_BK_Action('adjust_date',{});" />
</div>  
</form>