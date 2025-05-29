
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
</div>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("startdate", "startdate", "%Y-%m-%d");
cal.manageFields("enddate", "enddate", "%Y-%m-%d");
//cal.manageFields("s_startdate", "s_startdate", "%Y-%m-%d");
//cal.manageFields("s_enddate", "s_enddate", "%Y-%m-%d");
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
	}

}
</script>