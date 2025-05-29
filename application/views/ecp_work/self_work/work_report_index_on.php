<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<input type="hidden" id="time_tag" value="<?=$time_tag?>" />
<input type="hidden" id="rp_time" value="<?=$rp_time?>" />
<style>
.mm_pg_width_1{
	width:80px;
}
.mm_pg_width_2{
	width:80px;
}
</style>
<table width="100%" onclick="PL_DivClick();">
	<tr>
    	<td valign="top"  class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_mng_div" class="mm_area_div_3">
			<?php $this->load->view('common/project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="task_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/self_work/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
        </td>
        <td valign="top">
        <div  class="mm_area_div_1">
<div id="search_area_div">
	<p><input type='checkbox' id='chkToboss' name='chkToboss' title="是否一起回報主管" />是否一起回報主管</p>
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="5" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">工作完成</td>
            <td>工作狀態：<?=isset($projtasktype_pdb[$projt_data['projtasktype']])?$projtasktype_pdb[$projt_data['projtasktype']]:''?></td>
            <td>工作進度：</td>
            <td id="frominputarea">完成時間： <?=$main_op['rp_finish_time']['op']?></td><td class="mm_pg_width_2"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_finish/'.$time_tag.'/')?>')" class="mm_submit_button" >
            <div id="file_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/self_work/file_info_div',array('dir'=>'rp_finish'.$time_tag)); ?>
        </div>
            </td>
        </tr>
		<tr>
        	<td>工作紀錄：</td>
            <td colspan="4" id="frominputarea"><?=$main_op['rp_finish']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_finish/')?>')" class="mm_submit_button">
            <br/><input type="button" value="回報此項工作已完成" class="mm_submit_button" onclick="PG_BK_Action('rp_finish',{url:'<?=$rp_url['rp_finish']?>'});"  id="rp_finish_btn"  >&nbsp;&nbsp;<input type="button" value="工作尚未完成，但回報目前工作進度" class="mm_submit_button" onclick="PG_BK_Action('rp_progress',{url:'<?=$rp_url['rp_progress']?>'});" id="rp_progress_btn" ></td>
        </tr>
	</table>
</div>
<table border="1" cellpadding="0" cellspacing="0">
<tr><td>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3"  onclick="PL_DivClick();" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">調整日期</td>
            <td id="frominputarea">申請調整新的完成日期：<?=$main_op['rp_adtime_startdate']['op']?>~<?=$main_op['rp_adtime_enddate']['op']?></td>
            <td class="mm_pg_width_2"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_adjust/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>申請說明：</td>
            <td colspan="2"><?=$main_op['rp_adjust']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_adjust/')?>')" class="mm_submit_button" >
            <br/><input type="button" value="申請調整完成日期" onclick="PG_BK_Action('rp_adjust',{url:'<?=$rp_url['rp_adjust']?>'});" class="mm_submit_button" id="rp_adjust_btn" ></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">工作移轉</td>
            <td id="frominputarea">申請將工作移轉至他人：<?=$main_op['rp_transfer_user']['op']?><?=$main_op['rp_transfer_user_title']['op']?></td>
            <td class="mm_pg_width_2"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_transfer/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>申請說明：</td>
            <td colspan="2" id="frominputarea"><?=$main_op['rp_transfer']['op']?><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_transfer/')?>')" class="mm_submit_button" >
            <br/><input type="button" value="申請工作移轉他人" onclick="PG_BK_Action('rp_transfer_check',{url:'<?=$rp_url['rp_transfer']?>'});" class="mm_submit_button" id="rp_transfer_btn" ></td>
        </tr>
	</table>
</div>
<input type="button" value="申請調整日期並將工作移轉他人" onclick="PG_BK_Action('rp_adjust_transfer_check',{url:'<?=$rp_url['rp_adjust_transfer']?>'});" class="mm_submit_button" id="rp_adjust_transfer_btn" >
</td></tr></table>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">督導人移轉</td>
            <td id="frominputarea">申請將督導人移轉至他人：
              <?=$main_op['rp_transfer_superuser']['op']?><?=$main_op['rp_transfer_superuser_title']['op']?></td>
            <td class="mm_pg_width_2"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_transfer_superuser/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>申請說明：</td>
            <td colspan="2" id="frominputarea"><?=$main_op['rp_transfer_super']['op']?><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_transfer_superuser/')?>')" class="mm_submit_button" >
            <br/><input type="button" value="申請督導人移轉他人" onclick="PG_BK_Action('rp_transfer_supercheck',{url:'<?=$rp_url['rp_transfer_superuser']?>'});" class="mm_submit_button" id="rp_transfer_superuser_btn" ></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">無法完成</td>
            <td id="frominputarea">回報時間：<?=$main_op['rp_impossible_time']['op']?></td>
            <td class="mm_pg_width_2"><input type="button" value="上傳附件" onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_impossible/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>問題說明：</td>
            <td colspan="2" id="frominputarea"><?=$main_op['rp_impossible']['op']?><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_impossible/')?>')" class="mm_submit_button" >
            <br/><input type="button" value="回報此項工作無法完成" class="mm_submit_button" onclick="PG_BK_Action('rp_impossible',{url:'<?=$rp_url['rp_impossible']?>'});" id="rp_impossible_btn"  ></td>
        </tr>
	</table>
</div>
<div id="search_area_div">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td class="mm_pg_width_1">工作暫停</td>
            <td id="frominputarea">申請時間：<?=$main_op['rp_pause_time']['op']?> 預計恢復日：<?=$main_op['rp_pause_startdate']['op']?>~<?=$main_op['rp_pause_enddate']['op']?></td>
            <td class="mm_pg_width_2"><input type="button" value="上傳附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div_rp/rp_pause/'.$time_tag.'/')?>')" class="mm_submit_button" ></td>
        </tr>
		<tr>
        	<td>暫停原因：</td>
            <td colspan="2" id="frominputarea"><?=$main_op['rp_pause']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/rp_pause/')?>')"  class="mm_submit_button"><br/><input type="button" value="申請工作暫停"  onclick="PG_BK_Action('rp_pause',{url:'<?=$rp_url['rp_pause']?>'});" class="mm_submit_button" id="rp_pause_btn" ></td>
        </tr>
	</table>
</div>
		</div>
        </td>
    </tr>
</table>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("rp_adtime_enddate", "rp_adtime_enddate", "%Y-%m-%d");
cal.manageFields("rp_pause_startdate", "rp_pause_startdate", "%Y-%m-%d");
cal.manageFields("rp_pause_enddate", "rp_pause_enddate", "%Y-%m-%d");
function PG_BK_Action(type,data)
{	var info=Array();
	
	if(typeof(data)=='object'){
		data.time_tag=document.getElementById('time_tag').value;
		data.rp_time=document.getElementById('rp_time').value;
		if($("#chkToboss").is(':checked')==true)
		{			
			data.toboss='Y';
		}
		else
		{			
			data.toboss='N';
		}		
		if($("#"+type).length==0){			
			data.content=document.getElementById('rp_finish').value;
		}else{
			data.content=document.getElementById(type).value;
		}
	}

	switch(type){
		case 'rp_finish':
			if(confirm("確定回報工作完成?")){
				document.getElementById('rp_finish_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'rp_progress':
			if(confirm("確定回報目前進度?")){
				document.getElementById('rp_progress_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'rp_adjust':
			
			data.rp_adtime_enddate=document.getElementById('rp_adtime_enddate').value;
			data.rp_adtime_startdate=document.getElementById('rp_adtime_startdate').value;
			info[0]={sd_id:'rp_adtime_startdate',ed_id:'rp_adtime_enddate',msg:'結束日不能小於起始日',type:'sed'};
			msg=fi_submit_check(info);
			if(msg==''){
				if(confirm("確定申請調整日期?")){
					document.getElementById('rp_adjust_btn').disabled=true;
					AWEA_Ajax(data.url,data,'');
				}
			}
			break;
		case 'rp_transfer_check':		
			data={ bk_action:'rp_transfer',sales_name:$("#rp_transfer_user_title").val(),rp_url:data.url,toboss:data.toboss};		
			
			AWEA_Ajax('<?=$check_rp_url?>',data,'');
			break;
		case 'rp_adjust_transfer_check':		
			data={ bk_action:'rp_adjust_transfer',sales_name:$("#rp_transfer_user_title").val(),rp_url:data.url,toboss:data.toboss};		
			
			AWEA_Ajax('<?=$check_rp_url?>',data,'');
			break;
		case 'rp_transfer_supercheck':			
		  	data={ bk_action:'rp_transfer_super',sales_name:$("#rp_transfer_superuser_title").val(),rp_url:data.url,toboss:data.toboss};		
		  
		  	AWEA_Ajax('<?=$check_rp_super_url?>',data,'');
		break;
		case 'rp_transfer':
			if(GetTagV(data,'isexist')=='Y'){
				
				info[0]={id:'rp_transfer_user_title',msg:'請選擇移轉對象',type:'ne'};
				msg=fi_submit_check(info);				
				if(msg==''){// 
					if(confirm("確定申請工作移轉?")){
					//data.jec_usernew_id=document.getElementById('rp_transfer_user').value;
						var rp_url=GetTagV(data,'rp_url');
						var jec_usernew_id=GetTagV(data,'sales_id');	
								
						data={ jec_usernew_id:jec_usernew_id,content:document.getElementById('rp_transfer').value,toboss:GetTagV(data,'toboss')};
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('rp_transfer_btn').disabled=true;
						
						AWEA_Ajax(rp_url,data,'');
					}
				}
			}
			break;
		case 'rp_adjust_transfer':
			if(GetTagV(data,'isexist')=='Y'){
				info[0]={sd_id:'rp_adtime_startdate',ed_id:'rp_adtime_enddate',msg:'結束日不能小於起始日',type:'sed'};
				info[1]={id:'rp_transfer_user_title',msg:'請選擇移轉對象',type:'ne'};
				msg=fi_submit_check(info);				
				if(msg==''){// 
					if(confirm("確定申請調整日期一併移轉工作嗎?")){
					//data.jec_usernew_id=document.getElementById('rp_transfer_user').value;
						var rp_url=GetTagV(data,'rp_url');
						var jec_usernew_id=GetTagV(data,'sales_id');	
								
						data={ jec_usernew_id:jec_usernew_id,rp_adtime_startdate:document.getElementById('rp_adtime_startdate').value,rp_adtime_enddate:document.getElementById('rp_adtime_enddate').value,content:document.getElementById('rp_adjust').value+'&'+document.getElementById('rp_transfer').value,toboss:GetTagV(data,'toboss')};
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('rp_adjust_transfer_btn').disabled=true;
						
						AWEA_Ajax(rp_url,data,'');
					}
				}
			}
			break;
		case 'rp_transfer_super':
			if(GetTagV(data,'isexist')=='Y'){
				
				info[0]={id:'rp_transfer_superuser_title',msg:'請選擇移轉對象',type:'ne'};
				msg=fi_submit_check(info);
				if(msg==''){// 
					if(confirm("確定申請督導人移轉?")){
					//data.jec_usernew_id=document.getElementById('rp_transfer_user').value;
						var rp_url=GetTagV(data,'rp_url');
						var jec_usernew_id=GetTagV(data,'sales_id');						
						data={ jec_usernew_id:jec_usernew_id,content:document.getElementById('rp_transfer_super').value,toboss:GetTagV(data,'toboss') };
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('rp_transfer_superuser_btn').disabled=true;
						
						AWEA_Ajax(rp_url,data,'');
					}
				}
			}
			break;
		case 'rp_impossible':
			if(confirm("確定回報工作無法完成?")){
				document.getElementById('rp_impossible_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'rp_pause':					
                    data.rp_pause_startdate=document.getElementById('rp_pause_startdate').value;
                    data.rp_pause_enddate=document.getElementById('rp_pause_enddate').value;
					
                    info[0]={sd_id:'rp_pause_startdate',ed_id:'rp_pause_enddate',msg:'結束日不能小於起始日',type:'sed'};
                    info[1]={id:'rp_pause_startdate',msg:'請選擇開始日期',type:'ne'};
                    info[2]={id:'rp_pause_enddate',msg:'請選擇結束日期',type:'ne'};
			msg=fi_submit_check(info);                    
			if(msg==''){

			if(confirm("確定申請工作暫停?")){
				document.getElementById('rp_pause_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
                    }
			break;
		case 'after_reply':
			JS_Link('<?=$tcate_url['work_list_index']?>');
			break;
		case 'reload_file_list':			
			ECP_Load_Div('file_info_div','<?=$file_list_url?>','');
		break;
	}
}
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
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
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'rp_transfer_user_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'rp_transfer_user','input_type':'R','width':160,'title_id':'rp_transfer_user_title' },
				superuser:{ search_list:'pl_search_list',search_value:'search_value',search_here:'rp_transfer_superuser_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'rp_transfer_superuser','input_type':'R','width':160,'title_id':'rp_transfer_superuser_title' }
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