<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
<script src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_red_font{
	color:#FF0000;
}  
</style>
<div id="search_area_div"  class="mm_area_div_1" onclick="PL_DivClick();">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        <td align="right">專案類型：</td><td id="frominputarea"><?=$s_main_op['s_proj_projtype']['op']?></td>
        <td align="right">專案狀態：</td><td id="frominputarea"><?=$s_main_op['s_proj_projstatus']['op']?></td>
        <td align="right">專案部門：</td><td id="frominputarea"><?=$s_main_op['s_projdept_id']['op']?></td>
        	<td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>              
            <td align="right">客戶名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_customer_title']['op']?><?=$s_main_op['s_proj_jec_customer_id']['op']?><label id="s_proj_customer_title_lb"></label></td>           
        	
        </tr>
		<tr>            
        	<td align="right">工作狀態：</td><td id="frominputarea"><?=$s_main_op['s_task_tasktype']['op']?></td>
            <td align="right">工作進度：</td><td id="frominputarea"><?=$s_main_op['s_task_taskprogress']['op']?></td>
            <td align="right">負責人部門：</td><td id="frominputarea"><?=$s_main_op['s_dept_id']['op']?></td>
            <td align="right">工作名稱：</td><td id="frominputarea"><?=$s_main_op['s_task_name']['op']?></td>
            <td align="right">負責人員：</td>
            <td id="frominputarea"><?=$s_main_op['s_user_id']['op']?><?=$s_main_op['s_user_id_title']['op']?></td>
            
        </tr>
        <tr>        	
            <td align="right">督導人：</td><td id="frominputarea"><?=$s_main_op['s_superuser_id']['op']?><?=$s_main_op['s_superuser_id_title']['op']?></td>          
            <td align="right">開始期限：</td><td id="frominputarea"><?=$s_main_op['s_startdate2']['op']?>~<?=$s_main_op['s_enddate2']['op']?></td>
            <td align="right">完成期限：</td><td id="frominputarea"><?=$s_main_op['s_startdate']['op']?>~<?=$s_main_op['s_enddate']['op']?></td>
        	<td colspan="4" align="right"><input type="button" value="查詢工作資料" onclick="PG_BK_Action('search_go')" class="mm_submit_button" /></td>     
        </tr>
		
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2"  onclick="PL_DivClick();">
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="8">工作項目列表</td><td colspan="6"><?=$s_main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='delaydate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_delaydate_url']?>">逾期</a></td>
        	<td class="mm_table2_title2" <?=$ob=='projtasktype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_projtasktype_url']?>">狀態</a></td>
            <td class="mm_table2_title2" <?=$ob=='isfinish'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isfinish_url']?>">完成</a></td>
            <td class="mm_table2_title2" <?=$ob=='isconfirm'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isconfirm_url']?>">確認</a></td>
            <td class="mm_table2_title2" <?=$ob=='proj_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_proj_name_url']?>">專案名稱</a></td>
            <td class="mm_table2_title2" <?=$ob=='job_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_job_name_url']?>">任務名稱</a></td> 
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_name_url']?>" >工作名稱</a></td>
            <td class="mm_table2_title2" id="detail-normal">備註說明</td>
            <td class="mm_table2_title2" <?=$ob=='jec_user_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_user_id_url']?>" >負責人</a></td> 
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_startdate_url']?>" >工作日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='replytime'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_replytime_url']?>">回報日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='confirmtime'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_confirmtime_url']?>">確認日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='super_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_super_name_url']?>" >督導人員</a></td> 
            <td class="mm_table2_title2" id="detail-normal">工作紀錄</td>  
        </tr>
        <?php foreach($main_list as $value):?>
        <tr> 
        	<td style="width:50px;"><?php if($value['delaydate']>0):?><img src="<?=base_url()?>images/02.gif" height="14" /> <label class="mm_red_font"><?=$value['delaydate']?> 天</label><?php endif;?></td>
        	<td style="width:20px;" align="center">
        		<?php if ($value['projtasktype']=='1'): ?>準備
        		<?php elseif ($value['projtasktype']=='2'): ?>開展
        		<?php elseif ($value['projtasktype']=='3'): ?>移轉
        		<?php elseif ($value['projtasktype']=='4'): ?>廢止
        		<?php elseif ($value['projtasktype']=='5'): ?>暫停
        		<?php elseif ($value['projtasktype']=='6'): ?>完成
        		<?php else: ?>未定義:<?=$value['projtasktype']?>
        		<?php endif; ?>
        	</td>
            <td style="width:20px;"><img src="<?=base_url()?>images/<?=$value['isfinish']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td style="width:20px;"><img src="<?=base_url()?>images/<?=$value['isconfirm']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td style="width:150px;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/project_adjust_index/list/<?=$value['jec_project_id']?>.html'><?=$value['proj_name']?></a><?=$value['isproductprep']=='Y'?' || <a href="'.$this->config->item('base_url').'ecp_project/prepare_item_mng/item_submit_index/list/'.$value['jec_project_id'].'/created/asc/0/N">備品清單</a> ':''?></td>
          	<td style="width:150px;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/job_list_index/target/<?=$value['jec_project_id']?>/created/asc/0/-1/<?=$value['jec_projjob_id']?>'><?=$value['job_name']?></a></td>
            <td style="width:150px;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/task_list_index/target/<?=$value['jec_projjob_id']?>/created/asc/0/-1.html/<?=$value['jec_projtask_id']?>'><?=$value['taskname']?></a></td>
            <td style="width:150px;"><?=$value['description']?></td>
            <td style="width:60px;"><?php if($value['jec_user_id']>0):?><?=$value['sales_name']?><?php endif;?><?php if($value['jec_group_id']>0):?><?=$value['group_name']?><?php endif;?></td>
            <td style="width:90px;word-break: break-all;"><?=substr($value['startdate'],0,10)?>~<?=substr($value['enddate'],0,10)?></td> 
            <td style="width:80px;word-break: break-all;"><?=substr($value['replytime'],0,10)?></td> 
            <td style="width:80px;word-break: break-all;"><?=$value['confirmtime']=='0000-00-00 00:00:00'?'':substr($value['confirmtime'],0,10)?></td> 
            <td style="width:70px;"><?=$value['super_name']?></td>
            <td style="width:70px;"><input type="button" value="紀錄" onclick="JS_Link('<?=site_url($var_purl.'work_record_index/list/'.$value['jec_projtask_id'].'/created/DESC/0/-1/')?>');" class="mm_submit_button"  ></td>  
        </tr>        
        <?php endforeach;?>
    </table>
    <?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
</div>
<form name="pg_form" id="pg_form" target="phf" method="post" action="">
<input type="hidden" name="pg_var_1" id="pg_var_1" />
</form>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("s_startdate", "s_startdate", "%Y-%m-%d");
cal.manageFields("s_enddate", "s_enddate", "%Y-%m-%d");
cal.manageFields("s_startdate2", "s_startdate2", "%Y-%m-%d");
cal.manageFields("s_enddate2", "s_enddate2", "%Y-%m-%d");
function PG_TB_Close(){
	//TPP_Frame.PG_Upload_Save();
}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'search_go':
			var info=Array();
			//info[0]={sd_id:'s_task_startdate',ed_id:'s_task_enddate',msg:'結束日不能小於起始日',type:'sed'};
			msg=fi_submit_check(info);

			if(msg==''){
				var data={};
				<?php
				foreach($_SESSION[$pg_tag] as $st=>$sv):
					?>
					if($("#<?=$st?>").length>0){
						data.<?=$st?>=$("#<?=$st?>").val();
					}
					<?php
				endforeach;
				?>
				if(data.s_user_id_title==''){
					data.s_user_id='';
				}
				AWEA_Ajax('<?=site_url('ecp_common/save_pg_session/'.$pg_tag.'/')?>',data,'');
			}
			break;
		case 'refresh_search':
			JS_Link('<?=site_url($var_purl.'work_analysis_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
			break;
		case 'export_excel':
			document.getElementById('pg_form').action="<?=$export_excel_url?>";			
			$("#pg_var_1").val($("#excel_type").val());
			document.getElementById('pg_form').submit();
			break;
	}
}
</script>
<div id="pl_search_div" style="display:none;background:#FFFFFF;position:absolute;top:0px;left:0px;">
<iframe id="pl_search_list" name="pl_search_list" frameborder="0" style="border:1px solid #CCCCCC;width:600px;height:300px;" ></iframe>
</div> 
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>

var InputList={
		on:'user',
		info:{ 
				//user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_task_proj_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_task_proj_user_id','input_type':'R','width':200,'label_id':'s_task_proj_user_id_title_lb' }
			cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_customer_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'s_proj_jec_customer_id','input_type':'R','width':200,'title_id':'s_proj_customer_title' },
			user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_user_id','input_type':'R','width':200,'title_id':'s_user_id_title' },
			superuser:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_superuser_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_superuser_id','input_type':'R','width':200,'title_id':'s_superuser_id_title' }

				//,,'label_id':'target_label' 
			 },
		on_select:'on_select',
		select_status:'select_status',
		css_off_select:'off_select',
		css_on_select:'on_select',
		pg_list_on:'N',
		blank_url:'<?=base_url('ecp_test/blank')?>',
		onfocus:''
		//,input_type:'A' //A/R		
	};
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>