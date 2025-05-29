<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_td_pad{
	padding-right:2px;
}
</style>

<div  id="search_area_div" class="mm_area_div_1">
<form id="edit_form" method="post" action="<?=$form_url?>" target="phf" onsubmit="return false;">
	<table class="query-div" cellspacing="1" cellpadding="3"  onclick="PL_DivClick();">
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">選擇履約備品清單所屬的專案：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['jec_project_id']['op']?><?=$main_op['jec_project_id_title']['op']?></td>
           <td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><input type="button" value="新增履約備品清單，內容稍後自行輸入" onclick="pg_submit('def');" /></td>
        </tr>
		<tr>
        	<td align="right">選擇料品範本：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['item_model']['op']?></td>
           <td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><input type="button" value="載入料品範本資料，並自動新增履約備品清單" onclick="pg_submit('item_model');" /></td>
        </tr>
		<tr>
        	<td align="right">選擇已建檔的履約備品清單：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['project_history']['op']?></td>
           <td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><input type="button" value="複製該清單所有資料，並自動新增履約備品清單" onclick="pg_submit('project_history');" /></td>
        </tr>        
        
	</table>
</form>    
</div>
<script>

function pg_submit(type)
{
	var info=Array();
	info[0]={id:'jec_project_id_title',msg:'所屬專案名稱不可空白',type:'ne'};
	switch(type){
		case 'def':
			document.getElementById('item_model').value='';
			document.getElementById('project_history').value='';
			break;
		case 'item_model':
			info[1]={id:'item_model',msg:'請選擇料品範本',type:'ne'};
			document.getElementById('project_history').value='';
			break;
		case 'project_history':
			info[1]={id:'project_history',msg:'請選擇專案',type:'ne'};
			document.getElementById('item_model').value='';
			break;
	}
	msg=fi_submit_check(info);
	if(msg==''){
		//final check
		//
		data={ proj_name:$("#jec_project_id_title").val() };
		AWEA_Ajax('<?=$check_item_url?>',data,'');
		//document.getElementById('edit_form').submit();
	}
}
function PG_BK_Action(type,data)
{	var info=Array();
	switch(type){
		case 'add_item_go':
			if(GetTagV(data,'isexist')=='Y'){
				$("#jec_project_id").val(GetTagV(data,'proj_id'));
				document.getElementById('edit_form').submit();  
			}
			break;
		case 'clean_project_id':
			
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
		on:'project',
		info:{ 
				project:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_project_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/prep_project/')?>','input_id':'jec_project_id','input_type':'R','width':300,'title_id':'jec_project_id_title' }
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