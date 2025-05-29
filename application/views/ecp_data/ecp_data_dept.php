<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ecplant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jackedup.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/thickbox.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/thickbox_rc.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/common.js"></script>
</head>
<body>
<div><?= $navigation ?></div>
<div id="container">
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 部門列表/展開部門/人員列表/群組人員 -->
	<div class="tabpage">
		<div class="clearfix">
			<div class="tab-div-left">
				<ul id="functiontabs">
					<li><a href=# onclick="loadme(0)" class="selected">部門列表</a></li>
					<li><a href=# onclick="loadme(1)">展開部門</a></li>
					<li><a href=# onclick="loadme(2)">人員列表</a></li>
					<li><a href=# onclick="loadme(3)">群組人員</a></li>
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
						//location.href = "<?= base_url().'ecp_data_deptuser/index/' ?>";
						break;
					case 1:
						location.href = "<?= base_url().'ecp_data_deptuser/dept_expand/' ?>";
						break;
					case 2:
						location.href = "<?= base_url().'ecp_data_deptuser/user_list/' ?>";
						break;
					case 3:
						location.href = "<?= base_url().'ecp_data_deptuser/usergroup_list/' ?>";
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
				<td colspan="6" align="left">新增部門</td>
			</tr>
			<tr>
				<td align="right">部門名稱：</td>
				<td id="frominputarea">
					<input id="name" type="text" value="" size="50" />
				</td>
				<td align="right">上層部門：</td>
				<td id="frominputarea">
					<select size="1" name="jec_deptuplayer_id" id="jec_deptuplayer_id">
						<?php foreach($select_deptuplayer as $selectdeptuplayer): ?>
							<option value="<?= $selectdeptuplayer['jec_dept_id'] ?>"><?= $selectdeptuplayer['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td align="right">部門主管：</td>
				<td id="frominputarea">
					<select size="1" name="jec_user_id" id="jec_user_id">
						<?php foreach($select_user as $selectuser): ?>
							<option value="<?= $selectuser['jec_user_id'] ?>"><?= $selectuser['name'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right">備註說明：</td>
				<td id="frominputarea" colspan="5">
					<input id="description" type="text" value="" size="100" />
					<input type="button" value="片語輸入"  onclick="thick_box('open','片語輸入','<?=base_url('ecp_common/phrase_search_div/description/')?>')"  />
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center">
					<?php if ($authority['isinsert']=='Y'): ?>
						<input type="button" id="btn_new" value="確定新增部門" onclick="data_new()" />
					<?php else: ?>
						---
					<?php endif; ?>
					<input type="hidden" id="sort_field" value="<?= $sort_field ?>" />
					<input type="hidden" id="sort_sequence" value="<?= $sort_sequence ?>" />
				</td>
			</tr>
		</table>
		<!-- ----------------------------------------------------------------------------------- -->
		<!-- 現有部門資料列表(含頁次) -->
		<div id="dept_list">
			<?php $this->load->view('ecp_data/ecp_data_dept_list', $dept_list); ?>
		</div>
		<script type="text/javascript">
			// 新增
			function data_new()
			{
				if ($.trim($("#name").val()) == "")
				{
					humane.error("部門名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要新增部門?")) return;
				$("#btn_new").attr("disabled", true);
				para_data = {
					name: $("#name").val(),
					description: $("#description").val(),
					jec_deptuplayer_id: $("#jec_deptuplayer_id").val(),
					jec_user_id: $("#jec_user_id").val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/dept_new/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('部門新增完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "NEW"
							};
							$("#dept_list").load('<?= site_url('ecp_data_deptuser/reload_dept_list/') ?>', para_data1);
							$("#btn_new").attr("disabled", false);
							$("#name").val("");
							$("#description").val("");
							$("#jec_deptuplayer_id").val("");
							$("#jec_user_id").val("");
						}
						else if (result == "EXIST")
						{
							humane.error('部門名稱重覆！');
							$("#btn_new").attr("disabled", false);
						}
						else
						{
							humane.error('部門新增作業失敗！');
							$("#btn_new").attr("disabled", false);
						}
					}
				});
			}
			// 修改
			function data_update(id)
			{
				if ($.trim($("#name" + id).val()) == "")
				{
					humane.error("部門名稱不可空白");
					return;
				}
				//if (! confirm("是否確認要更新部門?")) return;
				para_data = {
					jec_dept_id: id,
					name: $("#name" + id).val(),
					description: $("#description" + id).val(),
					jec_deptuplayer_id: $("#jec_deptuplayer_id" + id).val(),
					jec_user_id: $("#jec_user_id" + id).val()
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/dept_update/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
							humane.info('部門更新完成');
						else if (result == "EXIST")
							humane.error('部門名稱重覆！');
						else if (result == "UNREASON")
							humane.error('上層部門不能和目前的部門一樣！');
						else
							humane.error('部門更新作業失敗！');
					}
				});
			}
			// 刪除
			function data_delete(id)
			{
				if (! confirm("是否確認要刪除部門?")) return;
				para_data = {
					jec_dept_id: id
				};
				$.ajax({
					type: "POST",
					url: "<?=site_url('ecp_data_deptuser/dept_delete/')?>",
					data: (para_data),
					success: function(result){
						if (result == "OK")
						{
							humane.info('部門刪除完成');
							para_data1 = {
								pagestart: "<?= $pagestart ?>",
								sort_field: $("#sort_field").val(),
								sort_sequence: $("#sort_sequence").val(),
								opertype: "DEL"
							};
							$("#dept_list").load('<?= site_url('ecp_data_deptuser/reload_dept_list/') ?>', para_data1);
						}
						else if (result == "EXIST")
							humane.error('此部門為上層部門，不能刪除！');
						else
							humane.error('部門刪除作業失敗！');
					}
				});
			}
			// 欄位排序
			function data_sort(sort_field)
			{
				if (sort_field == $("#sort_field").val())
				{
					if ($("#sort_sequence").val() == "asc")
						$("#sort_sequence").val("desc");
					else
						$("#sort_sequence").val("asc");
				}
				else
				{
					$("#sort_field").val(sort_field);
					$("#sort_sequence").val("asc");
				}
				para_data = {
					pagestart: "<?= $pagestart ?>",
					sort_field: $("#sort_field").val(),
					sort_sequence: $("#sort_sequence").val(),
					opertype: "SORT"
				};
				$("#dept_list").load('<?= site_url('ecp_data_deptuser/reload_dept_list/') ?>', para_data);
			}
		</script>
	</div>
	</div>
	<p class="footer">ECPlant Tech. 2012</p>
</div>
</body>
</html>