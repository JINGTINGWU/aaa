<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<div id="search_area_div" class="mm_area_div_1">
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
            <td colspan="2"><input type="button" value="查詢專案立案資料" onclick="PG_BK_Action('search_go')" class="mm_submit_button"  /></td>
        </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2" onclick="PL_DivClick();">
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="10" class="mm_table2_title">履約備品清單列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='value'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_value_url']?>" >專案編號</a></td>
            <td  class="mm_table2_title2"  <?=$ob=='projstatus'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_projstatus_url']?>">性質</a></td>
            <td  class="mm_table2_title2"  <?=$ob=='jec_company_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_company_id_url']?>" >公司別</a></td>
            <td class="mm_table2_title2" <?=$ob=='jec_usersales_id'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_jec_usersales_id_url']?>">業務</a></td>  
            <td class="mm_table2_title2" <?=$ob=='customer_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_customer_name_url']?>" >客戶名稱</a></td>  
            <td class="mm_table2_title2" <?=$ob=='name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_name_url']?>" >專案名稱</a></td> 
            <td class="mm_table2_title2" <?=$ob=='startdate'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_startdate_url']?>">專案日期</a></td> 
            <td class="mm_table2_title2" id="detail-normal">表單流程</td> 
            <td class="mm_table2_title2" id="detail-normal">編輯</td>
            <td class="mm_table2_title2" id="detail-normal">刪除</td>  
        </tr>
        <?php foreach($main_list as $no=>$value):?>
        <?php //$jtp_data=$this->mm_project_search_set->get_jtp_num($value['jec_project_id']); 刪除權限的問題   ?>
        <tr id="tr_<?=$no?>">
        	<td><?=$value['value']?></td>
            <td><?=$projtype_pdb[$value['projtype']]?></td>
            <td><?=$value['company_name']?></td>
            <td><?=$value['sales_name']?></td> 
            <td><?=$value['jec_customer_id']==0?$value['customername']:$value['customer_name']?></td>
            <td><?=$value['name']?></td> 
            <td><?=date('Y-m-d',strtotime($value['startdate']))?>~<?=date('Y-m-d',strtotime($value['enddate']))?></td> 
            <td><?=$value['exportcode']==''?'未傳遞':'已傳遞'?>/<?=$value['isworkflow']=='Y'?'已完成':'未完成'?></td> 
            <td><input type="button" value="備品清單" onclick="JS_Link('<?=site_url($var_purl.'item_detail_index/list/'.$value['jec_project_id'].'/')?>');" class="mm_submit_button" <?=$value['isproductprep']=='Y'?'':'disabled'?>  /></td>
            <td><input type="button" value="刪除清單" onclick="AWEA_Ajax('<?=site_url($var_purl.$tag.'/delete_productprep/'.$value['jec_project_id'].'/'.$var_surl)?>','','clean','tr_<?=$no?>')" class="mm_submit_button" <?php if($value['exportcode']==''&&$value['isproductprep']=='Y'):?><?=$this->ECPM->m_right_tag['del_da']?><?php else:?> disabled="disabled" <?php endif;?>  /></td>
        </tr>        
        <?php endforeach;?>
    </table>
</div>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("s_proj_date", "s_proj_date", "%Y-%m-%d");
function PG_TB_Close(){
	TPP_Frame.PG_Upload_Save();
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
			JS_Link('<?=site_url($var_purl.'item_list_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
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