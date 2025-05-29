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
    	<td valign="top" class="mm_left_info_width">		
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_add_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/addendum_project/project_add_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td valign="top">
<div id="add_prod_div" class="mm_area_div_1" onclick="PL_DivClick();">
	<?php $this->load->view($this->m_controller.'/addendum_project/add_prod_div',array('main_op'=>$main_op,'form_url'=>$form_url)); ?>
</div>
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/addendum_project/a_prod_list_div',array('main_list'=>$main_list,'pd'=>$pd)); ?>

</div>
<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/addendum_project/a_file_list_div',array('file_list'=>$file_list,'fpd'=>$fpd)); ?>

</div>
        </td>
    </tr>
</table>
<script>
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
}
function pg_submit(type,url)
{
	switch(type){
		case 'add_prod':
			info=Array();
			info[0]={id:'jec_product_id_title',msg:'請選擇料品',type:'ne'};
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
					product_name:$("#jec_product_id_title").val(),
					description:$("#description").val(),
					quantity:$("#quantity").val(),
					price:$("#price").val(),
					addsubdate:$("#addsubdate").val(),
					addsubtype:$("#addsubtype").val(),
					value_spec:$("#value_spec").val(),
					name_spec:$("#name_spec").val(),
					jec_uom_id_spec:$("#jec_uom_id_spec").val(),
					specification_spec:$("#specification_spec").val(),
					description_spec:$("#description_spec").val()
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
		case 'import_prod_model':
			break;
		case 'import_prod_excel':
			break;
	}

}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'update_projprod':
			
			data.quantity=$("#quantity_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.addsubdate=$("#addsubdate_"+data.no).val();
			//data.jec_vendor_id=$("#jec_vendor_id_"+data.no).val();
			data.price=$("#price_"+data.no).val();
			
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
		case 'after_add_prod':
			PG_BK_Action('reset_add_prod');
			PG_BK_Action('reload_prod_list');
			break;
		case 'after_del_prod':
			PG_BK_Action('reset_add_prod');
			PG_BK_Action('reload_prod_list');
			//PG_BK_Action('reload_file_list'); -無關聯.
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
			$("#price").val(GetTagV(data,'prod_price'));
			if(GetTagV(data,'prodtype')=='8'){
				document.getElementById('spec_prod_div').style.display='block';
			}else{
				//clean&none-
				document.getElementById('spec_prod_div').style.display='none';
				document.getElementById('value_spec').value='';
				document.getElementById('name_spec').value='';
				document.getElementById('jec_uom_id_spec').value='';
				document.getElementById('description_spec').value='';
				document.getElementById('specification_spec').value='';
			}
			break;	
		case 'reload_file_list':
				ECP_Load_Div('file_area_div','<?=$file_list_url?>','');
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
		on:'product',
		info:{ 
				product:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_product_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/product/')?>','input_id':'jec_product_id','input_type':'R','width':350,'title_id':'jec_product_id_title','onchange':'check_prodtype' }
			 },
		on_select:'on_select',
		select_status:'select_status',
		css_off_select:'off_select',
		css_on_select:'on_select',
		pg_list_on:'N',
		blank_url:'<?=base_url('ecp_test/blank')?>',
		onfocus:'',
		left:50
		//,input_type:'A' //A/R		
	};
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>