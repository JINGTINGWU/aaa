        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2" class="info-title">專案管理</td>
            	</tr>
                <tr>
                	<td  width="75">起始日期</td>
                    <td><?=$proj_op['startdate']['op']?></td>
                </tr>
                <tr>
                	<td>結束日期</td>
                    <td><?=$proj_op['enddate']['op']?></td>
                </tr>
                <tr>
                	<td>部門</td>
                    <td><?=$proj_op['jec_dept_id']['op']?></td>
                </tr>
                <tr>
                	<td>業務</td>
                    <td><?=$proj_op['jec_usersales_id']['op']?><?=$proj_op['jec_usersales_id_title']['op']?></td>
                </tr>
                <tr>
                	<td>專案負責</td>
                    <td><?=$proj_op['jec_user_id']['op']?><?=$proj_op['jec_user_id_title']['op']?></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="button" value="確認修改專案資料" onclick="pg_proj_edit_submit();" class="mm_submit_button" <?=$up_btn?> /></td>
                </tr>
            </table>
