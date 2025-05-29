<!-- 現有系統參數列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="6">現有系統參數列表</td>
	</tr>
	<tr>
		<td>參數類型</td>
		<td>通知(郵件)內容</td>
		<td>代表圖示路徑與檔名</td>
		<td align="center">參數值</td>
		<td align="center">修改</td>
	</tr>
	<?php foreach($setting_list as $key => $settinglist): ?>
		<tr>
			<td>
				<?= $this->ecp_flag->get_noticetype($settinglist['noticetype']) ?>
			</td>
			<td>
				<?php if ($settinglist['noticetype']!='AT' && $settinglist['noticetype']!='AS' && substr($settinglist['noticetype'],0,1)<='9'): ?>
					<textarea id="<?= 'content'.$settinglist['jec_setup_id'] ?>" cols="40" rows="2"><?= $settinglist['content'] ?></textarea>
				<?php endif; ?>
			</td>
			<td>
				<?php if ($settinglist['noticetype']!='AT' && $settinglist['noticetype']!='AS' && substr($settinglist['noticetype'],0,1)<='9'): ?>
					<input type="text" id="<?= 'icon'.$settinglist['jec_setup_id'] ?>" 
					value="<?= $settinglist['icon'] ?>" size="10" />
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($settinglist['noticetype']!='AT' && $settinglist['noticetype']!='AS'): ?>
					<input type="text" id="<?= 'value'.$settinglist['jec_setup_id'] ?>" 
					value="<?= $settinglist['value'] ?>" size="30" />
				<?php else: ?>
					<?= $settinglist['value'] ?>
				<?php endif; ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y' && $settinglist['noticetype']!='AT' && $settinglist['noticetype']!='AS'): ?>
					<input type="button" id="<?= 'btn_update'.$settinglist['jec_setup_id'] ?>" 
					value="修改" onclick="data_update(<?= $settinglist['jec_setup_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
				<input type="hidden" id="<?= 'noticetype'.$settinglist['jec_setup_id'] ?>"  value="<?= $settinglist['noticetype'] ?>" />
			</td>
		</tr>
	<?php endforeach; ?>
</table>