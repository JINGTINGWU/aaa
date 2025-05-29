
<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
</script>
<input type="hidden" name="prodtype_string" id="prodtype_string" value="1" />
<table width="100%" onclick="PL_DivClick();">
<tr><td>
        <div id="project_info_div" class="mm_area_div_3" onclick="PL_DivClick();">
        	<?php $this->load->view('common/project/project_info_div_t3',array('proj_data'=>$proj_data)); ?>
        </div>
</td></tr>
<tr><td>
	<?php //
$add_da=$this->ECPM->m_right_tag['add_da'];
//if($proj_data['projstatus']==6) $add_da='disabled';	
if($proj_data['exportcode']!=''):
	$add_da="disabled";
	$add_dp='style="display:none;"';
endif;
	?>
	<table width="100%" class="info-div" cellspacing="1" cellpadding="3">
    <tr><td rowspan="2" class="info-title" width="60">新增料品<br /><br /><input type="button" value="新增料品" onclick="pg_submit('add_projprod','<?=$form_url?>');" class="mm_submit_button" <?=$add_da?> style="width:60px;" /><br /><input  class="mm_submit_button"  type="button" value="回上頁" onclick="JS_Link('<?=$tcate_url['bk_url']?>')"  style="width:60px;" /></td><td>
<div id="search_area_div"  class="mm_area_div_1">
	<form id="import_edit_form" enctype="multipart/form-data" method="post" target="phf" action="<?=$import_url?>">
    <?php
	$add_dp=$this->ECPM->m_right_tag['add_dp'];
	if($proj_data['exportcode']!=''):
		$add_dp='style="display:none;"';
	endif;
	?>
	<table <?=$add_dp?> >
		<tr>
        	<th>選擇料品範本：</th><td colspan="2"><?=$main_op['import_producttemp']['op']?><input type="button" value="從範本匯入料品清單" onclick="PG_BK_Action('import_producttemp',{})" /></td>
            <th>選擇EXCEL檔案：<br/><a href='<?=base_url()?>uploads/template/download.xls' target="_blank">下載履約備品EXCEL範本</a></th><td><?=$main_op['import_excel']['op']?></td><td><input type="button" value="從EXCEL匯入料品清單" onclick="pg_submit('import_prod_excel');" /></td><td><input type="button" value="匯出EXCEL檔" onclick="pg_submit('export_excel');" /></td>
        </tr>
	</table>
    </form>
</div>
    </td></tr>
    <tr><td>
    <form id="edit_form" method="post" target="phf" action="">
    <input type="hidden" name="excel_type" id="f_excel_type" value="" /> 
    <input type="hidden" name="jec_project_id" id="jec_project_id" value="<?=$proj_data['jec_project_id']?>" />
    <div id="add_prod_div">
   
		<?php $this->load->view($this->m_controller.'/prepare_item/add_prod_div',array('main_op'=>$main_op,'form_url'=>$form_url)); ?>
    
    </div>  
    </form> 
    </td></tr>
    </table>
    <table class="info-div" cellspacing="1" cellpadding="3" style="height:60px;">
    <tr><td class="info-title" width="50">ERP</td>
    <td><input type="button" value="送出ERP銷售預測" onclick="pg_submit('export_copme');" <?=$proj_data['resda021']=='2' && $proj_data['efprojno']!=''?'':'disabled="disabled"'?>/>(備品核准後可拋至ERP銷售預測，請至訂單複製前置單據)</td>
    </tr></table>
</td></tr>
<tr><td colspan="2">
<div id="result_area_div"  class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/prepare_item/prod_list_div',array('main_list'=>$main_list,'uom_pdb'=>$uom_pdb,'pd'=>$pd)); ?>
</div> 
</td></tr>

</table>
<script>
function pg_submit(type,url)
{	var info=Array(); var msg='';
	switch(type){
		
		case 'add_projprod':
			info[0]={id:'value',msg:'請輸入料號',type:'ne'};
			info[1]={id:'jec_product_id_title',msg:'請輸入品名',type:'ne'};
			info[2]={id:'quantity',msg:'請輸入數量',type:'nz'};
			info[3]={id:'prod_uom_id',msg:'請選擇單位',type:'ne'};
			//info[2]={id:'prod_uom_id',msg:'請選擇單位',type:'ne'};
			//要先check廠商/人員------ 
			msg=fi_submit_check(info);
			if(msg==''){
				var mvalue={//
					//prodtype:PG_BK_Action('get_init_prodtype',{}),					
					jec_product_id:$("#jec_product_id").val(),
					description:$("#description").val(),
					quantity:$("#quantity").val(),
					price:$("#price").val(),
					jec_vendor_id:$("#jec_vendor_id").val(),
					startdate:$("#startdate").val(),
					prod_uom_id:$("#prod_uom_id").val(),
					jec_user_id:$("#jec_user_id").val(),
					prodspec:$("#prodspec").val(),
					prodname:$("#jec_product_id_title").val(),
					value:$("#value").val(),
					jec_user_id_title:$("#jec_user_id_title").val()
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
		case 'export_excel':
			document.getElementById('edit_form').action="<?=$export_excel_url?>";
			$("#f_excel_type").val($("#excel_type").val());
			document.getElementById('edit_form').submit();
			break;
		case 'export_copme':
			data={
					jec_project_id:'<?=$key_id?>',
					target_db:$("#target_db").val(),
					jec_customer_id:'<?=$proj_data['jec_customer_id']?>'
				};
			if (data['jec_customer_id'] != "")
			{
				document.getElementById('edit_form').action="<?=$export_copme_url?>";			
				document.getElementById('edit_form').submit();			
			}
			else
			{
				alert('客戶名稱未正確對應ERP客戶代號，請修正後再送銷售預測');
			}
			break;
		case 'import_prod_excel':
			info[0]={id:'import_excel',msg:'請選擇上傳檔案',type:'ne'};
			msg=fi_submit_check(info);
			if(msg==''){
				if(confirm("確定匯入?")){
					document.getElementById('import_edit_form').submit();
				}
			}
			break;
	}

}

function PG_BK_Action(type,data)
{ var msg='';var info=Array();
	switch(type){
		case 'get_init_prodtype':
			var prodtype=1;
			if($("#prodtype_string").val()=='work'){
				prodtype=9;
			}
			return prodtype;
			break;
		case 'change_prodname':
			$("#jec_product_id").val('');
			document.getElementById('prodspec').disabled=false;
			document.getElementById('prod_uom_id').disabled=false;
			break;
		case 'change_value':
			$("#jec_product_id").val('');
			document.getElementById('prodspec').disabled=false;
			document.getElementById('prod_uom_id').disabled=false;
			break;
		case 'import_producttemp':
			
			data.producttemp_id=$("#import_producttemp").val();
			if(confirm("確定匯入?")){
				AWEA_Ajax('<?=$import_producttemp_url?>',data,'');
			}
			break;
		case 'update_projprod':
			if($("#oppro_value_"+data.no).length > 0)
			{
			info[0]={id:'oppro_value_'+data.no,msg:'請輸入料號',type:'ne'};
			info[1]={id:'prodname_'+data.no,msg:'請輸入品名',type:'ne'};
			info[2]={id:'quantity_'+data.no,msg:'請輸入數量',type:'nz'};
			info[3]={id:'prod_uom_id_'+data.no,msg:'請選擇單位',type:'ne'};
			//info[2]={id:'prod_uom_id',msg:'請選擇單位',type:'ne'};
			//要先check廠商/人員------ 
			msg=fi_submit_check(info);
			}
			if(msg==''){			
			data.quantity=$("#quantity_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.startdate=$("#startdate_"+data.no).val();
			data.jec_vendor_id=$("#jec_vendor_id_"+data.no).val();
			data.jec_user_id=$("#jec_user_id_"+data.no).val();
			data.price=$("#price_"+data.no).val();
			data.jec_user_id_title=$("#jec_user_id_title_"+data.no).val();
			//假如是可修改的品號,才去抓textbox內的值
			if($("#oppro_value_"+data.no).length > 0)
			data.value=$("#oppro_value_"+data.no).val();
			if($("#prodname_"+data.no).length > 0)
			data.prodname=$("#prodname_"+data.no).val();
			if($("#prodspec_"+data.no).length > 0)
			data.prodspec=$("#prodspec_"+data.no).val();
			
			data.prod_uom_id=$("#prod_uom_id_"+data.no).val();
			
			AWEA_Ajax('<?=$update_projprod_url?>',data,'');
			}
			break;
		case 'after_add_prod':
			PG_BK_Action('reset_add_prod');
			PG_BK_Action('reload_prod_list');
			break;
		case 'reset_add_prod':
				ECP_Load_Div('add_prod_div','<?=$add_prod_url?>','');
			break;
		case 'reload_prod_list':
				ECP_Load_Div('result_area_div','<?=$prod_list_url?>','');
			break;
		case 'check_prodtype':
			data={ jec_product_id:$("#jec_product_id").val() };
			AWEA_Ajax('<?=$check_prodtype_url?>',data,'');
			break;
		case 'edit_spec_prod':
			//自動帶入單價			
			$("#value").val(GetTagV(data,'value'));
			$("#jec_product_id_title").val(GetTagV(data,'name'));
			$("#price").val(GetTagV(data,'prod_price'));
			$("#prodspec").val(GetTagV(data,'prod_spec'));
			$("#prod_uom_id").val(GetTagV(data,'prod_uom_id'));
			//document.getElementById('prodspec').disabled=true;
			//document.getElementById('prod_uom_id').disabled=true;
			if(GetTagV(data,'prodtype')=='8'){
				//document.getElementById('spec_prod_div').style.display='block';
			}else{
				//clean&none-

			}
			break;	
		case 'recount_row_cost':
			//data->no
			fi_nod(document.getElementById('extramultiple_'+data));
			fi_noam(document.getElementById('extraaddition_'+data));
			var base_total=parseFloat($("#total_tag_"+data).html());
			var base_cost=parseFloat($("#cost_total_"+data).val());
			if($("#extramultiple_"+data).val()==''){
				var multi_var=0;
			}else{
				var multi_var=parseFloat($("#extramultiple_"+data).val());
			}
			if($("#extraaddition_"+data).val()==''){
				var add_var=0;
			}else{
				var add_var=parseFloat($("#extraaddition_"+data).val());
			}			
			//var add_var=parseFloat($("#extraaddition_"+data).val());
			var new_esti_cost=accMul(base_total,multi_var)+add_var;//+add_var
			if(base_cost==0){
				var new_esti_sales=new_esti_cost;
			}else{
				var new_esti_sales=accMul(base_cost,multi_var)+add_var;//+add_var
			}
			
			$("#estimcostcalc_tag_"+data).html(new_esti_cost+'');
			if($("#prodtype_"+data).val()!='9'){
				$("#salecostcalc_tag_"+data).html(new_esti_sales+'');
			}
			break;	
		case 'change_prod_pq'://change_tag_
			fi_nod(document.getElementById("price_"+data));
			fi_nod(document.getElementById("quantity_"+data));
			var unit_price=$("#price_"+data).val();
			if(unit_price==''){ 
				$("#price_"+data).val(0);
				unit_price=0;
			}
			var qty=$("#quantity_"+data).val();
			if(qty==''){ 
				qty=0;
				$("#quantity_"+data).val(0);
			}
			if(qty==0||unit_price==0){
				var new_total='0';
			}else{
				var new_total=accMul(parseFloat(unit_price),parseFloat(qty));
			}
			
			$("#total_tag_"+data).html(new_total);
			PG_BK_Action('recount_row_cost',data);
			break;	
		case 'prod_search_type':
			//data=>check_id
			var old_url=InputList.info.product.url;
			if(document.getElementById(data).checked==true){
				new_url=old_url.replace('/search_select/','/search_select_self/');
				
			}else{
				new_url=old_url.replace('/search_select_self/','/search_select/');
			}
			InputList.info.product.url=new_url;
			//alert(new_url);
			break;
		case 'prod_search_prodtype':
			//data->work/full/prod
			var old_url=InputList.info.product.url;
			if(InStr(old_url,'/product_work')){
				var target_tag='/product_work';
			}else{
				var target_tag='/product';
			}
			if(data=='work'){
				new_url=old_url.replace(target_tag,'/product_work');
			}else{
				new_url=old_url.replace(target_tag,'/product');
			}

			InputList.info.product.url=new_url;
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
//Textbox下拉選單設定
var InputList={
		on:'product',
		info:{ 
				product:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_product_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/product/')?>','input_id':'jec_product_id','input_type':'R','width':400,'title_id':'jec_product_id_title','onchange':'check_prodtype' },
				value:{ search_list:'pl_search_list',search_value:'search_value',search_here:'value',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/value/')?>','input_id':'jec_product_id','input_type':'R','width':200,'title_id':'value','onchange':'check_prodtype' },
				<?php
				for($i=0;$i<$pp;$i++):
					?>
					vendor_<?php echo $i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title_<?php echo $i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id_<?php echo $i?>','input_type':'R','width':230,'title_id':'jec_vendor_id_title_<?php echo $i?>' },
					user_<?php echo $i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title_<?php echo $i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_user_id_<?php echo $i?>','input_type':'R','width':230,'title_id':'jec_user_id_title_<?php echo $i?>' },
					<?php
				endfor;
				?>
				vendor:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id','input_type':'R','width':200,'title_id':'jec_vendor_id_title' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_user_id','input_type':'R','width':200,'title_id':'jec_user_id_title' }
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