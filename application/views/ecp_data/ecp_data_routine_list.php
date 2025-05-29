<!-- 現有系統參數列表  -->
<table class="detail-div" cellspacing="1" cellpadding="3" style="margin-top: 10px;">
	<tr>
		<td colspan="8">現有系統參數列表</td>
	</tr>
	<tr>
		<td>程式說明</td>
		<td>程式名稱</td>
		<td align="center">是否執行</td>
		<td align="center">間隔或定時</td>
		<td align="center">間隔時間(分鐘)</td>
		<td align="center">固定時間(HH:SS)</td>
		<td align="center">預計執行時間</td>
		<td align="center">修改</td>
	</tr>
	<?php $alert='N'; foreach($setting_list as $key => $settinglist): ?>
<?php
//
if($alert=='N'&&$settinglist['zrs_status']=='Y'&&strtotime($settinglist['zrs_setchange_time'])<time()) $alert='Y';
?>
		<tr>
			<td>
				<?= $settinglist['zrs_title'] ?>
			</td>
			<td>
				<?= $settinglist['zrs_exe_file'] ?>
			</td>
			<td align="center">
				<input type="checkbox" name="<?= 'zrs_exe_switch'.$settinglist['zrs_id'] ?>" id="<?= 'zrs_exe_switch'.$settinglist['zrs_id'] ?>" 
				value="Y" <?php if ($settinglist['zrs_exe_switch']=='Y'): ?> checked="checked" <?php endif;?> />
			</td>
			<td align="center">
				<input type="radio" name="<?= 'zrs_exe_type'.$settinglist['zrs_id'] ?>" value="1" 
					<?php if ($settinglist['zrs_exe_type']=='1'): ?> checked="checked" <?php endif;?> />&nbsp;間隔&nbsp;&nbsp;
				<input type="radio" name="<?= 'zrs_exe_type'.$settinglist['zrs_id'] ?>" value="2" 
					<?php if ($settinglist['zrs_exe_type']=='2'): ?> checked="checked" <?php endif;?> />&nbsp;定時
			</td>
			<td align="center">
				<input type="text" id="<?= 'zrs_exe_timespan'.$settinglist['zrs_id'] ?>" 
				value="<?= $settinglist['zrs_exe_timespan'] ?>" size="3" />
			</td>
			<td align="center">
				<input type="text" id="<?= 'zrs_exe_dailytime'.$settinglist['zrs_id'] ?>" 
				value="<?= $settinglist['zrs_exe_dailytime'] ?>" size="3" />
			</td>
			<td align="center">
				<?= $settinglist['zrs_setchange_time'] ?>
			</td>
			<td align="center">
				<?php if ($authority['isupdate']=='Y'): ?>
					<input type="button" id="<?= 'btn_update'.$settinglist['zrs_id'] ?>" 
					value="修改" onclick="data_update(<?= $settinglist['zrs_id'] ?>)" />
				<?php else: ?>
					---
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<?php log_message('info','alert,status:'.$alert.','.$status_on); if($alert=='Y'||$status_on=='N'){ ?><input type="button" value="重新啟動" onclick="Reset_Routine();" /><?php } ?>