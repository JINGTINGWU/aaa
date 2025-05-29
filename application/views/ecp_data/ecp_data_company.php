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
	<!-- 設定功能操作頁籤: 人員職稱/人員群組/費用名稱/公司設定/公司設定 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)">人員職稱</a></li>
					<li><a href=# onclick="loadme(1)">人員群組</a></li>
					<li><a href=# onclick="loadme(2)">費用名稱</a></li>
					<li><a href=# onclick="loadme(3)">單位設定</a></li>
					<li><a href=# onclick="loadme(4)" class="selected">公司設定</a></li>
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
						location.href = "<?= base_url().'ecp_data_title/unit_measure/' ?>";
						break;
					case 4:
						//location.href = "<?= base_url().'ecp_data_title/company_setup/' ?>";
						break;
				}
			}
		</script>
	</div>
	<div id="body">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 公司設定 -->
	<div id="company_setup">
		<table class="query-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6" align="left">新增公司</td>
			</tr>
			<tr>
				<td align="right">公司：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="20" />
				</td>
				<td align="right">DB連結字串：</td>
				<td id="frominputarea">
					<input id="dbsetup" type="text" value="" size="20" />
				</td>
				<td align="right">連結EasyFlow：</td>
				<td id="frominputarea">
					<input id="iseasyflow" type="text" value="" size="2" />
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td colspan="5" id="frominputarea">
					<input id="description" type="text" value="" size="100" />
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增公司" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
				</td>
			</tr>
		</table>
		<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
			<tr>
				<td colspan="6">現有公司列表</td>
			</tr>
			<tr>
				<td id="detail-normal">公司</td>
				<td id="detail-normal">DB連結字串</td>
				<td id="detail-normal">連結EasyFlow</td>
				<td id="detail-normal">備註說明</td>
				<td align="center" id="detail-normal">修改</td>
				<td align="center" id="detail-normal">刪除</td>
			</tr>
			<?php foreach($company_list as $key => $companylist): ?>
				<tr>
					<td>
						<input type="text" id="<?= 'name'.$companylist['jec_company_id'] ?>" 
						value="<?= $companylist['name'] ?>" size="38" />
					</td>
					<td>
						<input type="text" id="<?= 'dbsetup'.$companylist['jec_company_id'] ?>" 
						value="<?= $companylist['dbsetup'] ?>" size="20" />
					</td>
					<td>
						<input type="text" id="<?= 'iseasyflow'.$companylist['jec_company_id'] ?>" 
						value="<?= $companylist['iseasyflow'] ?>" size="2" />
					</td>
					<td>
						<input type="text" id="<?= 'description'.$companylist['jec_company_id'] ?>" 
						value="<?= $companylist['description'] ?>" size="50" />
					</td>
					<td align="center">
						<?php if ($authority['isupdate']=='Y'): ?>
							<input type="button" id="<?= 'btn_update'.$companylist['jec_company_id'] ?>" 
							value="修改" onclick="data_update(<?= $companylist['jec_company_id'] ?>)" />
						<?php else: ?>
							---
						<?php endif; ?>
					</td>
					<td align="center">
						<?php if ($authority['isdelete']=='Y'): ?>
							<input type="button" id="<?= 'btn_delete'.$companylist['jec_company_id'] ?>" 
							value="刪除" onclick="data_delete(<?= $companylist['jec_company_id'] ?>)" />
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
					humane.error("公司不可空白");
					return;
				}
				//if (! confirm("是否確認要新增公司?")) return;
				para_data = {
					name: $("#name").val(),
					dbsetup: $("#dbsetup").val(),
					iseasyflow: $("#iseasyflow").val(),
					description: $("#description").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/company_new/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('公司新增完成');
							pagereload();
						}
						else
							humane.error('公司新增作業失敗！');
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("公司不可空白");
					return;
				}
				//if (! confirm("是否確認要更新公司?")) return;
				para_data = {
					jec_company_id: id,
					name: $("#name" + id).val(),
					dbsetup: $("#dbsetup" + id).val(),
					iseasyflow: $("#iseasyflow" + id).val(),
					description: $("#description" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/company_update/')?>",
					data: (para_data),
					success: function(result){
						if (result)
							humane.info('公司更新完成');
						else
							humane.error('公司更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除公司?")) return;
				para_data = {
					jec_company_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_title/company_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result)
						{
							humane.info('公司刪除完成');
							pagereload();
						}
						else
							humane.error('公司刪除作業失敗！');
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