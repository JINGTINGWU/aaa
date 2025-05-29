<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
<script src="<?=base_url()?>js/form_input.js"></script>
<div id="search_area_div" class="mm_area_div_1" onclick="PL_DivClick();">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">待移轉人員：</td><td id="frominputarea"><?=$main_op['from_user']['op']?></td>
        </tr>
        <tr>
            <td align="right">移轉到人員：</td><td id="frominputarea"><?=$main_op['to_user']['op']?></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="button" value="工作確定移轉" onclick="PG_BK_Action('trans_go',{})" class="mm_submit_button" /></td>
        </tr>
	</table>
</div>

<script>

function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
}
function PG_BK_Action(type,data)
{   var info=Array();
	switch(type){
		case 'trans_go':
			info[0]={id:'from_user',msg:'請選擇離職人員。',type:'ne'};
			info[1]={id:'to_user',msg:'請選擇轉入人員。',type:'ne'};
			msg=fi_submit_check(info);
			if(msg==''){
				if(confirm("確定移轉?")){
					data.from_user=$("#from_user").val();
					data.to_user=$("#to_user").val();
					AWEA_Ajax('<?=$form_url?>',data,'');
				}
			}
			break;
		case 'after_trans':
			$("#from_user").val("");
			$("#to_user").val("");
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
		on:'cus',
		info:{ 
				cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_customer_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'s_proj_jec_customer_id','input_type':'R','width':200,'title_id':'s_proj_customer_title' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_salesuser_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_proj_jec_salesuser_id','input_type':'R','width':200,'title_id':'s_proj_salesuser_title' }
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