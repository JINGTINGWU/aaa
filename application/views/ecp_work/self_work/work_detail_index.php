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
<?php
//SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='9220';

?>
<table width="100%"  onclick="PL_DivClick();">
	<tr>
    	<td valign="top" style="margin:0px;padding:0px;">       
        <div id="project_info_div" class="mm_area_div_3" style="margin:0px;padding:0px;">
        	<?php $this->load->view('common/project/project_info_div_t2',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td width="73%" style="margin:0px;padding:0px;">
        <div id="task_info_div" class="mm_area_div_3" style="margin:0px;padding:0px;">
        	<?php $this->load->view($this->m_controller.'/self_work/task_info_div_t1',array('projt_data'=>$projt_data)); ?>
        </div>
        </td>
    </tr>
	<tr>
        <td valign="top" colspan="2">
<form id="edit_form" target="phf" action="" method="post" >
<div id="search_area_div" class="mm_area_div_1" style="margin-top:-10px;margin-bottom:-10px;">

	<table>
		<tr>
        	<td><input id="select_all" type="checkbox" onclick="PG_BK_Action('select_all');"> 全選 <input  id="unselect_all"  type="checkbox"  onclick="PG_BK_Action('unselect_all');"> 全不選</td>
			<td>費用人員：<?=$main_op['s_user_id']['op']?><?=$main_op['s_user_id_title']['op']?>  <?=$main_op['target_db']['op']?>
			  <input type="hidden" name="prod_string" id="prod_string" />
              <input type="hidden" name="uselast_string" id="uselast_string" />
			  <?php if($proj_data['efprojno']!='' && ($proj_data['projstatus']=='1' || $proj_data['projstatus']=='2')):?>
              <input type="button" value="將選擇的料品匯出採購報支單" class="mm_submit_button" onclick="PG_BK_Action('check_charge_user',{})" style="width:200px;" >
			  <?php elseif($proj_data['projstatus']!='1' && $proj_data['projstatus']!='2'):?> 
			  <input type="button" value="專案已取消或結案，無法匯出報支單" class="mm_submit_button" style="width:250px;" disabled>(請提出資訊需求單辦理並會簽行銷部本部)
			  <?php else:?>
              <input type="button" value="專案沒有EF專案代號，無法匯出報支單" class="mm_submit_button" style="width:250px;" disabled>(請聯繫專案負責助理協助處理)
			  <?php endif;?></td>
        </tr>
	</table>

</div>
<div id="result_area_div"  class="mm_area_div_2">
	<?php $this->load->view($this->m_controller.'/self_work/work_detail_div',array('main_list'=>$main_list)); ?>
</div>
</form>
        </td>
    </tr>
</table>
<script>
function pg_submit(type,url)
{	
	switch(type){
		case 'add_projprod':
			info=Array();
			info[0]={id:'jec_product_id',msg:'請選擇料品',type:'ne'};
			info[1]={id:'quantity',msg:'請輸入數量',type:'nz'};
			msg=fi_submit_check(info);
			if(msg==''){
				mvalue={
					jec_product_id:$("#jec_product_id").val(),
					price:$("#price").val(),
					jec_vendor_id:$("#jec_vendor_id").val(),
					startdate:$("#startdate").val()
				};
				AWEA_Ajax(url,mvalue,type);
			}
			break;
		case 'export_excel':
			
			document.getElementById('edit_form').action="<?=$export_excel_url?>";
			document.getElementById('edit_form').submit();
			break;
	}

}
function PG_BK_Action(type,data)
{	var info=Array();
	var total_item=parseInt("<?=$total_item?>");	
	switch(type){
		case 'refresh_purchase_status':
			//alert('<?=base_url()?>images/loader.gif');			
			thick_box('open','表單狀況更新中…','<?=base_url()?>images/loader.gif');
			AWEA_Ajax('<?=$refresh_purchase_status_url?>',data,'');
			break;
		case 'after_refresh_purchase':
			thick_box('close');//import
			PG_BK_Action('reload_prod_list');
			break;//
		case 'update_projprod':
			//data.jec_vendor_id=$("#jec_vendor_id_"+data.no).val();			
			$("#taxprice_id_"+data.no).html(Math.round($("#price_"+data.no).val()*1.05));
			data.vendor_name=document.getElementById("jec_vendor_id_title_"+data.no).value;	
			data.price=$("#price_"+data.no).val();
			data.quantity=$("#quantity_"+data.no).val();
			AWEA_Ajax('<?=$update_projprod_url?>',data,'');
			break;
		case 'reload_prod_list':
				location.href="<?=$refresh_url?>";
				//ECP_Load_Div('result_area_div','<?=$prod_list_url?>','');
			break;
		case 'select_all':
			if(document.getElementById('select_all').checked==true){
				document.getElementById('unselect_all').checked=false;
				for(i=0;i<total_item;i++){
					if(document.getElementById('select_'+i).disabled==false){
						document.getElementById('select_'+i).checked=true;
					}
				}
			}
			break;
		case 'unselect_all':
			if(document.getElementById('unselect_all').checked==true){
				document.getElementById('select_all').checked=false;
				for(i=0;i<total_item;i++){
					document.getElementById('select_'+i).checked=false;
				}
			}
			break;
		case 'export_purchase':			
			if(GetTagV(data,'isexist')=='Y'){
			
				if(PG_BK_Action('check_select',{})==true){
				//send
					$("#s_user_id").val(GetTagV(data,'user_id'));					
					if(confirm("確定送出報支單?")){
						if(confirm("是否繼續使用剩餘費用?")){
							document.getElementById('uselast_string').value='Y';
						}
						else{
							document.getElementById('uselast_string').value='N';
						}
						document.getElementById('prod_string').value=PG_BK_Action('get_string',{});
						document.getElementById('edit_form').action="<?=$purchase_submit_url?>";
						document.getElementById('edit_form').submit();
					}
				}			
			}

			break;
		case 'cancel_purchase':
			document.getElementById('purchase_div').style.display='none';
			document.getElementById('purchase_div').innerHTML='';
			break;
		case 'check_charge_user':
			//check
			if($("#s_user_id_title").val()==''){
				ECP_Msg('請選擇費用人員',999,'error');
			}else{
				data={ user_name:$("#s_user_id_title").val(),bk_action:'export_purchase' };
				AWEA_Ajax('<?=$check_charge_user_url?>',data,'');
			}
			
			break;
		case 'send_purchase':
			//check
			info[0]={id:'ad005053',msg:'請選擇報支流程',type:'ne'};
			info[1]={id:'ad005059',msg:'請選擇報支類別',type:'ne'};
			info[2]={id:'ad005005',msg:'請選擇廠商',type:'ne'};
			info[3]={id:'ad005006',msg:'請選擇採購人員',type:'ne'};
			//info[4]={id:'ad005010',msg:'請選擇申請人員',type:'ne'};
			//info[5]={id:'ad005013',msg:'請選擇領用人員',type:'ne'};
			msg=fi_submit_check(info);
			if(msg==''){
				if(parseFloat($("#ad005018").val())<0){
					ECP_Msg('實際請款金額有誤。');
				}else{
					if(confirm("確定送出?")){
						document.getElementById('ad005053').disabled=false;
						document.getElementById('ad005059').disabled=false;
						document.getElementById('ad005055_1').disabled=false;
						document.getElementById('ad005055_2').disabled=false;
						document.getElementById('ad005017').disabled=false;
						document.getElementById('purchase_submit_btn').disabled=true;
						document.getElementById('purchase_form').submit();
					}
				}
				
			}
			
			break;

		case 'recount_amt':
			//data->type
			//先判斷
			fi_noam(document.getElementById('ad005037'));
			fi_nod(document.getElementById('ad005057'));
			fi_nod(document.getElementById('ad005056'));
			//alert($("#ad005056").val());
			var ad005037=$("#ad005037").val();
			var ad005057=$("#ad005057").val();
			if($("#ad005056").val()==''){
				var ad005056=0;
			}else{
				var ad005056=$("#ad005056").val();
			} 
			if(ad005037==''){ 
				ad005037=0;
			}
			if(ad005057==''){
				 ad005057=0;
			}
			//alert(ad005037+'-'+ad005056+'-'+ad005057);
			
			var now_amt=parseFloat($("#fix_price").val()*1);//
			var ad_amt=parseFloat(ad005037);
			var m1_amt=parseFloat(ad005056);
			var m2_amt=parseFloat(ad005057);
			
			var final=accAdd(now_amt,ad_amt)-m1_amt-m2_amt;//now_amt_ad_amt
			//var final=now_amt+ad_amt-m1_amt-m2_amt;//now_amt+ad_amt
			//alert(now_amt+"-"+ad_amt+"-"+m1_amt+"-"+m2_amt);
			/*
			
			if($("#"+data.id).val()==''){
				var ch_num=0;
			}else{
				var ch_num=$("#"+data.id).val();
			}//
			switch(data.type){
				case 'a':
					now_amt+=parseFloat(ch_num);
					break;
				case 'm':
					now_amt-=parseFloat(ch_num);
					break;
				case 'am':
					now_amt+=parseFloat(ch_num);
					break;
			}//
			*/
			/*
			var test=final+'';
			if(test.length>12){
				test=test.substr(0,12);
				//now_amt-=0.0000000000002;
				final=parseFloat(test);
			}*/
			
			//get_final_num
			AWEA_Ajax('<?=$recount_result_url?>',{ num:final },'');
			$("#ad005018").val(final);
			//reGet 中文字
			break;
			
		case 'input_recount_result':
			var ch_num=GetTagV(data,'ch_num');
			$("#ad005017").val(ch_num);
			break;
		case 'check_select':
			
			var num=0; var vendor_id=0; var pass='Y';
			
			for(i=0;i<total_item;i++){
				if(parseInt($("#jec_vendor_id_"+i).val())>0){					
					if(document.getElementById('select_'+i).checked==true){
						if(vendor_id==0){
							vendor_id=parseInt($("#jec_vendor_id_"+i).val());							
						}else{
							if(vendor_id!=parseInt($("#jec_vendor_id_"+i).val())){
							//alert($("#jec_vendor_id_"+(i-1)).val());								
								pass='N';
								break;
							}
						}
						num++;						
					}
				}else{
					if(document.getElementById('select_'+i).checked==true){
						num++;
						if($("#uom_id_"+i).text()=='')
						{
							ECP_Msg('選擇匯出的品項沒有單位。');
							return false;
						}
					}
				}				
			}
			if(pass=='N'){
				ECP_Msg('請選擇相同的廠商。');
				return false;
			}else{
				if(num==0){
					ECP_Msg("請選擇要匯出的料品。");
					return false;
				}else{
					return true;
				}
			}
			break;
		case 'load_select_prod':
			data.prod_string=PG_BK_Action('get_string',{});
			document.getElementById('prod_string').value=data.prod_string;
			document.getElementById('purchase_prod_div').src="<?=$purchase_prod_url?>/"+data.prod_string+"/";
			
			break;
		case 'get_string':
			var prod_string='';
			for(i=0;i<total_item;i++){
				if(document.getElementById('select_'+i).checked==true){
					prod_string+='-'+document.getElementById('select_'+i).value;
				}
			}
			prod_string=prod_string.substr(1);
			return prod_string;
			break;
	}
}
</script>


<div id="purchase_div" style="display:none;position:fixed;top:50px;left:50px;width:900px;height:545px;background:#FFFFFF;border:#CCCCCC 1px solid;padding:10px;">
</div>


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
				for($i=0;$i<$total_item;$i++):
					?>
					vendor_<?php echo $i?>:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title_<?php echo $i?>',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id_<?php echo $i?>','input_type':'R','width':200,'title_id':'jec_vendor_id_title_<?php echo $i?>' },
					<?php
				endfor;
				?>
vendor:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_vendor_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'jec_vendor_id','input_type':'R','width':100,'title_id':'jec_vendor_id_title' },
				p_vendor:{ search_list:'pl_search_list',search_value:'search_value',search_here:'ad005005_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/vendor/')?>','input_id':'ad005005','input_type':'R','width':250,'title_id':'ad005005_title' },
				p_user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'ad005006_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'ad005006','input_type':'R','width':100,'title_id':'ad005006_title' },
				a_user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'ad005010_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'ad005010','input_type':'R','width':100,'title_id':'ad005010_title' },
				r_user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'ad005013_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'ad005013','input_type':'R','width':100,'title_id':'ad005013_title' },
				s_user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_user_id','input_type':'R','width':100,'title_id':'s_user_id_title' }
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
<?php endif;?>
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>