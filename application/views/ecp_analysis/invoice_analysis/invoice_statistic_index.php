
<script src="<?=base_url()?>js/form_input.js"></script>
<div id="search_area_div" class="mm_area_div_1" onclick="PL_DivClick();">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	
            <td align="right">公司別：</td><td id="frominputarea"><?=$s_main_op['s_proj_jec_company_id']['op']?></td>
            <td align="right">年度：</td><td id="frominputarea"><?=$s_main_op['s_year']['op']?></td>
            <td align="right">客戶名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_customer_title']['op']?><?=$s_main_op['s_proj_jec_customer_id']['op']?><label id="s_proj_customer_title_lb"></label></td>
        </tr>
		<tr>
        	<td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>
            <td align="right">業務/負責：</td><td id="frominputarea"><?=$s_main_op['s_proj_salesuser_title']['op']?><?=$s_main_op['s_proj_jec_salesuser_id']['op']?><label id="s_proj_salesuser_title_lb"></label></td>
			<td><input type="hidden" id="s_statistic_type" value="<?=$_SESSION[$pg_tag]['s_statistic_type']?>" /><input type="radio" name="statistic_type" id="statistic_type_1" value="1" <?=$_SESSION[$pg_tag]['s_statistic_type']==1?'checked':''?> onclick="PG_BK_Action('change_statistic_type',this.value)" />以年度統計<br />
            	<input type="radio" name="statistic_type" id="statistic_type_2" value="2"  <?=$_SESSION[$pg_tag]['s_statistic_type']==2?'checked':''?>  onclick="PG_BK_Action('change_statistic_type',this.value)" />以年度+專案別統計
            </td>
            <td><input type="button" value="查詢專案立案資料" onclick="PG_BK_Action('search_go')" class="mm_submit_button" /></td>
        </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2"  onclick="PL_DivClick();">
	<?php $up_right=$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'))?'':'disabled';
		  $del_right=$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('delete'))?'':'disabled';
	?>
    <?php if($_SESSION[$pg_tag]['s_statistic_type']==2):?>
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
    <?php endif;?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="5" class="mm_table2_title">專案列表</td><td colspan="2"><?=$s_main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
            <td  class="mm_table2_title2"  <?=$ob=='jec_company_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_company_id_url']?>" >公司</a></td>
        	<td class="mm_table2_title2" <?=$ob=='projyear'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_projyear_url']?>" >年度</a></td>
            <td class="mm_table2_title2" <?=$ob=='customer_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_customer_name_url']?>" >客戶名稱</a></td>  
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_name_url']?>" >專案名稱</a></td>  
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_startdate_url']?>">專案日期</a></td> 
            <td class="mm_table2_title2" id="detail-normal">發票金額合計</td> 
            <td class="mm_table2_title2" id="detail-normal">發票明細</td>   
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <?php $jtp_data=$this->mm_project_search_set->get_jtp_num($value['jec_project_id']);?>
        <?php
			$e_project_id=$_SESSION[$pg_tag]['s_statistic_type']==1?0:(int)$value['jec_project_id'];
		?>
        <tr id="tr_<?=$no?>">
            <td><?=$value['company_name']?></td>
            <td><?=$value['invoiceyear']?></td>
            <td><?=$value['jec_customer_id']==0?$value['customername']:$value['customer_name']?></td>  
            <td><?=$value['name']?></td> 
            <td><?=substr($value['startdate'],0,10)?>~<?=substr($value['enddate'],0,10)?></td> 
            <td><?=number_format($value['invoice_amount'])?></td> 
            <td><input type="button" value="發票明細" onclick="JS_Link('<?=site_url($var_purl.'invoice_detail_index/list/'.$e_project_id.'/seqno/asc/0/-1/')?>');" class="mm_submit_button" /></td> 
        </tr>        
        <?php endforeach;?>
    </table>
</div>
<form name="pg_form" id="pg_form" target="phf" method="post" action="">
<input type="hidden" name="pg_var_1" id="pg_var_1" />
</form>
<script>

function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
}
function PG_BK_Action(type,data)
{
	switch(type){
		case 'change_statistic_type':
			if($("#s_statistic_type").val()!=data){
				PG_BK_Action('search_go');
			}
			break;
		case 'statistic_type_search':
			break;
		case 'search_go':
			var data={};
			<?php
			foreach($_SESSION[$pg_tag] as $st=>$sv):
				?>
				if($("#<?=$st?>").length>0){
					data.<?=$st?>=$("#<?=$st?>").val();
				}
				<?php
			endforeach;
			?>
			data.s_statistic_type=PG_BK_Action('get_statistic_type_value',{});
			if(data.s_proj_customer_title==''){
				data.s_proj_jec_customer_id='';
			}
			if(data.s_proj_salesuser_title==''){
				data.s_proj_jec_salesuser_id='';
			}
			AWEA_Ajax('<?=site_url('ecp_common/save_pg_session/'.$pg_tag.'/')?>',data,'');
			break;
		case 'refresh_search':
			JS_Link('<?=site_url($var_purl.'invoice_statistic_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
			break;
		case 'get_statistic_type_value':
				if(document.getElementById('statistic_type_1').checked==true){
					return 1;
				}else{
					return 2;
				}
			break;
		case 'export_excel':
			document.getElementById('pg_form').action="<?=$export_excel_url?>";
			$("#pg_var_1").val($("#excel_type").val());
			document.getElementById('pg_form').submit();
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
		on:'cus',
		info:{ 
				cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_customer_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'s_proj_jec_customer_id','input_type':'R','width':200,'title_id':'s_proj_customer_title' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_salesuser_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_proj_jec_salesuser_id','input_type':'R','width':200,'title_id':'s_proj_salesuser_title' }
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