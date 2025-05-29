<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<table width="100%" onclick="PL_DivClick();">
	<tr>
    	<td valign="top"  class="mm_left_info_width">
        <div id="project_info_div" class="mm_area_div_3" onclick="PL_DivClick();">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_mng_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/init_project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td valign="top">
<div id="add_job_div" class="mm_area_div_1">
	<?php $this->load->view($this->m_controller.'/init_project/add_job_div',array('main_op'=>$main_op,'form_url'=>$form_url)); ?>
</div>
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/init_project/job_list_div',array('main_list'=>$main_list,'pd'=>$pd)); ?>
</div>
<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/init_project/project_file_list_div',array('file_list'=>$file_list,'fpd'=>$fpd)); ?>
</div>
        </td>
    </tr>
</table>
<script>
function pg_submit(type,url)
{
	info=Array();
	info[0]={id:'jec_job_id_title',msg:'任務不可空白',type:'ne'};
	msg=fi_submit_check(info);
	if(msg==''){
		mvalue={
				jec_job_id:$("#jec_job_id").val(),
				jobname:$("#jec_job_id_title").val(),
				description:$("#description_n").val()
			};
		AWEA_Ajax(url,mvalue,type);
		//document.getElementById('edit_form').submit();
	}
}

function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
}
function PG_BK_Action(type,data)
{ var msg='';
	switch(type){
		case 'change_jobname':
			$("#jec_job_id").val('');
			break;
		case 'update_projjob':
			data.description=$("#description_"+data.no).val();
			data.jobjobtype=$("#jobjobtype_"+data.no).val();
			if($("#jobname_"+data.no).length>0){
				data.jobname=$("#jobname_"+data.no).val();
				if(data.jobname==''){
					msg="任務名稱不可空白。";
				}	//
			}else{
				data.jobname="";
			}
			if(msg==''){
				AWEA_Ajax('<?=$update_projjob_url?>',data,'');
			}else{
				humane.error(msg);
			}//	
			/*
			AWEA_Ajax('<?=$update_projjob_url?>',data,'');*/
			break;
		case 'after_add_job':
			PG_BK_Action('reset_add_job');
			PG_BK_Action('reload_job_list');
			break;
		case 'reset_add_job':
				ECP_Load_Div('add_job_div','<?=$add_job_url?>','');
			break;
		case 'reload_job_list':
				ECP_Load_Div('result_area_div','<?=$job_list_url?>','');
			break;
		case 'reload_file_list':
				ECP_Load_Div('file_area_div','<?=$file_list_url?>','');
			break;
		case 'after_del_job':
			PG_BK_Action('reset_add_job');
			PG_BK_Action('reload_job_list');
			PG_BK_Action('reload_file_list');
			break;
		case 'job_search_type':
			//data=>check_id
			var old_url=InputList.info.job.url;
			if(document.getElementById(data).checked==true){
				new_url=old_url.replace('/search_select_con/','/search_select_con_self/');
				
			}else{
				new_url=old_url.replace('/search_select_con_self/','/search_select_con/');
			}
			InputList.info.job.url=new_url;
			//alert(new_url);
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
		on:'job',
		info:{ 
				job:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_job_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select_con/job_con/'.$key_id.'/')?>','input_id':'jec_job_id','input_type':'R','width':400,'title_id':'jec_job_id_title' }
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