<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ecplant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/pagereload.js"></script>
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 料品列表/ERP料品對應 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">料品列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">ERP料品對應</a></li>
				</ul>
			</div>
			<div class="tab-div-right"><?= $function_name ?></div>
		</div>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr><td class="tab-underline"></td></tr>
		</table>
		<!-- 頁籤切換  -->
		<script type="text/javascript">
			function loadme(idxtag)
			{
				switch (idxtag)
				{
					case 0:
						location.href = "<?= base_url().'ecp_data_product/index/' ?>";
						break;
					case 1:
						break;
				}
			}
		</script>
	</div>
	<div class="clearfix">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 料品資料 -->
	<div class="order-div" style="width: 18%; margin-right: 5px;">
		<table class="info-div" cellspacing="1" cellpadding="3">
			<tr><td class="info-title">料品資料</td></tr>
			<tr><td>類別：<?= $this->ecp_flag->get_prodtype($prod_data[0]['prodtype']) ?></td></tr>
			<tr><td>料號：<?= $prod_data[0]['value'] ?></td></tr>
			<tr><td>品名：<?= $prod_data[0]['name'] ?></td></tr>
			<tr><td>規格：<?= $prod_data[0]['specification'] ?></td></tr>
			<tr><td>單位：<?= $prod_data[0]['unit'] ?></td></tr>
		</table>
	</div>
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 編輯ERP對應關係 -->
	<div class="order-div" style="display: inline; width: 81%;">
		<div id="proderp_list">
			<?php $this->load->view('ecp_data/ecp_data_product_proderp_list', $proderp_list); ?>
		</div>
		<table class="query-div" cellspacing="1" cellpadding="3">
			<tr>
				<td colspan="2" align="left">查詢關鍵字後，可勾選相關的ERP材料，再執行新增作業</td>
			</tr>
			<tr>
				<td align="right">查詢相關詞：</td>
				<td>
					<input id="kwstring" type="text" value="" size="20" />&nbsp;
					<input type="button" id="btn_kwquery" value="查詢" onclick="keyword_query()" />
					<input type="button" id="btn_back" value="返回料品列表" onclick="back_to_prod_list()" />
				</td>
			</tr>
		</table>
		<div id="proderp_select">
			<?php $this->load->view('ecp_data/ecp_data_product_proderp_select', $proderp_select); ?>
		</div>
		<script type="text/javascript">
			// 回到料品列表之前的頁次
			function back_to_prod_list()
			{
				location.href = "<?= base_url().'ecp_data_product/index/' ?>" + "<?= $sort_field ?>" + "/" + "<?= $sort_sequence ?>" + "/" + "<?= $pagestart ?>";
			}
			// 查詢關鍵字, 顯示查詢結果
			function keyword_query()
			{
				if ($.trim($("#kwstring").val())=="")
				{
					humane.error('查詢相關詞不可空白');
					return;
				}
				para_data = {
					kwstring: $("#kwstring").val()
				};
				$("#proderp_select").load('<?= site_url('ecp_data_product/reload_proderp_select/') ?>', para_data);
			}
			// 新增勾選的關鍵字
			function keyword_select()
			{
				var obj=document.getElementsByName("kwselect");
				var len = obj.length;
				var checklist = "";
				var checked = false;
				for (i = 0; i < len; i++)
				{
					id = $("#kwselectid" + i).val();
					if (obj[i].checked == true)
					{
						checklist = checklist + id + "/Y;";
						checked = true;
					}
					else
					{
						checklist = checklist + id + "/N;";
					}
				}
				if (! checked)
				{
					humane.error("沒有選擇ERP材料，無法新增");
					return;
				}
				if (! confirm("是否確認要新增勾選的ERP材料對應?")) return;
				para_data = {
					jec_product_id: "<?= $prod_data[0]['jec_product_id'] ?>",
					checklist: checklist
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_product/keyword_select/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('ERP材料對應新增完成');
							para_data1 = {
								jec_product_id: "<?= $prod_data[0]['jec_product_id'] ?>"
							};
							$("#proderp_list").load('<?= site_url('ecp_data_product/reload_proderp_list/') ?>', para_data1);
							$("#kwstring").val("");
							para_data2 = {
								kwstring: ""
							};
							$("#proderp_select").load('<?= site_url('ecp_data_product/reload_proderp_select/') ?>', para_data2);
						}
						else
						{
							humane.error("關鍵字新增作業失敗！");
						}
					}
				});
			}
			// 移除勾選的關鍵字
			function keyword_delete()
			{
				var obj=document.getElementsByName("kwlist");
				var len = obj.length;
				var checklist = "";
				var checked = false;
				for (i = 0; i < len; i++)
				{
					id = $("#kwlistid" + i).val();
					if (obj[i].checked == true)
					{
						checklist = checklist + id + "/Y;";
						checked = true;
					}
					else
					{
						checklist = checklist + id + "/N;";
					}
				}
				if (! checked)
				{
					humane.error("沒有選擇關鍵字，無法移除");
					return;
				}
				if (! confirm("是否確認要移除勾選的關鍵字?")) return;
				para_data = {
					jec_product_id: "<?= $prod_data[0]['jec_product_id'] ?>",
					checklist: checklist
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_product/keyword_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('關鍵字移除完成');
							para_data1 = {
								jec_product_id: "<?= $prod_data[0]['jec_product_id'] ?>"
							};
							$("#proderp_list").load('<?= site_url('ecp_data_product/reload_proderp_list/') ?>', para_data1);
						}
						else
						{
							humane.error("關鍵字移除作業失敗！");
						}
					}
				});
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>