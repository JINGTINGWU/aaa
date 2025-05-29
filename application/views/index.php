<script type="text/javascript" src="<?=base_url()?>js/jquery.blockUI.js"></script>
<!-- 功能選單 -->
<div id="ecp_menudiv" style="z-index: 1000; width: 100%; height: 60px; position:absolute; top: 0px; left: 0px;">
	<div class="logininfo">
		<table border="0" width="100%" cellpadding="0">
		  <tr>
		    <td>&nbsp;使用者：<?= $users[0]['name'] ?>&nbsp;｜&nbsp;
		    	部門：<?= $users[0]['deptname'] ?>&nbsp;｜&nbsp;
		    	登入時間：<?= $nowtime ?>&nbsp;｜&nbsp;
                <?=strpos(base_url(),"pmstest")?'<span style="color:red">測試區</span>':''?>
		    </td>
		    <td>&nbsp;｜&nbsp;待辦工作：&nbsp;<span class="logintask"><a href="<?=base_url('ecp_work/self_work_mng/work_list_index/list/-1/created/DESC/0/Undone/ ')?>"><?=$undone_task?></a></span></td>
		    <td>&nbsp;｜&nbsp;待確認件：&nbsp;<span class="logintask"><a href="<?=base_url('ecp_work/inform_item_mng/inform_list_index/list/-1/created/DESC/0/Unconfirm/ ')?>"><?=$unconfirm_notice?></a></span>　批次確認件：&nbsp;<span class="logintask"><a href="<?=base_url('ecp_work/inform_item_mng/project_list_index/list/-1/created/DESC/0/Unconfirm/ ')?>"><?=$batchunconfirm_notice?></a></span></td>            
		    <td>&nbsp;｜&nbsp;逾期工作：&nbsp;<span class="loginalert"><a href="<?=base_url('ecp_work/self_work_mng/work_list_index/list/-1/created/DESC/0/Delay/ ')?>"><?=$delay_task?></a></span></td>
		    <td>&nbsp;｜&nbsp;警示通知：&nbsp;<span class="loginalert"><a href="<?=base_url('ecp_work/inform_item_mng/inform_list_index/list/-1/created/DESC/0/Alert/ ')?>"><?=$alert_notice?></a></span></td>
		    <td align="right">
		    	<?php if ($isadmin == 'Y' && ($users[0]['value']=='06058' || $users[0]['value']=='07024'|| $users[0]['value']=='08034')): ?>
		    	<input type="button" id="exchange" value="切換帳號" onclick="exchange()" />
		    	<?php endif; ?>
		    	<input type="button" id="logout" value="登出" onclick="logout()" />
		    </td>
		  </tr>
		</table>
		<script type="text/javascript">
			function logout()
			{
				$.ajax({
					type: "POST",
					url: "<?= base_url().'ecp_admin/ecp_logout/' ?>",
					success: function(){
						location.href = "<?= base_url() ?>";
					}
				});
			}
		</script>
	</div>
	<div class="menu">
		<ul>
			<?php ini_set('memory_limit', '256M');
foreach($menus as $menu): ?>
				<?php if ($menu['menutype']=='1'): ?>
					<?php $parentid = $menu['jec_menu_id'] ?>
					<li>
						<?php if(!empty($menu['control'])): ?>
							<a href="<?= base_url().$menu['control'] ?>" target="_self"><?= $menu['name'] ?></a>
						<?php else: ?>
							<a href="" target="_self"><?= $menu['name'] ?></a>
						<?php endif; ?>
						<ul>
						<?php foreach($menus as $submenu): ?>
							<?php if ($submenu['menutype']=='2' and $submenu['parentid']==$parentid): ?>
								<li>
									<?php if(!empty($submenu['control'])): ?>
										<a href="<?= base_url().$submenu['control'] ?>" target="_self"><?= $submenu['name'] ?></a>
									<?php else: ?>
										<a href="" target="_self"><?= $submenu['name'] ?></a>
									<?php endif; ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
	//開啟切換帳號的DIV
	function exchange()
	{
		$.blockUI({
			css: {
				top:  ($(window).height() - 200) /2 + 'px',
	            left: ($(window).width() - 300) /2 + 'px',
				width: '300px',
				height: '100px'
	        },
			message: $('#account_exchange')
		});
	}
	// 關閉切換帳號的DIV
	function account_close()
	{
		$.unblockUI();
	}
	// 確定切換帳號
	function account_exchange()
	{
		if ($.trim($("#new_account").val())=="")
		{
			humane.error('帳號不可空白');
			return;
		}
		para_data = {new_account: $("#new_account").val()};
		$.ajax({
			type: "POST",
			url: "<?=site_url('ecp_admin/account_exchange/')?>",
			data: (para_data),
			success: function(result){
				if (result)
				{
					$.unblockUI();
					location.href = "<?=base_url() ?>";
				}
				else
				{
					humane.error("查無此帳號，請重新輸入！");
				}
			}
		});
	}
	function pressEnter(e)
	{
		if (e.keyCode == 13) {
			account_exchange();
		}
	}
</script>
<div id="account_exchange" style="display: none;">
	<table width="100%" cellspacing="1" cellpadding="3" style="margin: 10px 10px 10px 10px;">
		<tr><td align="center">請輸入要切換的帳號</td></tr>
		<tr>
			<td align="center">
				<input type="text" id="new_account" size="10" onkeypress="pressEnter(event);"/>
			</td>
		</tr>
		<tr>
			<td align="center">
				<input type="button" id="btn_exchange" value="確定切換帳號" onclick="account_exchange()" />&nbsp;
				<input type="button" value="關閉" onclick="account_close()" />
			</td>
		</tr>
	</table>
</div>
