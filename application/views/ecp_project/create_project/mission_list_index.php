<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>

<table width="100%"  onclick="PL_DivClick();">
	<tr>
    	<td valign="top" class="mm_left_info_width">
        <form id="proj_edit_form" method="post" action="<?=$proj_edit_url?>" target="phf">
        <div id="project_info_div"  class="mm_area_div_3"  onclick="PL_DivClick();">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        	<!-- $this->load->view($this->m_controller.'/create_project/project_info_edit_div',array('proj_op'=>$proj_op));-->
        </div>
        <div id="project_mng_div"  class="mm_area_div_3" onclick="PL_DivClick();">
            <?php $this->load->view('common/project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        	<!--$this->load->view($this->m_controller.'/create_project/project_mng_edit_div',array('proj_op'=>$proj_op));-->
        </div>
        </form>
        </td>
        <td valign="top">
<div id="add_mission_div" class="mm_area_div_1">
	<?php $this->load->view($this->m_controller.'/create_project/add_mission_div',array('main_op'=>$main_op,'form_url'=>$form_url,'proj_data'=>$proj_data)); ?>
</div>
<div id="result_area_div" class="mm_area_div_2">	
	<?php $this->load->view($this->m_controller.'/create_project/mission_list_div',array('main_list'=>$main_list,'pd'=>$pd,'proj_data'=>$proj_data)); ?>
</div>
<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/create_project/project_file_list_div',array('file_list'=>$file_list,'fpd'=>$fpd,'proj_data'=>$proj_data)); ?>
</div>
        </td>
    </tr>
</table>
<script>
function pg_submit(type,url)
{	var msg='';
	var info=Array();//-
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

function pg_proj_edit_submit()
{	//check--
	var msg='';
	var info=Array();
	info[0]={id:'name',msg:'專案名稱不可空白',type:'ne'};
	info[1]={sd_id:'startdate',ed_id:'enddate',msg:'結束日不能小於起始日',type:'sed'};
	/*
	if($("#cus_select_type").val()=='S'){
		info[2]={id:'jec_customer_id',msg:'請選擇客戶',type:'ne'};
	}else{
		info[2]={id:'jec_customer_id_title',msg:'請選擇客戶',type:'ne'};
	}	*/
	info[2]={id:'jec_customer_id_title',msg:'請選擇客戶',type:'ne'};
	info[3]={id:'jec_user_id_title',msg:'請選擇專案負責人',type:'ne'};
	info[4]={id:'jec_usersales_id_title',msg:'請選擇業務',type:'ne'};
	if($("#efprojdept").val()!=''){
		info[5]={id:'efprojno',msg:'請選擇專案採購編號',type:'ne'};
	}else{
		info[5]={id:'name',msg:'專案名稱不可空白',type:'ne'};
	}
	msg=fi_submit_check(info);
	if(msg==''){
		data={ cus_name:$("#jec_customer_id_title").val(),sales_name:$("#jec_usersales_id_title").val(),user_name:$("#jec_user_id_title").val() };
		AWEA_Ajax('<?=$check_proj_url?>',data,'');			
	}	
}

function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
}
function PG_BK_Action(type,data)
{ var msg='';
	switch(type){
		case 'edit_proj_go':
			if(GetTagV(data,'isexist')=='Y'){
				$("#jec_customer_id").val(GetTagV(data,'cus_id'));
				//$("#jec_customer_id_title").val(GetTagV(data,'cus_name'));
				$("#jec_user_id").val(GetTagV(data,'user_id'));
				$("#jec_user_id_title").val(GetTagV(data,'user_name'));
				$("#jec_usersales_id").val(GetTagV(data,'sales_id'));
				$("#jec_usersales_id_title").val(GetTagV(data,'sales_name'));
				$("#jec_dept_id").val(GetTagV(data,'sales_dept'));
				document.getElementById('proj_edit_form').submit();
			}
			break;
		case 'change_jobname':
			//alert('hahahhaa');
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
			break;
		case 'after_add_mission':
			PG_BK_Action('reset_add_mission');
			PG_BK_Action('reload_mission_list');
			break;
		case 'reset_add_mission':
				ECP_Load_Div('add_mission_div','<?=$add_mission_url?>','');
			break;
		case 'reload_mission_list':
				ECP_Load_Div('result_area_div','<?=$mission_list_url?>','');
			break;
		case 'reload_file_list':
				ECP_Load_Div('file_area_div','<?=$file_list_url?>','');
			break;
		case 'after_del_mission':
			PG_BK_Action('reset_add_mission');
			PG_BK_Action('reload_mission_list');
			PG_BK_Action('reload_file_list');
			break;
		case 'get_dept_id_by_saler':
			data={ user_id:$("#jec_usersales_id").val() };
			AWEA_Ajax('<?=$get_dept_url?>',data,'');
			break;
		case 'get_purchase_list_by_dept':
			data={ dept_id:$("#efprojdept").val() };
			AWEA_Ajax('<?=$get_purchase_url?>',data,'');
			break;
		case 'get_purchase_name':
			var name=GetString(data,'>>','');
			$("#purchase_name_tag").html(name);
			break;
		case 'change_dept_id':
			var dept_id=GetTagV(data,'dept_id');
			$("#jec_dept_id").val(dept_id);
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
		case 'check_projno'://抓資料進來
			var deptno=$("#efprojdept").val();
			var projno=$("#efprojno").val();
			if(projno!=''){
				data={ projdept:deptno,projno:projno };
				AWEA_Ajax('<?=$check_projno_url?>',data,'');
			}			
			break;
		case 'projno_check_result':
			var isexist=GetTagV(data,'isexist');
			if(isexist=='Y'){
				$("#efprojdept").val(GetTagV(data,'projdept'));
				$("#efprojno").val(GetTagV(data,'projno'));
				$("#efprojname").val(GetTagV(data,'projname'));
			}else{
				alert("查無此專案");
				$("#efprojdept").val('');
				$("#efprojno").val('');
				$("#efprojname").val('');
			}
			break;
		case 'change_projdept':
			$("#efprojno").val('');
			$("#efprojname").val('');
			break;
		case 'search_ef_proj':
			var url="<?=$search_ef_proj_url?>";
			var deptno=$("#efprojdept").val();
			if(deptno=='') deptno='-';
			url=url+'/'+deptno+'/';
			window.open(url,'','width=650,height=600');
			break;
	}
}

var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
//cal.manageFields("startdate", "startdate", "%Y-%m-%d");
//cal.manageFields("enddate", "enddate", "%Y-%m-%d");
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
				job:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_job_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select_con/job_con/'.$key_id.'/')?>','input_id':'jec_job_id','input_type':'R','width':400,'title_id':'jec_job_id_title' },
				cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_customer_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'jec_customer_id','input_type':'R','width':250,'title_id':'jec_customer_id_title' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_user_id','input_type':'R','width':150,'title_id':'jec_user_id_title','top':356 },
				usersales:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_usersales_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_usersales_id','input_type':'R','width':150,'title_id':'jec_usersales_id_title','top':356,'onchange':"get_dept_id_by_saler" }
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

