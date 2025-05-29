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
	<!-- 設定功能操作頁籤: 人員職稱/人員群組/費用名稱/單位設定/公司設定 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">人員職稱</a></li>
					<li><a href=# onclick="loadme(1)">人員群組</a></li>
					<li><a href=# onclick="loadme(2)">費用名稱</a></li>
					<li><a href=# onclick="loadme(3)" class="selected">單位設定</a></li>
					<li><a href=# onclick="loadme(4)">公司設定</a></li>
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
						location.href = "<?= base_url().'ecp_data_title/index/' ?>";
						break;
					case 1:
						location.href = "<?= base_url().'ecp_data_title/user_group/' ?>";
						break;
					case 2:
						location.href = "<?= base_url().'ecp_data_title/charge_item/' ?>";
						break;
					case 3:
						//location.href = "<?= base_url().'ecp_data_title/unit_measure/' ?>";
						break;
					case 4:
						location.href = "<?= base_url().'ecp_data_title/company_setup/' ?>";
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 單位設定 -->
	<div id="unit_measure">
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="2" align="left">新增單位</td>
			</tr>
			<tr>
				<td align="right">單位：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea">
					<input id="description" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增單位" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="4">現有單位列表</td>
			</tr>
			<tr>
				<td id="detail-normal">單位</td>
				<td id="detail-normal">備註說明</td>
				<td align="center" id="detail-normal">修改</td>
				<td align="center" id="detail-normal">刪除</td>
			</tr>
			<?php foreach($uom_list as $key => $uomlist): ?>
				<tr>
					<td>
						<input type="text" id="<?= 'name'.$uomlist['jec_uom_id'] ?>" 
						value="<?= $uomlist['name'] ?>" size="38" />
					</td>
					<td>
						<input type="text" id="<?= 'description'.$uomlist['jec_uom_id'] ?>" 
						value="<?= $uomlist['description'] ?>" size="88" />
					</td>
					<td align="center">
						<?php if ($authority['isupdate']=='Y'): ?>
							<input type="button" id="<?= 'btn_update'.$uomlist['jec_uom_id'] ?>" 
							value="修改" onclick="data_update(<?= $uomlist['jec_uom_id'] ?>)" />
						<?php else: ?>
							---
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($authority['isdelete']=='Y'): ?>
							<input type="button" id="<?= 'btn_delete'.$uomlist['jec_uom_id'] ?>" 
							value="刪除" onclick="data_delete(<?= $uomlist['jec_uom_id'] ?>)" />
						<?php else: ?>
							---
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("單位不可空白");
					return;
				}
				//if (! confirm("是否確認要新增單位?")) return;
				para_data = {
					name: $("#name").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/uom_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('單位新增完成');
							pagereload();
						}
						else
							humane.error('單位新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("單位不可空白");
					return;
				}
				//if (! confirm("是否確認要更新單位?")) return;
				para_data = {
					jec_uom_id: id,
					name: $("#name" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/uom_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('單位更新完成');
						else
							humane.error('單位更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除單位?")) return;
				para_data = {
					jec_uom_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/uom_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('單位刪除完成');
							pagereload();
						}
						else
							humane.error('單位刪除作業失敗！');
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