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
<table width="100%" onclick="PL_DivClick();">
	<tr>
    <td rowspan="2">
        <div id="task_info_div" class="mm_area_div_3">
			<?php $this->load->view('common/task/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
    </td>
    <td>
        <div id="project_info_div" class="mm_area_div_3" onclick="PL_DivClick();">
        	<?php $this->load->view('common/project/project_info_div_top',array('proj_data'=>$proj_data)); ?>
        </div>
    <td>
    </tr>
    <tr><td>
<div id="search_area_div"  class="mm_area_div_1">
	<form id="import_edit_form" enctype="multipart/form-data" method="post" target="phf" action="<?=$import_url?>">
    <?php
	$add_dp=$this->ECPM->m_right_tag['add_dp'];
	if($proj_data['projstatus']==6):
   		$add_dp='style="display:none;"';
	endif;
	?>
	<table <?=$add_dp?> >
		<tr>
        	<th>選擇料品範本：</th><td colspan="2"><?=$main_op['import_producttemp']['op']?><input type="button" value="從範本匯入料品清單" onclick="PG_BK_Action('import_producttemp',{})" /></td>
            <th>選擇EXCEL檔案：</th><td><?=$main_op['import_excel']['op']?></td><td><input type="button" value="從EXCEL匯入料品清單" onclick="pg_submit('import_prod_excel');" /></td>
        </tr>
	</table>
    </form>
    <div id="add_jobdetail_div">
		<?php $this->load->view($this->m_controller.'/create_project/add_jobdetail_div',array('main_op'=>$main_op,'form_url'=>$form_url)); ?>
    </div>
    </td></tr>
    <tr><td colspan="2">
<div id="result_area_div"  class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/create_project/jobdetail_list_div',array('main_list'=>$main_list,'uom_pdb'=>$uom_pdb,'pd'=>$pd)); ?>
</div>  
    </td></tr>
</table>    

<script>
function pg_submit(type,url)
{	var info=Array();	
	switch(type){
		case 'add_projprod':
			
			info[0]={id:'jec_product_id',msg:'請選擇料品',type:'ne'};
			info[1]={id:'quantity',msg:'請輸入數量',type:'nz'};
			info[2]={id:'price',msg:'請輸入單價',type:'nz'};
			if(document.getElementById('spec_prod_div').style.display=='block'){
				info[3]={id:'value_spec',msg:'請輸入自訂料號',type:'ne'};
				info[4]={id:'name_spec',msg:'請輸入自訂料品名稱',type:'ne'};
				info[5]={id:'jec_uom_id_spec',msg:'請輸入自訂料品單位',type:'ne'};
			}
			msg=fi_submit_check(info);
			if(msg==''){
				mvalue={
					jec_product_id:$("#jec_product_id").val(),
					description:$("#description").val(),
					quantity:$("#quantity").val(),
					price:$("#price").val(),
					jec_vendor_id:$("#jec_vendor_id").val(),
					startdate:$("#startdate").val(),
					value_spec:$("#value_spec").val(),
					name_spec:$("#name_spec").val(),
					jec_uom_id_spec:$("#jec_uom_id_spec").val(),
					specification_spec:$("#specification_spec").val(),
					description_spec:$("#description_spec").val()
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
		case 'import_prod_excel':
			info[0]={id:'import_excel',msg:'請選擇上傳檔案',type:'ne'};
			msg=fi_submit_check(info);
			if(msg==''){
				document.getElementById('import_edit_form').submit();
			}
			break;
	}

}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'import_producttemp':
			
			data.producttemp_id=$("#import_producttemp").val();
			AWEA_Ajax('<?=$import_producttemp_url?>',data,'');
			break;
		
		case 'update_projprod'://
			
			data.quantity=$("#quantity_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.startdate=$("#startdate_"+data.no).val();
			data.jec_vendor_id=$("#jec_vendor_id_"+data.no).val();
			data.price=$("#price_"+data.no).val();
			
			data.extramultiple=$("#extramultiple_"+data.no).val();
			data.extraaddition=$("#extraaddition_"+data.no).val();
			data.estimcostcalc=$("#estimcostcalc_tag_"+data.no).html();
			data.salecostcalc=$("#salecostcalc_tag_"+data.no).html();
			
			if($("#oppro_value_"+data.no).length>0){
				data.oppro_value=$("#oppro_value_"+data.no).val();
			}
			if($("#oppro_name_"+data.no).length>0){
				data.oppro_name=$("#oppro_name_"+data.no).val();
			}
			if($("#oppro_specification_"+data.no).length>0){
				data.oppro_specification=$("#oppro_specification_"+data.no).val();
			}
			if($("#oppro_uom_"+data.no).length>0){
				data.oppro_uom=$("#oppro_uom_"+data.no).val();
			}
			AWEA_Ajax('<?=$update_projprod_url?>',data,'');
			break;
		case 'after_add_jobdetail':
			PG_BK_Action('reset_add_jobdetail');
			PG_BK_Action('reload_jobdetail_list');
			break;
		case 'reset_add_jobdetail':
				ECP_Load_Div('add_jobdetail_div','<?=$add_jobdetail_url?>','');
			break;
		case 'reload_jobdetail_list':
				ECP_Load_Div('result_area_div','<?=$jobdetail_list_url?>','');
			break;
		case 'check_prodtype':
			data={ jec_product_id:$("#jec_product_id").val() };
			AWEA_Ajax('<?=$check_prodtype_url?>',data,'');
			break;
		case 'edit_spec_prod':
			$("#price").val(GetTagV(data,'prod_price'));
			if(GetTagV(data,'prodtype')=='8'){
				//document.getElementById('spec_prod_div').style.display='block';
			}else{
				//clean&none-
				/*
				document.getElementById('spec_prod_div').style.display='none';
				document.getElementById('value_spec').value='';
				document.getElementById('name_spec').value='';
				document.getElementById('jec_uom_id_spec').value='';
				document.getElementById('description_spec').value='';
				document.getElementById('specification_spec').value='';*/
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
			var new_esti_sales=accMul(base_cost,multi_var)+add_var;//+add_var
			
			$("#estimcostcalc_tag_"+data).html(new_esti_cost+'');
			$("#salecostcalc_tag_"+data).html(new_esti_sales+'');
			break;
	}
}
function pg_proj_edit_submit()
{
	document.getElementById('proj_edit_form').submit();
}



</script>
<div id="pl_search_div" style="display:none;background:#FFFFFF;position:absolute;top:0px;left:0px;">
<iframe id="pl_search_list" name="pl_search_list" frameborder="0" style="border:1px solid #CCCCCC;width:600px;height:300px;" ></iframe>
</div> 
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>

var InputList={
		on:'product',
		info:{ 
				product:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_product_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/product/')?>','input_id':'jec_product_id','input_type':'R','width':400,'title_id':'jec_product_id_title','onchange':'check_prodtype' },
				<?php
				for($i=0;$i<$pp;$i++):
					?>
					vendor_<?php echo $i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title_<?php echo $i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id_<?php echo $i?>','input_type':'R','width':100,'title_id':'jec_vendor_id_title_<?php echo $i?>' },
					<?php
				endfor;
				?>
				vendor:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id','input_type':'R','width':100,'title_id':'jec_vendor_id_title' }
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