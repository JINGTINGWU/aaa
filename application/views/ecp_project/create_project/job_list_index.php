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
<tr><td>
        <div id="project_info_div" class="mm_area_div_1" onclick="PL_DivClick();">
        	<?php $this->load->view('common/project/project_info_div_t2',array('proj_data'=>$proj_data)); ?>
        </div>
</td><td>
        <div id="mission_info_div" class="mm_area_div_3">
			<?php $this->load->view('common/job/job_info_div_t2',array('projj_data'=>$projj_data,'jobtype_pdb'=>$jobtype_pdb)); ?>
        </div>
</td></tr>
	<tr>
        <td valign="top" colspan="2">
<div id="add_task_div"  class="mm_area_div_1">
	<?php $this->load->view($this->m_controller.'/create_project/add_task_div',array('main_op'=>$main_op,'form_url'=>$form_url,'proj_data'=>$proj_data)); ?>
</div>
<div id="result_area_div"   class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/create_project/task_list_div',array('main_list'=>$main_list,'pd'=>$pd,'user_ld'=>$ip_info['jec_user_id']['ld'],'proj_data'=>$proj_data)); ?>
</div>
<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/create_project/job_file_list_div',array('main_list'=>$file_list,'fpd'=>$fpd,'proj_data'=>$proj_data)); ?>
</div>
        </td>
    </tr>
</table>
<script>
function pg_submit(type,url)
{	

	var info=Array();//
	info[0]={id:'jec_task_id_title',msg:'工作項目不可空白',type:'ne'};
	//info[1]={id:'startdate',msg:'工作起始日期不可空白',type:'ne'};
	//info[2]={id:'enddate',msg:'工作結束日期不可空',type:'ne'};
	//
	if($("#startdate").val()!=''&&$("#enddate").val()!=''){
		info[1]={sd_id:'startdate',ed_id:'enddate',msg:'結束日不能小於起始日',type:'sed'};
	}
	
	var msg=fi_submit_check(info);
	if(msg==''){
		if($("#jec_user_id_title").val()!=''){
			data={ bk_action:'add_task_go',sales_name:$("#jec_user_id_title").val()};
			AWEA_Ajax('<?=$check_task_url?>',data,'');
		}else{
			PG_BK_Action('add_task_go','<isexist>Y</isexist><sales_id></sales_id>');
		}			
	}
}
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
}
function PG_BK_Action(type,data)
{	var info=Array();  var msg='';
	switch(type){
		case 'recover_task_user':
			var no=GetTagV(data,'no');
			if(GetTagV(data,'is_sales')=='Y'){
				$("#jec_user_id_"+no).val(GetTagV(data,'bk_userid'));
				$("#jec_user_id_title_"+no).val(GetTagV(data,'bk_username'));
			}
			if(GetTagV(data,'is_super')=='Y'){
				$("#jec_usersuper_id_"+no).val(GetTagV(data,'bk_superid'));
				$("#jec_usersuper_id_title_"+no).val(GetTagV(data,'bk_supername'));
			}			
			break;
		case 'add_task_go':
			if(GetTagV(data,'isexist')=='Y'){
				mvalue={
						jec_task_id:$("#jec_task_id").val(),
						description:$("#description").val(),
						startdate:$("#startdate").val(),
						enddate:$("#enddate").val(),
						jec_user_id:GetTagV(data,'sales_id'),
						jec_user_id_title:$("#jec_user_id_title").val(),
						price:$("#price").val(),
						taskname:$("#jec_task_id_title").val(),
						taskprocesstype:$("#taskprocesstype").val(),
						taskdaynotice:$("#taskdaynotice").val(),
						taskdaydelay:$("#taskdaydelay").val(),
						taskworkweight:$("#taskworkweight").val(),
						taskconfirmtype:$("#taskconfirmtype").val()
				};
				AWEA_Ajax('<?=$form_url?>',mvalue,'add_task');
			}
			break;
		case 'change_taskname':
			$("#jec_task_id").val('');
			break;
		case 'update_projtask':
			
			data.jec_user_id=$("#jec_user_id_"+data.no).val();
			data.jec_user_id_title=$("#jec_user_id_title_"+data.no).val();
			data.jec_usersuper_id=$("#jec_usersuper_id_"+data.no).val();
			data.jec_usersuper_id_title=$("#jec_usersuper_id_title_"+data.no).val();
			data.description=$("#description_"+data.no).val();
			data.startdate=$("#startdate_"+data.no).val();
			data.enddate=$("#enddate_"+data.no).val();
			data.price=$("#price_"+data.no).val();
			data.taskdaynotice=$("#taskdaynotice_"+data.no).val();
			data.taskdaydelay=$("#taskdaydelay_"+data.no).val();
			data.taskworkweight=$("#taskworkweight_"+data.no).val();
			data.taskprocesstype=$("#taskprocesstype_"+data.no).val();
			data.taskconfirmtype=$("#taskconfirmtype_"+data.no).val();
			data.no=data.no;


			//info[0]={id:'startdate_'+data.no,msg:'工作起始日期不可空白',type:'ne'};
			//info[1]={id:'enddate_'+data.no,msg:'工作結束日期不可空',type:'ne'};
			info[0]={sd_id:'startdate_'+data.no,ed_id:'enddate_'+data.no,msg:'結束日不能小於起始日',type:'sed'};
			info[1]={id:'jec_usersuper_id_title_'+data.no,msg:'請選擇督導人員',type:'ne'};
			info[2]={sd_id:'jec_user_id_title_'+data.no,ed_id:'jec_usersuper_id_title_'+data.no,msg:'負責人與督導人不得相同',type:'quote'};
			if($("#taskname_"+data.no).length>0){
				info[3]={id:'taskname_'+data.no,msg:'工作名稱不可空白',type:'ne'};
				data.taskname=$("#taskname_"+data.no).val();
			}else{
				data.taskname='';
			}
			msg=fi_submit_check(info);
			var strdate=$("#enddate_"+data.no).val().replace(/-/g,"/");			
			var ed=new Date(strdate);
			var cd = new Date();			
			if(Date.parse(ed).valueOf()<=Date.parse(cd).valueOf() && strdate!="0000/00/00")
			{
				if(!confirm('工作結束日小於今日，將導致負責人一收到工作通知就逾期，\r\n請審慎設定，如有惡意者將呈報上級'))
				{
					return;
				}
			}
			if(msg==''){
				/* 
				if(data.jec_user_id!=''){
					if($("#jec_user_id_"+data.no+" option[index='0']").val()==''){
						$("#jec_user_id_"+data.no+" option[index='0']").remove(); 
					}
				}*/
				AWEA_Ajax('<?=$update_projtask_url?>',data,'');
			}
			break;
		case 'after_add_task':
			
			PG_BK_Action('reset_add_task');
			PG_BK_Action('reload_task_list');
			break;
		case 'reset_add_task':
				ECP_Load_Div('add_task_div','<?=$add_task_url?>','');
			break;
		case 'reload_task_list':
				ECP_Load_Div('result_area_div','<?=$task_list_url?>','');
			break;
		case 'reload_file_list':
				ECP_Load_Div('file_area_div','<?=$file_list_url?>','');
			break;
		case 'after_del_task':
			PG_BK_Action('reset_add_task');
			PG_BK_Action('reload_task_list');
			PG_BK_Action('reload_file_list');
			break;
		case 'task_search_type':
			//data=>check_id
			var old_url=InputList.info.task.url;
			if(document.getElementById(data).checked==true){
				new_url=old_url.replace('/search_select_con/','/search_select_con_self/');
				
			}else{
				new_url=old_url.replace('/search_select_con_self/','/search_select_con/');
			}
			InputList.info.task.url=new_url;;
			break;
		case 'after_select_task':
			
			if(parseInt($("#jec_task_id").val())>0){

				data={ jec_task_id:$("#jec_task_id").val() };
				AWEA_Ajax('<?=$after_select_task_url?>',data,'');
			}
			break;
		case 'load_task_data':
			$("#jec_user_id").val(GetTagV(data,'jec_user_id'));
			$("#jec_user_id_title").val(GetTagV(data,'jec_user_id_title'));
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
		on:'task',
		info:{ 
				task:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_task_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select_con/task_con/'.$key_id.'/')?>','input_id':'jec_task_id','input_type':'R','width':400,'title_id':'jec_task_id_title','onchange':'after_select_task' },
				<?php for($i=0;$i<$pp;$i++):?>
				user_<?=$i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title_<?=$i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'jec_user_id_<?=$i?>','input_type':'R','width':150,'title_id':'jec_user_id_title_<?=$i?>','top':355 },
				usersuper_<?=$i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_usersuper_id_title_<?=$i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'jec_usersuper_id_<?=$i?>','input_type':'R','width':150,'title_id':'jec_usersuper_id_title_<?=$i?>','top':355 },				
				<?php endfor;?>
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'jec_user_id','input_type':'R','width':150,'title_id':'jec_user_id_title' },
				usersuper:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_usersuper_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'jec_usersuper_id','input_type':'R','width':150,'title_id':'jec_usersuper_id_title' }
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