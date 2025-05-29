<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<div id="search_area_div" class="mm_area_div_1">
<form id="export_edit_form" method="post" action="<?=$export_url?>" target="phf">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>	
            <tr>
        	<td>選擇料品範本：</td><td id="frominputarea"><?=$s_main_op['s_producttemp']['op']?><?=$s_main_op['excel_type']['op']?><input type="button" value="料品範本匯出EXCEL" onclick="PG_BK_Action('export_excel',{})"></td>
        </tr>
	</table>
</form>
</div>
<div id="result_area_div" class="mm_area_div_2" >
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="5" class="mm_table2_title">範本內容明細列表</td>
    	</tr>
        <tr>
        	<td>編號</td>
            <td>料品品名/工作明細</td>
            <td>規格</td>
            <td>預估單價</td> 
            <td>供應廠商</td>  
        </tr>
    </table>
</div>
<script>
function PG_BK_Action(type,data)
{	var info=Array();
	switch(type){
		case 'search_prod_list':
				ECP_Load_Div('result_area_div','<?=$prod_list_url?>',data);
			break;	
		case 'export_excel':
	
			info[0]={id:'s_producttemp',msg:'請選擇範本',type:'ne'};
			var msg=fi_submit_check(info);
			if(msg==''){
				document.getElementById('export_edit_form').submit();
			}
			break;		
	}
}
</script>