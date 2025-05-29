<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />
<script src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_cut_1{
	width:150px;
	white-space:nowrap;
	text-overflow:ellipsis;
	-o-text-overflow:ellipsis;
	overflow: hidden;
}
</style>
<div id="search_area_div" class="mm_area_div_1">
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">通知狀態：</td><td id="frominputarea"><?=$s_main_op['s_noticetype']['op']?></td>
            <td align="right">通知日期：</td><td id="frominputarea"><?=$s_main_op['s_startdate']['op']?> ~ <?=$s_main_op['s_enddate']['op']?></td>
            <td></td>
            <td></td>
        </tr>
		<tr>
        	<td align="right">專案編號：</td><td id="frominputarea"><?=$s_main_op['s_proj_value']['op']?></td>
            <td align="right">專案名稱：</td><td id="frominputarea"><?=$s_main_op['s_proj_name']['op']?></td>
            <td align="right">任務名稱：</td>
            <td id="frominputarea"><?=$s_main_op['s_job_name']['op']?></td>
        </tr>
		<tr>
        	<td align="right">工作名稱：</td><td id="frominputarea"><?=$s_main_op['s_task_name']['op']?></td>
            <td align="right">關鍵字：</td><td id="frominputarea"><?=$s_main_op['s_keyword']['op']?><?=$s_main_op['s_string']['op']?></td>
            <td colspan="2"><input type="button" value="查詢通知事項" onclick="PG_BK_Action('search_go')" class="mm_submit_button" /></td>
        </tr>
	</table>
</div>
<div id="result_area_div" class="mm_area_div_2">
	<?php $this->load->view('common/page_bar_div_p',array('pd'=>$pd)); ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
	    <tr>
	      <td colspan="11">通知事項列表</td>
	      </tr>
	    <tr>
	      <td class="mm_table2_title2" <?=$ob=='noticetype'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_noticetype_url']?>">類別</a></td>
	      <td class="mm_table2_title2" <?=$ob=='noticetime'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_noticetime_url']?>">通知時間</a></td>
	      <td class="mm_table2_title2" <?=$ob=='isconfirm'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_isconfirm_url']?>">確認</a></td>
	      <td class="mm_table2_title2" <?=$ob=='proj_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_proj_name_url']?>" >專案名稱</a></td>
	      <td class="mm_table2_title2" <?=$ob=='job_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_job_name_url']?>" >任務名稱</a></td>
	      <td class="mm_table2_title2" <?=$ob=='task_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_task_name_url']?>" >工作名稱及日期</a></td>
	      <td class="mm_table2_title2" <?=$ob=='projtask_desc'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_projtask_desc_url']?>" >備註說明</a></td>
	      <td class="mm_table2_title2" <?=$ob=='emailcontent'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a href="<?=$pd['ob_emailcontent_url']?>" >通知內容</a></td>
	      <td id="detail-normal">負責人員</td>
	      <td id="detail-normal">確認</td>
	      <td id="detail-normal">工作紀錄</td>
	      </tr>
	    <?php foreach($main_list as $value):?>
	    <tr>
	      <td style="width:60px;"><?php if(isset($noticetype_img[$value['noticetype']])):?>
	        <img src="<?=base_url().$noticetype_img[$value['noticetype']]?>" height="14" />
	        <?php endif;?>
	        <?=$noticetype_pdb[$value['noticetype']]?></td>
	      <td style="width:80px;"><?=$value['noticetime']?></td>
	      <td style="width:20px;" align="center"><img src="<?=base_url()?>images/<?=$value['isconfirm']=='Y'?'ok':'no'?>.gif" height="14" /></td>
	      <td style="width:220px;word-break: break-all;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/project_adjust_index/list/<?=$value['jec_project_id']?>.html'>
	        <?=$value['proj_name']?></a><?=$value['isproductprep']=='Y'?' || <a href="'.$this->config->item('base_url').'ecp_project/prepare_item_mng/item_submit_index/list/'.$value['jec_project_id'].'/created/asc/0/N">備品清單</a> ':''?></td>
	      <td style="width:220px;word-break: break-all;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/job_list_index/list/<?=$value['jec_project_id']?>/created/asc/0/-1'>
	        <?=$value['job_name']?>
	        </a></td>
	      <td style="width:200px;word-break: break-all;"><a href='<?=$this->config->item('base_url')?>ecp_project/adjust_project_mng/task_list_index/target/<?=$value['jec_projjob_id']?>/created/asc/0/-1.html/<?=$value['jec_projtask_id']?>'>
	        <?=$value['task_name']?>
	        </a><br/>
	        (
	        <?=substr($value['startdate'],0,10)?>
	        ~
	        <?=substr($value['enddate'],0,10)?>
	        )</td>
	      <td style="width:150px;word-break: break-all;"><?=$value['projtask_desc']?></td>
	      <td style="width:200px;word-break: break-all;"><?=$value['emailcontent']?></td>
	      <td style="width:60px;"><?=(int)$value['jec_group_id']>0?$value['group_name']:$value['sales_name']?></td>
	      <td style="width:60px;"><?php if(in_array($value['noticetype'],$btn_allow) && $value['description']<>'加簽中'):?>
	        <input type="button" value="進入" onclick="JS_Link('<?=site_url($var_purl.'confirm_list_index/list/'.$value['jec_projnotice_id'].'/')?>');" class="mm_submit_button" />
            <?php elseif($value['description']=='加簽中'):?>
            <input type="button" value="加簽中" disabled />
	        <?php endif;?></td>
	      <td style="width:60px;"><input type="button" value="紀錄" onclick="JS_Link('<?=site_url($var_purl.'work_record_index/list/'.$value['jec_projnotice_id'].'/created/DESC/0/-1/')?>');" class="mm_submit_button" /></td>
	      </tr>
	    <?php endforeach;?>
      </table>
</div>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("s_startdate", "s_startdate", "%Y-%m-%d");
cal.manageFields("s_enddate", "s_enddate", "%Y-%m-%d");

function PG_BK_Action(type,data)
{	var msg='';	
	switch(type){
		case 'search_go':
			var info=Array();
			info[0]={sd_id:'s_startdate',ed_id:'s_enddate',msg:'結束日不能小於起始日',type:'sed'};
			msg=fi_submit_check(info);
			if(msg==''){
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
				AWEA_Ajax('<?=site_url('ecp_common/save_pg_session/'.$pg_tag.'/')?>',data,'');
			}
			break;
		case 'refresh_search':
			JS_Link('<?=site_url($var_purl.'inform_list_index/list/0/'.$ob.'/'.$ot.'/0/')?>');
			break;
			
		case 'save_session':	
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
				AWEA_Ajax('<?=site_url('ecp_common/save_session/'.$pg_tag.'/')?>',data,'');
			break;
		case 'get_test_sess':
			PG_BK_Action('search_go');
			break;//	
	 }
}
<?php
if(isset($save_session)&&$save_session=='Y'):
	/*?>PG_BK_Action('save_session',{});<?php*/
endif;
?>
</script>
