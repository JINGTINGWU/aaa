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
<table width="100%">
	<tr>
    	<?php if($key_id>0):?>
    	<td valign="top" class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_invoice_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/invoice_analysis/project_invoice_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <?php endif;?>
        </td>
        <td valign="top">
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/invoice_analysis/invoice_list_div',array('main_list'=>$main_list,'pd'=>$pd)); ?>
</div>
        </td>
    </tr>
</table>
<form name="pg_form" id="pg_form" target="phf" method="post" action="">
<input type="hidden" name="pg_var_1" id="pg_var_1" />
</form>
<script>
function pg_submit(type,url)
{	
	switch(type){
		case 'add_invoice':
			info=Array();
			info[0]={id:'invoiceamount',msg:'請輸入金額',type:'nz'};
			msg=fi_submit_check(info);
			if(msg==''){
				mvalue={
					invoiceamount:$("#invoiceamount").val(),
					description:$("#description").val(),
					invoiceyear:$("#invoiceyear").val(),
					invoicedate:$("#invoicedate").val(),
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
	}

}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'update_invoice':
			
			data.invoiceamount=$("#invoiceamount_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.invoicedate=$("#invoicedate_"+data.no).val();
			data.invoiceyear=$("#invoiceyear_"+data.no).val();
			AWEA_Ajax('<?=$update_invoice_url?>',data,'');
			break;
		case 'after_add_invoice':
			PG_BK_Action('reset_add_invoice');
			PG_BK_Action('reload_invoice_list');
			break;
		case 'after_del_invoice':
			PG_BK_Action('reset_add_invoice');
			PG_BK_Action('reload_invoice_list');
			//PG_BK_Action('reload_file_list'); -無關聯.
			break;			
		case 'reset_add_invoice':
				ECP_Load_Div('add_invoice_div','<?=$add_invoice_url?>','');
			break;
		case 'reload_invoice_list':
				ECP_Load_Div('result_area_div','<?=$invoice_list_url?>','');
			break;
		case 'export_excel':
			document.getElementById('pg_form').action="<?=$export_excel_url?>";
			$("#pg_var_1").val($("#excel_type").val());
			document.getElementById('pg_form').submit();
			break;	
	}
}
</script>