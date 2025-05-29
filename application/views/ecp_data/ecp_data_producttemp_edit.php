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
	<!-- 設定功能操作頁籤: 料品範本列表/範本內容編輯 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">料品範本列表</a></li>
					<li><a href=# onclick="loadme(1)" class="selected">範本內容編輯</a></li>
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
						location.href = "<?= base_url().'ecp_data_producttemp/index/' ?>";
						break;
					case 1:
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<div>
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="4" align="left">料品範本內容編輯</td>
			</tr>
			<tr>
				<td align="right">範本名稱：</td>
				<td id="frominputarea"><?= $producttemp_data[0]['name'] ?></td>
				<td align="right">查詢相關詞：</td>
				<td>
					<?php if ($authority['isinsert']=='Y'): ?>
						<input id="kwstring" type="text" value="" size="20" />&nbsp;
						<input type="button" id="btn_kwquery" value="查詢料品或工作明細" onclick="keyword_query()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="button" id="btn_back" value="返回料品範本列表" onclick="back_to_producttemp_list()" />
				</td>
			</tr>
		</table>
		<div id="prod_select">
			<?php $this->load->view('ecp_data/ecp_data_producttemp_edit_product_select', $prod_select); ?>
		</div>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 料品範本內容(不分頁) -->
		<div id="producttemp_edit">
			<?php $this->load->view('ecp_data/ecp_data_producttemp_edit_list', $producttemp_edit); ?>
		</div>
		<script type="text/javascript">
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
				$("#prod_select").load('<?= site_url('ecp_data_producttemp/reload_prod_select/') ?>', para_data);
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
					tp = $("#kwselecttp" + i).val();
					if (obj[i].checked == true)
					{
						checklist = checklist + id + "/" + tp + "/Y;";
						checked = true;
					}
					else
					{
						checklist = checklist + id + "/" + tp + "/N;";
					}
				}
				if (! checked)
				{
					humane.error("沒有選擇料品或工作明細，無法新增");
					return;
				}
				//if (! confirm("是否確認要新增勾選的料品或工作明細?")) return;
				$("#btn_kwselect").attr("disabled", true);
				para_data = {
					jec_producttemp_id: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>",
					checklist: checklist
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_producttemp/keyword_select/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('料品或工作明細新增完成');
							para_data1 = {
								jec_producttemp_id: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "NEW"
							};
							$("#producttemp_edit").load('<?= site_url('ecp_data_producttemp/reload_producttemp_edit/') ?>', para_data1);
							$("#kwstring").val("");
							para_data2 = {
								kwstring: ""
							};
							$("#prod_select").load('<?= site_url('ecp_data_producttemp/reload_prod_select/') ?>', para_data2);
							$("#btn_kwselect").attr("disabled", false);
						}
						else
						{
							humane.error("料品或工作明細新增作業失敗！");
						}
					}
				});
			}
			// 返回料品範本列表
			function back_to_producttemp_list()
			{
				location.href = "<?= base_url().'ecp_data_producttemp/index/' ?>" + "<?= $sort_field ?>" + "/" + "<?= $sort_sequence ?>" + "/" + "<?= $pagestart ?>";
			}

			// 向上下移動
			function producttemp_updown(id, updown)
			{
				para_data = {
					id: id,
					updown: updown,
					parentid: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>"
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_producttemp/producttemp_updown/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('排序移動完成');
							para_data1 = {
								jec_producttemp_id: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "SORT"
							};
							$("#producttemp_edit").load('<?= site_url('ecp_data_producttemp/reload_producttemp_edit/') ?>', para_data1);
						}
						else
							humane.error('排序移動作業失敗！');
					}
				});
			}
			// 刪除料品範本內容
			function data_delete(id, seqno)
			{
				if (! confirm("是否確認要刪除料品範本內容?")) return;
				para_data = {
					jec_producttempline_id: id,
					jec_producttemp_id: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>",
					seqno: seqno
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_producttemp/producttemp_product_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('料品範本內容刪除完成');
							para_data1 = {
								jec_producttemp_id: "<?= $producttemp_data[0]['jec_producttemp_id'] ?>",
								pagestart: "<?= $pagestart ?>",
								sort_field: "<?= $sort_field ?>",
								sort_sequence: "<?= $sort_sequence ?>",
								opertype: "DEL"
							};
							$("#producttemp_edit").load('<?= site_url('ecp_data_producttemp/reload_producttemp_edit/') ?>', para_data1);
						}
						else
							humane.error('料品範本內容刪除作業失敗！');
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