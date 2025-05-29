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
    	<td valign="top" class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_cost_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/cost_project/project_cost_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td valign="top">
<div id="add_cost_div" class="mm_area_div_1">
	<?php $this->load->view($this->m_controller.'/cost_project/add_cost_div',array('main_op'=>$main_op,'form_url'=>$form_url)); ?>
</div>
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/cost_project/cost_list_div',array('main_list'=>$main_list,'pd'=>$pd)); ?>
</div>
        </td>
    </tr>
</table>
<script>
function pg_submit(type,url)
{	
	switch(type){
		case 'add_cost':
			info=Array();
			info[0]={id:'jec_chargeitem_id',msg:'請選擇費用',type:'ne'};
			info[1]={id:'chargefee',msg:'請輸入金額',type:'nz'};
			msg=fi_submit_check(info);
			if(msg==''){
				mvalue={
					jec_chargeitem_id:$("#jec_chargeitem_id").val(),
					description:$("#description").val(),
					chargefee:$("#chargefee").val(),
					chargedate:$("#chargedate").val()
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
	}

}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'update_cost':
			
			data.chargefee=$("#chargefee_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.chargedate=$("#chargedate_"+data.no).val();
			data.jec_chargeitem_id=$("#jec_chargeitem_id_"+data.no).val();
			AWEA_Ajax('<?=$update_cost_url?>',data,'');
			break;
		case 'after_add_cost':
			PG_BK_Action('reset_add_cost');
			PG_BK_Action('reload_cost_list');
			break;
		case 'after_del_cost':
			PG_BK_Action('reset_add_cost');
			PG_BK_Action('reload_cost_list');
			//PG_BK_Action('reload_file_list'); -無關聯.
			break;			
		case 'reset_add_cost':
				ECP_Load_Div('add_cost_div','<?=$add_cost_url?>','');
			break;
		case 'reload_cost_list':
				ECP_Load_Div('result_area_div','<?=$cost_list_url?>','');
			break;	
	}
}
</script>