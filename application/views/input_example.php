<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script><!-- jquery為必要-->

<!--片語用的-->
<script type="text/javascript" src="<?=base_url()?>js/thickbox_rc.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/common.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/thickbox.css" />
<!--片語用的-End-->

<body onclick="PL_DivClick();"><!-- PL_DivClick(); 放在輸入區外圍的地方，當點擊到時關閉目前的列表 -->

<br /><br /><br />

<div onclick="PL_DivClick();" style="padding:30px;">
Customer:
<input type="text"   style="width:200px;" id="s_proj_customer_title" name="s_proj_customer_title"  onclick="PL_ChangePL('cus');" onfocus="PL_ChangePL('cus');" onblur="PL_CloseList();"    value=""  /><input type="hidden"  id="s_proj_jec_customer_id" name="s_proj_jec_customer_id"  value=""  /><label id="s_proj_customer_title_lb"></label><br />
User:
<input type="text"   style="width:300px;" id="s_proj_salesuser_title" name="s_proj_salesuser_title"  onclick="PL_ChangePL('user');" onfocus="PL_ChangePL('user');" onblur="PL_CloseList();"    value=""  /><input type="hidden"  id="s_proj_jec_salesuser_id" name="s_proj_jec_salesuser_id"  value=""  />
<br /><br />
product:
<input type="text"   style="width:400px;" id="s_prod" name="s_prod"  onclick="PL_ChangePL('product_ex');" onfocus="PL_ChangePL('product_ex');" onblur="PL_CloseList();"    value=""  /><input type="hidden"  id="s_prod_id" name="s_prod_id"  value=""  />
<br /><br /><br />
片語的套用：<br />
<input type="text" id="phase_here" /><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/phase_here/')?>')"  /><br />
<input type="text" id="phase_here_2" /><input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/phase_here_2/')?>')"  />
</div>





<!--以下為必要的東東-->
<div id="pl_search_div" style="display:none;background:#FFFFFF;position:absolute;top:0px;left:0px;">
<iframe id="pl_search_list" name="pl_search_list" frameborder="0" style="border:1px solid #CCCCCC;width:600px;height:300px;" ></iframe>
</div> 
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>
var InputList={
		on:'cus',
		info:{ 
				cus:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_customer_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/customer/')?>','input_id':'s_proj_jec_customer_id','input_type':'R','width':200,'label_id':'s_proj_customer_title_lb' },
				user:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_proj_salesuser_title',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select/user/')?>','input_id':'s_proj_jec_salesuser_id','input_type':'R','width':300 },
				product_ex:{ search_list:'pl_search_list',search_value:'search_value',search_here:'s_prod',search_div:'pl_search_div',url:'<?=base_url('ecp_common/search_select_con/product_ex/1/')?>','input_id':'s_prod_id','input_type':'R','width':400 }
				/*
				label_id->有需要顯示的話才加
				主要設定
				search_here->輸入框的id
				url=>目標網址 /輸入的字串會加再網址尾巴
				input_id=>實際儲存的id
				width:寬度
				
				*/
			 },
		on_select:'on_select',
		select_status:'select_status',
		css_off_select:'off_select',
		css_on_select:'on_select',
		pg_list_on:'N',
		blank_url:'<?=base_url('ecp_test/blank')?>', //給一個空白頁
		onfocus:'',
		top:-18,	//預設35 //視情況微調位置
		left:0 //預設10
	};
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>
<!--以上為必要的東東-->
</body>
</html>
