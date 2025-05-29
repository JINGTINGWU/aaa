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
        	<?php $this->load->view($this->m_controller.'/prepare_item/project_info_div_t2',array('proj_data'=>$proj_data)); ?>
        </div>
</td></tr>
	<tr>
        <td valign="top" colspan="2">

<div id="file_area_div" class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/prepare_item/submit_list_div',array('main_list'=>$main_list,'pd'=>$pd,'user_ld'=>array())); ?>
</div>
<div class="mm_area_div_2">
        	<table class="info-div" cellspacing="1" cellpadding="3" style="height:60px;">
            	<tr>
            		<td class="info-title" width="50">電子表單</td><td><?=$main_op['target_db']['op']?><input type="button" value="送出聯絡單及簽呈電子表單" onclick="PG_BK_Action('send_prepare_easyflow')" id="send_ef_btn"  class="mm_submit_button" <?=$proj_data['exportcode']==''?'':'disabled="disabled"'?>   > 已送出則不能再送，除非刪除或退回</td><td class="info-title" width="50">表單流程</td><td><?=$proj_data['exportcode']==''?'未傳送':'已傳送'?>/<?=$proj_data['isworkflow']=='Y'?'已完成':'未完成'?> <input type="button" value="即時更新" onclick="PG_BK_Action('refresh_prepare_status',{})"  class="mm_submit_button" <?=$proj_data['exportcode']==''?'disabled':''?> <?=$proj_data['isworkflow']=='Y'?'disabled':''?>   ></td>
            	</tr>
            </table>

</div>
        </td>
    </tr>
</table>
<form method="post" id="test_form" action="" target="phf">
<input type="hidden" name="jec_project_id" value="<?=$key_id?>" />
</form>
<script>
function pg_submit(type,url)
{
	info=Array();
	info[0]={id:'jec_task_id_title',msg:'工作項目不可空白',type:'ne'};
	//info[1]={id:'startdate',msg:'工作起始日期不可空白',type:'ne'};
	//info[2]={id:'enddate',msg:'工作結束日期不可空',type:'ne'};
	if($("#startdate").val()!=''&&$("#enddate").val()!=''){
		info[1]={sd_id:'startdate',ed_id:'enddate',msg:'結束日不能小於起始日',type:'sed'};
	}
	
	msg=fi_submit_check(info);
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
	if($("#TPP_Frame").length>0){
		TPP_Frame.PG_Upload_Save();
	}
}
function PG_BK_Action(type,data)
{	var info=Array(); var msg='';
	switch(type){
		case 'send_prepare_easyflow':
			//用ajax 處理
			data={
					jec_project_id:'<?=$key_id?>',
					target_db:$("#target_db").val(),
					jec_customer_id:'<?=$proj_data['jec_customer_id']?>'
				};
			//alert('<?=$send_prepare_url?>'+data.target_db);	
			
			if (data['jec_customer_id'] != "")
			{
			if(confirm("確定送出?")){
				document.getElementById('send_ef_btn').disabled=true;
				AWEA_Ajax('<?=$send_prepare_url?>',data,'');
			}
			}
			else
			{
				alert('客戶名稱未正確對應ERP客戶代號，請修正後再送單');
			}
			//document.getElementById('test_form').action="<?=$send_prepare_url?>";
			//document.getElementById('test_form').submit();
			break;
		case 'refresh_prepare_status'://
			data={
					jec_project_id:'<?=$key_id?>'
				};
			thick_box('open','表單狀況更新中…','<?=base_url()?>images/loader.gif');
			AWEA_Ajax('<?=$refresh_prepare_url?>',data,'');
			break;
		case 'after_refresh_prepare':			
			thick_box('close');
			//整頁Refresh
			PG_BK_Action('refresh_page',{});
			break;
		case 'refresh_page':
			location.href="<?=$refresh_page_url?>";
			break;
		case 'after_send_easyflow':
			setTimeout("PG_BK_Action('refresh_page',{})",1200);
			break;
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
			//alert('hahahhaa');
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
			if($("#taskname_"+data.no).length>0){
				info[2]={id:'taskname_'+data.no,msg:'工作名稱不可空白',type:'ne'};
				data.taskname=$("#taskname_"+data.no).val();
			}else{
				data.taskname='';
			}
			msg=fi_submit_check(info);
			if(msg==''){
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
			InputList.info.task.url=new_url;
			//alert(new_url);
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
                case 'updatexls':
			data={ jec_project_id:<?=$key_id?> };
			AWEA_Ajax('<?=$get_updatexls_url?>',data,'');
			parent.ECP_Msg('已重新產生Excel檔',999);
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
<?php if(isset($w_url)):?>
	//window.open('<?php echo $w_url;?>','ecflow','height=650,width=1000,resizable=yes,scrollbars=yes');
	//window.open('http://ef.ems.com.tw/','ecflow','height=650,width=1000,resizable=yes,scrollbars=yes');
<?php endif;?>
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>