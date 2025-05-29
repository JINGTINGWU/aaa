<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
</script>	
<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<input type="hidden" id="cp_time" value="<?=$cp_time?>" />
<table width="100%" onclick="PL_DivClick();">
	<tr>
    	<td valign="top"  class="mm_left_info_width">
        <div id="task_info_div" class="mm_area_div_3">
        	<?php $this->load->view($this->m_controller.'/inform_item/task_info_div',array('projt_data'=>$projt_data)); ?>
        </div>
        <div id="project_info_div" class="mm_area_div_3">
        	<?php $this->load->view('common/project/project_info_div',array('proj_data'=>$proj_data)); ?>
        </div>
        <div id="project_mng_div" class="mm_area_div_3">
			<?php $this->load->view('common/project/project_mng_div',array('proj_data'=>$proj_data)); ?>
        </div>
        </td>
        <td valign="top">
        <div  class="mm_area_div_1"><div id="search_area_div">
        <?php
		switch($projn_data['noticetype']):
			case 4://工作完成待確認
				?>

	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>工作完成確認</td>
            <td>確認時間：<?=$main_op['cp_finish_time']['op']?></td>
        </tr>
		<tr>
        	<td>工作紀錄：</td>
            <td><?=$projr_data['description']?></td>
        </tr>
		<tr>
        	<td>意見：</td>
            <td><?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="此項工作已確認完成"  class="mm_submit_button" onclick="PG_BK_Action('cp_finish',{url:'<?=$cp_url['cp_finish']?>',reply:'Y'});" id="cp_finish_Y_btn" />
	      <input type="button" value="此項工作尚未完成" class="mm_submit_button"  onclick="PG_BK_Action('cp_finish',{url:'<?=$cp_url['cp_finish']?>',reply:'N'});"  id="cp_finish_N_btn" /></td>
	  </tr>        
        
	</table>
			
				<?php
				break;
			case 5:	//日期變更待確認
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>調整日期確認</td>
            <td>申請調整新的完成日期：<?=$main_op['cp_adtime_startdate']['op']?> ~ <?=$main_op['cp_adtime_enddate']['op']?></td>
            </tr>
		<tr>
        	<td>申請說明：</td>
            <td><?=$projr_data['description']?></td>
        </tr>
		<tr>
		  <td>意見：</td>
		  <td><?=$main_op['cp_finish']['op']?>
	      <img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="確認可以調整日期" class="mm_submit_button" onclick="PG_BK_Action('cp_adjust',{url:'<?=$cp_url['cp_adjust']?>',reply:'Y'});" id="cp_adjust_Y_btn" />
          <input type="button" value="完成日期不可調整" class="mm_submit_button" onclick="PG_BK_Action('cp_adjust',{url:'<?=$cp_url['cp_adjust']?>',reply:'N'});"  id="cp_adjust_N_btn" /></td>
	  </tr>
	</table>
    <script>
    	cal.manageFields("cp_adtime_enddate", "cp_adtime_enddate", "%Y-%m-%d");
    </script>			
				<?php
				break;
			case 6:	//工作移轉待確認
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>工作移轉確認</td>
            <td>申請將工作移轉至他人：<?=$main_op['cp_transfer_user']['op']?><?=$main_op['cp_transfer_user_title']['op']?></td>
      </tr>
		<tr>
        	<td>申請說明：</td>
            <td><?=$projr_data['description']?></td>
        </tr>
		<tr>
		  <td>意見：</td>
		  <td><?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="確認工作可以移轉他人" class="mm_submit_button" onclick="PG_BK_Action('cp_transfer_check',{url:'<?=$cp_url['cp_transfer']?>',reply:'Y'});"  id="cp_transfer_Y_btn" />
	      <input type="button" value="此項工作不可移轉他人"  class="mm_submit_button"  onclick="PG_BK_Action('cp_transfer_check',{url:'<?=$cp_url['cp_transfer']?>',reply:'N'});"  id="cp_transfer_N_btn" /></td>
	  </tr>
	</table>	
<?php
				break;
			case 31:	//日期調整暨工作移轉待確認
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>日期調整暨工作移轉確認</td>
            <td>申請調整新的完成日期：<?=$main_op['cp_adtime_startdate']['op']?> ~ <?=$main_op['cp_adtime_enddate']['op']?><br/>申請將工作移轉至他人：<?=$main_op['cp_transfer_user']['op']?><?=$main_op['cp_transfer_user_title']['op']?></td>
      </tr>
		<tr>
        	<td>申請說明：</td>
            <td><?=$projr_data['description']?></td>
        </tr>
		<tr>
		  <td>意見：</td>
		  <td><?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="確認工作可以調整日期並移轉他人" class="mm_submit_button" onclick="PG_BK_Action('cp_adjust_transfer_check',{url:'<?=$cp_url['cp_adjust_transfer']?>',reply:'Y'});"  id="cp_adjust_transfer_Y_btn" />
	      <input type="button" value="此項工作不可調整日期並移轉他人"  class="mm_submit_button"  onclick="PG_BK_Action('cp_adjust_transfer_check',{url:'<?=$cp_url['cp_adjust_transfer']?>',reply:'N'});"  id="cp_adjust_transfer_N_btn" /></td>
	  </tr>
	</table>
    <script>
    	cal.manageFields("cp_adtime_enddate", "cp_adtime_enddate", "%Y-%m-%d");
    </script>
<?php
				break;
			case 7://無法完成待處理
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="5" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>無法完成處理</td>
            <td colspan="4">問題說明：<?=$projr_data['description']?></td>
        </tr>
		<tr>
        	<td></td>
            <td colspan="2">調整新的 完成日期：<?=$main_op['cp_iptime_startdate']['op']?>~<?=$main_op['cp_iptime_enddate']['op']?></td>
            <td><input type="button" value="確認可以調整完成日期"  class="mm_submit_button"   onclick="PG_BK_Action('cp_impossible',{url:'<?=$cp_url['cp_impossible']?>',reply:'A'});"  id="cp_impossible_A_btn" ></td>
            
        </tr>
		<tr>
        	<td></td>
            <td colspan="2">將工作移轉至他人：<?=$main_op['cp_ip_transfer_user']['op']?><?=$main_op['cp_ip_transfer_user_title']['op']?></td>
            <td><input type="button" value="確認工作可以移轉他人"  class="mm_submit_button" onclick="PG_BK_Action('cp_impossible_check',{url:'<?=$cp_url['cp_impossible']?>',reply:'T'});"  id="cp_impossible_T_btn"  ></td>
            
        </tr>
		<tr>
        	<td></td>
            <td colspan="2">意見：<?=$main_op['cp_impossible']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_impossible/')?>')"/>
              </td>
            <td><input type="button" value="廢止此項工作 "  class="mm_submit_button" onclick="PG_BK_Action('cp_impossible',{url:'<?=$cp_url['cp_impossible']?>',reply:'C'});"  id="cp_impossible_C_btn" ></td>
        </tr>
        <tr><td colspan="4">※不同意結案者,請選第一個”確認可以調整完成日期”,預設會帶原本需完成的日期,督導人可以自行調整在不要結案情況下,但延長完成日期
</td></tr>
	</table>
    <script>
    	cal.manageFields("cp_iptime_enddate", "cp_iptime_enddate", "%Y-%m-%d");		
    </script>			
				<?php
				break;
			case 8:	//工作暫停待確認
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>工作暫停確認</td>
            <td>暫停原因：<?=$projr_data['description']?> 恢復日期：<?=$main_op['cp_pause_startdate']['op']?>~<?=$main_op['cp_pause_enddate']['op']?></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>意見：<?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="確認此項工作可以暫停" class="mm_submit_button"  onclick="PG_BK_Action('cp_pause',{url:'<?=$cp_url['cp_pause']?>',reply:'Y'});"  id="cp_pause_Y_btn" />
          <input type="button" value="此項工作不可暫停"  class="mm_submit_button" onclick="PG_BK_Action('cp_pause',{url:'<?=$cp_url['cp_pause']?>',reply:'N'});"  id="cp_pause_N_btn" /></td>
	  </tr>
        </table>
        <script>
        cal.manageFields("cp_pause_startdate", "cp_pause_startdate", "%Y-%m-%d");
        cal.manageFields("cp_pause_enddate", "cp_pause_enddate", "%Y-%m-%d");
		</script>
				<?php 
				break;	
			case 9:
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="3" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>工作回復確認</td>
            <td>暫停時間：<?=$main_op['cp_recover_time']['op']?></td>
            <td>&nbsp;</td>
        </tr>
		<tr>
        	<td></td>
        	<td>暫停原因：<?=$projr_data['pause_description']?></td>
            <td>回復原因：<?=$projr_data['description']?></td>
        </tr>
		<tr>
		  <td></td>
		  <td colspan="2"><input type="button" value="確認此項工作可以回復繼續" class="mm_submit_button"  onclick="PG_BK_Action('cp_recover',{url:'<?=$cp_url['cp_recover']?>',reply:'Y'});"  id="cp_recover_Y_btn" />
	      <input type="button" value="此項工作不需回復繼續"  class="mm_submit_button" onclick="PG_BK_Action('cp_recover',{url:'<?=$cp_url['cp_recover']?>',reply:'N'});" id="cp_recover_N_btn" /></td>
	  </tr>
	</table>
				<?php 
				break;
				case 10:	//工作移轉待確認
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>督導人移轉確認</td>
            <td>申請將督導人移轉至他人：<?=$main_op['cp_transfer_superuser']['op']?><?=$main_op['cp_transfer_superuser_title']['op']?></td>
      </tr>
		<tr>
        	<td>申請說明：</td>
            <td><?=$projr_data['description']?></td>
        </tr>
		<tr>
		  <td>意見：</td>
		  <td><?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="確認督導人可以移轉他人" class="mm_submit_button" onclick="PG_BK_Action('cp_transfer_supercheck',{url:'<?=$cp_url['cp_transfer_super']?>',reply:'Y'});"  id="cp_transfer_super_Y_btn" />
	      <input type="button" value="此項督導人不可移轉他人"  class="mm_submit_button"  onclick="PG_BK_Action('cp_transfer_supercheck',{url:'<?=$cp_url['cp_transfer_super']?>',reply:'N'});"  id="cp_transfer_super_N_btn" /></td>
	  </tr>
	</table>    
<?php
				break;				
				case 32:	//向前加簽待回覆
				?>
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td>向前加簽回簽</td>
            <td>&nbsp;</td>
        </tr>
		<tr>
        	<td>負責人工作回報說明：</td>
            <td><?=$projr_data['description']?></td>
        </tr>        
		<tr>
		  <td>加簽人意見：</td>
		  <td><?=$main_op['cp_finish']['op']?><img src="../../../../images/pela.gif" width="28" height="28" style="cursor:hand;" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/cp_finish/')?>')"/>(100個字元內)</td>
		  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="button" value="完成回簽" class="mm_submit_button" onclick="PG_BK_Action('cp_addsign',{url:'<?=$cp_url['cp_addsign']?>',reply:'Y'});"  id="cp_addsign_Y_btn" /></td>
	  </tr>
	</table>    
<?php
				break;
				default:
				?>                
                <table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="3" align="left" style="padding:0px;">此項工作已確認完成
				  <input type="button" value="取消確認此項工作"  class="mm_submit_button" onclick="PG_BK_Action('cp_cancel',{url:'<?=$cp_url['cp_cancel']?>',reply:'Y'});" id="cp_cancel_btn" ></td>
			</tr>
            </table>
        <?php
		endswitch;
		?>
        <?php 
		if(($projn_data['noticetype']>=4 && $projn_data['noticetype']<=10) || $projn_data['noticetype']==31)
		{
	    ?>
			<table class="query-div" cellspacing="1" cellpadding="3">
            <tr>
				<td colspan="2" align="left" style="padding:0px;"></td>
			</tr>
			<tr>
				<td width="134">向前加簽其他人員</td>
                <td><?=$main_op['rp_addsign_user']['op']?><?=$main_op['rp_addsign_user_title']['op']?>
                
				  <input type="button" value="向前加簽"  class="mm_submit_button" onclick="PG_BK_Action('rp_addsign_check',{url:'<?=$cp_url['rp_addsign']?>',reply:'Y'});" id="rp_addsign_btn" ></td>
			</tr>
            </table>
		<?php
        }
		?>
        <table>
    <tr><td>
    <?php $this->load->view($this->m_controller.'/inform_item/task_file_list_div',array('file_list'=>$file_list,'fpd'=>$fpd)); ?>

</td></tr>
    </table>
    <?php $this->load->view('common/page_bar_div',array('pd'=>$pd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4">工作紀錄列表
    		  <select name="recordtype" id="recordtype" onchange="recordtype_change();">
    		    <option value="N" <?=$ac=='list' || $ac=='list_div'?'selected':''?>>不顯示逾期通知</option>
    		    <option value="ALL" <?=$ac=='list-all' || $ac=='list_div-all'?'selected':''?>>顯示全部</option>
  		    </select></td>
    	</tr>
    	<tr>
    	  <td colspan="4" style="color:#F00">此工作已逾期<?=$projt_data['delaydate']?>日，調整日期<?=$datechangecount?>次，移轉人員<?=$mantransfercount?>次，申請暫停<?=$pausecount?>次</td>
  	  </tr>
        <tr>
            <td  class="mm_table2_title2" <?=$ob=='recordtime'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?> onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_recordtime_url']?>');" width="120"  >處理時間</td>
            <td  class="mm_table2_title2" <?=$ob=='description'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?> onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description_url']?>');" >工作紀錄</td>
            <td  class="mm_table2_title2" <?=$ob=='description2'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?> onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_description2_url']?>');" >備註說明</td>         
            <td  class="mm_table2_title2" <?=$ob=='jec_user_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?> onclick="ECP_Load_Div('result_area_div','<?=$pd['ob_jec_user_id_url']?>');" width="70"  >異動人員</td>              
        </tr>
        <?php foreach($main_list as $value):?>
        <tr>
            <td><?=$value['recordtime']?></td>
            <td><?=$value['description']?></td>
            <td><?=$value['description2']?></td>
            <td><?=$value['user_name']?></td>  
        </tr>        
        <?php endforeach;?>
    </table>
    </div></div>	
        </td>
    </tr>
   </table> 
    

    


<script>
function PG_BK_Action(type,data)
{	var info=Array();

	if(typeof(data)=='object'){
		data.cp_time=document.getElementById('cp_time').value;
		//data.content=document.getElementById(type).value;
	}
	switch(type){
		case 'cp_finish':
			if(confirm("確定要送出?")){
			data.cp_finish_time=document.getElementById('cp_finish_time').value;
			data.cp_finish=document.getElementById('cp_finish').value;
			document.getElementById('cp_finish_Y_btn').disabled=true;
			document.getElementById('cp_finish_N_btn').disabled=true;
			AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'cp_addsign':
			if(confirm("確定要送出?")){			
			data.cp_finish=document.getElementById('cp_finish').value;
			document.getElementById('cp_addsign_Y_btn').disabled=true;
			AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'cp_adjust':
			if(confirm("確定要送出?")){
			data.cp_adtime_enddate=document.getElementById('cp_adtime_enddate').value;
			data.cp_adtime_startdate=document.getElementById('cp_adtime_startdate').value;
			data.cp_finish=document.getElementById('cp_finish').value;
			info[0]={sd_id:'cp_adtime_startdate',ed_id:'cp_adtime_enddate',msg:'結束日不能小於起始日',type:'sed'};
			msg=fi_submit_check(info);
			if(msg==''){
				document.getElementById('cp_adjust_Y_btn').disabled=true;
				document.getElementById('cp_adjust_N_btn').disabled=true;
				AWEA_Ajax(data.url,data,'');
			}
			}
			break;
		case 'cp_transfer_check':	
		if(confirm("確定要送出?")){		
			if(data.reply=='Y'){
				data={ bk_action:'cp_transfer',sales_name:$("#cp_transfer_user_title").val(),cp_url:data.url,reply:data.reply };
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax('<?=$check_cp_url?>',data,'');
			}else{
				data.cp_finish=document.getElementById('cp_finish').value;				
				PG_BK_Action('cp_transfer',data);
			}	
		}
		break;
		case 'cp_adjust_transfer_check':	
		if(confirm("確定要送出?")){		
			if(data.reply=='Y'){
				data={ bk_action:'cp_adjust_transfer',sales_name:$("#cp_transfer_user_title").val(),cp_url:data.url,reply:data.reply };
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax('<?=$check_cp_url?>',data,'');
			}else{
				data.cp_finish=document.getElementById('cp_finish').value;				
				PG_BK_Action('cp_adjust_transfer',data);
			}		
		}
		break;
		case 'cp_transfer':			
			if(typeof(data)=='object'){
				data.jec_usernew_id='';				
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax(data.url,data,'');
			}else{
				if(GetTagV(data,'isexist')=='Y'){
					info[0]={id:'cp_transfer_user',msg:'請選擇移轉對象',type:'ne'};
					msg=fi_submit_check(info);
					if(msg==''){						
						var cp_url=GetTagV(data,'cp_url');
						//var jec_usernew_id=GetTagV(data,'sales_id');
						data={ jec_usernew_id:GetTagV(data,'sales_id'),reply:GetTagV(data,'reply') };
						data.cp_time=document.getElementById('cp_time').value;
						data.cp_finish=document.getElementById('cp_finish').value;						
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('cp_transfer_Y_btn').disabled=true;
						document.getElementById('cp_transfer_N_btn').disabled=true;						
						AWEA_Ajax(cp_url,data,'');						
					//data.jec_usernew_id=document.getElementById('cp_transfer_user').value;
					//AWEA_Ajax(data.url,data,'');
					}
				}
			}			

			break;
		case 'cp_adjust_transfer':
			
			if(typeof(data)=='object'){
				data.jec_usernew_id='';		
				data.cp_adtime_enddate=document.getElementById('cp_adtime_enddate').value;
						data.cp_adtime_startdate=document.getElementById('cp_adtime_startdate').value;			
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax(data.url,data,'');
			}else{
				if(GetTagV(data,'isexist')=='Y'){
					info[0]={id:'cp_transfer_user',msg:'請選擇移轉對象',type:'ne'};
					msg=fi_submit_check(info);
					if(msg==''){						
						var cp_url=GetTagV(data,'cp_url');
						//var jec_usernew_id=GetTagV(data,'sales_id');
						data={ jec_usernew_id:GetTagV(data,'sales_id'),reply:GetTagV(data,'reply') };
						data.cp_time=document.getElementById('cp_time').value;
						data.cp_finish=document.getElementById('cp_finish').value;	
						data.cp_adtime_enddate=document.getElementById('cp_adtime_enddate').value;
						data.cp_adtime_startdate=document.getElementById('cp_adtime_startdate').value;				
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('cp_adjust_transfer_Y_btn').disabled=true;
						document.getElementById('cp_adjust_transfer_N_btn').disabled=true;						
						AWEA_Ajax(cp_url,data,'');						
					//data.jec_usernew_id=document.getElementById('cp_transfer_user').value;
					//AWEA_Ajax(data.url,data,'');
					}
				}
			}			

			break;
		case 'cp_transfer_supercheck':	
		if(confirm("確定要送出?")){		
			if(data.reply=='Y'){
				data={ bk_action:'cp_transfer_super',sales_name:$("#cp_transfer_superuser_title").val(),cp_url:data.url,reply:data.reply };
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax('<?=$check_cp_super_url?>',data,'');
			}else{
				data.cp_finish=document.getElementById('cp_finish').value;				
				PG_BK_Action('cp_transfer_super',data);
			}	
		}
		break;
		case 'cp_transfer_super':			
			if(typeof(data)=='object'){
				data.jec_usernew_id='';				
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax(data.url,data,'');
			}else{				
				if(GetTagV(data,'isexist')=='Y'){
					info[0]={id:'cp_transfer_superuser',msg:'請選擇督導人移轉對象',type:'ne'};
					msg=fi_submit_check(info);
					if(msg==''){
						
						var cp_url=GetTagV(data,'cp_url');
						//var jec_usernew_id=GetTagV(data,'sales_id');
						data={ jec_usernew_id:GetTagV(data,'sales_id'),reply:GetTagV(data,'reply') };
						data.cp_time=document.getElementById('cp_time').value;
						data.cp_finish=document.getElementById('cp_finish').value;						
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('cp_transfer_super_Y_btn').disabled=true;
						document.getElementById('cp_transfer_super_N_btn').disabled=true;						
						AWEA_Ajax(cp_url,data,'');
						
					//data.jec_usernew_id=document.getElementById('cp_transfer_user').value;
					//AWEA_Ajax(data.url,data,'');
					}
				}				
			}
			break;
		case 'cp_impossible_check':
			if(confirm("確定要送出?")){
				data={ bk_action:'cp_impossible',sales_name:$("#cp_ip_transfer_user_title").val(),cp_url:data.url,reply:data.reply };
				AWEA_Ajax('<?=$check_cp_url?>',data,'');
			}
			break;
		case 'cp_impossible':
			if(confirm("確定要送出?")){
			if(typeof(data)=='object'){
				data.jec_usernew_id=document.getElementById('cp_ip_transfer_user').value;
				var pass='Y';
			}else{
				if(GetTagV(data,'isexist')=='Y'){
					var pass='Y';
				var jec_usernew_id=GetTagV(data,'sales_id');
				var reply=GetTagV(data,'reply');
				var cp_url=GetTagV(data,'cp_url');
				data={
						jec_usernew_id:jec_usernew_id,
						url:cp_url,
						reply:reply
					};
				}else{
					var pass='N';
				}
			}
			
			if(pass=='Y'){
				data.cp_iptime_startdate=document.getElementById('cp_iptime_startdate').value;
				data.cp_iptime_enddate=document.getElementById('cp_iptime_enddate').value;
				data.cp_impossible=document.getElementById('cp_impossible').value;
				if(data.reply=='A'){
					info[0]={sd_id:'cp_iptime_startdate',ed_id:'cp_iptime_enddate',msg:'結束日不能小於起始日',type:'sed'};
					info[1]={id:'cp_iptime_enddate',msg:'請選擇結束日',type:'ne'};
					msg=fi_submit_check(info);
				}else{
					if(data.reply=='T'){
						info[0]={id:'cp_ip_transfer_user_title',msg:'請選擇移轉對象',type:'ne'};
						msg=fi_submit_check(info);
					}else{
						msg='';
					}
				}

				if(msg==''){
					document.getElementById('cp_impossible_A_btn').disabled=true;
					document.getElementById('cp_impossible_T_btn').disabled=true;
					document.getElementById('cp_impossible_C_btn').disabled=true;
					AWEA_Ajax(data.url,data,'');
				}
			}
			}
			break;
		case 'cp_pause':
			if(confirm("確定要送出?")){
			document.getElementById('cp_pause_Y_btn').disabled=true;
			document.getElementById('cp_pause_N_btn').disabled=true;
			data.cp_finish=document.getElementById('cp_finish').value;
                     data.cp_pause_startdate=document.getElementById('cp_pause_startdate').value;
                     data.cp_pause_enddate=document.getElementById('cp_pause_enddate').value;
                     info[0]={sd_id:'cp_pause_startdate',ed_id:'cp_pause_enddate',msg:'結束日不能小於起始日',type:'sed'};
			msg=fi_submit_check(info);
                        if(msg=='')
                        {
                            AWEA_Ajax(data.url,data,'');
                        }
			}
			break;
		case 'cp_recover':
			if(confirm("確定要送出?")){
			document.getElementById('cp_recover_Y_btn').disabled=true;
			document.getElementById('cp_recover_N_btn').disabled=true;
			AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'cp_cancel':
			if(confirm("確定要送出?")){
			document.getElementById('cp_cancel_btn').disabled=true;			
			AWEA_Ajax(data.url,data,'');
			}
			break;
		case 'rp_addsign_check':	
			if(confirm("確定要加簽?")){		
				if(data.reply=='Y'){
				data={ bk_action:'rp_addsign',sales_name:$("#rp_addsign_user_title").val(),cp_url:data.url,reply:data.reply };
			    data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax('<?=$check_cp_url?>',data,'');
				}	
			}
			break;
		case 'rp_addsign':
			if(typeof(data)=='object'){
				data.jec_usernew_id='';				
				data.cp_finish=document.getElementById('cp_finish').value;
				AWEA_Ajax(data.url,data,'');
			}else{
				if(GetTagV(data,'isexist')=='Y'){
					info[0]={id:'rp_addsign_user',msg:'請選擇加簽對象',type:'ne'};
					msg=fi_submit_check(info);
					if(msg==''){
						var cp_url=GetTagV(data,'cp_url');
						//var jec_usernew_id=GetTagV(data,'sales_id');
						data={ jec_usernew_id:GetTagV(data,'sales_id'),reply:GetTagV(data,'reply') };
						data.cp_time=document.getElementById('cp_time').value;
						data.cp_finish=document.getElementById('cp_finish').value;						
						//data.jec_usernew_id=jec_usernew;
						document.getElementById('rp_addsign_btn').disabled=true;					
						AWEA_Ajax(cp_url,data,'');						
					//data.jec_usernew_id=document.getElementById('cp_transfer_user').value;
					//AWEA_Ajax(data.url,data,'');
					}
				}
			}	
			break;
		case 'after_reply':
			JS_Link('<?=$tcate_url['inform_list_index_unconfirm']?>');
			break;
	}//
}
function PG_TB_Close(){//
	TPP_Frame.PG_Upload_Save();
}
</script>

<div id="pl_search_div" style="display:none;background:#FFFFFF;position:absolute;top:0px;left:0px;">
<iframe id="pl_search_list" name="pl_search_list" frameborder="0" style="border:1px solid #CCCCCC;width:600px;height:300px;" ></iframe>
</div> 
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>

var InputList={
		on:'user',
		info:{ 
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'cp_transfer_user_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'cp_transfer_user','input_type':'R','width':160,'title_id':'cp_transfer_user_title' },
				superuser:{ search_list:'pl_search_list',search_value:'search_value',search_here:'cp_transfer_superuser_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'cp_transfer_superuser','input_type':'R','width':160,'title_id':'cp_transfer_superuser_title' },
				ipuser:{ search_list:'pl_search_list',search_value:'search_value',search_here:'cp_ip_transfer_user_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'cp_ip_transfer_user','input_type':'R','width':160,'title_id':'cp_transfer_user_title' },
				addsignuser:{ search_list:'pl_search_list',search_value:'search_value',search_here:'rp_addsign_user_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/usergroup/')?>','input_id':'rp_addsign_user','input_type':'R','width':160,'title_id':'rp_addsign_user_title' }
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