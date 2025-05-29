
<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_cut_1{
	width:170px;
	white-space:nowrap;
	text-overflow:ellipsis;
	-o-text-overflow:ellipsis;
	overflow: hidden;
}
.mm_emp_tb{
	border:0px;
	margin:0px;
	background:#FFFFFF;
}
.mm_emp_tb tr:first-child td {
	background:#F6F6F6;
	color:#333333;
	border:0px;
	background-image: url(../images/blank.gif);
}
.mm_emp_tb td{
	border:0px;
	background:#F6F6F6;
}
.mm_emp_tb ul{
	width:700px;
}
.mm_emp_tb li{
	width:100px;
	float:left;
	list-style:none;
}
</style>
<!--
<div id="search_area_div" class="mm_area_div_1">
	<table class="query-div" cellspacing="1" cellpadding="3" <?=$this->ECPM->m_right_tag['add_dp']?>>
			<tr>
				<td colspan="5" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">*工作日期：</td><td id="frominputarea"><?=$cal_main_op['startdate']['op']?> ~ <?=$cal_main_op['enddate']['op']?></td>
            <td align="right">*工作名稱：</td><td id="frominputarea"><?=$cal_main_op['name']['op']?></td>
            <td align="right" id="frominputarea">提前通知：<?=$cal_main_op['daynotice']['op']?></td>
        </tr>
        <tr><td align="right">是否公開：</td><td colspan="4" id="frominputarea" style="padding:0px;">
			<table class="mm_emp_tb" style="border:#FFFFFF 0px;background:#F6F6F6;">
            <tr><td>
			<?=$cal_main_op['isopen']['op']?>
            </td><td>
            <ul id="dept_plate_div" style="display:none;"><?=$cal_main_op['open_dept']['op']?></ul>
            </td></tr>
            </table>
            
            </td></tr>
		<tr>
        	<td align="right">備註說明：</td>
            <td colspan="4" id="frominputarea"><?=$cal_main_op['description']['op']?><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')" class="mm_submit_button"><input type="button" value="手動新增我的行事曆"  class="mm_submit_button" onclick="PG_BK_Action('add_self_cal','');" ></td>
        </tr>
	</table>
</div>-->
<div id="search_area_div" class="mm_area_div_1">
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">工作類型：</td><td id="frominputarea"><?=$s_main_op['s_cal_noticetype']['op']?></td>
            <td align="right">工作日期：</td><td id="frominputarea"><?=$s_main_op['s_startdate']['op']?> ~ <?=$s_main_op['s_enddate']['op']?></td>
            <td align="right">工作名稱：</td>
            <td id="frominputarea"><?=$s_main_op['s_task_name']['op']?></td>
        </tr>
		<tr>
        	<td align="right">專案編號：</td><td id="frominputarea"><?=$s_main_op['s_proj_value']['op']?></td>
            <td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>
            <td align="right">關鍵字：</td><td id="frominputarea"><?=$s_main_op['s_keyword']['op']?><input type="button" value="查詢我的行事曆" onclick="PG_BK_Action('search_go')" class="mm_submit_button" style="width:110px;"></td>
        </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="10">通知事項列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='isopen'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isopen_url']?>" >公開</a></td>
        	<td class="mm_table2_title2" <?=$ob=='noticetype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_noticetype_url']?>" >工作類型</a></td>
            <td class="mm_table2_title2"  <?=$ob=='created'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_created_url']?>">日期</a></td>
            <td class="mm_table2_title2"  <?=$ob=='isconfirm'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isconfirm_url']?>">確認</a></td>
            <td class="mm_table2_title2"  <?=$ob=='proj_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_proj_name_url']?>" >專案名稱</a></td> 
            <td class="mm_table2_title2"  <?=$ob=='task_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_task_name_url']?>" >工作名稱及日期</a></td>  
            <td class="mm_table2_title2"  <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_description_url']?>" >通知內容</a></td> 
            <td class="mm_table2_title2"  id="detail-normal">督導確認</td> 
            <td class="mm_table2_title2"  id="detail-normal">工作項目</td> 
            <td class="mm_table2_title2"  id="detail-normal">刪除</td> 
        </tr>
        <?php foreach($main_list as $value):?>
        <tr>
            <td width="35" align="center"><?php if($value['noticefrom']==2):?><img src="<?=base_url()?>images/<?=$value['isopen']=='Y'?'ok':'no'?>.gif" height="14" /><?php endif;?></td>        
        	<td width="110"><?php if(isset($noticetype_img[$value['noticetype']])):?><img src="<?=base_url().$noticetype_img[$value['noticetype']]?>" height="14" /><?php endif;?><?=$noticetype_pdb[$value['noticetype']]?></td>
            <td width="75"><?=substr($value['created'],0,10)?></td>
            <td width="35" align="center"><img src="<?=base_url()?>images/<?=$value['isconfirm']=='Y'?'ok':'no'?>.gif" height="14" /></td>
            <td width="100"><?=$value['proj_name']?></td> 
            <td width="240"><?=(int)$value['jec_projtask_id']>0?$value['task_name']:$value['name']?><br />(<?=substr($value['startdate'],0,10)?>~<?=substr($value['enddate'],0,10)?>)</td> 
            <td width="170"><div class="mm_cut_1"><?=$value['description']?></div></td> 
            <td width="80" align="center">
            	<?php if($value['noticefrom']==3&&in_array($value['noticetype'],$confirm_btn)&&($value['jec_user_id']==$value['jec_usersuper_id']||$value['jec_user_id']==$value['proj_jec_user_id'])):?>
            	<input type="button" value="進入"  class="mm_submit_button" onclick="JS_Link('<?=base_url($this->m_controller.'/inform_item_mng/confirm_list_index/list/'.$value['jec_projnotice_id'].'.html')?>')" >
                <?php endif;?>
            
            </td> 
            <td width="80" align="center">
            	<?php if($value['noticefrom']==1&&in_array($value['noticetype'],$rp_btn)&&($value['jec_user_id']==$this->ad_id)):?>
            	<input type="button" value="回報"  class="mm_submit_button"  onclick="JS_Link('<?=base_url($this->m_controller.'/self_work_mng/work_report_index/list/'.$value['jec_projtask_id'].'/')?>')"  >
                <?php endif;?>
            </td> 
            <td width="40">
            	<?php if($value['createdby']==$this->ad_id):?>
            	<input type="button" value="刪除"  class="mm_submit_button"  onclick="PG_BK_Action('delete_self_cal',{ cal_id:'<?=$value['jec_calendar_id']?>',obj:this })"  >
                <?php endif;?>
            </td>
        </tr>        
        <?php endforeach;?>
    </table>
</div>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
//cal.manageFields("startdate", "startdate", "%Y-%m-%d");
//cal.manageFields("enddate", "enddate", "%Y-%m-%d");
cal.manageFields("s_startdate", "s_startdate", "%Y-%m-%d");
cal.manageFields("s_enddate", "s_enddate", "%Y-%m-%d");

function PG_BK_Action(type,data)
{	var msg='';
	var info=Array();
	
	switch(type){
		case 'add_self_cal':
			info[0]={id:'startdate',msg:'請輸入工作起始日',type:'ne'};
			info[1]={id:'enddate',msg:'請輸入工作結束日',type:'ne'};
			info[2]={sd_id:'startdate',ed_id:'enddate',msg:'結束日不能小於起始日',type:'sed'};
			info[3]={id:'name',msg:'請輸入工作名稱',type:'ne'};
			var msg=fi_submit_check(info);
			if(msg==''){
				if($("#isopen").val()=='Y'){
					var total_ti=parseInt($("#open_dept_ti").val());
					var isSelect='N';
					for(i=0;i<=total_ti;i++){
						if(document.getElementById('open_dept_'+i).checked==true){
							isSelect='Y';
							break;
						}
					}
					if(isSelect=='N'){
						msg="請勾選要公開的部門。";
						humane.error(msg);
					}
				}
			}
			if(msg==''){
				var total_ti=parseInt($("#open_dept_ti").val());
				var mvalue={
					startdate:$("#startdate").val(),
					enddate:$("#enddate").val(),
					daynotice:$("#daynotice").val(),
					description:$("#description").val(),
					isopen:$("#isopen").val(),
					open_dept_ti:total_ti,
					name:$("#name").val()
				};
				mvalue.open_dept_string='';
				for(i=0;i<=total_ti;i++){
					if(document.getElementById('open_dept_'+i).checked==true){
						mvalue.open_dept_string+="-"+document.getElementById('open_dept_'+i).value;
					}
				}
				AWEA_Ajax('<?=$add_self_cal_url?>',mvalue,type);
			}
			break;//
		case 'refresh_calendar':
			JS_Link('<?=$refresh_url?>');
			break;
		case 'search_go':
			//sed
			info[0]={sd_id:'s_startdate',ed_id:'s_enddate',msg:'結束日不能小於起始日',type:'sed'};
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
				AWEA_Ajax('<?=site_url('ecp_common/save_pg_session/'.$pg_tag.'/')?>',data,'');
			}
			break;
		case 'refresh_search':
			JS_Link('<?=site_url($var_purl.'calendar_list_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
			break;
		case 'refresh_calendar_fix':
			JS_Link('<?=site_url($var_purl.'calendar_list_index/list/0/'.$ob.'/'.$ot.'/0/N/')?>');
			break;
		case 'cal_isopen':
			if(data=='Y'){
				$("#dept_plate_div").css('display','block');
			}else{
				$("#dept_plate_div").css('display','none');
			}
			break;
		case 'dept_select':
			var total_ti=parseInt($("#open_dept_ti").val());
			if(data==$("#open_dept_0").val()){
				if(document.getElementById('open_dept_0').checked==true){
					for(i=1;i<=total_ti;i++){
						document.getElementById('open_dept_'+i).checked=true;
						$("#open_dept_"+i).attr('disabled','disabled');
					}
				}else{
					for(i=1;i<=total_ti;i++){
						//document.getElementById('open_dept_'+i).checked=true;
						$("#open_dept_"+i).attr('disabled','');
					}					
				}
			}
			break;
		case 'delete_self_cal':
			if(confirm("確定刪除?")){
				//disable
				data.obj.disabled=true;
				AWEA_Ajax('<?=$delete_self_cal_url?>',data,'');				
			}
			break;
	}

}
</script>