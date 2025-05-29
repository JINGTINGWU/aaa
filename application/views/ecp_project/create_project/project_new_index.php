
<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_td_pad{
	padding-right:2px;
}
</style>

<div  id="search_area_div" class="mm_area_div_1">
<form id="edit_form" method="post" action="<?=$form_url?>" target="phf">
	<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="5" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">系統自動編號</td><td id="frominputarea"><?=$main_op['value']['op']?></td>
            <td align="right">專案性質</td><td colspan="2" id="frominputarea"><?=$main_op['projtype']['op']?><!--<select   id="projtype" name="projtype"    >
              <option value="1" >標案</option>
              <option value="2" >專案</option>
            </select>--></td>
        </tr>
		<tr>
		  <td align="right">公司別</td>
		  <td id="frominputarea"><?=$main_op['jec_company_id']['op']?></td>
		  <td align="right">專案年度</td>
		  <td colspan="2" id="frominputarea"><?=$main_op['projyear']['op']?></td>
	  </tr>
		<tr>
        	<td align="right">*專案主持人(業務)</td>
        	<td id="frominputarea"><?=$main_op['jec_usersales_id']['op']?><?=$main_op['jec_usersales_id_title']['op']?><?=$main_op['jec_dept_id']['op']?><!--<input type="text"   id="name5" name="name5"     value=""  />
       	    <select   id="jec_dept_id" name="jec_dept_id"    disabled ><option value="" selected>-部門-</option><option value="1" >全公司</option><option value="2" >董事長室</option><option value="3" >總經理室</option><option value="4" >管理部</option><option value="5" >財務室</option><option value="6" >流量實驗室</option><option value="7" >行銷部</option><option value="8" >研發部</option><option value="12" >生產部</option><option value="13" >品保部</option><option value="14" >專案組</option><option value="15" >水務組</option><option value="16" >市售組</option><option value="17" >外貿組</option><option value="18" >售服組</option><option value="19" >電子組</option><option value="20" >機械組</option><option value="21" >小表組</option><option value="22" >測試部門</option><option value="23" >測試主管</option><option value="24" >新測試部門</option></select>--></td>
            <td align="right">*專案負責人</td>
            <td colspan="2" id="frominputarea"><?=$main_op['jec_user_id']['op']?><?=$main_op['jec_user_id_title']['op']?><!--<input type="text"   id="name4" name="name4"     value=""  />-->
            (專案追蹤、承辦人)</td>
        </tr>
 		<tr>
        	<td align="right">建檔人員(助理)</td>
        	<td id="frominputarea"><?=$main_op['createdby']['op']?><?=$main_op['createdby_title']['op']?></td>
            <td align="right">建檔日期</td>
            <td colspan="2" id="frominputarea"><?=date('Y-m-d')?></td>
        </tr>       
		<tr>
		  <td align="right">*客戶名稱</td>
		  <td id="frominputarea"><?=$main_op['jec_customer_id']['op']?><?=$main_op['jec_customer_id_title']['op']?><!--<input type="text"   id="name3" name="name3"  style="width:260px;"   value=""  />--></td>
		  <td align="right">客戶案號</td>
		  <td id="frominputarea" colspan="2"><?=$main_op['customerdoc']['op']?><!--<input type="text"   id="customerdoc" name="customerdoc"   maxlength="50"   value=""  />--></td>
	  </tr>
		<tr>
		  <td align="right">*專案名稱</td>
		  <td id="frominputarea"><?=$main_op['name']['op']?><br/><!--(請勿使用'\','/',':','"','?','*','<','>','|'等特殊符號)--><!--<input type="text"   id="name" name="name"  style="width:260px;"   value=""  />--></td>
		  <td align="right">履約地點</td>
		  <td id="frominputarea" colspan="2"><?=$main_op['address']['op']?><!--<input type="text"   style="width:450px;" id="address" name="address"   maxlength="100"   value=""  />--></td>
	  </tr>		
		<tr>
        	<td align="right">*起始日期</td><td id="frominputarea"><?=$main_op['startdate']['op']?><!--<input type="text"   id="startdate" name="startdate"    readonly  value=""  />--></td>
            <td align="right"><span id='enddate_star'>結束日期</span></td>
            <td id="frominputarea" colspan="2"><?=$main_op['enddate']['op']?><span id='enddate_desc'></span><!--<input type="text"   id="enddate" name="enddate"    readonly  value=""  />--></td>
		</tr>        
		<tr>
        	<td align="right">備註說明</td><td colspan="4" id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')" /><!--<input type="text"   style="width:730px;" id="description" name="description"     value=""  /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','http://server.ecplant.com/emsproj/ecp_common/phrase_search_div/description.html')" />--></td>
        </tr>  
        <tr>
		  <td align="right"><span id='showdate_star'></span>開標日</td>
		  <td id="frominputarea"><?=$main_op['showdate']['op']?>(請輸入第1次開標日,如有異動請再次修改)</td>
		  <td align="right"><span id='tendertype_star'></span>標案類型</td>
		  <td colspan="2" id="frominputarea"><?=$main_op['tendertype']['op']?></td>
	  </tr>      
		<tr>
        	<td align="right">工程(採購)編號</td><td id="frominputarea"><?=$main_op['value2']['op']?><!--<input type="text"   id="value2" name="value2"   maxlength="50" style="width:260px;"  value=""  />--></td>
            <td align="right"><span id='description2_star'></span>管制編號</td><td colspan="2" id="frominputarea"><?=$main_op['description2']['op']?><!--<input type="text"   style="width:370px;" id="description2" name="description2"   maxlength="100"   value=""  /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','http://server.ecplant.com/emsproj/ecp_common/phrase_search_div/description2.html')" />--></td>
			
        </tr>
        
		<tr>
        	<td align="right">工程(標的)名稱</td><td id="frominputarea"><?=$main_op['name2']['op']?><!--<input type="text"   id="name2" name="name2"   maxlength="50" style="width:260px;"  value=""  />--></td>
            <td align="right">預算金額(含稅)</td><td colspan="2" id="frominputarea"><?=$main_op['description3']['op']?><!--<input type="text"   style="width:370px;" id="description3" name="description3"   maxlength="100"   value=""  /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','http://server.ecplant.com/emsproj/ecp_common/phrase_search_div/description3.html')" />--></td>
        </tr>
		
        <tr>
          <td align="right">得標日</td>
          <td id="frominputarea"><?=$main_op['getdate']['op']?></td>
          <td align="right"><span id='limitdate_star'></span>合約期限</td>
          <td colspan="2" id="frominputarea"><?=$main_op['limitdate']['op']?><span id='limitdate_desc'></span></td>
        </tr>
        <tr>
        	<td align="right">專案採購案號</td><td colspan="4" id="frominputarea"><?=$main_op['efprojdept']['op']?><?=$main_op['efprojno']['op']?><!--<input type="button" value="..." onclick="PG_BK_Action('search_ef_proj',{})" />--><?=$main_op['efprojname']['op']?><!--
        	  <select name="efprojdept" id="efprojdept">
        	    <option value="水務組">水務組</option>
        	    <option value="市售組">市售組</option>
              </select>
        	  <input type="text"   style="width:120px;" id="jec_customer_id_title2" name="jec_customer_id_title2"  onclick="PL_ChangePL('cus');" onfocus="PL_ChangePL('cus');" onblur="PL_CloseList();"    value=""  />
        	  <input class="mm_submit_button" type="button" value="..." />
        	  <input name="jec_customer_id_title3" type="text" id="jec_customer_id_title3"   style="width:400px;" onfocus="PL_ChangePL('cus');" onblur="PL_CloseList();"  onclick="PL_ChangePL('cus');"    value=""  />--></td>
        </tr>
		<tr>
		  <td align="right">合約總價(含稅)</td>
		  <td id="frominputarea"><?=$main_op['total']['op']?><!--<input type="text"   id="total" name="total"   value="只能輸入數字"  />--></td>
		  <td align="right">成本係數</td>
		  <td colspan="2" id="frominputarea"><?=$main_op['costrate']['op']?><!--<input type="text"   id="costrate" name="costrate"   value="小數點數字，預設1"  />--></td>
	  </tr>
		<tr>
		  <td align="right">發票金額(含稅)</td>
		  <td id="frominputarea"><?=$main_op['totalvoucher']['op']?><!--<input type="text"   id="total2" name="total2"   value="只能輸入數字"  />--></td>
		  <td align="right">驗收金額(含稅)</td>
		  <td colspan="2" id="frominputarea"><?=$main_op['totalaccept']['op']?><!--<input type="text"   id="total3" name="total3"   value="只能輸入數字"  />--></td>
	  </tr>
		
		<tr>
		  <td colspan="2" align="right">&nbsp;</td>
		  <td colspan="3"><input class="mm_submit_button" type="button" value="確定要新增專案，內容稍後自行輸入" onclick="pg_submit('def')" /></td>
	  </tr>
		<tr>
        	<td align="right">選擇範本</td><td id="frominputarea"><?=$main_op['project_model']['op']?><!--<select   id="project_model" name="project_model"    ><option value="" selected>--請選擇--</option><option value="2" >台水-區處(工程標案)</option><option value="3" >台水-總處(小表統購)</option><option value="4" >北水-統購</option><option value="6" >市售標案</option><option value="7" >市售工程專案</option><option value="8" >政策性推廣專案</option><option value="9" >產品異常維謢案件</option><option value="10" >設計開發案</option><option value="11" >設計變更案</option><option value="13" >產品交接後之各單位執行事項</option><option value="14" >電路會議</option><option value="15" >電子小表量產規劃</option><option value="16" >台水-區處(物料標案)</option><option value="17" >台水-總處(大表統購)</option><option value="19" >DMA規劃設計專案</option><option value="20" >勞務專案</option><option value="21" >品保部SOP文件制/修訂</option></select>--></td>
            <td colspan="3"><input class="mm_submit_button" type="button" value="載入專案範本資料，並自動新增專案"  onclick="pg_submit('project_model')"></td>
        </tr>
		<tr>
        	<td align="right">選擇專案</td><td id="frominputarea"><?=$main_op['project_history']['op']?><!--<select   id="project_history" name="project_history"    ><option value="" selected>--請選擇--</option><option value="1" >TestProj</option><option value="2" >來自範本</option><option value="3" >TEST2</option><option value="4" >新建工程</option><option value="8" >test123</option><option value="20" >許乃文</option><option value="52" >MRB通信保護</option><option value="53" >WT150/300mm設變</option><option value="55" >GTI宗蔚北水案電路功能設變</option><option value="56" >淡大水量計功能提升計劃</option><option value="60" >電子小表全球訂單佈置規劃</option><option value="61" >管理部經管會議</option><option value="62" >101年度小型螺紋式水量計(第八標項)</option><option value="63" >QC工程表、最終成品檢驗說明書再檢討</option><option value="64" >南投赤水旱灌專案</option><option value="65" >美和科大水資源建置案</option><option value="71" >電子式水量計</option><option value="74" >草屯所101年度水量計汰換工程</option><option value="75" >履約管制系統新建工程</option><option value="78" >101年度澎湖所各監測站設備維護單價</option></select>--></td>
            <td colspan="3"><input class="mm_submit_button" type="button" value="複製該專案所有資料，並自動新增專案"  onclick="pg_submit('project_history')"></td>
        </tr>
	</table>
    <!--
	<table class="query-div" cellspacing="1" cellpadding="3"  onclick="PL_DivClick();">
			<tr>
				<td colspan="6" align="left" style="padding:0px;"></td>
			</tr>
		<tr>
        	<td align="right">系統自動編號：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['value']['op']?>專案性質：<?=$main_op['projtype']['op']?></td>
            <td align="right">公司別：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['jec_company_id']['op']?></td>
            <td align="right">專案年度：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['projyear']['op']?></td>
        </tr>
		<tr>
        	<td align="right">*業務(專案主持人)：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['jec_usersales_id']['op']?><?=$main_op['jec_usersales_id_title']['op']?><?=$main_op['jec_dept_id']['op']?></td>
            <td align="right">*客戶名稱：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['jec_customer_id']['op']?><?=$main_op['jec_customer_id_title']['op']?></td>
            <td align="right">客戶案號：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['customerdoc']['op']?></td>
        </tr>
        
		<tr>
        	<td align="right">*專案負責人：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['jec_user_id']['op']?><?=$main_op['jec_user_id_title']['op']?>(專案追蹤、承辦人)</td>
            <td align="right">履約地點：</td>
            <td id="frominputarea" colspan="3" class="mm_td_pad"><?=$main_op['address']['op']?></td>
		</tr>
        
		<tr>
        	<td align="right">*專案名稱：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['name']['op']?></td>
            <td align="right">備註說明：</td><td colspan="3" id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['description']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')" /></td>
        </tr>
		<tr>
        	<td align="right">工程(採購)編號：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['value2']['op']?></td>
            <td align="right">備註說明2：</td><td colspan="3" id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['description2']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description2/')?>')" /></td>
        </tr>
		<tr>
        	<td align="right">工程(標的)名稱：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['name2']['op']?></td>
            <td align="right">備註說明3：</td><td colspan="3" id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['description3']['op']?><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description3/')?>')" /></td>
        </tr>
		<tr>
        	<td align="right">*起始日期：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['startdate']['op']?></td>
            <td align="right">*結束日期：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['enddate']['op']?></td>
            <td align="right">專案狀態：</td><td>得標前/工作準備 </td>
        </tr>
		<tr>
        	<td align="right">專案採購案號：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;" colspan="5"><?=$main_op['efprojdept']['op']?><?=$main_op['efprojno']['op']?><input type="button" value="..." onclick="PG_BK_Action('search_ef_proj',{})" /><?=$main_op['efprojname']['op']?></td>
        </tr>
		<tr>
        	<td align="right">合約總價：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['total']['op']?></td>
            <td align="right">成本係數：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['costrate']['op']?></td>
            <td align="right"></td><td></td>
        </tr>        
        
		<tr>
        	<td align="right">選擇範本：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['project_model']['op']?></td>
            <td colspan="2"><input class="mm_submit_button" type="button" value="載入專案範本資料，並自動新增專案"  onclick="pg_submit('project_model')"></td>
            <td align="right"></td><td></td>
        </tr>
		<tr>
        	<td align="right">選擇專案：</td><td id="frominputarea" class="mm_td_pad" style="padding-right:2px;"><?=$main_op['project_history']['op']?></td>
            <td colspan="2"><input class="mm_submit_button" type="button" value="複製該專案所有資料，並自動新增專案"  onclick="pg_submit('project_history')"></td>
            <td colspan="2"><input class="mm_submit_button" type="button" value="確定要新增專案" onclick="pg_submit('def')"></td>
        </tr>
	</table>-->
</form>    
</div>
<script>
var cal = Calendar.setup({
    	  onSelect: function(cal) { cal.hide() },
		  showTime: true
	  });
cal.manageFields("startdate", "startdate", "%Y-%m-%d");
cal.manageFields("enddate", "enddate", "%Y-%m-%d");
cal.manageFields("showdate", "showdate", "%Y-%m-%d");
cal.manageFields("getdate", "getdate", "%Y-%m-%d");
cal.manageFields("limitdate", "limitdate", "%Y-%m-%d");
function pg_submit(type)
{
	info=Array();
	var errno=0;
	info[errno++]={id:'name',msg:'專案名稱不可空白',type:'ne'};
	
	info[errno++]={id:'startdate',msg:'起始日期不可空白',type:'ne'};
	
	/*
	if($("#cus_select_type").val()=='S'){
		info[4]={id:'jec_customer_id',msg:'請選擇客戶',type:'ne'};
	}else{
		info[4]={id:'jec_customer_id_title',msg:'請選擇客戶',type:'ne'};
	}	*/
	info[errno++]={id:'jec_customer_id_title',msg:'請選擇客戶',type:'ne'};
	info[errno++]={id:'jec_user_id_title',msg:'請選擇專案負責人',type:'ne'};
	info[errno++]={id:'jec_usersales_id_title',msg:'請選擇業務',type:'ne'};
	if($("#efprojdept").val()!=''){
		info[errno++]={id:'efprojno',msg:'請選擇專案採購編號',type:'ne'};
	}else{
		info[errno++]={id:'name',msg:'專案名稱不可空白',type:'ne'};
	}	
	info[errno++]={id:'projtype',msg:'請選擇專案性質',type:'nz'};
	info[errno++]={id:'jec_company_id',msg:'請選擇公司別',type:'nz'};
	info[errno++]={id:'projyear',msg:'請選擇專案年度',type:'nz'};
	if($("#projtype").val()==1)//標案
	{
		info[errno++]={id:'description2',msg:'管制編號不可空白',type:'ne'};
		info[errno++]={id:'showdate',msg:'請輸入開標日，以利得標前準備工作展開',type:'ne'};
		info[errno++]={id:'tendertype',msg:'請選擇標案類型',type:'nz'};
		info[errno++]={id:'limitdate',msg:'請選擇合約期限',type:'ne'};
	}
	else//專案
	{
		info[errno++]={id:'enddate',msg:'結束日期不可空白',type:'ne'};	
		info[errno++]={sd_id:'startdate',ed_id:'enddate',msg:'結束日期不能小於起始日',type:'sed'};
	}
	switch(type){
		case 'def':
			document.getElementById('project_model').value='';
			document.getElementById('project_history').value='';
			break;
		case 'project_model':
			info[errno++]={id:'project_model',msg:'請選擇專案範本',type:'ne'};			
			document.getElementById('project_history').value='';
			break;
		case 'project_history':
			if($("#projtype").val()==1)
			{
				ECP_Msg('標案請使用範本匯入',-1,'error');
				return;
			}
			info[errno++]={id:'project_history',msg:'請選擇專案',type:'ne'};
			document.getElementById('project_model').value='';
			break;
	}
	
	msg=fi_submit_check(info);
	if(msg==''){
		//final check
		//		
		data={ cus_name:$("#jec_customer_id_title").val(),sales_name:$("#jec_usersales_id_title").val(),user_name:$("#jec_user_id_title").val(),createdby_name:$("#createdby_title").val() };
		AWEA_Ajax('<?=$check_proj_url?>',data,'');
		//document.getElementById('edit_form').submit();
	}
}
function PG_BK_Action(type,data)
{	var info=Array();  
	switch(type){
		case 'add_proj_go':
			if(GetTagV(data,'isexist')=='Y'){
				$("#jec_customer_id").val(GetTagV(data,'cus_id'));
				//$("#jec_customer_id_title").val(GetTagV(data,'cus_name'));
				$("#jec_user_id").val(GetTagV(data,'user_id'));
				$("#jec_user_id_title").val(GetTagV(data,'user_name'));
				$("#jec_usersales_id").val(GetTagV(data,'sales_id'));				
				$("#jec_usersales_id_title").val(GetTagV(data,'sales_name'));
				$("#createdby").val(GetTagV(data,'createdby'));
				$("#createdby_title").val(GetTagV(data,'createdby_name'));
				$("#jec_dept_id").val(GetTagV(data,'sales_dept'));
				document.getElementById('edit_form').submit();
			}
			break;
		case 'get_dept_id_by_saler':
			data={ user_id:$("#jec_usersales_id").val() };
			AWEA_Ajax('<?=$get_dept_url?>',data,'');
			break;
		case 'get_purchase_list_by_dept':
			data={ dept_id:$("#efprojdept").val() };
			$("#purchase_name_tag").html('');
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
			window.open(url,'','width=650,height=600,scrollbars=yes');
			break;
	}
}
function projtype_onchange()
{
	if($("#projtype").val()==1)//標案
	{
		$("#project_model").attr('disabled', true);		
		$("#project_history").attr('disabled', true);
		$('#project_model option')[0].selected = true;
		$('#project_history option')[0].selected = true;
		$('#enddate_star').text('竣工日期');
		$('#limitdate_star').text('*');
		$('#description2_star').text('*');
		$('#showdate_star').text('*');
		$('#enddate_desc').text('(竣工時再填入實際竣工日期)');
		$('#limitdate_desc').text('(預計完成日)');
		$('#tendertype_star').text('*');
	}
	else
	{
		$("#project_model").attr('disabled', false);
		$("#project_history").attr('disabled', false);
		$('#enddate_star').text('*結束日期');
		$('#limitdate_star').text('');
		$('#description2_star').text('');
		$('#showdate_star').text('');
		$('#enddate_desc').text('');
		$('#limitdate_desc').text('');
		$('#tendertype_star').text('');
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
				cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_customer_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'jec_customer_id','input_type':'R','width':300,'title_id':'jec_customer_id_title' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_user_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_user_id','input_type':'R','width':160,'title_id':'jec_user_id_title' },
				usersales:{ search_list:'pl_search_list',search_value:'search_value',search_here:'jec_usersales_id_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'jec_usersales_id','input_type':'R','width':160,'title_id':'jec_usersales_id_title','onchange':"get_dept_id_by_saler" },
			 createdby:{ search_list:'pl_search_list',search_value:'search_value',search_here:'createdby_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'createdby','input_type':'R','width':160,'title_id':'createdby_title' }
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