
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
        	<td align="right">客戶名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_jec_customer_id']['op']?><?=$s_main_op['s_proj_customer_title']['op']?></td>
            <td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>
            <td align="right">部門：</td><td id="frominputarea"><?=$s_main_op['s_dept_id']['op']?></td>
            <td align="right">人員：</td><td id="frominputarea"><?=$s_main_op['s_user_id']['op']?><?=$s_main_op['s_user_id_title']['op']?></td>
        </tr>
		<tr>
        	<td align="right">工作名稱：</td><td id="frominputarea"><?=$s_main_op['s_task_name']['op']?></td>
        	<td align="right">工作狀態：</td><td id="frominputarea"><?=$s_main_op['s_task_tasktype']['op']?></td>
            <td align="right">工作進度：</td><td id="frominputarea"><?=$s_main_op['s_task_taskprogress']['op']?></td>
            <td colspan="2"><input type="button" value="查詢工作資料" onclick="PG_BK_Action('search_go')" class="mm_submit_button" /></td>
        </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2"  onclick="PL_DivClick();">
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="7">工作項目列表</td><td colspan="4"><?=$s_main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='delaydate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_delaydate_url']?>">逾期</a></td>
            <td class="mm_table2_title2" <?=$ob=='isfinish'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isfinish_url']?>">完成</a></td>
            <td class="mm_table2_title2" <?=$ob=='isconfirm'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isconfirm_url']?>">確認</a></td>
            <td class="mm_table2_title2" <?=$ob=='proj_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_proj_name_url']?>">專案名稱</a></td> 
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_name_url']?>" >工作名稱</a></td>  
            <td class="mm_table2_title2" id="detail-normal"><a href="" >負責人</a></td> 
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_startdate_url']?>" >工作日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='finishdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_finishdate_url']?>">完成日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='confirmdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_confirmdate_url']?>">確認日期</a></td> 
            <td class="mm_table2_title2" <?=$ob=='super_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_super_name_url']?>" >督導人員</a></td> 
            <td class="mm_table2_title2" id="detail-normal">工作紀錄</td>  
        </tr>
        <?php foreach($main_list as $value):?>
        <tr> 
        	<td><?php if($value['delaydate']>0):?><img src="<?=base_url()?>images/02.gif" height="14" /> <label class="mm_red_font"><?=$value['delaydate']?> 天</label><?php endif;?></td>
            <td><img src="<?=base_url()?>images/<?=$value['isfinish']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td><img src="<?=base_url()?>images/<?=$value['isconfirm']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td><?=$value['proj_name']?></td> 
            <td><?=$value['taskname']?></td>  
            <td><?php if($value['jec_user_id']>0):?><?=$value['sales_name']?><?php endif;?><?php if($value['jec_group_id']>0):?><?=$value['group_name']?><?php endif;?></td>
            <td><?=substr($value['startdate'],0,10)?>~<?=substr($value['enddate'],0,10)?></td> 
            <td><?=$value['isfinish']=='Y'?substr($value['finishdate'],0,10):''?></td> 
            <td><?=$value['confirmdate']=='0000-00-00 00:00:00'?'':substr($value['confirmdate'],0,10)?></td> 
            <td><?=$value['super_name']?></td>
            <td><input type="button" value="工作紀錄" onclick="JS_Link('<?=site_url($var_purl.'work_record_index/list/'.$value['jec_projtask_id'].'/created/DESC/0/-1/')?>');" class="mm_submit_button"  ></td>  
        </tr>        
        <?php endforeach;?>
    </table>
</div>
<form name="pg_form" id="pg_form" target="phf" method="post" action="">
<input type="hidden" name="pg_var_1" id="pg_var_1" />
</form>
<script>
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
				if(data.s_task_proj_user_id_title==''){
					data.s_task_proj_user_id='';
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
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_task_proj_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_task_proj_user_id','input_type':'R','width':200,'label_id':'s_task_proj_user_id_title_lb' }
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