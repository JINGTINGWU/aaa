<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<div id="search_area_div" class="mm_area_div_1" onclick="PL_DivClick();">
	<table class="query-div" cellspacing="1" cellpadding="3" >
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">專案編號：</td><td id="frominputarea"><?=$s_main_op['s_proj_value']['op']?></td>
            <td align="right">公司別：</td><td id="frominputarea"><?=$s_main_op['s_proj_jec_company_id']['op']?></td>
            <td align="right">客戶名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_customer_title']['op']?><?=$s_main_op['s_proj_jec_customer_id']['op']?><label id="s_proj_customer_title_lb"></label></td>
        </tr>
		<tr>
        	<td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>
            <td align="right">專案狀態：</td><td id="frominputarea"><?=$s_main_op['s_proj_projstatus']['op']?></td>
            <td align="right">專案負責人/業務：</td><td id="frominputarea"><?=$s_main_op['s_proj_salesuser_title']['op']?><?=$s_main_op['s_proj_jec_salesuser_id']['op']?><label id="s_proj_salesuser_title_lb"></label></td>
        </tr>
		<tr>
        	<td align="right">專案日期：</td><td id="frominputarea"><?=$s_main_op['s_proj_date']['op']?></td>
            <td align="right">關鍵字：</td><td id="frominputarea"><?=$s_main_op['s_proj_keyword']['op']?></td>
            <td align="right">工程(採購)編號：</td><td id="frominputarea"><?=$s_main_op['s_proj_value2']['op']?></td>
        </tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td id="frominputarea2">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		  <td id="frominputarea2">&nbsp;</td>
		  <td colspan="2"><input type="button" value="查詢專案資料" onclick="PG_BK_Action('search_go')" class="mm_submit_button" /></td>
	  </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2"  onclick="PL_DivClick();">
	<?php $up_right=$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('update'))?'':'disabled';
		  $del_right=$this->QIM->menu_right_check($this->ECPM->m_menu_right,array('delete'))?'':'disabled';
	?>
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table  class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="10" class="mm_table2_title">專案列表</td>
            <td colspan="3"><?=$s_main_op['excel_type']['op']?><input type="button" value="查詢結果匯出Excel" class="mm_submit_button" onclick="PG_BK_Action('export_excel');"  /></td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2"  <?=$ob=='percent'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_percent_url']?>">進度</a></td>
        	<td  class="mm_table2_title2"  <?=$ob=='value'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_value_url']?>">專案編號</a></td>
            <td  class="mm_table2_title2"  <?=$ob=='projstatus'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_projstatus_url']?>">狀態</a></td>
            <td  class="mm_table2_title2"  <?=$ob=='jec_company_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_company_id_url']?>" >公司別</a></td>
            <td  class="mm_table2_title2" <?=$ob=='jec_dept_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_dept_id_url']?>" >部門</td>
            <td class="mm_table2_title2" <?=$ob=='customer_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_customer_name_url']?>" >客戶名稱</a></td>  
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_name_url']?>" >專案名稱</a></td> 
            <td class="mm_table2_title2" <?=$ob=='jec_usersales_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_usersales_id_url']?>">業務/負責</a></td>  
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_startdate_url']?>">專案日期</a></td> 
            <td class="mm_table2_title2" id="detail-normal">任務/工作/明細</td> 
            <td class="mm_table2_title2" id="detail-normal">工作清單</td>
            <!--<td class="mm_table2_title2" id="detail-normal">甘特圖</td>-->
            <td class="mm_table2_title2" id="detail-normal">成本分析</td>  
            <td class="mm_table2_title2" id="detail-normal">備品分析</td>  
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <?php
			//$e_percent=$this->mm_project_search_set->get_project_percentage($value['jec_project_id']);
		?>
        <?php $jtp_data=$this->mm_project_search_set->get_jtp_num($value['jec_project_id']);?>
        <tr id="tr_<?=$no?>">
        	<td align="right" <?=$this->mm_project_search_set->get_percent_css($value['percent'],$value)?>><label ><?=number_format($value['percent'],2)?>%</label></td>
        	<td><?=$value['value']?></td>
            <!-- <td width="34"><?=$projtype_pdb[$value['projtype']]?></td> -->
            <td width="105"><?=$projstatus_pdb[$value['projstatus']]?>  <!-- Update by Johnson 2012/12/04 -->
            <td width="34"><?=$value['company_name']?></td>
            <td width="70"><?=isset($dept_pdb[$value['jec_dept_id']])?$dept_pdb[$value['jec_dept_id']]:''?></td>
            <td><?=$value['jec_customer_id']==0?$value['customername']:$value['customer_name']?></td>  
            <td><?=$value['name']?></td> 
            <td width="70"><?=$value['sales_name']?></td>  
            <td width="80"><?=date('Y-m-d',strtotime($value['startdate']))?>~<br /><?=date('Y-m-d',strtotime($value['enddate']))?></td> 
            <td align="center"><?=$jtp_data['j']?>/<?=$jtp_data['t']?>/<?=$jtp_data['p']?></td> 
            <td><input type="button" value="工作清單" onclick="JS_Link('<?=site_url($var_purl.'work_overview_index/list/'.$value['jec_project_id'].'/seqno/asc/0/-1/')?>');" class="mm_submit_button" /></td>
            <!--<td><input type="button" value="甘特圖" onclick="JS_Link('<?=site_url($var_purl.'gantt_view_index/list/'.$value['jec_project_id'].'/seqno/asc/0/-1/')?>');" class="mm_submit_button" /></td>-->
            <td><input type="button" value="成本分析" onclick="JS_Link('<?=site_url($var_purl.'cost_analysis_index/list/'.$value['jec_project_id'].'/seqno/asc/0/-1/')?>');" class="mm_submit_button" /></td>   
            <td><input type="button" value="備品分析" onclick="JS_Link('<?=site_url($var_purl.'prepare_item_index/list/'.$value['jec_project_id'].'/seqno/asc/0/-1/')?>');" class="mm_submit_button" /></td> 
        </tr>        
        <?php endforeach;?>
    </table>
</div>
<form name="pg_form" id="pg_form" target="phf" method="post" action="">
<input type="hidden" name="pg_var_1" id="pg_var_1" />
</form>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("s_proj_date", "s_proj_date", "%Y-%m-%d");

function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
	//2 seconds
	//setTimeout(Test,2000);
}
function PG_BK_Action(type,data)
{
	switch(type){
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
			if(data.s_proj_customer_title==''){
				data.s_proj_jec_customer_id='';
			}
			if(data.s_proj_salesuser_title==''){
				data.s_proj_jec_salesuser_id='';
			}
			AWEA_Ajax('<?=site_url('ecp_common/save_pg_session/'.$pg_tag.'/')?>',data,'');
			break;
		case 'refresh_search':
			JS_Link('<?=site_url($var_purl.'project_list_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
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